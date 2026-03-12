<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PedirPresupuestoRequest;
use App\Http\Requests\ResponderPedirPresupuestoRequest;
use App\Models\Notificacion;
use App\Models\PedirPresupuesto;

class PedirPresupuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $solicitudes = PedirPresupuesto::with(['usuario', 'empresa', 'boda'])->paginate(10);

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

        Notificacion::create([
            'user_id' => $pedirPresupuesto->empresa_id,
            'tipo' => 'presupuesto',
            'titulo' => 'Nueva solicitud de presupuesto',
            'mensaje' => 'Has recibido una nueva solicitud',
            'referencia_id' => $pedirPresupuesto->id
        ]);

        return response()->json($pedirPresupuesto->load(['usuario', 'empresa', 'boda']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(PedirPresupuesto $pedirPresupuesto)
    {
        return response()->json($pedirPresupuesto->load(['usuario', 'empresa', 'boda']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PedirPresupuestoRequest $request, PedirPresupuesto $pedirPresupuesto)
    {
        $pedirPresupuesto->update($request->validated());

        return response()->json($pedirPresupuesto->load(['usuario', 'empresa', 'boda']));
    }

    public function responder(ResponderPedirPresupuestoRequest $request, PedirPresupuesto $pedirPresupuesto)
    {
        $validated = $request->validated();

        if ($validated['estado'] === PedirPresupuesto::ESTADO_RECHAZADO_EMPRESA) {
            $validated['importe_ofertado'] = null;
        }

        $pedirPresupuesto->update([
            ...$validated,
            'fecha_respuesta' => now(),
        ]);

        return response()->json($pedirPresupuesto->load(['usuario', 'empresa', 'boda']));
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
        $pedirPresupuesto = PedirPresupuesto::where('empresa_id', $idEmpresa)->get();
        return response()->json($pedirPresupuesto, 200);
    }
}
