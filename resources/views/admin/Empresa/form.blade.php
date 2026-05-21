@extends('admin.admin')

@section('title', $isEdit ? 'Editar empresa' : 'Nueva empresa')
@section('breadcrumb', 'Empresas')

@include('admin.partials.crud-styles')

@php
    $usuario = $empresa->usuario;
    $fotosEmpresa = $empresa->fotos;

    if (is_string($fotosEmpresa)) {
        $decoded = json_decode($fotosEmpresa, true);
        $fotosEmpresa = is_array($decoded) ? $decoded : [];
    }

    $fotosEmpresa = is_array($fotosEmpresa) ? $fotosEmpresa : [];
@endphp

@section('admin-content')
    <div class="crud-toolbar">
        <div class="page-header mb-0">
            <h1>{{ $isEdit ? 'Editar empresa' : 'Nueva empresa' }}</h1>
            <p>Gestiona la cuenta asociada, los datos de servicio y los archivos visuales de la empresa.</p>
        </div>

        <div class="crud-actions">
            <a href="{{ route('admin.empresas.index') }}" class="btn btn-outline-secondary">Volver al listado</a>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="admin-card">
        <form action="{{ $isEdit ? route('admin.empresas.update', $empresa) : route('admin.empresas.store') }}"
            method="POST" enctype="multipart/form-data" class="d-grid gap-4">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div>
                <h2 class="h5 mb-3">Usuario de acceso</h2>
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
                <h2 class="h5 mb-3">Datos de empresa</h2>
                <div class="form-grid">
                    <div>
                        <label for="nombre_empresa" class="form-label">Nombre de empresa</label>
                        <input type="text" id="nombre_empresa" name="nombre_empresa" class="form-control"
                            value="{{ old('nombre_empresa', $empresa->nombre_empresa) }}" required>
                    </div>

                    <div>
                        <label for="tipo_servicio" class="form-label">Tipo de servicio</label>
                        <input type="text" id="tipo_servicio" name="tipo_servicio" class="form-control"
                            value="{{ old('tipo_servicio', $empresa->tipo_servicio) }}" required>
                    </div>

                    <div>
                        <label for="telefono" class="form-label">Telefono</label>
                        <input type="text" id="telefono" name="telefono" class="form-control"
                            value="{{ old('telefono', $empresa->telefono) }}" required>
                    </div>

                    <div>
                        <label for="poblacion_id" class="form-label">Poblacion</label>
                        <select id="poblacion_id" name="poblacion_id" class="form-select" required>
                            <option value="">Selecciona una poblacion</option>
                            @foreach ($poblaciones as $poblacion)
                                <option value="{{ $poblacion->id }}"
                                    @selected(old('poblacion_id', $empresa->poblacion_id) == $poblacion->id)>
                                    {{ $poblacion->nombre }} - {{ $poblacion->provincia->nombre ?? 'Sin provincia' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="full-span">
                        <label for="direccion" class="form-label">Direccion</label>
                        <input type="text" id="direccion" name="direccion" class="form-control"
                            value="{{ old('direccion', $empresa->direccion) }}" required>
                    </div>

                    <div class="full-span">
                        <label for="descripcion" class="form-label">Descripcion</label>
                        <textarea id="descripcion" name="descripcion" rows="5" class="form-control">{{ old('descripcion', $empresa->descripcion) }}</textarea>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="h5 mb-3">Archivos</h2>
                <div class="form-grid">
                    <div>
                        <label for="logo" class="form-label">Logo</label>
                        <input type="file" id="logo" name="logo" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                        @if ($empresa->logo)
                            <div class="thumb-list">
                                <img src="{{ asset('storage/' . $empresa->logo) }}" alt="Logo actual">
                            </div>
                        @endif
                    </div>

                    <div>
                        <label for="fotos" class="form-label">Galeria</label>
                        <input type="file" id="fotos" name="fotos[]" class="form-control" multiple
                            accept=".jpg,.jpeg,.png,.webp">
                        <div class="muted mt-2">
                            Si subes nuevas fotos, se sustituira la galeria actual completa.
                        </div>

                        @if (! empty($fotosEmpresa))
                            <div class="thumb-list">
                                @foreach ($fotosEmpresa as $foto)
                                    <img src="{{ is_array($foto) ? ($foto['url'] ?? asset('storage/' . ($foto['path'] ?? ''))) : asset('storage/' . $foto) }}"
                                        alt="Foto de empresa">
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.empresas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    {{ $isEdit ? 'Guardar cambios' : 'Crear empresa' }}
                </button>
            </div>
        </form>
    </div>
@endsection
