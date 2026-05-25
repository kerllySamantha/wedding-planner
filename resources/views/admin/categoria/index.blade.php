@extends('admin.admin')

@section('title', 'Categorias')
@section('breadcrumb', 'Categorias')

@section('admin-content')
    <div class="crud-toolbar">
        <div class="page-header mb-0">
            <h1>Categorias</h1>
            <p>Organiza el catalogo base que despues alimenta tipos de producto, productos y presupuestos.</p>
        </div>

        <div class="crud-actions">
            <a href="{{ route('admin.categorias.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Nueva categoria
            </a>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="entity-kpis mb-4">
        <div class="entity-kpi">
            <span class="entity-kpi__label">Categorias</span>
            <strong class="entity-kpi__value">{{ $totals['categorias'] }}</strong>
        </div>
        <div class="entity-kpi">
            <span class="entity-kpi__label">Con tipos asociados</span>
            <strong class="entity-kpi__value">{{ $totals['conTipos'] }}</strong>
        </div>
        <div class="entity-kpi">
            <span class="entity-kpi__label">Tipos de producto</span>
            <strong class="entity-kpi__value">{{ $totals['tipos'] }}</strong>
        </div>
    </div>

    <div class="admin-card">
        @if ($categorias->isEmpty())
            <div class="empty-state text-center py-5">
                <p class="mb-3">Todavia no hay categorias registradas.</p>
                <a href="{{ route('admin.categorias.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i>Crear primera categoria
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-admin align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Categoria</th>
                            <th>Slug</th>
                            <th>Icono</th>
                            <th>Tipos</th>
                            <th>Actualizada</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categorias as $categoria)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="entity-icon-chip">
                                            @if($categoria->icono && str_starts_with($categoria->icono, 'http'))
                                                <img src="{{ $categoria->icono }}" alt="{{ $categoria->nombre }}" style="width:1.4rem;height:1.4rem;object-fit:contain;">
                                            @else
                                                <i class="{{ $categoria->icono ?: 'bi bi-grid-1x2' }}"></i>
                                            @endif
                                        </span>
                                        <div>
                                            <div class="fw-semibold">{{ $categoria->nombre }}</div>
                                            <div class="muted">
                                                {{ \Illuminate\Support\Str::limit($categoria->descripcion, 60) ?: 'Sin descripcion.' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="soft-chip">{{ $categoria->slug ?: 'Sin slug' }}</span></td>
                                <td>
                                    @if($categoria->icono && str_starts_with($categoria->icono, 'http'))
                                        <img src="{{ $categoria->icono }}" alt="icono" class="categoria-icon-thumb">
                                    @elseif($categoria->icono)
                                        <i class="{{ $categoria->icono }} fs-5 text-primary"></i>
                                    @else
                                        <span class="muted">—</span>
                                    @endif
                                </td>
                                <td>{{ $categoria->tipos_count }}</td>
                                <td>{{ optional($categoria->updated_at)->format('d/m/Y') ?: 'Sin fecha' }}</td>
                                <td class="text-end">
                                    <div class="table-actions justify-content-end">
                                        <a href="{{ route('admin.categorias.show', $categoria) }}"
                                            class="btn btn-sm btn-outline-secondary btn-icon" title="Ver" aria-label="Ver">
                                            <i class="bi bi-eye"></i><span class="visually-hidden">Ver</span>
                                        </a>
                                        <a href="{{ route('admin.categorias.edit', $categoria) }}"
                                            class="btn btn-sm btn-outline-primary btn-icon" title="Editar" aria-label="Editar">
                                            <i class="bi bi-pencil"></i><span class="visually-hidden">Editar</span>
                                        </a>
                                        <form action="{{ route('admin.categorias.destroy', $categoria) }}" method="POST"
                                            onsubmit="return confirm('Se eliminara esta categoria. Continuar?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger btn-icon" title="Eliminar"
                                                aria-label="Eliminar">
                                                <i class="bi bi-trash"></i><span class="visually-hidden">Eliminar</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $categorias->links() }}
            </div>
        @endif
    </div>
@endsection
