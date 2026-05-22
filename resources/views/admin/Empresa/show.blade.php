@extends('admin.admin')

@section('title', 'Detalle de empresa')
@section('breadcrumb', 'Empresas')

@push('styles')
    @vite('resources/css/empresa/empresa.css')
@endpush

@php
    $fotosEmpresa = $empresa->fotos;
    if (is_string($fotosEmpresa)) {
        $decoded = json_decode($fotosEmpresa, true);
        $fotosEmpresa = is_array($decoded) ? $decoded : [];
    }
    $fotosEmpresa = is_array($fotosEmpresa) ? $fotosEmpresa : [];
@endphp

@section('admin-content')

    {{-- TOOLBAR --}}
    <div class="ec-toolbar">
        <div>
            <h1 class="ec-page-title">
                <i class="ti ti-building ec-page-title__icon" aria-hidden="true"></i>
                {{ $empresa->nombre_empresa }}
            </h1>
            <p class="ec-page-subtitle">Consulta del registro y de su cuenta asociada.</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.empresas.edit', $empresa) }}"
               class="btn btn-primary btn-sm d-flex align-items-center gap-1">
                <i class="bi bi-pencil" aria-hidden="true"></i> Editar
            </a>
            <a href="{{ route('admin.empresas.index') }}"
               class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                <i class="bi bi-arrow-left" aria-hidden="true"></i> Volver
            </a>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="d-flex flex-column gap-3">

        {{-- HERO: logo + nombre + stats ─────────────────────────────── --}}
        <div class="ec-card">
            <div class="d-flex align-items-center gap-4 flex-wrap">

                {{-- Logo --}}
                <div class="empresa-logo-box">
                    @if ($empresa->logo)
                        <img src="{{ asset('storage/' . $empresa->logo) }}"
                             alt="Logo de {{ $empresa->nombre_empresa }}"
                             class="empresa-logo-box__img">
                    @else
                        <div class="empresa-logo-box__placeholder">
                            <i class="bi bi-building" aria-hidden="true"></i>
                        </div>
                    @endif
                </div>

                {{-- Nombre y tipo --}}
                <div class="flex-grow-1 min-width-0">
                    <h2 class="fw-bold mb-1" style="font-size:1.15rem;color:#0d2a42;line-height:1.2;">
                        {{ $empresa->nombre_empresa }}
                    </h2>
                    <span class="badge rounded-pill"
                          style="background:#e7f1ff;color:#1459b8;font-size:.75rem;font-weight:500;letter-spacing:.01em;">
                        {{ $empresa->tipo_servicio }}
                    </span>
                    @if ($empresa->poblacion)
                        <div class="mt-1" style="font-size:.8rem;color:#6788a3;">
                            <i class="bi bi-geo-alt-fill" aria-hidden="true"></i>
                            {{ $empresa->poblacion->nombre }}{{ $empresa->poblacion->provincia ? ', ' . $empresa->poblacion->provincia->nombre : '' }}
                        </div>
                    @endif
                </div>

                {{-- Stats rápidos --}}
                <div class="d-flex gap-4 text-center flex-shrink-0">
                    <div>
                        <div class="fw-bold" style="font-size:1.4rem;color:#0d2a42;line-height:1;">
                            {{ $empresa->productos_count }}
                        </div>
                        <div style="font-size:.7rem;color:#6788a3;text-transform:uppercase;letter-spacing:.05em;margin-top:2px;">
                            Productos
                        </div>
                    </div>
                    <div>
                        <div class="fw-bold" style="font-size:1.4rem;color:#0d2a42;line-height:1;">
                            {{ $empresa->reservas_count }}
                        </div>
                        <div style="font-size:.7rem;color:#6788a3;text-transform:uppercase;letter-spacing:.05em;margin-top:2px;">
                            Reservas
                        </div>
                    </div>
                    <div>
                        <div class="fw-bold" style="font-size:1.4rem;color:#0d2a42;line-height:1;">
                            {{ $empresa->pedir_presupuestos_count }}
                        </div>
                        <div style="font-size:.7rem;color:#6788a3;text-transform:uppercase;letter-spacing:.05em;margin-top:2px;">
                            Presupuestos
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- INFORMACIÓN GENERAL ──────────────────────────────────────── --}}
        <div class="ec-card">
            <div class="ec-card__header">
                <span class="ec-card__icon">
                    <i class="ti ti-info-circle" aria-hidden="true"></i>
                </span>
                <div>
                    <h2 class="ec-card__title">Información general</h2>
                    <p class="ec-card__subtitle">Datos públicos y de contacto</p>
                </div>
            </div>

            <div class="ec-grid">
                <div class="ec-field">
                    <span class="ec-label">Usuario asociado</span>
                    <div class="fw-medium" style="color:#0d2a42;">
                        {{ $empresa->usuario->name ?? '—' }}
                    </div>
                    <div style="font-size:.82rem;color:#6788a3;">
                        {{ $empresa->usuario->email ?? '' }}
                    </div>
                </div>

                <div class="ec-field">
                    <span class="ec-label">Teléfono</span>
                    <div style="color:#0d2a42;">{{ $empresa->telefono ?: '—' }}</div>
                </div>

                <div class="ec-field">
                    <span class="ec-label">Población</span>
                    <div style="color:#0d2a42;">{{ $empresa->poblacion->nombre ?? '—' }}</div>
                    <div style="font-size:.82rem;color:#6788a3;">
                        {{ $empresa->poblacion->provincia->nombre ?? '' }}
                    </div>
                </div>

                <div class="ec-field">
                    <span class="ec-label">Dirección</span>
                    <div style="color:#0d2a42;">{{ $empresa->direccion ?: '—' }}</div>
                </div>

                <div class="ec-field ec-field--full">
                    <span class="ec-label">Descripción</span>
                    <div style="color:#0d2a42;white-space:pre-line;line-height:1.6;">
                        {{ $empresa->descripcion ?: 'Sin descripción' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- ARCHIVOS VISUALES ───────────────────────────────────────── --}}
        @if ($empresa->logo || !empty($fotosEmpresa))
            <div class="ec-card">
                <div class="ec-card__header">
                    <span class="ec-card__icon">
                        <i class="ti ti-photo" aria-hidden="true"></i>
                    </span>
                    <div>
                        <h2 class="ec-card__title">Archivos visuales</h2>
                        <p class="ec-card__subtitle">
                            @if ($empresa->logo)Logo · @endif
                            @if (!empty($fotosEmpresa))
                                {{ count($fotosEmpresa) }} foto{{ count($fotosEmpresa) !== 1 ? 's' : '' }} en galería
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Logo grande --}}
                @if ($empresa->logo)
                    <div class="mb-4">
                        <span class="ec-label">Logo</span>
                        <div class="empresa-gallery empresa-gallery--logo mt-2">
                            <div class="empresa-gallery__item">
                                <img src="{{ asset('storage/' . $empresa->logo) }}"
                                     alt="Logo de {{ $empresa->nombre_empresa }}">
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Galería --}}
                @if (!empty($fotosEmpresa))
                    <div>
                        <span class="ec-label">Galería ({{ count($fotosEmpresa) }})</span>
                        <div class="empresa-gallery mt-2">
                            @foreach ($fotosEmpresa as $foto)
                                <div class="empresa-gallery__item">
                                    <img src="{{ is_array($foto)
                                                    ? ($foto['url'] ?? asset('storage/' . ($foto['path'] ?? '')))
                                                    : asset('storage/' . $foto) }}"
                                         alt="Foto de {{ $empresa->nombre_empresa }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif

    </div>

@endsection
