<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PresupuestoRequest;
use App\Http\Resources\PresupuestoCollection;
use App\Models\Boda;
use App\Models\Presupuesto;
use Illuminate\Http\Request;

class PresupuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $presupuestos = Presupuesto::all();
        return response()->json($presupuestos, 200);
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(PresupuestoRequest $request)
    {
        $validated = $request->validated();
        $presupuesto = Presupuesto::create([
            'boda_id' => $validated['boda_id'],
            'tipo_producto_id' =>  $validated['tipo_producto_id'],
            // 'nombre' => $validated['nombre'],
            // 'descripcion' => $validated['descripcion'] ?? null,
            'monto_total' => $validated['monto_total'],
            'estado' => $validated['estado'] ?? false,
            'fecha_creacion' => $validated['fecha_creacion']
        ]);

        return response()->json($presupuesto, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Presupuesto $presupuesto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Presupuesto $presupuesto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Presupuesto $presupuesto)
    {
        //
    }

    public function getPresupuestoByBoda($bodaId)
    {
        $boda = Boda::with([
            'presupuesto.tipoProducto',
            'presupuesto.itemsPresupuesto' // 👈 importante
        ])->find($bodaId);

        if (!$boda) {
            return response()->json([
                'status' => 'error',
                'message' => 'No se encontró la boda'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Presupuestos encontrados correctamente',
            'data' => $boda->presupuesto->map(function ($p) {
                return [
                    'id' => $p->id,
                    'monto_total' => $p->monto_total,
                    'monto_pagado' => $p->monto_pagado ?? 0,
                    'monto_restante' => ($p->monto_total ?? 0) - ($p->monto_pagado ?? 0),
                    'estado' => $p->estado,
                    'fecha_creacion' => $p->fecha_creacion,
                    'tipo_producto' => [
                        'id' => $p->tipoProducto->id,
                        'nombre' => $p->tipoProducto->nombre,
                    ],
                    'items_presupuesto' => $p->itemsPresupuesto->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'tipo_producto_id' => $item->tipo_producto_id,
                            'nombre_tipo_personalizado' => $item->nombre_tipo_personalizado,
                            'monto_estimado' => $item->monto_estimado,
                            'monto_pagado' => $item->monto_pagado ?? 0,
                            'diferencia' => ($item->monto_estimado ?? 0) - ($item->monto_pagado ?? 0),
                            'es_personalizado' => $item->es_personalizado,
                            'notas' => $item->notas,
                        ];
                    }),
                ];
            }),
        ]);
    }
}
