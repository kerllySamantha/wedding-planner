<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMensajeRequest;
use App\Http\Requests\UpdateMensajeRequest;
use App\Http\Resources\MensajeCollection;
use App\Http\Resources\MensajeResource;
use App\Models\Mensaje;
use Illuminate\Http\Request;

class MensajeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mensajes = Mensaje::with(['emisor', 'receptor'])->paginate(10);
        return new MensajeCollection($mensajes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMensajeRequest $request)
    {
        $validated = $request->validated();

        $mensaje = new Mensaje();
        $mensaje->emisor_id = $validated['emisor_id'];
        $mensaje->receptor_id = $validated['receptor_id'];
        $mensaje->contenido = $validated['contenido'];

        if ($request->hasFile('archivo')) {
            $mensaje->archivo = $request->file('archivo')->store('mensajes');
        }

        if (!$mensaje->save()) {
            return response()->json([
                'message' => 'No se ha podido enviar el mensaje',
                'status' => 'error'
            ], 401);
        }

        return response()->json([
            'message' => 'Mensaje enviado correctamente',
            'data' => new MensajeResource($mensaje),
            'status' => 'success'
        ], 201);
    }


    // return response()->json([
    //             'status' => 'success',
    //             'data' => $mensaje,
    //             'message' => 'Se ha enviado el correctamente'
    //         ], 200);



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mensaje = Mensaje::findOrFail($id);

        if (!$mensaje) {
            return response()->json([
                'message' => 'No se ha encontrado ningun mensaje',
                'status' => 'error'
            ], 404);
        }

        return response()->json($mensaje, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMensajeRequest $request, string $id)
    {
        $validated = $request->validated();
        $mensaje = Mensaje::findOrFail($id);
        $mensaje->fill($validated);

        if (!$mensaje->save()) {
            return response()->json([
                'message' => 'No se ha modificado el mensaje',
                'status' => 'error'
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'data' => $mensaje,
            'message' => 'Se ha modificado el mensaje correctamente'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mensaje = Mensaje::findOrFail($id);
        $mensaje->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'datos eliminados correctamente',

        ], 200);
    }
}