<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PerfilUserUpdateRequest;
use App\Http\Requests\PerfilUsuarioRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\PerfilUsuarioResource;
use App\Models\Boda;
use App\Models\PerfilUsuario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $validated = $request->validated();

        $perfil = DB::transaction(function () use ($validated, $request) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
            ]);

            $user->assignRole($validated['rol']);

            $perfil = PerfilUsuario::create(
                ['usuario_id' => $user->id] + $request->only(['direccion', 'telefono', 'poblacion_id', 'fecha_boda'])
            );

            Boda::create([
                'usuario_id' => $user->id,
                'nombre_pareja' => $validated['name'],
                'fecha_boda' => $validated['fecha_boda'],
                'ubicacion' => $validated['direccion'],
                'poblacion_id' => $validated['poblacion_id'],
            ]);

            return $perfil;
        });

        return response()->json([
            'message' => 'Perfil creado correctamente',
            'status' => 'success',
            'data' => new PerfilUsuarioResource($perfil)
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
    public function update(PerfilUserUpdateRequest $request, string $id)
    {
        $perfil = PerfilUsuario::findOrFail($id);

        DB::transaction(function () use ($request, $perfil) {
            $user = User::findOrFail($perfil->usuario_id);

            $user->name  = $request->name;
            $user->email = $request->email;

            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }

            if ($request->filled('foto_perfil')) {
                $user->fotoPerfil = $request->input('foto_perfil');
            }

            $user->syncRoles([$request->rol]);
            $user->save();

            $perfil->direccion    = $request->direccion;
            $perfil->telefono     = $request->telefono;
            $perfil->poblacion_id = $request->poblacion_id;
            $perfil->save();
        });

        return response()->json([
            'message' => 'Perfil actualizado correctamente',
            'status' => 'success',
            'data' => new PerfilUsuarioResource($perfil->fresh()),
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

    public function getPerfilByUserId(string $usuarioId)
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
        ]);
        ;
    }
}