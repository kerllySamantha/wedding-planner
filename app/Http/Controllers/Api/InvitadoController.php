<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvitadoRequest;
use App\Http\Resources\InvitadoCollection;
use App\Http\Resources\InvitadoResource;
use App\Models\Invitado;
use Illuminate\Http\Request;

class InvitadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Invitado::all()->toResourceCollection();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvitadoRequest $request)
    {
        $invitado  = new Invitado();
        $validated = $request->validated();

        $invitado->boda_id = $validated['boda_id'];
        $invitado->user_id = $validated['user_id'];

        if (!$invitado->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No se ha podido ingresar el invitado'
            ], 401);
        }

        return response()->json(
            new InvitadoResource($invitado),
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invitado = Invitado::findOrFail($id);

        if (!$invitado) {
            return response()->json([
                'status' => 'error',
                'message' => 'No se ha encontrado ese invitado'
            ], 401);
        };

        return response()->json(new InvitadoResource($invitado), 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(InvitadoRequest $request, string $id)
    {
        $invitado  = Invitado::findOrFail($id);
        $validated = $request->validated();

        $invitado->boda_id = $validated['boda_id'];
        $invitado->user_id = $validated['user_id'];

        if (!$invitado->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No se ha podido actualizar el invitado'
            ], 401);
        }

        return response()->json(new InvitadoResource($invitado), 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $invitado = Invitado::findOrFail($id);
        $invitado->delete();

        return response()->json([
            'status' => 'error',
            'message' => 'No se eliminado el invitado correctamente'
        ], 400);
    }
}