@extends('admin.admin')

@section('title', 'Detalle de categoria')
@section('breadcrumb', 'Categorias')

@section('admin-content')
    <div class="crud-toolbar">
        <div class="page-header mb-0">
            <h1>{{ $categoria->nombre }}</h1>
            <p>Consulta la informacion general de la categoria y los tipos de producto que cuelgan de ella.</p>
        </div>

        <div class="crud-actions">
            <a href="{{ route('admin.categorias.edit', $categoria) }}" class="btn btn-primary">Editar</a>
            <a href="{{ route('admin.categorias.index') }}" class="btn btn-outline-secondary">Volver</a>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="entity-kpis mb-4">
        <div class="entity-kpi">
            <span class="entity-kpi__label">Tipos asociados</span>
            <strong class="entity-kpi__value">{{ $categoria->tipos_count }}</strong>
        </div>
        <div class="entity-kpi">
            <span class="entity-kpi__label">Slug</span>
            <strong class="entity-kpi__value entity-kpi__value--sm">{{ $categoria->slug ?: 'Sin slug' }}</strong>
        </div>
        <div class="entity-kpi">
            <span class="entity-kpi__label">Icono</span>
            <strong class="entity-kpi__value entity-kpi__value--sm">{{ $categoria->icono ?: 'bi bi-grid-1x2' }}</strong>
        </div>
    </div>

    <div class="admin-card mb-4">
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label">Nombre</span>
                <div class="detail-value">{{ $categoria->nombre }}</div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Slug</span>
                <div class="detail-value">{{ $categoria->slug ?: 'Sin slug' }}</div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Icono</span>
                <div class="detail-value d-flex align-items-center gap-2">
                    <span class="entity-icon-chip">
                        <i class="{{ $categoria->icono ?: 'bi bi-grid-1x2' }}"></i>
                    </span>
                    <span>{{ $categoria->icono ?: 'Sin icono' }}</span>
                </div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Creada</span>
                <div class="detail-value">{{ optional($categoria->created_at)->format('d/m/Y H:i') ?: 'Sin fecha' }}</div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Actualizada</span>
                <div class="detail-value">{{ optional($categoria->updated_at)->format('d/m/Y H:i') ?: 'Sin fecha' }}</div>
            </div>
        </div>

        <div class="mt-4">
            <span class="detail-label">Descripcion</span>
            <div class="detail-value fw-normal">{{ $categoria->descripcion ?: 'Sin descripcion registrada.' }}</div>
        </div>
    </div>

    <div class="admin-card">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
            <div>
                <div class="fw-semibold">Tipos de producto asociados</div>
                <div class="muted">Listado rapido de los elementos que dependen de esta categoria.</div>
            </div>
            <a href="{{ route('admin.tipos-producto.index') }}" class="btn btn-outline-secondary btn-sm">Ver catalogo completo</a>
        </div>

        @if ($categoria->tipoProducto->isEmpty())
            <div class="empty-state">No hay tipos de producto asociados a esta categoria todavia.</div>
        @else
            <div class="table-responsive">
                <table class="table table-admin align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Modalidad</th>
                            <th>Productos</th>
                            <th>Presupuestos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categoria->tipoProducto as $tipoProducto)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $tipoProducto->nombre }}</div>
                                    <div class="muted">
                                        {{ \Illuminate\Support\Str::limit($tipoProducto->descripcion, 72) ?: 'Sin descripcion' }}
                                    </div>
                                </td>
                                <td><span class="soft-chip">{{ ucfirst($tipoProducto->modalidad) }}</span></td>
                                <td>{{ $tipoProducto->productos_count }}</td>
                                <td>{{ $tipoProducto->presupuestos_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
