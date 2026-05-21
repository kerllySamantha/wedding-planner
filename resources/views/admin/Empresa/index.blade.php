@extends('admin.admin')

@section('title', 'Empresas')
@section('breadcrumb', 'Empresas')

@include('admin.partials.crud-styles')

@section('admin-content')
    <div class="crud-toolbar">
        <div class="page-header mb-0">
            <h1>Empresas</h1>
            <p>CRUD de empresas con su usuario asociado y datos principales de servicio.</p>
        </div>

        <div class="crud-actions">
            <a href="{{ route('admin.empresas.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Nueva empresa
            </a>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="admin-card">
        @if ($empresas->isEmpty())
            <div class="empty-state">No hay empresas registradas todavia.</div>
        @else
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Empresa</th>
                            <th>Contacto</th>
                            <th>Ubicacion</th>
                            <th>Productos</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($empresas as $empresa)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $empresa->nombre_empresa }}</div>
                                    <div class="muted">{{ $empresa->tipo_servicio }}</div>
                                </td>
                                <td>
                                    <div>{{ $empresa->usuario->name ?? 'Sin usuario' }}</div>
                                    <div class="muted">{{ $empresa->usuario->email ?? 'Sin email' }}</div>
                                </td>
                                <td>
                                    <div>{{ $empresa->poblacion->nombre ?? 'Sin poblacion' }}</div>
                                    <div class="muted">{{ $empresa->poblacion->provincia->nombre ?? 'Sin provincia' }}</div>
                                </td>
                                <td>{{ $empresa->productos_count }}</td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('admin.empresas.show', $empresa) }}"
                                            class="btn btn-sm btn-outline-secondary">Ver</a>
                                        <a href="{{ route('admin.empresas.edit', $empresa) }}"
                                            class="btn btn-sm btn-outline-primary">Editar</a>
                                        <form action="{{ route('admin.empresas.destroy', $empresa) }}" method="POST"
                                            onsubmit="return confirm('Se eliminara la empresa y su usuario asociado. Continuar?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $empresas->links() }}
            </div>
        @endif
    </div>
@endsection
