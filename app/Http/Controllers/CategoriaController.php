<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaRequest;
use App\Models\Categoria;
use App\Models\TipoProducto;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    public function index(): View
    {
        $categorias = Categoria::query()
            ->withCount(['tipoProducto as tipos_count'])
            ->orderBy('nombre')
            ->paginate(8);

        return view('admin.categoria.index', [
            'categorias' => $categorias,
            'totals' => [
                'categorias' => Categoria::count(),
                'conTipos' => Categoria::has('tipoProducto')->count(),
                'tipos' => TipoProducto::count(),
            ],
        ]);
    }

    public function create(): View
    {
        return view('admin.categoria.create', [
            'categoria' => new Categoria(),
            'isEdit' => false,
        ]);
    }

    public function store(CategoriaRequest $request): RedirectResponse
    {
        Categoria::create($request->validated());

        return redirect()
            ->route('admin.categorias.index')
            ->with('success', 'Categoria creada correctamente.');
    }

    public function show(Categoria $categoria): View
    {
        $categoria->load([
            'tipoProducto' => fn ($query) => $query
                ->withCount(['productos', 'presupuestos'])
                ->orderBy('nombre'),
        ])->loadCount(['tipoProducto as tipos_count']);

        return view('admin.categoria.show', compact('categoria'));
    }

    public function edit(Categoria $categoria): View
    {
        return view('admin.categoria.edit', [
            'categoria' => $categoria,
            'isEdit' => true,
        ]);
    }

    public function update(CategoriaRequest $request, Categoria $categoria): RedirectResponse
    {
        $categoria->update($request->validated());

        return redirect()
            ->route('admin.categorias.index')
            ->with('success', 'Categoria actualizada correctamente.');
    }

    public function destroy(Categoria $categoria): RedirectResponse
    {
        if ($categoria->tipoProducto()->exists()) {
            return redirect()
                ->route('admin.categorias.index')
                ->with('error', 'No se puede eliminar una categoria que ya tiene tipos de producto asociados.');
        }

        $categoria->delete();

        return redirect()
            ->route('admin.categorias.index')
            ->with('success', 'Categoria eliminada correctamente.');
    }
}
