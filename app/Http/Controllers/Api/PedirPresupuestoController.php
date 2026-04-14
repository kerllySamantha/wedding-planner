<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PedirPresupuestoRequest;
use App\Http\Requests\ResponderPedirPresupuestoRequest;
use App\Models\PedirPresupuesto;
use App\Models\Producto;
use App\Models\Reserva;
use App\Support\NotificacionHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedirPresupuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $solicitudes = PedirPresupuesto::with(['usuario', 'empresa', 'boda', 'tipoProducto'])->paginate(10);

        return response()->json($solicitudes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PedirPresupuestoRequest $request)
    {
        $pedirPresupuesto = PedirPresupuesto::create([
            ...$request->validated(),
            'estado' => PedirPresupuesto::ESTADO_PENDIENTE,
        ]);

        $pedirPresupuesto->load('empresa.usuario');
        $usuario_id = $pedirPresupuesto->empresa?->user_id;

        if ($usuario_id) {
            NotificacionHelper::crear(
                $usuario_id,
                'solicitud_creada',
                'Nueva solicitud de presupuesto',
                'Has recibido una nueva solicitud de presupuesto.',
                $pedirPresupuesto
            );
        }

        return response()->json($pedirPresupuesto->load(['usuario', 'empresa', 'boda', 'tipoProducto']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(PedirPresupuesto $pedirPresupuesto)
    {
        return response()->json($pedirPresupuesto->load(['usuario', 'empresa', 'boda', 'tipoProducto']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PedirPresupuestoRequest $request, PedirPresupuesto $pedirPresupuesto)
    {
        $pedirPresupuesto->update($request->validated());

        return response()->json($pedirPresupuesto->load(['usuario', 'empresa', 'boda', 'tipoProducto']));
    }

    public function responder(ResponderPedirPresupuestoRequest $request, PedirPresupuesto $pedirPresupuesto)
    {
        $userId = auth()->id();

        if (!$userId) {
            return response()->json([
                'status' => 'error',
                'message' => 'No autenticado.'
            ], 401);
        }

        $pedirPresupuesto->load('empresa');

        if (!$pedirPresupuesto->empresa || (int) $pedirPresupuesto->empresa->user_id !== (int) $userId) {
            return response()->json([
                'status' => 'error',
                'message' => 'No tienes permiso para responder este presupuesto.'
            ], 403);
        }

        $validated = $request->validated();
        $estadoSolicitado = $validated['estado'] ?? null;
        $esRechazo = $estadoSolicitado === PedirPresupuesto::ESTADO_RECHAZADO_EMPRESA;

        if ($esRechazo) {
            $pedirPresupuesto->update([
                'estado' => PedirPresupuesto::ESTADO_RECHAZADO_EMPRESA,
                'importe_ofertado' => null,
                'comentario_empresa' => $validated['comentario_empresa'] ?? null,
                'producto_id' => null,
                'modalidad' => null,
                'fecha_inicio' => null,
                'fecha_fin' => null,
                'fecha_respuesta' => now(),
            ]);

            $usuarioId = $pedirPresupuesto->user_id;
            if ($usuarioId) {
                NotificacionHelper::crear(
                    $usuarioId,
                    'presupuesto_rechazado',
                    'Solicitud rechazada',
                    'El proveedor ha rechazado tu solicitud de presupuesto.',
                    $pedirPresupuesto
                );
            }

            return response()->json($pedirPresupuesto->load(['usuario', 'empresa', 'boda', 'tipoProducto']));
        }

        if (empty($validated['producto_id'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'El producto es obligatorio para la propuesta.'
            ], 422);
        }

        $producto = Producto::with('tipoProducto')->find($validated['producto_id']);

        if (!$producto) {
            return response()->json([
                'status' => 'error',
                'message' => 'Producto no encontrado.'
            ], 422);
        }

        if ((int) $producto->empresa_id !== (int) $pedirPresupuesto->empresa_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'El producto no pertenece a este proveedor.'
            ], 422);
        }

        $modalidad = $validated['modalidad'] ?? $producto->tipoProducto?->modalidad;

        if (!$modalidad) {
            return response()->json([
                'status' => 'error',
                'message' => 'La modalidad es obligatoria.'
            ], 422);
        }

        if ($modalidad === 'dia') {
            $modalidad = 'producto';
        }

        $incluyeHora = function (?string $valor): bool {
            if (!$valor) {
                return false;
            }

            return (bool) preg_match('/^\d{4}-\d{2}-\d{2}[ T]\d{2}:\d{2}(:\d{2})?(?:Z|[+-]\d{2}:\d{2})?$/', $valor);
        };

        if ($modalidad === 'servicio') {
            if (empty($validated['fecha_inicio']) || empty($validated['fecha_fin'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Para servicios debes indicar fecha_inicio y fecha_fin.'
                ], 422);
            }

            if (!$incluyeHora($validated['fecha_inicio']) || !$incluyeHora($validated['fecha_fin'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Las fechas de servicio deben incluir hora.'
                ], 422);
            }

            $fechaInicio = Carbon::parse($validated['fecha_inicio']);
            $fechaFin = Carbon::parse($validated['fecha_fin']);
        } else {
            if (empty($validated['fecha_inicio'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Para productos debes indicar fecha_inicio.'
                ], 422);
            }

            $fechaInicio = Carbon::parse($validated['fecha_inicio'])->startOfDay();
            if (!empty($validated['fecha_fin'])) {
                $fechaFin = Carbon::parse($validated['fecha_fin'])->startOfDay()->addDay();
            } else {
                $fechaFin = (clone $fechaInicio)->addDay();
            }
        }

        if ($fechaFin->lessThanOrEqualTo($fechaInicio)) {
            return response()->json([
                'status' => 'error',
                'message' => 'La fecha de fin debe ser posterior a la de inicio.'
            ], 422);
        }

        $pedirPresupuesto->update([
            'producto_id' => $producto->id,
            'modalidad' => $modalidad,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'importe_ofertado' => $validated['importe_ofertado'],
            'comentario_empresa' => $validated['comentario_empresa'] ?? null,
            'estado' => PedirPresupuesto::ESTADO_PENDIENTE_USUARIO,
            'fecha_respuesta' => now(),
        ]);

        $usuarioId = $pedirPresupuesto->user_id;
        if ($usuarioId) {
            NotificacionHelper::crear(
                $usuarioId,
                'presupuesto_respondido',
                'Presupuesto disponible',
                'El proveedor ha respondido tu solicitud con una propuesta.',
                $pedirPresupuesto
            );
        }

        return response()->json($pedirPresupuesto->load(['usuario', 'empresa', 'boda', 'tipoProducto']));
    }

    public function aceptarPorUsuario(Request $request, PedirPresupuesto $pedirPresupuesto)
    {
        $userId = auth()->id();

        if (!$userId) {
            return response()->json([
                'status' => 'error',
                'message' => 'No autenticado.'
            ], 401);
        }

        if ((int) $pedirPresupuesto->user_id !== (int) $userId) {
            return response()->json([
                'status' => 'error',
                'message' => 'No tienes permiso para aceptar este presupuesto.'
            ], 403);
        }

        if (!in_array($pedirPresupuesto->estado, [
            PedirPresupuesto::ESTADO_PENDIENTE_USUARIO,
            PedirPresupuesto::ESTADO_ACEPTADO_USUARIO,
        ], true)) {
            return response()->json([
                'status' => 'error',
                'message' => 'El presupuesto no esta pendiente de tu confirmacion.'
            ], 409);
        }

        return DB::transaction(function () use ($pedirPresupuesto) {
            $pedirPresupuesto->load(['boda', 'reserva', 'producto.tipoProducto']);

            $reservaActual = $pedirPresupuesto->reserva;
            if ($reservaActual && $reservaActual->estado !== 'cancelada') {
                if (!$reservaActual->expires_at || $reservaActual->expires_at->isFuture()) {
                    if ($pedirPresupuesto->estado !== PedirPresupuesto::ESTADO_ACEPTADO_USUARIO) {
                        $pedirPresupuesto->update([
                            'estado' => PedirPresupuesto::ESTADO_ACEPTADO_USUARIO,
                        ]);
                    }

                return response()->json([
                    'reserva_id' => $reservaActual->id,
                    'reserva' => $reservaActual,
                    ], 200);
                }

                if ($reservaActual->expires_at && $reservaActual->expires_at->isPast() && $reservaActual->estado === 'bloqueada') {
                    $reservaActual->update([
                        'estado' => 'cancelada',
                    ]);
                }
            }

            $producto = $pedirPresupuesto->producto;
            if (!$producto && $pedirPresupuesto->producto_id) {
                $producto = Producto::with('tipoProducto')->find($pedirPresupuesto->producto_id);
            }

            if (!$producto) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'La propuesta no tiene producto asignado.'
                ], 422);
            }

            if ((int) $producto->empresa_id !== (int) $pedirPresupuesto->empresa_id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'El producto no pertenece a este proveedor.'
                ], 422);
            }

            $modalidad = $pedirPresupuesto->modalidad ?? $producto->tipoProducto?->modalidad;

            if (!$modalidad) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'La propuesta no tiene modalidad definida.'
                ], 422);
            }

            if ($modalidad === 'dia') {
                $modalidad = 'producto';
            }

            if ($pedirPresupuesto->importe_ofertado === null) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'La propuesta no tiene importe ofertado.'
                ], 422);
            }

            $allDay = true;
            if ($modalidad === 'servicio') {
                if (!$pedirPresupuesto->fecha_inicio || !$pedirPresupuesto->fecha_fin) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'La propuesta de servicio no tiene fechas completas.'
                    ], 422);
                }

                $fechaInicio = Carbon::parse($pedirPresupuesto->fecha_inicio);
                $fechaFin = Carbon::parse($pedirPresupuesto->fecha_fin);
                $allDay = false;
            } else {
                if (!$pedirPresupuesto->fecha_inicio) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'La propuesta no tiene fecha de inicio.'
                    ], 422);
                }

                $fechaInicio = Carbon::parse($pedirPresupuesto->fecha_inicio)->startOfDay();
                if ($pedirPresupuesto->fecha_fin) {
                    $fechaFin = Carbon::parse($pedirPresupuesto->fecha_fin);
                } else {
                    $fechaFin = (clone $fechaInicio)->addDay();
                }
            }

            if ($fechaFin->lessThanOrEqualTo($fechaInicio)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'La fecha de fin debe ser posterior a la de inicio.'
                ], 422);
            }

            $overlap = function ($query) use ($fechaInicio, $fechaFin) {
                $query->where(function ($query) use ($fechaInicio, $fechaFin) {
                    $query->whereNotNull('fecha_inicio')
                        ->whereNotNull('fecha_fin')
                        ->where('fecha_inicio', '<', $fechaFin)
                        ->where('fecha_fin', '>', $fechaInicio);
                })->orWhere(function ($query) use ($fechaInicio) {
                    $query->whereNotNull('fecha_inicio')
                        ->whereNull('fecha_fin')
                        ->whereDate('fecha_inicio', $fechaInicio->toDateString());
                });
            };

            $vigentes = function ($query) {
                $query->where(function ($q) {
                    $q->whereNull('expires_at')
                        ->orWhere('expires_at', '>', now());
                });
            };

            $baseQuery = Reserva::where('empresa_id', $pedirPresupuesto->empresa_id)
                ->whereIn('estado', ['confirmada', 'bloqueada'])
                ->where($overlap)
                ->where($vigentes);

            if ($reservaActual) {
                $baseQuery->where('id', '!=', $reservaActual->id);
            }

            $conflictoBloqueo = (clone $baseQuery)
                ->where('tipo_reserva', 'bloqueo')
                ->lockForUpdate()
                ->exists();

            if ($conflictoBloqueo) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'La fecha ya no esta disponible para este proveedor.'
                ], 409);
            }

            if ($producto) {
                $reservasExistentes = Reserva::where('producto_id', $producto->id)
                    ->whereIn('estado', ['confirmada', 'bloqueada'])
                    ->where($overlap)
                    ->where($vigentes);

                if ($reservaActual) {
                    $reservasExistentes->where('id', '!=', $reservaActual->id);
                }

                $reservasCount = $reservasExistentes->lockForUpdate()->count();

                if ($reservasCount >= $producto->stock_paralelo) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Agenda llena para esta fecha.'
                    ], 409);
                }
            } else {
                $conflictoEmpresa = (clone $baseQuery)
                    ->lockForUpdate()
                    ->exists();

                if ($conflictoEmpresa) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Agenda llena para esta fecha.'
                    ], 409);
                }
            }

            $holdDays = (int) env('RESERVA_HOLD_DAYS', 7);

            $reserva = Reserva::create([
                'user_id' => $pedirPresupuesto->user_id,
                'empresa_id' => $pedirPresupuesto->empresa_id,
                'boda_id' => $pedirPresupuesto->boda_id,
                'pedir_presupuesto_id' => $pedirPresupuesto->id,
                'producto_id' => $producto?->id,
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'tipo_reserva' => 'bloqueo',
                'estado' => 'bloqueada',
                'origen' => 'usuario',
                'all_day' => $allDay,
                'expires_at' => now()->addDays($holdDays),
                'notas' => 'Hold pendiente de pago para presupuesto #' . $pedirPresupuesto->id,
            ]);

            $pedirPresupuesto->update([
                'estado' => PedirPresupuesto::ESTADO_ACEPTADO_USUARIO,
                'reserva_id' => $reserva->id,
            ]);

            $pedirPresupuesto->load('empresa');

            if ($pedirPresupuesto->empresa?->user_id) {
                NotificacionHelper::crear(
                    $pedirPresupuesto->empresa->user_id,
                    'presupuesto_aceptado',
                    'Presupuesto aceptado',
                    'El cliente ha aceptado la propuesta y se ha bloqueado la fecha.',
                    $pedirPresupuesto
                );

                NotificacionHelper::crear(
                    $pedirPresupuesto->empresa->user_id,
                    'reserva_bloqueada',
                    'Reserva bloqueada',
                    'Se ha creado una reserva bloqueada pendiente de pago.',
                    $reserva
                );
            }

            if ($pedirPresupuesto->user_id) {
                NotificacionHelper::crear(
                    $pedirPresupuesto->user_id,
                    'reserva_bloqueada',
                    'Reserva bloqueada',
                    'Tu fecha ha quedado bloqueada temporalmente pendiente de pago.',
                    $reserva
                );
            }

            return response()->json([
                'reserva_id' => $reserva->id,
                'reserva' => $reserva,
            ], 200);
        });
    }



    public function rechazarPorUsuario(PedirPresupuesto $pedirPresupuesto)
{
    $userId = auth()->id();

    if (!$userId) {
        return response()->json([
            'status' => 'error',
            'message' => 'No autenticado.'
        ], 401);
    }

    if ((int) $pedirPresupuesto->user_id !== (int) $userId) {
        return response()->json([
            'status' => 'error',
            'message' => 'No tienes permiso para rechazar este presupuesto.'
        ], 403);
    }

    if ($pedirPresupuesto->estado !== PedirPresupuesto::ESTADO_PENDIENTE_USUARIO) {
        return response()->json([
            'status' => 'error',
            'message' => 'Este presupuesto no se puede rechazar.'
        ], 409);
    }

    $pedirPresupuesto->update([
        'estado' => PedirPresupuesto::ESTADO_RECHAZADO_USUARIO
    ]);


    $pedirPresupuesto->load('empresa');

    if ($pedirPresupuesto->empresa?->user_id) {
        NotificacionHelper::crear(
            $pedirPresupuesto->empresa->user_id,
            'presupuesto_rechazado',
            'Presupuesto rechazado',
            'El cliente ha rechazado tu propuesta.',
            $pedirPresupuesto
        );
    }

    return response()->json([
        'message' => 'Presupuesto rechazado correctamente'
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PedirPresupuesto $pedirPresupuesto)
    {
        $pedirPresupuesto->delete();

        return response()->json(['message' => 'Datos eliminados correctamente']);
    }

    public function getPedirPresupuestosEmpresa(string $idEmpresa)
    {
        $pedirPresupuesto = PedirPresupuesto::with('tipoProducto')
            ->where('empresa_id', $idEmpresa)
            ->get();
        return response()->json($pedirPresupuesto, 200);
    }
}
