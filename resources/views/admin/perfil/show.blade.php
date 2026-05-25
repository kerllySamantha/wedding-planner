@extends('admin.admin')

@section('title', 'Mi Perfil')
@section('breadcrumb', 'Perfil personal del administrador')

@php
    $name   = $user->name;
    $words  = explode(' ', trim($name));
    $inits  = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
    $role   = ucfirst($user->roles->first()?->name ?? 'Sin rol');
@endphp

@section('admin-content')

    @include('admin.partials.flash')

    <div class="profile-hero">

        {{-- Cabecera: avatar + info + acción --}}
        <div class="d-flex align-items-center gap-3 flex-wrap" style="position:relative;z-index:1">

            <div class="profile-hero__avatar">{{ $inits }}</div>

            <div class="flex-grow-1 min-width-0">
                <p class="profile-hero__name">{{ $name }}</p>
                <p class="profile-hero__email">
                    <i class="bi bi-envelope me-1"></i>{{ $user->email }}
                </p>
                <span class="profile-hero__role">
                    <i class="bi bi-shield-check"></i> {{ $role }}
                </span>
            </div>

            <a href="{{ route('admin.profile.edit') }}"
                class="btn btn-primary btn-sm d-inline-flex align-items-center gap-1 flex-shrink-0"
                style="position:relative;z-index:1">
                <i class="bi bi-pencil-square"></i> Editar perfil
            </a>

        </div>

        <hr class="profile-hero__divider">

        {{-- Campos de detalle --}}
        <div class="profile-hero__fields">
            <div>
                <div class="profile-hero__field-label">
                    <i class="bi bi-person me-1"></i>Nombre
                </div>
                <div class="profile-hero__field-value">{{ $name }}</div>
            </div>
            <div>
                <div class="profile-hero__field-label">
                    <i class="bi bi-envelope me-1"></i>Email
                </div>
                <div class="profile-hero__field-value">{{ $user->email }}</div>
            </div>
            <div>
                <div class="profile-hero__field-label">
                    <i class="bi bi-shield-check me-1"></i>Rol
                </div>
                <div class="profile-hero__field-value">{{ $role }}</div>
            </div>
        </div>

    </div>

@endsection
