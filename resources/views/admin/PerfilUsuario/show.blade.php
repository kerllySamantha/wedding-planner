@extends('admin.admin')

@section('title', 'Detalle de perfil de usuario')
@section('breadcrumb', 'Perfiles de usuario')


@section('admin-content')
    <div class="crud-toolbar">
        <div class="page-header mb-0">
            <h1>{{ $perfilUsuario->user->name ?? 'Perfil de usuario' }}</h1>
            <p>Detalle del perfil del usuario final y sus datos de boda.</p>
        </div>

        <div class="crud-actions">
            <a href="{{ route('admin.perfiles-usuario.edit', $perfilUsuario) }}" class="btn btn-primary">Editar</a>
            <a href="{{ route('admin.perfiles-usuario.index') }}" class="btn btn-outline-secondary">Volver</a>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="admin-card">
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label">Nombre</span>
                <div class="detail-value">{{ $perfilUsuario->user->name ?? 'Sin usuario' }}</div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Email</span>
                <div class="detail-value">{{ $perfilUsuario->user->email ?? 'Sin email' }}</div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Telefono</span>
                <div class="detail-value">{{ $perfilUsuario->telefono ?: 'Sin telefono' }}</div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Fecha de boda</span>
                <div class="detail-value">
                    {{ $perfilUsuario->fecha_boda ? \Illuminate\Support\Carbon::parse($perfilUsuario->fecha_boda)->format('d/m/Y') : '-' }}
                </div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Poblacion</span>
                <div class="detail-value">{{ $perfilUsuario->poblacion->nombre ?? 'Sin poblacion' }}</div>
                <div class="muted">{{ $perfilUsuario->poblacion->provincia->nombre ?? 'Sin provincia' }}</div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Direccion</span>
                <div class="detail-value">{{ $perfilUsuario->direccion ?: 'Sin direccion' }}</div>
            </div>
        </div>
    </div>
@endsection
