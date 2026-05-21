@extends('admin.admin')

@section('title', 'Detalle de empresa')
@section('breadcrumb', 'Empresas')
@section('admin-content')
    <div class="crud-toolbar">
        <div class="page-header mb-0">
            <h1>{{ $empresa->nombre_empresa }}</h1>
            <p>Consulta rapida del registro y de su cuenta asociada.</p>
        </div>

        <div class="crud-actions">
            <a href="{{ route('admin.empresas.edit', $empresa) }}" class="btn btn-primary">Editar</a>
            <a href="{{ route('admin.empresas.index') }}" class="btn btn-outline-secondary">Volver</a>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="admin-card">
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label">Empresa</span>
                <div class="detail-value">{{ $empresa->nombre_empresa }}</div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Tipo de servicio</span>
                <div class="detail-value">{{ $empresa->tipo_servicio }}</div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Usuario asociado</span>
                <div class="detail-value">{{ $empresa->usuario->name ?? 'Sin usuario' }}</div>
                <div class="muted">{{ $empresa->usuario->email ?? 'Sin email' }}</div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Telefono</span>
                <div class="detail-value">{{ $empresa->telefono }}</div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Poblacion</span>
                <div class="detail-value">{{ $empresa->poblacion->nombre ?? 'Sin poblacion' }}</div>
                <div class="muted">{{ $empresa->poblacion->provincia->nombre ?? 'Sin provincia' }}</div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Direccion</span>
                <div class="detail-value">{{ $empresa->direccion }}</div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Productos asociados</span>
                <div class="detail-value">{{ $empresa->productos_count }}</div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Reservas</span>
                <div class="detail-value">{{ $empresa->reservas_count }}</div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Solicitudes presupuesto</span>
                <div class="detail-value">{{ $empresa->pedir_presupuestos_count }}</div>
            </div>
        </div>

        <div class="mt-4">
            <span class="detail-label">Descripcion</span>
            <div class="detail-value fw-normal">{{ $empresa->descripcion ?: 'Sin descripcion' }}</div>
        </div>

        @if ($empresa->logo)
            <div class="mt-4">
                <span class="detail-label">Logo</span>
                <div class="thumb-list">
                    <img src="{{ asset('storage/' . $empresa->logo) }}" alt="Logo de empresa">
                </div>
            </div>
        @endif

        @if (! empty($empresa->fotos))
            <div class="mt-4">
                <span class="detail-label">Galeria</span>
                <div class="thumb-list">
                    @foreach ($empresa->fotos as $foto)
                        <img src="{{ is_array($foto) ? ($foto['url'] ?? asset('storage/' . ($foto['path'] ?? ''))) : asset('storage/' . $foto) }}"
                            alt="Foto de empresa">
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
