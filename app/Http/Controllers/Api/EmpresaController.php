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
use App\Models\Producto;
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
            ->paginate(8);

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

                if (!empty($validated['fotoPerfil'])) {
                    $user->update(['fotoPerfil' => $validated['fotoPerfil']]);
                }

                // logo and fotos arrive as strings/arrays pre-uploaded via SubirImagenController
                $empresa = $user->empresa()->create(
                    Arr::except($validated, ['name', 'email', 'password', 'rol', 'fotoPerfil'])
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

                // 2. Usuario
                $this->updateUser($empresa->usuario, $validated);

                // 3. Logo e Información de Empresa
                $this->updateEmpresaData($empresa, $validated);

                // 4. Productos (solo si se envían en el request)
                if (array_key_exists('productos', $validated) || array_key_exists('productos_eliminados', $validated)) {
                    $this->handleProductos($empresa, $validated);
                }

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

    private function updateUser(User $user, array $validated): void
    {
        $userData = Arr::only($validated, ['name', 'email', 'fotoPerfil']);

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


    private function updateEmpresaData(Empresa $empresa, array $validated): void
    {
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
            $empresaData['fotos'] = $validated['fotos'] ?? [];
        }

        $empresa->update($empresaData);
    }


    private function handleProductos(Empresa $empresa, array $validated): void
    {
        $productosEliminados = collect($validated['productos_eliminados'] ?? [])
            ->map(fn ($id) => (int) $id)
            ->all();

        if (empty($validated['productos'])) {
            if (!empty($productosEliminados)) {
                $empresa->productos()->whereIn('id', $productosEliminados)->delete();
            }
            return;
        }

        foreach ($validated['productos'] as $productoData) {
            $productoId = !empty($productoData['id']) ? (int) $productoData['id'] : null;

            if ($productoId !== null && in_array($productoId, $productosEliminados, true)) {
                continue;
            }

            $precioMin = $productoData['precio_min'] ?? null;
            $precioMax = $productoData['precio_max'] ?? null;

            if ($precioMin !== null && $precioMax !== null && (float) $precioMin > (float) $precioMax) {
                throw new \InvalidArgumentException('precio_min no puede ser mayor que precio_max.');
            }

            $tipoProducto = null;
            if (!empty($productoData['tipo_producto_id'])) {
                $tipoProducto = TipoProducto::find((int) $productoData['tipo_producto_id']);
            } else {
                $categoria = Categoria::where('nombre', $productoData['categoria_nombre'])->first();
                if (!$categoria) {
                    throw new \InvalidArgumentException('La categoría indicada no existe.');
                }

                $tipoProducto = TipoProducto::where('nombre', $productoData['tipo_producto_nombre'])
                    ->where('categoria_id', $categoria->id)
                    ->first();
            }

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

            if ($productoId !== null) {
                $producto = $empresa->productos()->where('id', $productoId)->first();

                if ($producto) {
                    $producto->update($payloadProducto);
                    continue;
                }

                $productoSistema = Producto::query()
                    ->where('id', $productoId)
                    ->whereNull('empresa_id')
                    ->exists();

                if (!$productoSistema) {
                    throw new \InvalidArgumentException('No puedes actualizar un producto que no pertenece a esta empresa.');
                }
            }

            $empresa->productos()->updateOrCreate(
                [
                    'nombre' => $payloadProducto['nombre'],
                    'tipo_producto_id' => $payloadProducto['tipo_producto_id'],
                ],
                $payloadProducto
            );
        }

        if (!empty($productosEliminados)) {
            $empresa->productos()->whereIn('id', $productosEliminados)->delete();
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

    public function estadisticas(string $id)
    {
        Empresa::findOrFail($id);
        $year = now()->year;

        // Reservas por estado (global)
        $reservasPorEstado = DB::table('reservas')
            ->where('empresa_id', $id)
            ->select('estado', DB::raw('COUNT(*) as total'))
            ->groupBy('estado')
            ->get();

        // Reservas por mes del año actual (12 meses completos)
        $rawPorMes = DB::table('reservas')
            ->where('empresa_id', $id)
            ->whereYear('fecha_inicio', $year)
            ->select(DB::raw("DATE_FORMAT(fecha_inicio, '%m') as mes"), DB::raw('COUNT(*) as total'))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->keyBy('mes');

        $reservasPorMes = collect(range(1, 12))->map(function ($m) use ($rawPorMes) {
            $key = str_pad($m, 2, '0', STR_PAD_LEFT);
            return ['mes' => $key, 'total' => $rawPorMes->get($key)?->total ?? 0];
        });

        // Top 5 productos con más reservas
        $topProductos = DB::table('productos')
            ->leftJoin('reservas', 'reservas.producto_id', '=', 'productos.id')
            ->where('productos.empresa_id', $id)
            ->select('productos.nombre', DB::raw('COUNT(reservas.id) as total'))
            ->groupBy('productos.id', 'productos.nombre')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Distribución de valoraciones 1–5 estrellas
        $rawValoraciones = DB::table('resenias')
            ->where('empresa_id', $id)
            ->whereNotNull('puntuacion')
            ->select(DB::raw('ROUND(puntuacion) as estrella'), DB::raw('COUNT(*) as total'))
            ->groupBy('estrella')
            ->get()
            ->keyBy('estrella');

        $distribucionValoraciones = collect(range(1, 5))->map(fn ($i) => [
            'estrella' => $i,
            'total'    => $rawValoraciones->get($i)?->total ?? 0,
        ]);

        $mediaValoracion = DB::table('resenias')
            ->where('empresa_id', $id)
            ->avg('puntuacion');

        return response()->json([
            'status' => 'success',
            'data' => [
                'reservasPorEstado'       => $reservasPorEstado,
                'reservasPorMes'          => $reservasPorMes,
                'topProductos'            => $topProductos,
                'distribucionValoraciones'=> $distribucionValoraciones,
                'mediaValoracion'         => round($mediaValoracion ?? 0, 1),
                'totalReservas'           => DB::table('reservas')->where('empresa_id', $id)->count(),
                'totalResenias'           => DB::table('resenias')->where('empresa_id', $id)->count(),
                'totalProductos'          => DB::table('productos')->where('empresa_id', $id)->count(),
            ],
        ]);
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
