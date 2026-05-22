<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Poblacion;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EmpresaController extends Controller
{
    public function index(): View
    {
        $empresas = Empresa::with(['usuario', 'poblacion.provincia'])
            ->withCount('productos')
            ->orderBy('nombre_empresa')
            ->paginate(12);

        return view('admin.Empresa.index', compact('empresas'));
    }

    public function create(): View
    {
        return view('admin.Empresa.form', [
            'empresa' => new Empresa(),
            'poblaciones' => $this->getPoblaciones(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules(), $this->messages());

        DB::transaction(function () use ($request, $validated): void {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $user->assignRole('empresa');

            $payload = $this->empresaPayload($request, $validated, $user->id);
            $payload['user_id'] = $user->id;

            Empresa::create($payload);
        });

        return redirect()
            ->route('admin.empresas.index')
            ->with('success', 'Empresa creada correctamente.');
    }

    public function show(Empresa $empresa): View
    {
        $empresa->load(['usuario', 'poblacion.provincia'])
            ->loadCount(['productos', 'reservas', 'pedirPresupuestos']);

        return view('admin.Empresa.show', compact('empresa'));
    }

    public function edit(Empresa $empresa): View
    {
        $empresa->load(['usuario', 'poblacion.provincia']);

        return view('admin.Empresa.form', [
            'empresa' => $empresa,
            'poblaciones' => $this->getPoblaciones(),
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, Empresa $empresa): RedirectResponse
    {
        $empresa->load('usuario');

        $validated = $request->validate(
            $this->rules($empresa->id, $empresa->user_id),
            $this->messages()
        );

        DB::transaction(function () use ($empresa, $request, $validated): void {
            $empresa->usuario?->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            if (! empty($validated['password'])) {
                $empresa->usuario?->update([
                    'password' => Hash::make($validated['password']),
                ]);
            }

            $empresa->usuario?->syncRoles(['empresa']);

            $payload = $this->empresaPayload(
                $request,
                $validated,
                $empresa->user_id,
                $empresa
            );

            $empresa->update($payload);
        });

        return redirect()
            ->route('admin.empresas.index')
            ->with('success', 'Empresa actualizada correctamente.');
    }

    public function destroy(Empresa $empresa): RedirectResponse
    {
        if ($empresa->reservas()->exists() || $empresa->pedirPresupuestos()->exists()) {
            return redirect()
                ->route('admin.empresas.index')
                ->with('error', 'No se puede eliminar una empresa con reservas o solicitudes de presupuesto asociadas.');
        }

        DB::transaction(function () use ($empresa): void {
            $this->deleteEmpresaFiles($empresa);
            $empresa->productos()->delete();

            $user = $empresa->usuario;
            $empresa->delete();
            $user?->delete();
        });

        return redirect()
            ->route('admin.empresas.index')
            ->with('success', 'Empresa eliminada correctamente.');
    }

    public function destroyFoto(Empresa $empresa, int $fotoIndex): RedirectResponse
    {
        $fotos = $this->parseFotos($empresa->fotos);

        if (! array_key_exists($fotoIndex, $fotos)) {
            return redirect()->back()->with('error', 'Foto no encontrada.');
        }

        $foto = $fotos[$fotoIndex];
        $path = is_array($foto) ? ($foto['path'] ?? null) : $foto;

        if ($path) {
            Storage::disk('public')->delete($path);
        }

        array_splice($fotos, $fotoIndex, 1);
        $empresa->update(['fotos' => array_values($fotos)]);

        return redirect()->back()->with('success', 'Foto eliminada correctamente.');
    }

    private function rules(?int $empresaId = null, ?int $userId = null): array
    {
        $passwordRules = $empresaId === null
            ? ['required', 'string', 'confirmed', 'min:8']
            : ['nullable', 'string', 'confirmed', 'min:8'];

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'password' => $passwordRules,
            'nombre_empresa' => ['required', 'string', 'max:255'],
            'direccion' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:20'],
            'descripcion' => ['nullable', 'string'],
            'tipo_servicio' => ['required', 'string', 'max:255'],
            'poblacion_id' => ['required', 'exists:poblaciones,id'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'fotos' => ['nullable', 'array'],
            'fotos.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ];
    }

    private function messages(): array
    {
        return [
            'logo.image'    => 'El logo debe ser una imagen.',
            'logo.mimes'    => 'El logo solo puede ser JPG, JPEG, PNG o WEBP.',
            'logo.max'      => 'El logo no puede superar los 2 MB.',
            'fotos.*.image' => 'Cada foto debe ser una imagen válida.',
            'fotos.*.mimes' => 'Las fotos solo pueden ser JPG, JPEG, PNG o WEBP.',
            'fotos.*.max'   => 'Cada foto no puede superar los 3 MB.',
        ];
    }

    private function getPoblaciones()
    {
        return Poblacion::with('provincia')
            ->orderBy('nombre')
            ->get();
    }

    private function empresaPayload(
        Request $request,
        array $validated,
        int $userId,
        ?Empresa $empresa = null
    ): array {
        $payload = [
            'nombre_empresa' => $validated['nombre_empresa'],
            'direccion' => $validated['direccion'],
            'telefono' => $validated['telefono'],
            'descripcion' => $validated['descripcion'] ?? null,
            'tipo_servicio' => $validated['tipo_servicio'],
            'poblacion_id' => $validated['poblacion_id'],
        ];

        if ($request->hasFile('logo')) {
            if ($empresa?->logo) {
                Storage::disk('public')->delete($empresa->logo);
            }

            $payload['logo'] = $request->file('logo')->store('logos', 'public');
        } elseif ($empresa !== null) {
            $payload['logo'] = $empresa->logo;
        }

        if ($request->hasFile('fotos')) {
            $existingFotos = $this->parseFotos($empresa?->fotos);
            $existingCount = count($existingFotos);

            $newFotos = collect($request->file('fotos'))
                ->values()
                ->map(function ($foto, int $index) use ($userId, $existingCount): array {
                    $extension = $foto->getClientOriginalExtension();
                    $filename = 'imagen_' . ($existingCount + $index + 1) . '_' . uniqid() . '.' . $extension;
                    $path = $foto->storeAs(
                        "imagenes/empresa_{$userId}",
                        $filename,
                        'public'
                    );

                    return [
                        'path' => $path,
                        'url' => asset('storage/' . $path),
                    ];
                })
                ->all();

            $payload['fotos'] = array_merge($existingFotos, $newFotos);
        } elseif ($empresa !== null) {
            $payload['fotos'] = $empresa->fotos;
        }

        return $payload;
    }

    private function parseFotos(mixed $fotos): array
    {
        if (is_array($fotos)) {
            return $fotos;
        }

        if (is_string($fotos)) {
            $decoded = json_decode($fotos, true);
            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    private function deleteEmpresaFiles(Empresa $empresa): void
    {
        if ($empresa->logo) {
            Storage::disk('public')->delete($empresa->logo);
        }

        $this->deleteGalleryFiles($empresa);
    }

    private function deleteGalleryFiles(Empresa $empresa): void
    {
        $fotos = $this->parseFotos($empresa->fotos);

        foreach ($fotos as $foto) {
            $path = is_array($foto) ? ($foto['path'] ?? null) : $foto;

            if ($path) {
                Storage::disk('public')->delete($path);
            }
        }
    }
}
