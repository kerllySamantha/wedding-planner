@extends('admin.admin')

@section('title', 'Detalle de perfil')
@section('breadcrumb', 'Perfiles de usuario')

@php
    $name    = $perfilUsuario->user->name ?? 'Usuario';
    $words   = explode(' ', trim($name));
    $inits   = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
    $palette = ['#1459b8','#7b2ff7','#0e7490','#0369a1','#6d28d9','#0f766e'];
    $bg      = $palette[abs(crc32($name)) % count($palette)];

    $fechaBoda = $perfilUsuario->fecha_boda
        ? \Illuminate\Support\Carbon::parse($perfilUsuario->fecha_boda)
        : null;
    $dias = $fechaBoda
        ? (int) now()->startOfDay()->diffInDays($fechaBoda->copy()->startOfDay(), false)
        : null;
@endphp

@section('admin-content')
    <div class="crud-toolbar">
        <div class="page-header mb-0">
            <h1>Perfil de usuario</h1>
            <p>Datos de cuenta y de boda del usuario final.</p>
        </div>
        <div class="crud-actions">
            <a href="{{ route('admin.perfiles-usuario.edit', $perfilUsuario) }}"
                class="btn btn-primary btn-sm d-inline-flex align-items-center gap-1">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="{{ route('admin.perfiles-usuario.index') }}"
                class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="d-flex flex-column gap-3">

        {{-- ── HERO ── --}}
        <div class="ec-card">
            <div class="d-flex align-items-center gap-4 flex-wrap">

                @if ($perfilUsuario->user?->fotoPerfil)
                    <img src="{{ asset('storage/' . $perfilUsuario->user->fotoPerfil) }}"
                         alt="{{ $name }}"
                         class="pu-avatar pu-avatar--lg"
                         style="object-fit:cover;">
                @else
                    <span class="pu-avatar pu-avatar--lg" style="--pu-avatar-bg:{{ $bg }}">{{ $inits }}</span>
                @endif

                <div class="flex-grow-1 min-width-0">
                    <h2 class="fw-bold mb-1" style="font-size:1.2rem;color:var(--admin-text);line-height:1.2">
                        {{ $name }}
                    </h2>
                    <div style="font-size:.85rem;color:var(--admin-muted)">
                        <i class="bi bi-envelope me-1"></i>{{ $perfilUsuario->user->email ?? '—' }}
                    </div>
                </div>

                @if ($fechaBoda)
                    <div class="text-center flex-shrink-0">
                        @if ($dias === 0)
                            <span class="wedding-badge wedding-badge--today fs-6 px-3 py-2">
                                <i class="bi bi-balloon-heart-fill"></i> ¡El gran día es hoy!
                            </span>
                        @elseif ($dias > 0)
                            <div class="fw-bold" style="font-size:1.6rem;color:var(--admin-text);line-height:1">{{ $dias }}</div>
                            <div style="font-size:.7rem;color:var(--admin-muted);text-transform:uppercase;letter-spacing:.05em;margin-top:2px">días para la boda</div>
                            <div style="font-size:.78rem;color:var(--admin-muted);margin-top:4px">{{ $fechaBoda->format('d/m/Y') }}</div>
                        @else
                            <span class="wedding-badge wedding-badge--past">
                                <i class="bi bi-calendar-check"></i> Boda celebrada · {{ $fechaBoda->format('d/m/Y') }}
                            </span>
                        @endif
                    </div>
                @endif

            </div>
        </div>

        {{-- ── CUENTA ── --}}
        <div class="ec-card">
            <div class="ec-card__header">
                <span class="ec-card__icon">
                    <i class="bi bi-person-circle"></i>
                </span>
                <div>
                    <h2 class="ec-card__title">Cuenta</h2>
                    <p class="ec-card__subtitle">Credenciales de acceso al sistema</p>
                </div>
            </div>

            <div class="ec-grid">
                <div class="ec-field">
                    <span class="ec-label"><i class="bi bi-person"></i> Nombre</span>
                    <div style="color:var(--admin-text);font-weight:500">{{ $perfilUsuario->user->name ?? '—' }}</div>
                </div>
                <div class="ec-field">
                    <span class="ec-label"><i class="bi bi-envelope"></i> Email</span>
                    <div style="color:var(--admin-text)">{{ $perfilUsuario->user->email ?? '—' }}</div>
                </div>
            </div>
        </div>

        {{-- ── PERFIL DE BODA ── --}}
        <div class="ec-card">
            <div class="ec-card__header">
                <span class="ec-card__icon">
                    <i class="bi bi-heart"></i>
                </span>
                <div>
                    <h2 class="ec-card__title">Datos de boda</h2>
                    <p class="ec-card__subtitle">Información de contacto y evento</p>
                </div>
            </div>

            <div class="ec-grid">
                <div class="ec-field">
                    <span class="ec-label"><i class="bi bi-telephone"></i> Teléfono</span>
                    <div style="color:var(--admin-text)">{{ $perfilUsuario->telefono ?: '—' }}</div>
                </div>
                <div class="ec-field">
                    <span class="ec-label"><i class="bi bi-calendar-heart"></i> Fecha de boda</span>
                    <div style="color:var(--admin-text)">
                        {{ $fechaBoda ? $fechaBoda->format('d/m/Y') : '—' }}
                        @if ($dias !== null && $dias > 0)
                            <span class="wedding-badge wedding-badge--upcoming ms-2">{{ $dias }}d restantes</span>
                        @elseif ($dias !== null && $dias < 0)
                            <span class="wedding-badge wedding-badge--past ms-2">Celebrada</span>
                        @endif
                    </div>
                </div>
                <div class="ec-field">
                    <span class="ec-label"><i class="bi bi-geo-alt"></i> Población</span>
                    <div style="color:var(--admin-text)">{{ $perfilUsuario->poblacion->nombre ?? '—' }}</div>
                    <div style="font-size:.82rem;color:var(--admin-muted)">{{ $perfilUsuario->poblacion->provincia->nombre ?? '' }}</div>
                </div>
                <div class="ec-field">
                    <span class="ec-label"><i class="bi bi-signpost-2"></i> Dirección</span>
                    <div style="color:var(--admin-text)">{{ $perfilUsuario->direccion ?: '—' }}</div>
                </div>
            </div>
        </div>

    </div>
@endsection
