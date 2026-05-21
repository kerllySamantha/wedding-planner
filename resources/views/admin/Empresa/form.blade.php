@extends('admin.admin')
@section('title', $isEdit ? 'Editar empresa' : 'Nueva empresa')
@section('breadcrumb', 'Empresas')
@push('styles')
    @vite('resources/css/empresa/empresa.css')
@endpush

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

    {{-- TOOLBAR --}}
    <div class="ec-toolbar">
        <div>
            <h1 class="ec-page-title">
                <i class="ti ti-building ec-page-title__icon" aria-hidden="true"></i>
                {{ $isEdit ? 'Editar empresa' : 'Nueva empresa' }}
            </h1>
            <p class="ec-page-subtitle">Gestiona la cuenta asociada, los datos de servicio y los archivos visuales.</p>
        </div>
        <a href="{{ route('admin.empresas.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-2">
            <i class="ti ti-arrow-left" aria-hidden="true"></i>
            Volver al listado
        </a>
    </div>

    @include('admin.partials.flash')

    {{-- FORM --}}
    <form
        action="{{ $isEdit ? route('admin.empresas.update', $empresa) : route('admin.empresas.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="d-flex flex-column gap-3 admin-form"
    >
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        {{-- SECCIÓN: USUARIO --}}
        <div class="ec-card">
            <div class="ec-card__header">
                <span class="ec-card__icon"><i class="ti ti-user" aria-hidden="true"></i></span>
                <div>
                    <h2 class="ec-card__title">Usuario de acceso</h2>
                    <p class="ec-card__subtitle">Credenciales para iniciar sesión en la plataforma</p>
                </div>
            </div>

            <div class="ec-grid">
                <div class="ec-field">
                    <label for="name" class="ec-label">Nombre</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $usuario->name ?? '') }}"
                        required
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="ec-field">
                    <label for="email" class="ec-label">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $usuario->email ?? '') }}"
                        required
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="ec-field">
                    <label for="password" class="ec-label">
                        {{ $isEdit ? 'Nueva contraseña' : 'Contraseña' }}
                        @if ($isEdit)
                            <span class="ec-badge-optional">opcional</span>
                        @endif
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="{{ $isEdit ? 'Dejar vacío para no cambiar' : '' }}"
                        {{ $isEdit ? '' : 'required' }}
                    >
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="ec-field">
                    <label for="password_confirmation" class="ec-label">Confirmar contraseña</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control"
                        {{ $isEdit ? '' : 'required' }}
                    >
                </div>
            </div>
        </div>

        {{-- SECCIÓN: DATOS DE EMPRESA --}}
        <div class="ec-card">
            <div class="ec-card__header">
                <span class="ec-card__icon"><i class="ti ti-building-store" aria-hidden="true"></i></span>
                <div>
                    <h2 class="ec-card__title">Datos de empresa</h2>
                    <p class="ec-card__subtitle">Información pública visible en el directorio</p>
                </div>
            </div>

            <div class="ec-grid">
                <div class="ec-field">
                    <label for="nombre_empresa" class="ec-label">Nombre de empresa</label>
                    <input
                        type="text"
                        id="nombre_empresa"
                        name="nombre_empresa"
                        class="form-control @error('nombre_empresa') is-invalid @enderror"
                        value="{{ old('nombre_empresa', $empresa->nombre_empresa) }}"
                        required
                    >
                    @error('nombre_empresa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="ec-field">
                    <label for="tipo_servicio" class="ec-label">Tipo de servicio</label>
                    <input
                        type="text"
                        id="tipo_servicio"
                        name="tipo_servicio"
                        class="form-control @error('tipo_servicio') is-invalid @enderror"
                        value="{{ old('tipo_servicio', $empresa->tipo_servicio) }}"
                        required
                    >
                    @error('tipo_servicio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="ec-field">
                    <label for="telefono" class="ec-label">Teléfono</label>
                    <input
                        type="text"
                        id="telefono"
                        name="telefono"
                        class="form-control @error('telefono') is-invalid @enderror"
                        value="{{ old('telefono', $empresa->telefono) }}"
                        required
                    >
                    @error('telefono')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="ec-field">
                    <label for="poblacion_id" class="ec-label">Población</label>
                    <select
                        id="poblacion_id"
                        name="poblacion_id"
                        class="form-select @error('poblacion_id') is-invalid @enderror"
                        required
                    >
                        <option value="">Selecciona una población</option>
                        @foreach ($poblaciones as $poblacion)
                            <option
                                value="{{ $poblacion->id }}"
                                @selected(old('poblacion_id', $empresa->poblacion_id) == $poblacion->id)
                            >
                                {{ $poblacion->nombre }} — {{ $poblacion->provincia->nombre ?? 'Sin provincia' }}
                            </option>
                        @endforeach
                    </select>
                    @error('poblacion_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="ec-field ec-field--full">
                    <label for="direccion" class="ec-label">Dirección</label>
                    <input
                        type="text"
                        id="direccion"
                        name="direccion"
                        class="form-control @error('direccion') is-invalid @enderror"
                        value="{{ old('direccion', $empresa->direccion) }}"
                        required
                    >
                    @error('direccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="ec-field ec-field--full">
                    <label for="descripcion" class="ec-label">Descripción</label>
                    <textarea
                        id="descripcion"
                        name="descripcion"
                        rows="5"
                        class="form-control @error('descripcion') is-invalid @enderror"
                        placeholder="Descripción pública de la empresa..."
                    >{{ old('descripcion', $empresa->descripcion) }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- SECCIÓN: ARCHIVOS --}}
        <div class="ec-card">
            <div class="ec-card__header">
                <span class="ec-card__icon"><i class="ti ti-photo" aria-hidden="true"></i></span>
                <div>
                    <h2 class="ec-card__title">Archivos visuales</h2>
                    <p class="ec-card__subtitle">Logo e imágenes de galería de la empresa</p>
                </div>
            </div>

            <div class="ec-grid">
                {{-- LOGO --}}
                <div class="ec-field">
                    <label class="ec-label">Logo</label>
                    <label for="logo" class="ec-upload">
                        <input type="file" id="logo" name="logo" accept=".jpg,.jpeg,.png,.webp">
                        <i class="ti ti-cloud-upload" aria-hidden="true"></i>
                        <span>Haz clic para subir el logo</span>
                        <small>.jpg, .jpeg, .png, .webp</small>
                    </label>

                    @if ($empresa->logo)
                        <div class="ec-thumbs mt-2">
                            <div class="ec-thumb">
                                <img src="{{ asset('storage/' . $empresa->logo) }}" alt="Logo actual">
                            </div>
                        </div>
                    @endif
                </div>

                {{-- GALERÍA --}}
                <div class="ec-field">
                    <label class="ec-label">Galería</label>
                    <label for="fotos" class="ec-upload">
                        <input type="file" id="fotos" name="fotos[]" multiple accept=".jpg,.jpeg,.png,.webp">
                        <i class="ti ti-photo-plus" aria-hidden="true"></i>
                        <span>Haz clic para subir fotos</span>
                        <small>Múltiples archivos permitidos</small>
                    </label>

                    <p class="ec-hint mt-2">
                        <i class="ti ti-info-circle" aria-hidden="true"></i>
                        Si subes nuevas fotos, se reemplazará la galería actual completa.
                    </p>

                    @if (! empty($fotosEmpresa))
                        <div class="ec-thumbs mt-2">
                            @foreach ($fotosEmpresa as $foto)
                                <div class="ec-thumb">
                                    <img
                                        src="{{ is_array($foto) ? ($foto['url'] ?? asset('storage/' . ($foto['path'] ?? ''))) : asset('storage/' . $foto) }}"
                                        alt="Foto de empresa"
                                    >
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- FOOTER ACTIONS --}}
        <div class="ec-footer">
            <p class="ec-footer__hint">
                <i class="ti ti-device-floppy" aria-hidden="true"></i>
                Los cambios se guardarán al confirmar
            </p>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.empresas.index') }}" class="btn btn-outline-secondary btn-sm">Cancelar</a>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="ti ti-check" aria-hidden="true"></i>
                    {{ $isEdit ? 'Guardar cambios' : 'Crear empresa' }}
                </button>
            </div>
        </div>

    </form>

@endsection