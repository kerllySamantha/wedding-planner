<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservaRequest;
use App\Http\Resources\ReservaCollection;
use App\Http\Resources\ReservaResource;
use App\Models\Boda;
use App\Models\Producto;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservas = Reserva::with(['usuario', 'empresa', 'boda'])->paginate(10);
        return new ReservaCollection($reservas);
        // return response()->json($reservas, 201);
    }

    /**
     * Show the form for creating a new resource.
     */


    public function show(Reserva $reserva)
    {
        $reserva = Reserva::with('producto.tipoProducto.categoria')->first();




        if (!$reserva) {
            return response()->json([
                'message' => 'No existe ninguna resenia con ese id',
                'status' => 'error'
            ], 404);
        }

        return new ReservaResource($reserva);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservaRequest $request)
    {
        $reserva = Reserva::create([
            'user_id' => $request->user_id,
            'empresa_id' => $request->empresa_id,
            'boda_id' => $request->boda_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'estado' => $request->estado ?? 'pendiente',
            'origen' => $request->origen ?? 'proveedor',
            'notas' => $request->notas,
        ]);

        return response()->json($reserva, 201);
    }

    /**
     * Display the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(ReservaRequest $request, string $id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->update([
            'fecha_inicio' => $request->fecha_inicio ?? $reserva->fecha_inicio,
            'fecha_fin' => $request->fecha_fin ?? $reserva->fecha_fin,
            'estado' => $request->estado ?? $reserva->estado,
            'notas' => $request->notas ?? $reserva->notas,
        ]);

        return response()->json($reserva, 201);
    }

    public function confirmar(Request $request, string $id)
    {
        $reserva = Reserva::findOrFail($id);

        $userId = auth()->id();
        if ($userId && $reserva->user_id && (int) $reserva->user_id !== (int) $userId) {
            return response()->json([
                'message' => 'No tienes permiso para confirmar esta reserva.',
                'status' => 'error'
            ], 403);
        }

        if ($reserva->estado !== 'bloqueada') {
            return response()->json([
                'message' => 'La reserva no esta en estado bloqueada.',
                'status' => 'error'
            ], 409);
        }

        if ($reserva->expires_at && $reserva->expires_at->isPast()) {
            $reserva->update([
                'estado' => 'cancelada',
            ]);

            return response()->json([
                'message' => 'El hold ha expirado.',
                'status' => 'error'
            ], 409);
        }

        $fechaInicio = Carbon::parse($reserva->fecha_inicio);
        $fechaFin = $reserva->fecha_fin
            ? Carbon::parse($reserva->fecha_fin)
            : (clone $fechaInicio)->addDay();

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

        if ($reserva->producto_id) {
            $producto = $reserva->producto;

            if ($producto) {
                $reservasExistentes = Reserva::where('producto_id', $reserva->producto_id)
                    ->whereIn('estado', ['confirmada', 'bloqueada'])
                    ->where('id', '!=', $reserva->id)
                    ->where($overlap)
                    ->where($vigentes)
                    ->count();

                if ($reservasExistentes >= $producto->stock_paralelo) {
                    return response()->json([
                        'message' => 'Agenda llena para esta fecha.',
                        'status' => 'error'
                    ], 409);
                }
            }
        } else {
            $conflicto = Reserva::where('empresa_id', $reserva->empresa_id)
                ->whereIn('estado', ['confirmada', 'bloqueada'])
                ->where('id', '!=', $reserva->id)
                ->where($overlap)
                ->where($vigentes)
                ->exists();

            if ($conflicto) {
                return response()->json([
                    'message' => 'La fecha ya no esta disponible para este proveedor.',
                    'status' => 'error'
                ], 409);
            }
        }

        $reserva->update([
            'estado' => 'confirmada',
            'expires_at' => null,
        ]);

        return response()->json([
            'message' => 'Reserva confirmada correctamente.',
            'data' => $reserva
        ], 200);
    }

    public function cancelar($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->estado = 'cancelada';
        $reserva->save();

        return response()->json(['message' => 'Reserva cancelada']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->delete();

        return response()->json(['message' => 'Datos eliminados correctamente', 200]);
    }


    public function getRersevaPorConfirmar(string $id, string $estado)
    {

        $reservas = Reserva::where('empresa_id', (int) $id)
            ->where('estado', $estado)
            ->get();


        return new ReservaCollection($reservas);
    }

    public function getReservaEmpresa(string $id)
    {

        $reservas = Reserva::where('empresa_id', (int) $id)
            ->get();


        return new ReservaCollection($reservas);
    }

    public function verificarDisponibilidad(Request $request)
    {
        $producto = Producto::find($request->producto_id);
        if (!$producto) {
            return response()->json(['disponible' => false, 'msj' => 'Producto no encontrado'], 404);
        }

        $fechaInicio = Carbon::parse($request->fecha_inicio)->startOfDay();
        $fechaFin = (clone $fechaInicio)->addDay();

        $bloqueoEmpresa = Reserva::where('empresa_id', $producto->empresa_id)
            ->where('tipo_reserva', 'bloqueo')
            ->whereIn('estado', ['confirmada', 'bloqueada'])
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->where(function ($query) use ($fechaInicio, $fechaFin) {
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
            })
            ->exists();

        if ($bloqueoEmpresa) {
            return response()->json(['disponible' => false, 'msj' => 'Agenda bloqueada para esta fecha'], 400);
        }

        // 1. Contar cuántas reservas CONFIRMADAS hay para ese producto en esa fecha
        $reservasExistentes = Reserva::where('producto_id', $producto->id)
            ->whereDate('fecha_inicio', $fechaInicio->toDateString())
            ->whereIn('estado', ['confirmada', 'bloqueada'])
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->count();

        // 2. Comparar con el "stock_paralelo"
        if ($reservasExistentes >= $producto->stock_paralelo) {
            return response()->json(['disponible' => false, 'msj' => 'Agenda llena para esta fecha'], 400);
        }

        return response()->json(['disponible' => true]);
    }

    public function getCalendario(string $id)
    {

        $reservas = Reserva::with(['boda', 'usuario', 'empresa'])
            ->where('empresa_id', $id)
            ->where(function ($query) {
                $query->where('estado', '!=', 'bloqueada')
                    ->orWhere(function ($q) {
                        $q->where('estado', 'bloqueada')
                            ->where(function ($q) {
                                $q->whereNull('expires_at')
                                    ->orWhere('expires_at', '>', now());
                            });
                    });
            })
            ->get();

        $data = $reservas->map(function ($r) {
            return [
                'id' => (string) $r->id,
                'title' => $r->boda->nombre_pareja
                    ?? $r->usuario->name
                    ?? 'Reserva',

                'start' => Carbon::parse($r->fecha_inicio)->toIso8601String(),
                'end' => Carbon::parse($r->fecha_fin)->toIso8601String(),

                'backgroundColor' => Helper::colorPorEstado($r->estado),
                'borderColor' => Helper::colorPorEstado($r->estado),

                'extendedProps' => [
                    'estado' => $r->estado,
                    'origen' => $r->origen,
                    'notas' => $r->notas,

                    'cliente' => $r->usuario ? [
                        'id' => $r->usuario->id,
                        'name' => $r->usuario->name,
                        'rol' => $r->usuario->getRoleNames()->first()
                    ] : null,

                    'empresa' => [
                        'id' => $r->empresa->id,
                        'nombre_empresa' => $r->empresa->nombre_empresa
                    ],

                    'boda' => $r->boda ? [
                        'id' => $r->boda->id,
                        'nombre_pareja' => $r->boda->nombre_pareja,
                        'fecha' => $r->boda->fecha
                    ] : null,

                    // 'servicio' => $r->servicio ? [
                    //     'id' => $r->servicio->id,
                    //     'nombre' => $r->servicio->nombre
                    // ] : null,
                    'tipo_reserva' => $r->tipo_reserva,
                    'all_day' => $r->all_day,

                    'producto' => $r->producto ? [
                        'id' => $r->producto->id,
                        'nombre' => $r->producto->nombre,
                        'categoria' => $r->producto->tipoProducto->categoria->nombre ?? "",
                        'tipo_producto' => $r->producto->tipoProducto->nombre ?? "",
                        // 'modalidad' => $r->producto->tipoProducto->modalidad ?? "",
                    ] : null,
                ]
            ];
        });

        return response()->json($data);
    }
}
