@extends('admin.admin')

@section('title', 'Nueva categoria')
@section('breadcrumb', 'Categorias')

@section('admin-content')
    <div class="crud-toolbar">
        <div class="page-header mb-0">
            <h1>Nueva categoria</h1>
            <p>Define el nombre, el slug, el icono y la descripcion con los que se organizara el catalogo.</p>
        </div>

        <div class="crud-actions">
            <a href="{{ route('admin.categorias.index') }}" class="btn btn-outline-secondary">Volver al listado</a>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="admin-card">
        @include('admin.categoria._form')
    </div>
@endsection
