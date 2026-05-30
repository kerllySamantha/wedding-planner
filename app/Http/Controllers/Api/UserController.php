<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $users = User::select('users.*')
        ->join('model_has_roles as mhr', 'users.id', '=', 'mhr.model_id')
        ->join('roles', 'roles.id', '=', 'mhr.role_id')
        ->where('mhr.model_type', User::class)
        ->with('roles')
        ->orderBy('roles.name')
        ->distinct()
        ->paginate(10);

    return UserResource::collection($users);
}
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {

        $validated = $request->validated();
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
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
   public function update(UpdateUserRequest $request, string $id)
{
    $user = User::findOrFail($id);

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    if ($request->hasFile('fotoPerfil')) {
        if ($user->fotoPerfil) {
            Storage::disk('public')->delete($user->fotoPerfil);
        }

        $user->fotoPerfil = $request->file('fotoPerfil')
            ->store('imagenes/usuarios', 'public');
    }

    $user->syncRoles([$request->rol]);

    if (!$user->save()) {
        return response()->json([
            'message' => 'No se ha podido modificar el usuario',
            'status' => 'error'
        ], 400);
    }

    return response()->json([
        'status' => 'success',
        'data' => $user,
        'message' => 'Se ha modificado el usuario correctamente'
    ], 200);
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