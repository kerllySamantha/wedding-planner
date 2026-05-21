@extends('admin.admin')

@section('title', 'Detalle de tipo de producto')
@section('breadcrumb', 'Tipos de producto')

@include('admin.partials.crud-styles')

@section('admin-content')
    <div class="crud-toolbar">
        <div class="page-header mb-0">
            <h1>{{ $tipoProducto->nombre }}</h1>
            <p>Detalle del tipo de producto y sus relaciones principales.</p>
        </div>

        <div class="crud-actions">
            <a href="{{ route('admin.tipos-producto.edit', $tipoProducto) }}" class="btn btn-primary">Editar</a>
            <a href="{{ route('admin.tipos-producto.index') }}" class="btn btn-outline-secondary">Volver</a>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="admin-card">
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label">Nombre</span>
                <div class="detail-value">{{ $tipoProducto->nombre }}</div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Categoria</span>
                <div class="detail-value">{{ $tipoProducto->categoria->nombre ?? 'Sin categoria' }}</div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Modalidad</span>
                <div class="detail-value">{{ ucfirst($tipoProducto->modalidad) }}</div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Productos asociados</span>
                <div class="detail-value">{{ $tipoProducto->productos_count }}</div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Presupuestos asociados</span>
                <div class="detail-value">{{ $tipoProducto->presupuestos_count }}</div>
            </div>
        </div>

        <div class="mt-4">
            <span class="detail-label">Descripcion</span>
            <div class="detail-value fw-normal">{{ $tipoProducto->descripcion ?: 'Sin descripcion' }}</div>
        </div>
    </div>
@endsection
