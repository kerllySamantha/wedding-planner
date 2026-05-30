@extends('admin.admin')

@section('title', 'Detalle · ' . $tipoProducto->nombre)
@section('breadcrumb', 'Tipos de producto')

@section('admin-content')
    <div class="crud-toolbar">
        <div class="page-header mb-0">
            <h1>{{ $tipoProducto->nombre }}</h1>
            <p>Detalle del tipo de producto y sus relaciones principales.</p>
        </div>
        <div class="crud-actions">
            <a href="{{ route('admin.tipos-producto.edit', $tipoProducto) }}"
               class="btn btn-primary btn-sm d-inline-flex align-items-center gap-1">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="{{ route('admin.tipos-producto.index') }}"
               class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="d-flex flex-column gap-3">

        {{-- ── KPIs ── --}}
        <div class="entity-kpis">
            <div class="entity-kpi">
                <span class="entity-kpi__label">Modalidad</span>
                <strong class="entity-kpi__value entity-kpi__value--sm">{{ ucfirst($tipoProducto->modalidad) }}</strong>
            </div>
            <div class="entity-kpi">
                <span class="entity-kpi__label">Productos asociados</span>
                <strong class="entity-kpi__value">{{ $tipoProducto->productos_count }}</strong>
            </div>
            <div class="entity-kpi">
                <span class="entity-kpi__label">Presupuestos</span>
                <strong class="entity-kpi__value">{{ $tipoProducto->presupuestos_count }}</strong>
            </div>
        </div>

        {{-- ── DESCRIPCIÓN ── --}}
        <div class="ec-card">
            <div class="ec-card__header">
                <span class="ec-card__icon"><i class="bi bi-card-text"></i></span>
                <div>
                    <h2 class="ec-card__title">Descripción</h2>
                    <p class="ec-card__subtitle">Cómo se usa este tipo dentro del catálogo</p>
                </div>
            </div>

            <p style="color:var(--admin-text);line-height:1.7;margin:0 0 1.25rem">
                {{ $tipoProducto->descripcion ?: 'Todavía no se ha registrado una descripción para este tipo de producto.' }}
            </p>

            <div class="d-flex flex-wrap gap-2">
                <span class="soft-chip"><i class="bi bi-tags me-1"></i>{{ ucfirst($tipoProducto->modalidad) }}</span>
                @if ($tipoProducto->categoria)
                    <a href="{{ route('admin.categorias.show', $tipoProducto->categoria) }}"
                       class="soft-chip text-decoration-none">
                        <i class="bi bi-grid-1x2 me-1"></i>{{ $tipoProducto->categoria->nombre }}
                    </a>
                @else
                    <span class="soft-chip">Sin categoría</span>
                @endif
            </div>
        </div>

        {{-- ── DATOS PRINCIPALES ── --}}
        <div class="ec-card">
            <div class="ec-card__header">
                <span class="ec-card__icon"><i class="bi bi-info-circle"></i></span>
                <div>
                    <h2 class="ec-card__title">Datos principales</h2>
                    <p class="ec-card__subtitle">Ficha rápida con los datos de registro</p>
                </div>
            </div>
            <div class="ec-grid">
                <div class="ec-field">
                    <span class="ec-label"><i class="bi bi-tag"></i> Nombre</span>
                    <div style="color:var(--admin-text);font-weight:500">{{ $tipoProducto->nombre }}</div>
                </div>
                <div class="ec-field">
                    <span class="ec-label"><i class="bi bi-grid-1x2"></i> Categoría</span>
                    <div style="color:var(--admin-text)">{{ $tipoProducto->categoria->nombre ?? 'Sin categoría' }}</div>
                </div>
                <div class="ec-field">
                    <span class="ec-label"><i class="bi bi-calendar-plus"></i> Creado el</span>
                    <div style="color:var(--admin-text)">{{ optional($tipoProducto->created_at)->format('d/m/Y') ?: '—' }}</div>
                </div>
                <div class="ec-field">
                    <span class="ec-label"><i class="bi bi-calendar-check"></i> Última actualización</span>
                    <div style="color:var(--admin-text)">{{ optional($tipoProducto->updated_at)->format('d/m/Y H:i') ?: '—' }}</div>
                </div>
            </div>
        </div>

    </div>
@endsection
