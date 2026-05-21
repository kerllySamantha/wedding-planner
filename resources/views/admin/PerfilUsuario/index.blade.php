@extends('admin.admin')

@section('title', 'Perfiles de usuario')
@section('breadcrumb', 'Perfiles de usuario')

@include('admin.partials.crud-styles')

@section('admin-content')
    <div class="crud-toolbar">
        <div class="page-header mb-0">
            <h1>Perfiles de usuario</h1>
            <p>CRUD de perfiles para usuarios finales con sincronizacion basica de su boda.</p>
        </div>

        <div class="crud-actions">
            <a href="{{ route('admin.perfiles-usuario.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Nuevo perfil
            </a>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="admin-card">
        @if ($perfiles->isEmpty())
            <div class="empty-state">No hay perfiles de usuario registrados.</div>
        @else
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Contacto</th>
                            <th>Poblacion</th>
                            <th>Fecha boda</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($perfiles as $perfil)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $perfil->user->name ?? 'Sin usuario' }}</div>
                                    <div class="muted">{{ $perfil->user->email ?? 'Sin email' }}</div>
                                </td>
                                <td>
                                    <div>{{ $perfil->telefono ?: 'Sin telefono' }}</div>
                                    <div class="muted">{{ $perfil->direccion ?: 'Sin direccion' }}</div>
                                </td>
                                <td>
                                    <div>{{ $perfil->poblacion->nombre ?? 'Sin poblacion' }}</div>
                                    <div class="muted">{{ $perfil->poblacion->provincia->nombre ?? 'Sin provincia' }}</div>
                                </td>
                                <td>{{ $perfil->fecha_boda ? \Illuminate\Support\Carbon::parse($perfil->fecha_boda)->format('d/m/Y') : '-' }}</td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('admin.perfiles-usuario.show', $perfil) }}"
                                            class="btn btn-sm btn-outline-secondary">Ver</a>
                                        <a href="{{ route('admin.perfiles-usuario.edit', $perfil) }}"
                                            class="btn btn-sm btn-outline-primary">Editar</a>
                                        <form action="{{ route('admin.perfiles-usuario.destroy', $perfil) }}" method="POST"
                                            onsubmit="return confirm('Se eliminara este perfil de usuario. Continuar?');">
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
                {{ $perfiles->links() }}
            </div>
        @endif
    </div>
@endsection
