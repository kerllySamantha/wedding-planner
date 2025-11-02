<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PerfilUsuarioRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\PerfilUsuarioResource;
use App\Models\PerfilUsuario;
use App\Models\User;
use Illuminate\Http\Request;

class PerfilUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $perfiles = PerfilUsuario::paginate(2);
        return PerfilUsuario::all()->toResourceCollection();
    }

    /**
     * Show the form for creating a new resource.
     */

    public function store(PerfilUsuarioRequest $request)
    {
        // Validar los datos
        $validated = $request->validated();

        // Crear usuario
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        // Asignar rol
        $user->assignRole($validated['rol']);

        // Crear perfil
        $perfil = PerfilUsuario::create([
            'usuario_id' => $user->id,
            'direccion'  => $validated['direccion'],
            'telefono'   => $validated['telefono'],
        ]);

        return response()->json([
            'message' => 'Perfil creado correctamente',
            'status'  => 'success',
            'data'    => new PerfilUsuarioResource($perfil)
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)

    {
        $perfil = PerfilUsuario::findOrFail($id);
        if (!$perfil) {
            return response()->json([
                'status' => 'error',
                'message' => 'Perfil no encontrada'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Perfil encontrada correctamente',
            'data' => new PerfilUsuarioResource($perfil)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(PerfilUsuarioRequest $request, string $id)
    {
        $perfil = PerfilUsuario::findOrFail($id);

        $perfil->usuario_id   = $request->usuario_id;
        $perfil->direccion = $request->direccion;
        $perfil->telefono  = $request->telefono;

        if (!$perfil->save()) {
            return response()->json([
                'message' => 'No se ha podido actualizar el perfil',
                'status'  => 'error',
            ], 400);
        }

        return response()->json([
            'message' => 'Perfil actualizado correctamente',
            'status'  => 'success',
            'data'    => $perfil
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $perfil = PerfilUsuario::findOrFail($id);
        $perfil->delete();

        return response()->json([
            'success' => 'Perfil eliminado correctamente'
        ], 200);
    }

    public function getPerfilByUserId($usuarioId)
    {
        $perfil = PerfilUsuario::with('user')
            ->where('usuario_id', $usuarioId)
            ->first();

        if (!$perfil) {
            return response()->json(['data' => null, 'message' => 'No se encontró perfil'], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Boda encontrada correctamente',
            'data' => new PerfilUsuarioResource($perfil)
        ]);;
    }
}