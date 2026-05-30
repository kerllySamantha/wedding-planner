<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Http\Resources\CategoriaResource;
use App\Http\Resources\CategoriaTipoCollection;
use App\Models\Categoria;
use App\Models\TipoProducto;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::with('tipoProducto')->orderBy('nombre')->get();

     
        return CategoriaResource::collection($categorias);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriaRequest $request)
    {
        $categoria = new Categoria();
        $categoria->nombre = $request->validated()['nombre'];
        $categoria->descripcion = $request->validated()['descripcion'];
        $categoria->save();

        return response()->json([
            'message' => 'Categoría creada correctamente',
            'data' => new CategoriaResource($categoria)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categoria = Categoria::findOrFail($id);
        return new CategoriaResource($categoria);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriaRequest $request, string $id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->validated());

        return response()->json([
            'message' => 'Categoría actualizada correctamente',
            'data' => $categoria
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return response()->json([
            'message' => 'Categoría eliminada correctamente'
        ], 204);
    }

    public function getByCategoria($id, Request $request)
    {
        $query = TipoProducto::where('categoria_id', $id);

        if ($request->has('search')) {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }

        $tipos = $query->select('id', 'nombre')->orderBy('nombre')->get();
        // return response()->json($tipos, 200);

        return new CategoriaTipoCollection($tipos);
    }
}
