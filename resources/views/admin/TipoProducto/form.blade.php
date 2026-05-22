@extends('admin.admin')

@section('title', $isEdit ? 'Editar tipo de producto' : 'Nuevo tipo de producto')
@section('breadcrumb', 'Tipos de producto')

@section('admin-content')
    <div class="crud-toolbar">
        <div class="page-header mb-0">
            <h1>{{ $isEdit ? 'Editar tipo de producto' : 'Nuevo tipo de producto' }}</h1>
            <p>Define el nombre, la categoria y la modalidad con la que se usara en el sistema.</p>
        </div>

        <div class="crud-actions">
            <a href="{{ route('admin.tipos-producto.index') }}" class="btn btn-outline-secondary">Volver al listado</a>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="admin-card">
        <form
            action="{{ $isEdit ? route('admin.tipos-producto.update', $tipoProducto) : route('admin.tipos-producto.store') }}"
            method="POST" class="d-grid gap-4 admin-form">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="form-grid">
                <div>
                    <label for="categoria_id" class="form-label">Categoria</label>
                    <select id="categoria_id" name="categoria_id" class="form-select" required>
                        <option value="">Selecciona una categoria</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}"
                                @selected(old('categoria_id', $tipoProducto->categoria_id) == $categoria->id)>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="modalidad" class="form-label">Modalidad</label>
                    <select id="modalidad" name="modalidad" class="form-select" required>
                        @foreach (['producto' => 'Producto', 'servicio' => 'Servicio', 'dia' => 'Dia'] as $valor => $texto)
                            <option value="{{ $valor }}" @selected(old('modalidad', $tipoProducto->modalidad ?: 'dia') === $valor)>
                                {{ $texto }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="full-span">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="form-control"
                        value="{{ old('nombre', $tipoProducto->nombre) }}" required>
                </div>

                <div class="full-span">
                    <label for="descripcion" class="form-label">Descripcion</label>
                    <textarea id="descripcion" name="descripcion" rows="5" class="form-control">{{ old('descripcion', $tipoProducto->descripcion) }}</textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.tipos-producto.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    {{ $isEdit ? 'Guardar cambios' : 'Crear tipo' }}
                </button>
            </div>
        </form>
    </div>
@endsection
