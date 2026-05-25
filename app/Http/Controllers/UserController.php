<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Perfil usuario autenticado
     */
    public function profile()
    {
        /** @var \User $user */
        $user = Auth::user();

        return view(
            'admin.users.profile',
            compact('user')
        );
    }

    /**
     * Actualizar perfil
     */
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([

            'name' => 'required|string|max:255',

            'email' => 'required|email|max:255|unique:users,email,' . $user->id,

            'avatar' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif|max:10240',

            'password' => [
                'nullable',
                'string',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],

        ]);

        $data = [

            'name' => $validated['name'],

            'email' => $validated['email'],

        ];

        if ($request->hasFile('avatar')) {

            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {

                Storage::disk('public')->delete($user->avatar);
            }

            $data['avatar'] = $request
                ->file('avatar')
                ->store('avatars', 'public');
        }
        if (!empty($validated['password'])) {

            $data['password'] = Hash::make($validated['password']);
        }


        $user->update($data);

        return redirect()
            ->route('admin.profile')
            ->with(
                'success',
                'Perfil actualizado correctamente'
            );
    }

    /**
     * Listado usuarios
     */
    public function index()
    {
        $users = User::query()
            ->where('id', '!=', '1')
            ->latest()
            ->paginate(15);

        return view(
            'admin.users.index',
            compact('users')
        );
    }

    /**
     * Crear
     */
    public function create()
    {
        $roles = Role::all();

        return view(
            'admin.users.edit',
            compact('roles')
        );
    }

    /**
     * Guardar
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => 'required|string|max:255',

            'email' => 'required|email|max:255|unique:users,email',

            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],

            'role' => 'required|exists:roles,name',

        ]);

        $user = User::create([

            'name' => $validated['name'],

            'email' => $validated['email'],

            'password' => Hash::make($validated['password']),

            'is_active' => $request->boolean('is_active'),

        ]);

        $user->assignRole(
            $validated['role']
        );

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'Usuario creado correctamente'
            );
    }

    /**
     * Editar
     */
    public function edit(User $user)
    {
        $authUser = Auth::user();

        if (
            $user->hasRole('admin') &&
            $authUser->id !== 1
        ) {
            abort(403);
        }

        $roles = Role::all();

        return view(
            'admin.users.edit',
            compact(
                'user',
                'roles'
            )
        );
    }

    /**
     * Actualizar
     */
    public function update(Request $request, User $user)
    {
        $authUser = Auth::user();

        if (
            $user->hasRole('admin') &&
            $authUser->id !== 1
        ) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'email' => 'required|email|max:255|unique:users,email,' . $user->id,

            'password' => [
                'nullable',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],

            'role' => 'required|exists:roles,name',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'is_active' => $request->boolean('is_active'),
        ]);

        if (!empty($validated['password'])) {

            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        $user->syncRoles([
            $validated['role']
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'Usuario actualizado correctamente'
            );
    }
}