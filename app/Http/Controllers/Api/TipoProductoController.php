<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TipoProducto;
use Illuminate\Http\Request;

class TipoProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return TipoProducto::orderBy('nombre', 'asc')
            ->get()
            ->toResourceCollection();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'categoria_id' => 'required|integer|exists:categorias,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'modalidad' => 'nullable|in:producto,servicio,dia',
        ]);

        $tipoProducto = TipoProducto::create([
            'categoria_id' => $validated['categoria_id'],
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
            'modalidad' => $validated['modalidad'] ?? 'dia',
        ]);

        return response()->json($tipoProducto, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoProducto $tipoProducto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoProducto $tipoProducto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoProducto $tipoProducto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoProducto $tipoProducto)
    {
        //
    }
}
