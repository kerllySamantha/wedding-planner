@extends('admin.admin')

@section('title', 'Mi Perfil')
@section('breadcrumb', 'Mi Perfil')

@php
    $name        = $user->name;
    $words       = explode(' ', trim($name));
    $inits       = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
    $palette     = ['#1459b8','#7b2ff7','#0e7490','#0369a1','#6d28d9','#0f766e'];
    $bg          = $palette[abs(crc32($name)) % count($palette)];
    $role        = ucfirst($user->roles->first()?->name ?? 'Sin rol');
    $memberSince = optional($user->created_at)->format('d/m/Y') ?: '—';
    $lastUpdate  = optional($user->updated_at)->format('d/m/Y H:i') ?: '—';
    $verified    = $user->email_verified_at ? 'Verificado' : 'Pendiente';
@endphp

@section('admin-content')
    <div class="crud-toolbar">
        <div class="page-header mb-0">
            <h1>Mi perfil</h1>
            <p>Información de tu cuenta de administrador.</p>
        </div>
        <div class="crud-actions">
            <a href="{{ route('admin.profile.edit') }}"
                class="btn btn-primary btn-sm d-inline-flex align-items-center gap-1">
                <i class="bi bi-pencil-square"></i> Editar perfil
            </a>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="d-flex flex-column gap-3">

        {{-- ── HERO ── --}}
        <div class="ec-card">
            <div class="d-flex align-items-center gap-4 flex-wrap">

                @if ($user->fotoPerfil)
                    <img src="{{ asset('storage/' . $user->fotoPerfil) }}"
                         alt="{{ $name }}"
                         class="pu-avatar pu-avatar--lg"
                         style="object-fit:cover;">
                @else
                    <span class="pu-avatar pu-avatar--lg" style="--pu-avatar-bg:{{ $bg }}">{{ $inits }}</span>
                @endif

                <div class="flex-grow-1 min-width-0">
                    <h2 class="fw-bold mb-1" style="font-size:1.25rem;color:var(--admin-text);line-height:1.2">
                        {{ $name }}
                    </h2>
                    <div style="font-size:.85rem;color:var(--admin-muted)">
                        <i class="bi bi-envelope me-1"></i>{{ $user->email }}
                    </div>
                    <div class="mt-2">
                        <span class="profile-hero__role">
                            <i class="bi bi-shield-check"></i> {{ $role }}
                        </span>
                    </div>
                </div>

            </div>
        </div>

        {{-- ── KPIs ── --}}
        <div class="entity-kpis">
            <div class="entity-kpi">
                <span class="entity-kpi__label">Rol</span>
                <strong class="entity-kpi__value entity-kpi__value--sm">{{ $role }}</strong>
            </div>
            <div class="entity-kpi">
                <span class="entity-kpi__label">Email</span>
                <strong class="entity-kpi__value entity-kpi__value--sm">{{ $verified }}</strong>
            </div>
            <div class="entity-kpi">
                <span class="entity-kpi__label">Miembro desde</span>
                <strong class="entity-kpi__value entity-kpi__value--sm">{{ $memberSince }}</strong>
            </div>
        </div>

        {{-- ── CUENTA ── --}}
        <div class="ec-card">
            <div class="ec-card__header">
                <span class="ec-card__icon"><i class="bi bi-person-circle"></i></span>
                <div>
                    <h2 class="ec-card__title">Cuenta</h2>
                    <p class="ec-card__subtitle">Credenciales de acceso al sistema</p>
                </div>
            </div>
            <div class="ec-grid">
                <div class="ec-field">
                    <span class="ec-label"><i class="bi bi-person"></i> Nombre</span>
                    <div style="color:var(--admin-text);font-weight:500">{{ $name }}</div>
                </div>
                <div class="ec-field">
                    <span class="ec-label"><i class="bi bi-envelope"></i> Email</span>
                    <div style="color:var(--admin-text)">{{ $user->email }}</div>
                </div>
                <div class="ec-field">
                    <span class="ec-label"><i class="bi bi-shield-check"></i> Rol</span>
                    <div style="color:var(--admin-text)">{{ $role }}</div>
                </div>
                <div class="ec-field">
                    <span class="ec-label"><i class="bi bi-patch-check"></i> Estado email</span>
                    <div style="color:var(--admin-text)">{{ $verified }}</div>
                </div>
            </div>
        </div>

        {{-- ── ACTIVIDAD ── --}}
        <div class="ec-card">
            <div class="ec-card__header">
                <span class="ec-card__icon"><i class="bi bi-clock-history"></i></span>
                <div>
                    <h2 class="ec-card__title">Actividad</h2>
                    <p class="ec-card__subtitle">Estado del perfil y registro de tiempos</p>
                </div>
            </div>
            <div class="ec-grid">
                <div class="ec-field">
                    <span class="ec-label"><i class="bi bi-hash"></i> ID de usuario</span>
                    <div style="color:var(--admin-text)">#{{ $user->id }}</div>
                </div>
                <div class="ec-field">
                    <span class="ec-label"><i class="bi bi-camera"></i> Foto de perfil</span>
                    <div style="color:var(--admin-text)">{{ $user->fotoPerfil ? 'Configurada' : 'Sin foto' }}</div>
                </div>
                <div class="ec-field">
                    <span class="ec-label"><i class="bi bi-calendar-plus"></i> Creado el</span>
                    <div style="color:var(--admin-text)">{{ $memberSince }}</div>
                </div>
                <div class="ec-field">
                    <span class="ec-label"><i class="bi bi-calendar-check"></i> Última actualización</span>
                    <div style="color:var(--admin-text)">{{ $lastUpdate }}</div>
                </div>
            </div>
        </div>

    </div>
@endsection
