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
            ->where('nombre_tipo_personalizado', $validated['nombre_tipo_personalizado'])
            ->first();

        $itemData = [
            'precio_unitario' => $validated['precio_unitario'] ?? 0,
            'cantidad' => $validated['cantidad'] ?? 1,
            'total_item' => ($validated['precio_unitario'] ?? 0) * ($validated['cantidad'] ?? 1),
            'es_personalizado' => $validated['es_personalizado'] ?? false,
            'notas' => $validated['notas'] ?? null,
        ];

        if ($existingItem) {
            $existingItem->update($itemData);
            $item = $existingItem;
        } else {
            $item = ItemPresupuesto::create(array_merge(
                [
                    'presupuesto_id' => $validated['presupuesto_id'],
                    'nombre_tipo_personalizado' => $validated['nombre_tipo_personalizado'] ?? null
                ],
                $itemData
            ));
        }

        $montoTotal = ItemPresupuesto::where('presupuesto_id', $validated['presupuesto_id'])
            ->sum('total_item');

        $presupuesto = Presupuesto::find($validated['presupuesto_id']);
        if ($presupuesto) {
            $presupuesto->update(['monto_total' => $montoTotal]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Item guardado correctamente',
            'data' => $item,
            'monto_total_presupuesto' => $montoTotal
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
