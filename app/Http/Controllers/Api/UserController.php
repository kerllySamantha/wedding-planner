<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::paginate(10);
        return new UserCollection($usuarios);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {

        $validated = $request->validated();
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);
        $user->assignRole($validated['rol']);

        if (!$user->save()) { {
                return response()->json([
                    'message' => 'No se ha podido insertar un usuario',
                    'status' => 'error'
                ], 400);
            }
        }
        return response()->json([
            'status' => 'success',
            'data' => new UserResource($user),
            'message' => 'Se ha insertado un nuevo usuario correctamente'
        ], 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        $userR = new UserResource($user);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Usuario encontrado correctamente',
            'data' => $userR
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;

        if (!$user->save()) { {
                return response()->json([
                    'message' => 'No se ha podido modificar un usuario',
                    'status' => 'error'
                ], 400);
            }
            return response()->json([
                'status' => 'success',
                'data' => $user,
                'message' => 'Se ha modificado el usuario correctamente'
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'datos eliminados correctamente',

        ], 200);
    }
}