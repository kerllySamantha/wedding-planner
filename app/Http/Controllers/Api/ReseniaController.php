<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReseniaRequest;
use App\Http\Resources\ReseniaResource;
use App\Models\Resenia;
use Illuminate\Http\Request;

class ReseniaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resenias = Resenia::with(['usuario', 'empresa'])->get();
        return ReseniaResource::collection($resenias);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReseniaRequest $request)
    {
        $resenia = new Resenia();
        
        $resenia->user_id = $request->validated()['user_id'];
        $resenia->empresa_id = $request->validated()['empresa_id'];
        $resenia->puntuacion = $request->validated()['puntuacion'];
        $resenia->comentario = $request->validated()['comentario'];
        $resenia->fotos = $request->validated()['fotos'];
        // if ($request->hasFile('imagen')) {
        //     $rese->imagen = $request->file('imagen')->store('imagenes', 'public');
        // }
        
        if (!$resenia->save()) {
            return response()->json([
                'message' => 'No se ha podido realizar la resenia',
                'status' => 'error'
            ], 401);
        }
        return response()->json([
            'status' => 'success',
            'data' => $resenia,
            'message' => 'Se ha realizado la resenia correctamente'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $resenia = Resenia::findOrFail($id);

        if (!$resenia) {
            return response()->json([
                'message' => 'No existe ninguna resenia con ese id',
                'status' => 'error'
            ], 404);
        }

        return response()->json($resenia, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReseniaRequest $request, string $id)
    {
        $resenia = Resenia::findOrFail($id);
        $resenia->user_id = $request->validated()['user_id'];
        $resenia->empresa_id = $request->validated()['empresa_id'];
        $resenia->puntuacion = $request->validated()['puntuacion'];
        $resenia->comentario = $request->validated()['comentario'];
        $resenia->fotos = $request->validated()['fotos'];
        if (!$resenia->save()) {
            return response()->json([
                'message' => 'No se ha podido actualizar la resenia',
                'status' => 'error'
            ], 401);
        }
        return response()->json([
            'status' => 'success',
            'data' => $resenia,
            'message' => 'Se ha actualizado la resenia correctamente'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $resenia = Resenia::findOrFail($id);
        $resenia->delete();

        return response()->json([
            'message' => 'Datos eliminados correctamente',
            'status' => 'success',

        ], 200);
    }
}