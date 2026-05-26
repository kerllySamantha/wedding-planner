<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\PerfilUsuario;
use App\Models\Producto;
use App\Models\TipoProducto;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'empresas' => Empresa::count(),
            'tiposProducto' => TipoProducto::count(),
            'perfilesUsuario' => PerfilUsuario::count(),
            'productos' => Producto::count(),
        ];

        $ultimasEmpresas = Empresa::with('usuario')
            ->latest()
            ->take(5)
            ->get();

        $ultimosPerfiles = PerfilUsuario::with('user')
            ->latest()
            ->take(5)
            ->get();

        $usuariosPorRol = DB::table('roles')
            ->leftJoin('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('roles.name as rol', DB::raw('COUNT(model_has_roles.model_id) as total'))
            ->groupBy('roles.id', 'roles.name')
            ->get();

        $serviciosPorCategoria = DB::table('categorias')
            ->leftJoin('tipo_productos', 'categorias.id', '=', 'tipo_productos.categoria_id')
            ->leftJoin('productos', 'tipo_productos.id', '=', 'productos.tipo_producto_id')
            ->select('categorias.nombre', DB::raw('COUNT(productos.id) as total'))
            ->groupBy('categorias.id', 'categorias.nombre')
            ->get();

        $altasUsuariosPorMes = User::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as mes"),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $altasServiciosPorMes = Producto::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as mes"),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $topCategorias = $serviciosPorCategoria
            ->sortByDesc('total')
            ->take(5)
            ->values();

        return view('admin.dashboard', compact(
            'stats',
            'ultimasEmpresas',
            'ultimosPerfiles',
            'usuariosPorRol',
            'serviciosPorCategoria',
            'altasUsuariosPorMes',
            'altasServiciosPorMes',
            'topCategorias'
        ));
    }
}