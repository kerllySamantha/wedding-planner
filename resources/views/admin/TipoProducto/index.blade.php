@extends('admin.admin')

@section('title', 'Tipos de producto')
@section('breadcrumb', 'Tipos de producto')

@section('admin-content')
    <div class="crud-toolbar">
        <div class="page-header mb-0">
            <h1>Tipos de producto</h1>
            <p>Gestion del catalogo base enlazado con categorias y productos del sistema.</p>
        </div>

        <div class="crud-actions">
            <a href="{{ route('admin.tipos-producto.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Nuevo tipo
            </a>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="admin-card">
        @if ($tiposProducto->isEmpty())
            <div class="empty-state">No hay tipos de producto registrados.</div>
        @else
            <div class="table-responsive">
                <table class="table table-admin align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Categoria</th>
                            <th>Modalidad</th>
                            <th>Productos</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tiposProducto as $tipoProducto)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $tipoProducto->nombre }}</div>
                                    <div class="muted">{{ \Illuminate\Support\Str::limit($tipoProducto->descripcion, 60) ?: 'Sin descripcion' }}</div>
                                </td>
                                <td>{{ $tipoProducto->categoria->nombre ?? 'Sin categoria' }}</td>
                                <td>
                                    <span class="badge text-bg-light border">{{ ucfirst($tipoProducto->modalidad) }}</span>
                                </td>
                                <td>{{ $tipoProducto->productos_count }}</td>
                                <td class="text-end">
                                    <div class="table-actions">
                                        <a href="{{ route('admin.tipos-producto.show', $tipoProducto) }}"
                                            class="btn btn-sm btn-outline-secondary btn-icon" title="Ver" aria-label="Ver"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('admin.tipos-producto.edit', $tipoProducto) }}"
                                            class="btn btn-sm btn-outline-primary btn-icon" title="Editar" aria-label="Editar"><i class="bi bi-pencil"></i></a>
                                        <form action="{{ route('admin.tipos-producto.destroy', $tipoProducto) }}"
                                            method="POST"
                                            onsubmit="return confirm('Se eliminara este tipo de producto. Continuar?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger btn-icon" title="Eliminar" aria-label="Eliminar"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $tiposProducto->links() }}
            </div>
        @endif
    </div>
@endsection
