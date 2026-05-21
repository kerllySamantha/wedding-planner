<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

          /** @var \App\Models\User|null $usuario    */
            $usuario = Auth::user();

        $token = $usuario->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Usuario encontrado correctamente',
            'user' => $usuario,
            'token' => $token, 
            'data' => [
                'id' => $usuario->id,
                'name' => $usuario->name,
                'email' => $usuario->email,
                'rol' => $usuario->getRoleNames()->first(),
            ]
        ], 200);
        }

        // Credenciales incorrectas
        return response()->json([
            'message' => 'Usuario o contraseña incorrectos'
        ], 401);
    }

        public function logout(Request $request)
        {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Sesión cerrada'], 200);
        }
}
