<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemsDetallesRequest;
use App\Http\Resources\ItemDetallesCollection;
use App\Models\ItemPresupuesto;
use App\Models\Presupuesto;
use Illuminate\Http\Request;

class ItemPresupuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = ItemPresupuesto::all();
        return new ItemDetallesCollection($items);
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemsDetallesRequest $request)
    {
        $validated = $request->validated();

        $existingItem = ItemPresupuesto::where('presupuesto_id', $validated['presupuesto_id'])
            ->where('tipo_producto_id', $validated['tipo_producto_id'])
            ->first();

        $montoPagado = array_key_exists('monto_pagado', $validated)
            ? $validated['monto_pagado']
            : ($existingItem?->monto_pagado ?? 0);

        $esPersonalizado = array_key_exists('es_personalizado', $validated)
            ? $validated['es_personalizado']
            : ($existingItem?->es_personalizado ?? false);

        $notas = array_key_exists('notas', $validated)
            ? $validated['notas']
            : ($existingItem?->notas ?? null);

        $itemData = [
            'monto_estimado' => $validated['monto_estimado'],
            'monto_pagado' => $montoPagado,
            'es_personalizado' => $esPersonalizado,
            'notas' => $notas,
        ];

        if ($existingItem) {
            $existingItem->update($itemData);
            $item = $existingItem;
        } else {
            $item = ItemPresupuesto::create(array_merge(
                [
                    'presupuesto_id' => $validated['presupuesto_id'],
                    'tipo_producto_id' => $validated['tipo_producto_id'],
                    'nombre_tipo_personalizado' => $validated['nombre_tipo_personalizado'] ?? null
                ],
                $itemData
            ));
        }

        $montoTotal = ItemPresupuesto::where('presupuesto_id', $validated['presupuesto_id'])
            ->sum('monto_estimado');
        $montoPagadoTotal = ItemPresupuesto::where('presupuesto_id', $validated['presupuesto_id'])
            ->sum('monto_pagado');

        $presupuesto = Presupuesto::find($validated['presupuesto_id']);
        if ($presupuesto) {
            $presupuesto->update([
                'monto_total' => $montoTotal,
                'monto_pagado' => $montoPagadoTotal
            ]);
        }

        $montoRestante = $montoTotal - $montoPagadoTotal;

        return response()->json([
            'status' => 'success',
            'message' => 'Item guardado correctamente',
            'data' => $item,
            'monto_total_presupuesto' => $montoTotal,
            'monto_pagado_presupuesto' => $montoPagadoTotal,
            'monto_restante_presupuesto' => $montoRestante
        ]);
    }



    /**
     * Display the specified resource.
     */
    public function show(ItemPresupuesto $itemPresupuesto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemPresupuesto $itemPresupuesto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemPresupuesto $itemPresupuesto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemPresupuesto $itemPresupuesto)
    {
        //
    }

    public function getByPresupuesto($id)
    {
        $items = ItemPresupuesto::where('presupuesto_id', $id)->get();
        return response()->json(['data' => $items]);
    }
}
