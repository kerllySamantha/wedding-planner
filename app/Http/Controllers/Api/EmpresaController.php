<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEmpresaRequest;
use App\Http\Requests\EmpresaRequest;
use App\Http\Resources\EmpresaCollection;
use App\Http\Resources\EmpresaResource;
use App\Http\Resources\ProductoResource;
use App\Models\Categoria;
use App\Models\Empresa;
use App\Models\TipoProducto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::with(['usuario', 'productos.tipoProducto.categoria'])
            ->withAvg('resenias', 'puntuacion')
            ->withCount('resenias')
            ->orderBy('nombre_empresa')
            ->paginate(10);

        return new EmpresaCollection($empresas);
    }
    public function store(EmpresaRequest $request)
    {
        $validated = $request->validated();

        try {
            return DB::transaction(function () use ($validated, $request) {

                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => bcrypt($validated['password']),
                ]);

                $user->assignRole($validated['rol']);

                if ($request->hasFile('logo')) {
                    $validated['logo'] = $request->file('logo')
                        ->store('logos', 'public');
                }

                if ($request->hasFile('fotos')) {
                    $validated['fotos'] = json_encode(
                        collect($request->file('fotos'))
                            ->values()
                            ->map(function ($foto, $index) use ($user) {
                                $numero = $index + 1;
                                $extension = $foto->getClientOriginalExtension();

                                $path = $foto->storeAs(
                                    "imagenes/empresa_{$user->id}",
                                    "imagen_{$numero}.{$extension}",
                                    'public'
                                );

                                return [
                                    'path' => $path,
                                    'url' => asset("storage/{$path}"),
                                ];
                            })
                            ->toArray()
                    );
                }

                if (isset($validated['fotos'])) {
                    $validated['fotos'] = json_encode($validated['fotos']);
                }

                $empresa = $user->empresa()->create(
                    Arr::except($validated, ['name', 'email', 'password', 'rol'])
                );

                return response()->json([
                    'status' => 'success',
                    'message' => 'Empresa creada correctamente',
                    'data' => new EmpresaResource(
                        $empresa->load(['usuario', 'productos.tipoProducto.categoria'])
                    ),
                ], 201);
            });

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al crear la empresa',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function show(Empresa $empresa)
    {
        $empresa->load(['productos.tipoProducto.categoria', 'poblacion.provincia', 'usuario', 'resenias'])
            ->loadAvg('resenias', 'puntuacion')
            ->loadCount('resenias');

        return new EmpresaResource($empresa);
    }

    public function update(UpdateEmpresaRequest $request, Empresa $empresa)
    {
        $validated = $request->validated();

        try {
            return DB::transaction(function () use ($validated, $request, $empresa) {

                // 1. Usuario
                $this->updateUser($empresa->usuario, $validated);

                // 2. Logo e Información de Empresa
                $this->updateEmpresaData($empresa, $request, $validated);

                // 3. Productos
                $this->handleProductos($empresa, $validated);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Empresa actualizada correctamente',
                    'data' => new EmpresaResource(
                        $empresa->fresh()->load([
                            'usuario',
                            'productos.tipoProducto.categoria',
                            'poblacion.provincia',
                        ])
                    ),
                ], 200);
            });
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al actualizar la empresa',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    private function updateUser(User $user , array $validated): void
    {
        $userData = Arr::only($validated, ['name', 'email']);

        if (!empty($validated['password'])) {
            $userData['password'] = bcrypt($validated['password']);
        }

        if (!empty($userData)) {
            $user->update($userData);
        }

        if (!empty($validated['rol'])) {
            $user->syncRoles([$validated['rol']]);
        }
    }


    private function updateEmpresaData(Empresa $empresa, UpdateEmpresaRequest $request, array $validated): void
    {
        if ($request->hasFile('logo')) {
            if ($empresa->logo) {
                Storage::disk('public')->delete($empresa->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $empresaData = Arr::only($validated, [
            'nombre_empresa',
            'direccion',
            'telefono',
            'descripcion',
            'logo',
            'tipo_servicio',
            'poblacion_id'
        ]);

        if (array_key_exists('fotos', $validated)) {
            $empresaData['fotos'] = json_encode($validated['fotos'] ?? []);
        }

        $empresa->update($empresaData);
    }


    private function handleProductos(Empresa $empresa, array $validated): void
    {
        if (!empty($validated['productos_eliminados'])) {
            $empresa->productos()->whereIn('id', $validated['productos_eliminados'])->delete();
        }

        foreach ($validated['productos'] as $productoData) {
            $precioMin = $productoData['precio_min'] ?? null;
            $precioMax = $productoData['precio_max'] ?? null;

            if ($precioMin !== null && $precioMax !== null && (float) $precioMin > (float) $precioMax) {
                throw new \InvalidArgumentException('precio_min no puede ser mayor que precio_max.');
            }

            $categoria = Categoria::where('nombre', $productoData['categoria_nombre'])->first();
            if (!$categoria) {
                throw new \InvalidArgumentException('La categoría indicada no existe.');
            }

            $tipoProducto = TipoProducto::where('nombre', $productoData['tipo_producto_nombre'])
                ->where('categoria_id', $categoria->id)
                ->first();

            if (!$tipoProducto) {
                throw new \InvalidArgumentException('El tipo de producto indicado no existe para la categoría seleccionada.');
            }

            $payloadProducto = [
                'nombre' => $productoData['nombre'],
                'descripcion' => $productoData['descripcion'] ?? null,
                'precio_min' => $precioMin,
                'precio_max' => $precioMax,
                'tipo_producto_id' => $tipoProducto->id,
            ];

            if (!empty($productoData['id'])) {
                $producto = $empresa->productos()->where('id', $productoData['id'])->first();

                if (!$producto) {
                    throw new \InvalidArgumentException('No puedes actualizar un producto que no pertenece a esta empresa.');
                }

                $producto->update($payloadProducto);
                continue;
            }

            $empresa->productos()->create($payloadProducto);
        }
    }

    public function destroy(Empresa $empresa)
    {
        $user = $empresa->usuario;
        $empresa->delete();
        $user?->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Empresa eliminada correctamente',
        ], 200);
    }

    public function getEmpresaPorUsuario(User $user)
    {
        $empresa = Empresa::where('user_id', $user->id)
            ->with(['productos.tipoProducto.categoria', 'poblacion.provincia'])
            ->firstOrFail();

        return new EmpresaResource($empresa);
    }

    public function productos(Empresa $empresa)
    {
        $productos = $empresa->productos()
            ->with(['tipoProducto.categoria'])
            ->latest()
            ->paginate(10);

        return ProductoResource::collection($productos);
    }
}