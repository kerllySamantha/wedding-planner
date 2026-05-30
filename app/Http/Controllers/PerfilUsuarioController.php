<?php

namespace App\Http\Controllers;

use App\Models\Boda;
use App\Models\PerfilUsuario;
use App\Models\Poblacion;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PerfilUsuarioController extends Controller
{
    public function index(): View
    {
        $perfiles = PerfilUsuario::with(['user', 'poblacion.provincia'])
            ->latest()
            ->paginate(12);

        return view('admin.PerfilUsuario.index', compact('perfiles'));
    }

    public function create(): View
    {
        return view('admin.PerfilUsuario.form', [
            'perfilUsuario' => new PerfilUsuario(),
            'poblaciones' => $this->getPoblaciones(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        DB::transaction(function () use ($request, $validated): void {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            if ($request->hasFile('fotoPerfil')) {
                $path = $request->file('fotoPerfil')->store('perfiles', 'public');
                $user->fotoPerfil = $path;
                $user->save();
            }

            $user->assignRole('usuario');

            $perfil = PerfilUsuario::create([
                'usuario_id' => $user->id,
                'direccion' => $validated['direccion'],
                'telefono' => $validated['telefono'],
                'poblacion_id' => $validated['poblacion_id'],
                'fecha_boda' => $validated['fecha_boda'],
            ]);

            $this->syncBoda($user, $perfil);
        });

        return redirect()
            ->route('admin.perfiles-usuario.index')
            ->with('success', 'Perfil de usuario creado correctamente.');
    }

    public function show(PerfilUsuario $perfilUsuario): View
    {
        $perfilUsuario->load(['user', 'poblacion.provincia']);

        return view('admin.PerfilUsuario.show', compact('perfilUsuario'));
    }

    public function edit(PerfilUsuario $perfilUsuario): View
    {
        $perfilUsuario->load(['user', 'poblacion.provincia']);

        return view('admin.PerfilUsuario.form', [
            'perfilUsuario' => $perfilUsuario,
            'poblaciones' => $this->getPoblaciones(),
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, PerfilUsuario $perfilUsuario): RedirectResponse
    {
        $perfilUsuario->load('user');

        $validated = $request->validate(
            $this->rules($perfilUsuario->id, $perfilUsuario->usuario_id)
        );

        DB::transaction(function () use ($request, $perfilUsuario, $validated): void {
            $perfilUsuario->user?->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            if (! empty($validated['password'])) {
                $perfilUsuario->user?->update([
                    'password' => Hash::make($validated['password']),
                ]);
            }

            if ($request->hasFile('fotoPerfil')) {
                if ($perfilUsuario->user?->fotoPerfil) {
                    Storage::disk('public')->delete($perfilUsuario->user->fotoPerfil);
                }
                $path = $request->file('fotoPerfil')->store('perfiles', 'public');
                $perfilUsuario->user?->update(['fotoPerfil' => $path]);
            }

            $perfilUsuario->user?->syncRoles(['usuario']);

            $perfilUsuario->update([
                'direccion' => $validated['direccion'],
                'telefono' => $validated['telefono'],
                'poblacion_id' => $validated['poblacion_id'],
                'fecha_boda' => $validated['fecha_boda'],
            ]);

            if ($perfilUsuario->user) {
                $this->syncBoda($perfilUsuario->user, $perfilUsuario->fresh());
            }
        });

        return redirect()
            ->route('admin.perfiles-usuario.index')
            ->with('success', 'Perfil de usuario actualizado correctamente.');
    }

    public function destroy(PerfilUsuario $perfilUsuario): RedirectResponse
    {
        $boda = Boda::where('usuario_id', $perfilUsuario->usuario_id)->first();

        if ($boda && ($boda->reservas()->exists() || $boda->presupuesto()->exists())) {
            return redirect()
                ->route('admin.perfiles-usuario.index')
                ->with('error', 'No se puede eliminar el perfil porque la boda asociada tiene reservas o presupuestos.');
        }

        $boda?->delete();
        $perfilUsuario->delete();

        return redirect()
            ->route('admin.perfiles-usuario.index')
            ->with('success', 'Perfil de usuario eliminado correctamente.');
    }

    private function rules(?int $perfilId = null, ?int $userId = null): array
    {
        $passwordRules = $perfilId === null
            ? ['required', 'string', 'confirmed', 'min:8']
            : ['nullable', 'string', 'confirmed', 'min:8'];

        return [
            'name' => ['required', 'string', 'max:255'],
            'fotoPerfil' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'password' => $passwordRules,
            'direccion' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:20'],
            'poblacion_id' => ['required', 'exists:poblaciones,id'],
            'fecha_boda' => ['required', 'date'],
        ];
    }

    private function getPoblaciones()
    {
        return Poblacion::with('provincia')
            ->orderBy('nombre')
            ->get();
    }

    private function syncBoda(User $user, PerfilUsuario $perfil): void
    {
        Boda::updateOrCreate(
            ['usuario_id' => $user->id],
            [
                'nombre_pareja' => $user->name,
                'fecha_boda' => $perfil->fecha_boda,
                'ubicacion' => $perfil->direccion,
                'poblacion_id' => $perfil->poblacion_id,
            ]
        );
    }
}
