<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\ItemPresupuesto;
use App\Models\TipoProducto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TipoProductoController extends Controller
{
    public function index(): View
    {
        $tiposProducto = TipoProducto::with('categoria')
            ->withCount('productos')
            ->orderBy('nombre')
            ->paginate(15);

        return view('admin.tipoProducto.index', compact('tiposProducto'));
    }

    public function create(): View
    {
        return view('admin.tipoProducto.form', [
            'tipoProducto' => new TipoProducto(),
            'categorias' => $this->getCategorias(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        TipoProducto::create($validated);

        return redirect()
            ->route('admin.tipos-producto.index')
            ->with('success', 'Tipo de producto creado correctamente.');
    }

    public function show(TipoProducto $tipoProducto): View
    {
        $tipoProducto->load('categoria')
            ->loadCount(['productos', 'presupuestos']);

        return view('admin.tipoProducto.show', compact('tipoProducto'));
    }

    public function edit(TipoProducto $tipoProducto): View
    {
        $tipoProducto->load('categoria');

        return view('admin.tipoProducto.form', [
            'tipoProducto' => $tipoProducto,
            'categorias' => $this->getCategorias(),
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, TipoProducto $tipoProducto): RedirectResponse
    {
        $validated = $request->validate($this->rules($tipoProducto->id));

        $tipoProducto->update($validated);

        return redirect()
            ->route('admin.tipos-producto.index')
            ->with('success', 'Tipo de producto actualizado correctamente.');
    }

    public function destroy(TipoProducto $tipoProducto): RedirectResponse
    {
        if (
            $tipoProducto->productos()->exists() ||
            $tipoProducto->presupuestos()->exists() ||
            ItemPresupuesto::where('tipo_producto_id', $tipoProducto->id)->exists()
        ) {
            return redirect()
                ->route('admin.tipos-producto.index')
                ->with('error', 'No se puede eliminar un tipo de producto que ya esta en uso.');
        }

        $tipoProducto->delete();

        return redirect()
            ->route('admin.tipos-producto.index')
            ->with('success', 'Tipo de producto eliminado correctamente.');
    }

    private function rules(?int $tipoProductoId = null): array
    {
        return [
            'categoria_id' => ['required', 'exists:categorias,id'],
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tipo_productos', 'nombre')
                    ->ignore($tipoProductoId)
                    ->where(fn ($query) => $query->where('categoria_id', request('categoria_id'))),
            ],
            'descripcion' => ['nullable', 'string'],
            'modalidad' => ['required', Rule::in(['producto', 'servicio', 'dia'])],
        ];
    }

    private function getCategorias()
    {
        return Categoria::orderBy('nombre')->get();
    }
}
