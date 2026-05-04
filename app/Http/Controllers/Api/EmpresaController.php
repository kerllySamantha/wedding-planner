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
                            ->map(fn($foto) => $foto->store('fotos', 'public'))
                            ->toArray()
                    );
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

                // 1. Actualizar usuario
                $user = $empresa->usuario;
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

                // 2. Manejar logo
                if ($request->hasFile('logo')) {
                    if ($empresa->logo) {
                        Storage::disk('public')->delete($empresa->logo);
                    }
                    $validated['logo'] = $request->file('logo')
                        ->store('logos', 'public');
                }

                // 3. Actualizar datos de la empresa
                $empresaData = Arr::only($validated, [
                    'nombre_empresa',
                    'direccion',
                    'telefono',
                    'descripcion',
                    'logo',
                    'tipo_servicio',
                    'poblacion_id',
                ]);

                // ✅ BUG FIX: fotos debe añadirse ANTES de llamar a $empresa->update()
                if (array_key_exists('fotos', $validated)) {
                    $empresaData['fotos'] = json_encode($validated['fotos'] ?? []);
                }

                if (!empty($empresaData)) {
                    $empresa->update($empresaData);
                }

                // 4. Manejar productos
                if (array_key_exists('productos', $validated) && !empty($validated['productos'])) {

                    $tipoProductoEmpresaId = $empresa->productos()
                        ->whereNotNull('tipo_producto_id')
                        ->value('tipo_producto_id');

                    foreach ($validated['productos'] as $index => $productoData) {

                        // Saltar si faltan campos clave
                        if (
                            empty($productoData['categoria_nombre']) ||
                            empty($productoData['tipo_producto_nombre']) ||
                            empty($productoData['nombre'])
                        ) {
                            continue;
                        }

                        // 4.1 Buscar categoría
                        $categoria = Categoria::where('nombre', $productoData['categoria_nombre'])->first();
                        if (!$categoria) {
                            throw new \Exception("Categoría '{$productoData['categoria_nombre']}' no encontrada.");
                        }

                        // 4.2 Buscar tipoProducto
                        $tipoProducto = TipoProducto::where([
                            'nombre' => $productoData['tipo_producto_nombre'],
                            'categoria_id' => $categoria->id,
                        ])->first();
                        if (!$tipoProducto) {
                            throw new \Exception("Tipo de producto '{$productoData['tipo_producto_nombre']}' no encontrado.");
                        }

                        // 4.3 Una empresa = un único tipo de producto
                        if ($tipoProductoEmpresaId !== null && $tipoProductoEmpresaId !== $tipoProducto->id) {
                            throw new \Exception('La empresa solo puede tener productos de un único tipo de producto.');
                        }

                        // 4.4 Crear o actualizar producto
                        $payloadProducto = [
                            'nombre' => $productoData['nombre'],
                            'descripcion' => $productoData['descripcion'] ?? null,
                            'precio_min' => $productoData['precio_min'] ?? null,
                            'precio_max' => $productoData['precio_max'] ?? null,
                            'tipo_producto_id' => $tipoProducto->id,
                        ];

                        if (!empty($productoData['id'])) {
                            $actualizado = $empresa->productos()
                                ->where('id', $productoData['id'])
                                ->update($payloadProducto);

                            if ($actualizado === 0) {
                                throw new \Exception("El producto ID {$productoData['id']} no pertenece a esta empresa.");
                            }
                        } else {
                            $empresa->productos()->create($payloadProducto);
                        }

                        $tipoProductoEmpresaId = $tipoProducto->id;
                    }
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'Empresa actualizada correctamente',
                    'data' => new EmpresaResource(
                        $empresa->fresh()->load(['usuario', 'productos.tipoProducto.categoria', 'poblacion.provincia'])
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