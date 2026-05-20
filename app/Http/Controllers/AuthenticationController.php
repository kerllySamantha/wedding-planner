<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest as AuthLoginRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function showLogin()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (Auth::check()) {

            // Solo admins pueden acceder
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }

            // Cierra sesión si no es admin
            Auth::logout();

            return redirect()
                ->route('login')
                ->with('error', 'No tienes permisos para acceder al panel de administración.');
        }

        return view('auth.login');
    }
    public function login(AuthLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        // $credentials['active'] = 1;

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }
        return back()
            ->withErrors([
                'auth' => 'Credenciales incorrectas o usuario inactivo.',
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // public function store(CreateUserRequest $request)
    // {
    //     $data = $request->validated();
    //     $data['password'] = Hash::make($data['password']);

    //     User::create($data);

    //     return redirect()->route('admin.users.index')->with('success', 'Usuario creado correctamente');
    // }

    // public function create()
    // {
    //     return view('auth.create');
    // }
}
