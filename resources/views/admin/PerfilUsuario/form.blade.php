@extends('admin.admin')

@section('title', $isEdit ? 'Editar perfil de usuario' : 'Nuevo perfil de usuario')
@section('breadcrumb', 'Perfiles de usuario')

@php
    $usuario = $perfilUsuario->user;
@endphp

@section('admin-content')
    <div class="crud-toolbar">
        <div class="page-header mb-0">
            <h1>{{ $isEdit ? 'Editar perfil de usuario' : 'Nuevo perfil de usuario' }}</h1>
            <p>Alta y edicion del usuario final junto con sus datos de perfil y fecha de boda.</p>
        </div>

        <div class="crud-actions">
            <a href="{{ route('admin.perfiles-usuario.index') }}" class="btn btn-outline-secondary">Volver al listado</a>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="admin-card">
        <form
            action="{{ $isEdit ? route('admin.perfiles-usuario.update', $perfilUsuario) : route('admin.perfiles-usuario.store') }}"
            method="POST" class="d-grid gap-4 admin-form">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div>
                <h2 class="h5 mb-3">Cuenta</h2>
                <div class="form-grid">
                    <div>
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" id="name" name="name" class="form-control"
                            value="{{ old('name', $usuario->name ?? '') }}" required>
                    </div>

                    <div>
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control"
                            value="{{ old('email', $usuario->email ?? '') }}" required>
                    </div>

                    <div>
                        <label for="password" class="form-label">
                            {{ $isEdit ? 'Nueva contrasena' : 'Contrasena' }}
                        </label>
                        <input type="password" id="password" name="password" class="form-control"
                            {{ $isEdit ? '' : 'required' }}>
                    </div>

                    <div>
                        <label for="password_confirmation" class="form-label">Confirmar contrasena</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control" {{ $isEdit ? '' : 'required' }}>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="h5 mb-3">Perfil</h2>
                <div class="form-grid">
                    <div>
                        <label for="telefono" class="form-label">Telefono</label>
                        <input type="text" id="telefono" name="telefono" class="form-control"
                            value="{{ old('telefono', $perfilUsuario->telefono) }}" required>
                    </div>

                    <div>
                        <label for="fecha_boda" class="form-label">Fecha de boda</label>
                        <input type="date" id="fecha_boda" name="fecha_boda" class="form-control"
                            value="{{ old('fecha_boda', $perfilUsuario->fecha_boda) }}" required>
                    </div>

                    <div>
                        <label for="poblacion_id" class="form-label">Poblacion</label>
                        <select id="poblacion_id" name="poblacion_id" class="form-select" required>
                            <option value="">Selecciona una poblacion</option>
                            @foreach ($poblaciones as $poblacion)
                                <option value="{{ $poblacion->id }}"
                                    @selected(old('poblacion_id', $perfilUsuario->poblacion_id) == $poblacion->id)>
                                    {{ $poblacion->nombre }} - {{ $poblacion->provincia->nombre ?? 'Sin provincia' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="full-span">
                        <label for="direccion" class="form-label">Direccion</label>
                        <input type="text" id="direccion" name="direccion" class="form-control"
                            value="{{ old('direccion', $perfilUsuario->direccion) }}" required>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.perfiles-usuario.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    {{ $isEdit ? 'Guardar cambios' : 'Crear perfil' }}
                </button>
            </div>
        </form>
    </div>
@endsection
