<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaRequest;
use App\Models\Categoria;
use App\Models\TipoProducto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        $data = $request->validated();
        $data['icono'] = $this->resolveIconoValue($request);

        Categoria::create($data);

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
        $data = $request->validated();
        $data['icono'] = $this->resolveIconoValue($request, $categoria);

        $categoria->update($data);

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

        $this->deleteStoredIcon($categoria->icono);
        $categoria->delete();

        return redirect()
            ->route('admin.categorias.index')
            ->with('success', 'Categoria eliminada correctamente.');
    }

    private function resolveIconoValue(CategoriaRequest $request, ?Categoria $categoria = null): ?string
    {
        $previousIcon = $categoria?->icono;
        $manualIcon = trim((string) $request->input('icono', ''));

        if ($request->hasFile('icono_file')) {
            $this->deleteStoredIcon($previousIcon);

            return $request->file('icono_file')->store('categorias/iconos', 'public');
        }

        if ($manualIcon !== '') {
            if ($manualIcon !== $previousIcon) {
                $this->deleteStoredIcon($previousIcon);
            }

            return $manualIcon;
        }

        return $previousIcon;
    }

    private function deleteStoredIcon(?string $iconValue): void
    {
        if (!$this->isStoredIcon($iconValue)) {
            return;
        }

        if (Storage::disk('public')->exists($iconValue)) {
            Storage::disk('public')->delete($iconValue);
        }
    }

    private function isStoredIcon(?string $iconValue): bool
    {
        if (!is_string($iconValue) || trim($iconValue) === '') {
            return false;
        }

        $iconValue = trim($iconValue);

        if (filter_var($iconValue, FILTER_VALIDATE_URL) !== false) {
            return false;
        }

        return !Str::startsWith($iconValue, 'bi');
    }
}
