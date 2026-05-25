@extends('admin.admin')

@section('title', 'Mi perfil')
@section('breadcrumb', 'Mi perfil')

@section('admin-content')
    <div class="crud-toolbar">
        <div class="page-header mb-0">
            <h1>Editar perfil</h1>
            <p>Actualiza tu informacion de acceso y la imagen con la que te identificas en el panel.</p>
        </div>

        <div class="crud-actions">
            <a href="{{ route('admin.profile.show') }}"
                class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1">
                <i class="bi bi-arrow-left"></i> Volver al perfil
            </a>
        </div>
    </div>

    @include('admin.partials.flash')

    @include('admin.perfil._form')
@endsection
