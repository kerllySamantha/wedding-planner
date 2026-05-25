@extends('admin.admin')

@section('title', $isEdit ? 'Editar perfil de usuario' : 'Nuevo perfil de usuario')
@section('breadcrumb', 'Perfiles de usuario')

@php $usuario = $perfilUsuario->user; @endphp

@section('admin-content')
    <div class="crud-toolbar">
        <div class="page-header mb-0">
            <h1>{{ $isEdit ? 'Editar perfil' : 'Nuevo perfil' }}</h1>
            <p>{{ $isEdit ? 'Actualiza los datos de cuenta y boda del usuario.' : 'Crea un nuevo usuario con sus datos de boda.' }}</p>
        </div>
        <div class="crud-actions">
            <a href="{{ route('admin.perfiles-usuario.index') }}"
                class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1">
                <i class="bi bi-arrow-left"></i> Volver al listado
            </a>
        </div>
    </div>

    @include('admin.partials.flash')

    <form
        action="{{ $isEdit ? route('admin.perfiles-usuario.update', $perfilUsuario) : route('admin.perfiles-usuario.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="d-flex flex-column gap-3 admin-form">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        {{-- ── FOTO DE PERFIL ── --}}
        @php
            $fotoActual = $isEdit ? ($perfilUsuario->user?->fotoPerfil ?? null) : null;
            $inicialFoto = strtoupper(substr($isEdit ? ($perfilUsuario->user?->name ?? 'U') : 'U', 0, 1));
        @endphp
        <div class="text-center py-2">
            <div class="foto-upload-wrapper" id="fotoUploadWrapper">
                @if ($fotoActual)
                    <img src="{{ asset('storage/' . $fotoActual) }}"
                         alt="Foto de perfil"
                         id="fotoPreviewImg"
                         class="foto-upload-img">
                @else
                    <span id="fotoPreviewInicial" class="foto-upload-inicial">{{ $inicialFoto }}</span>
                @endif
                <label for="fotoPerfil" class="foto-upload-btn" title="Cambiar foto">
                    <i class="bi bi-camera-fill"></i>
                </label>
            </div>
            <p class="mt-2 mb-0" style="font-size:.78rem;color:#3d5f80">
                {{ $fotoActual ? 'Haz clic en la foto para cambiarla' : 'Sube una foto de perfil' }}
            </p>
            <input type="file" id="fotoPerfil" name="fotoPerfil" accept="image/*" class="d-none">
            @error('fotoPerfil')
                <div class="text-danger mt-1" style="font-size:.82rem">{{ $message }}</div>
            @enderror
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

            <div class="form-grid">

                <div>
                    <label for="name" class="form-label fw-semibold">
                        <i class="bi bi-person text-muted me-1"></i>Nombre
                    </label>
                    <input type="text" id="name" name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $usuario->name ?? '') }}"
                        placeholder="Nombre completo"
                        required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="email" class="form-label fw-semibold">
                        <i class="bi bi-envelope text-muted me-1"></i>Email
                    </label>
                    <input type="email" id="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $usuario->email ?? '') }}"
                        placeholder="correo@ejemplo.com"
                        required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @include('admin.partials.password-input', [
                    'pwId'       => 'password',
                    'pwLabel'    => $isEdit ? 'Nueva contraseña' : 'Contraseña',
                    'pwRequired' => ! $isEdit,
                    'pwHint'     => $isEdit ? 'Déjala vacía para mantener la actual.' : null,
                ])

                @include('admin.partials.password-input', [
                    'pwId'       => 'password_confirmation',
                    'pwLabel'    => 'Confirmar contraseña',
                    'pwRequired' => ! $isEdit,
                ])

            </div>
        </div>

        {{-- ── DATOS DE BODA ── --}}
        <div class="ec-card">
            <div class="ec-card__header">
                <span class="ec-card__icon">
                    <i class="bi bi-heart"></i>
                </span>
                <div>
                    <h2 class="ec-card__title">Datos de boda</h2>
                    <p class="ec-card__subtitle">Información de contacto y evento nupcial</p>
                </div>
            </div>

            <div class="form-grid">

                <div>
                    <label for="telefono" class="form-label fw-semibold">
                        <i class="bi bi-telephone text-muted me-1"></i>Teléfono
                    </label>
                    <input type="text" id="telefono" name="telefono"
                        class="form-control @error('telefono') is-invalid @enderror"
                        value="{{ old('telefono', $perfilUsuario->telefono) }}"
                        placeholder="+34 600 000 000"
                        required>
                    @error('telefono')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="fecha_boda" class="form-label fw-semibold">
                        <i class="bi bi-calendar-heart text-muted me-1"></i>Fecha de boda
                    </label>
                    <input type="date" id="fecha_boda" name="fecha_boda"
                        class="form-control @error('fecha_boda') is-invalid @enderror"
                        value="{{ old('fecha_boda', $perfilUsuario->fecha_boda) }}"
                        required>
                    @error('fecha_boda')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="full-span">
                    <label for="poblacion_id" class="form-label fw-semibold">
                        <i class="bi bi-geo-alt text-muted me-1"></i>Población
                    </label>
                    <select id="poblacion_id" name="poblacion_id"
                        class="form-select @error('poblacion_id') is-invalid @enderror"
                        required>
                        <option value="">Selecciona una población…</option>
                        @foreach ($poblaciones as $poblacion)
                            <option value="{{ $poblacion->id }}"
                                @selected(old('poblacion_id', $perfilUsuario->poblacion_id) == $poblacion->id)>
                                {{ $poblacion->nombre }} — {{ $poblacion->provincia->nombre ?? 'Sin provincia' }}
                            </option>
                        @endforeach
                    </select>
                    @error('poblacion_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="full-span">
                    <label for="direccion" class="form-label fw-semibold">
                        <i class="bi bi-signpost-2 text-muted me-1"></i>Dirección
                    </label>
                    <input type="text" id="direccion" name="direccion"
                        class="form-control @error('direccion') is-invalid @enderror"
                        value="{{ old('direccion', $perfilUsuario->direccion) }}"
                        placeholder="Calle, número, piso…"
                        required>
                    @error('direccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>

        {{-- ── ACCIONES ── --}}
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.perfiles-usuario.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1">
                <i class="bi {{ $isEdit ? 'bi-floppy' : 'bi-person-plus-fill' }}"></i>
                {{ $isEdit ? 'Guardar cambios' : 'Crear perfil' }}
            </button>
        </div>

    </form>
@push('admin-scripts')
<script>
    document.getElementById('fotoPerfil').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (ev) {
            const wrapper = document.getElementById('fotoUploadWrapper');

            // Replace initials span with img if needed
            let img = wrapper.querySelector('img#fotoPreviewImg');
            if (!img) {
                const span = wrapper.querySelector('span#fotoPreviewInicial');
                if (span) span.remove();
                img = document.createElement('img');
                img.id = 'fotoPreviewImg';
                img.alt = 'Foto de perfil';
                img.className = 'foto-upload-img';
                wrapper.insertBefore(img, wrapper.querySelector('label'));
            }
            img.src = ev.target.result;
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush
@endsection
