@extends('admin.admin')

@section('title', 'Detalle · ' . $categoria->nombre)
@section('breadcrumb', 'Categorías')

@php
    $iconOrigin = $categoria->isBootstrapIcon()
        ? 'Bootstrap Icons'
        : ($categoria->isExternalIconUrl() ? 'URL remota' : ($categoria->isStoredIconImage() ? 'Imagen subida' : 'Sin icono'));
@endphp

@section('admin-content')
    <div class="crud-toolbar">
        <div class="page-header mb-0">
            <h1>{{ $categoria->nombre }}</h1>
            <p>Información general de la categoría y los tipos de producto asociados.</p>
        </div>
        <div class="crud-actions">
            <a href="{{ route('admin.categorias.edit', $categoria) }}"
               class="btn btn-primary btn-sm d-inline-flex align-items-center gap-1">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="{{ route('admin.categorias.index') }}"
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
                <span class="entity-kpi__label">Tipos asociados</span>
                <strong class="entity-kpi__value">{{ $categoria->tipos_count }}</strong>
            </div>
            <div class="entity-kpi">
                <span class="entity-kpi__label">Slug</span>
                <strong class="entity-kpi__value entity-kpi__value--sm">{{ $categoria->slug ?: '—' }}</strong>
            </div>
            <div class="entity-kpi">
                <span class="entity-kpi__label">Origen del icono</span>
                <strong class="entity-kpi__value entity-kpi__value--sm">{{ $iconOrigin }}</strong>
            </div>
        </div>

        {{-- ── IDENTIDAD VISUAL ── --}}
        <div class="ec-card">
            <div class="ec-card__header">
                <span class="ec-card__icon"><i class="bi bi-palette"></i></span>
                <div>
                    <h2 class="ec-card__title">Identidad visual</h2>
                    <p class="ec-card__subtitle">Icono y descripción de la categoría</p>
                </div>
            </div>

            <div class="d-flex align-items-start gap-4 flex-wrap">
                <span class="entity-icon-chip" style="width:4rem;height:4rem;border-radius:16px;flex-shrink:0">
                    @if ($categoria->iconPreviewUrl())
                        <img src="{{ $categoria->iconPreviewUrl() }}"
                             alt="{{ $categoria->nombre }}"
                             class="entity-icon-chip__image"
                             style="width:2rem;height:2rem">
                    @else
                        <i class="{{ $categoria->iconPreviewClass() }}" style="font-size:1.5rem"></i>
                    @endif
                </span>

                <div class="flex-grow-1 min-width-0">
                    <p style="color:var(--admin-text);margin:0 0 .75rem;line-height:1.7">
                        {{ $categoria->descripcion ?: 'Todavía no se ha registrado una descripción para esta categoría.' }}
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="soft-chip"><i class="bi bi-link-45deg me-1"></i>{{ $categoria->slug ?: 'Sin slug' }}</span>
                        <span class="soft-chip"><i class="bi bi-image me-1"></i>{{ $iconOrigin }}</span>
                    </div>
                </div>
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
                    <span class="ec-label"><i class="bi bi-grid-1x2"></i> Nombre</span>
                    <div style="color:var(--admin-text);font-weight:500">{{ $categoria->nombre }}</div>
                </div>
                <div class="ec-field">
                    <span class="ec-label"><i class="bi bi-link-45deg"></i> Slug</span>
                    <div style="color:var(--admin-text)">{{ $categoria->slug ?: '—' }}</div>
                </div>
                <div class="ec-field">
                    <span class="ec-label"><i class="bi bi-calendar-plus"></i> Creada el</span>
                    <div style="color:var(--admin-text)">{{ optional($categoria->created_at)->format('d/m/Y H:i') ?: '—' }}</div>
                </div>
                <div class="ec-field">
                    <span class="ec-label"><i class="bi bi-calendar-check"></i> Última actualización</span>
                    <div style="color:var(--admin-text)">{{ optional($categoria->updated_at)->format('d/m/Y H:i') ?: '—' }}</div>
                </div>
            </div>
        </div>

        {{-- ── TIPOS ASOCIADOS ── --}}
        <div class="ec-card">
            <div class="ec-card__header">
                <span class="ec-card__icon"><i class="bi bi-tags"></i></span>
                <div>
                    <h2 class="ec-card__title">Tipos de producto asociados</h2>
                    <p class="ec-card__subtitle">Elementos del catálogo que dependen de esta categoría</p>
                </div>
                <a href="{{ route('admin.tipos-producto.index') }}"
                   class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1 ms-auto flex-shrink-0">
                    <i class="bi bi-box-arrow-up-right"></i> Ver catálogo
                </a>
            </div>

            @if ($categoria->tipoProducto->isEmpty())
                <div class="empty-state">No hay tipos de producto asociados a esta categoría todavía.</div>
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
                                        <div style="font-size:.82rem;color:var(--admin-muted)">
                                            {{ \Illuminate\Support\Str::limit($tipoProducto->descripcion, 72) ?: 'Sin descripción' }}
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

    </div>
@endsection
