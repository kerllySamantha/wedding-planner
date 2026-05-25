@extends('admin.admin')

@section('title', 'Editar mi perfil')
@section('breadcrumb', 'Editar perfil personal')

@section('admin-content')
    <div class="crud-toolbar">
        <div class="page-header mb-0">
            <h1>Editar mi perfil</h1>
            <p>Actualiza tu nombre, email o contraseña.</p>
        </div>
        <div class="crud-actions">
            <a href="{{ route('admin.profile.show') }}" class="btn btn-outline-secondary">Volver</a>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="admin-card">
        <form action="{{ route('admin.profile.update') }}" method="POST" class="d-grid gap-4 admin-form">
            @csrf
            @method('PUT')

            <div class="form-grid">

                <div>
                    <label for="name" class="form-label fw-semibold">Nombre</label>
                    <input type="text" id="name" name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $user->name) }}"
                        required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" id="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $user->email) }}"
                        required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @include('admin.partials.password-input', [
                    'pwId'       => 'password',
                    'pwLabel'    => 'Nueva contraseña',
                    'pwRequired' => false,
                    'pwHint'     => 'Déjala vacía para mantener la actual.',
                ])

                @include('admin.partials.password-input', [
                    'pwId'       => 'password_confirmation',
                    'pwLabel'    => 'Confirmar contraseña',
                    'pwRequired' => false,
                ])

            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.profile.show') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>
        </form>
    </div>
@endsection
