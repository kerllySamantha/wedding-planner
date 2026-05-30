@extends('admin.admin')

@section('title', 'Editar categoria')
@section('breadcrumb', 'Categorias')

@section('admin-content')
    <div class="crud-toolbar">
        <div class="page-header mb-0">
            <h1>Editar categoria</h1>
            <p>Ajusta la presentacion y la estructura base de esta categoria dentro del catalogo.</p>
        </div>

        <div class="crud-actions">
            <a href="{{ route('admin.categorias.show', $categoria) }}" class="btn btn-outline-secondary">Volver al detalle</a>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="admin-card">
        @include('admin.categoria._form')
    </div>
@endsection
