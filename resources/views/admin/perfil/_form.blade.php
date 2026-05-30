<form action="{{ route('admin.profile.update') }}"
    method="POST"
    enctype="multipart/form-data"
    class="d-flex flex-column gap-3 admin-form">
    @csrf
    @method('PUT')

    @php
        $fotoActual = $user->fotoPerfil ?? null;
        $inicialFoto = strtoupper(substr($user->name ?? 'U', 0, 1));
        $rolActual = ucfirst($user->getRoleNames()->first() ?? 'Sin rol');
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

    <div class="ec-card">
        <div class="ec-card__header">
            <span class="ec-card__icon">
                <i class="bi bi-person-circle"></i>
            </span>
            <div>
                <h2 class="ec-card__title">Cuenta</h2>
                <p class="ec-card__subtitle">Datos principales del usuario que usa este panel</p>
            </div>
        </div>

        <div class="form-grid">
            <div>
                <label for="name" class="form-label fw-semibold">
                    <i class="bi bi-person text-muted me-1"></i>Nombre
                </label>
                <input type="text" id="name" name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name ?? '') }}"
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
                    value="{{ old('email', $user->email ?? '') }}"
                    placeholder="correo@ejemplo.com"
                    required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="form-label fw-semibold">
                    <i class="bi bi-shield-check text-muted me-1"></i>Rol actual
                </label>
                <div class="form-control d-flex align-items-center" style="background:rgba(255,255,255,.4)">
                    {{ $rolActual }}
                </div>
            </div>

            <!-- <div>
                <label class="form-label fw-semibold">
                    <i class="bi bi-patch-check text-muted me-1"></i>Estado del correo
                </label>
                <div class="form-control d-flex align-items-center" style="background:rgba(255,255,255,.4)">
                    {{ $user->email_verified_at ? 'Verificado' : 'Pendiente de verificacion' }}
                </div>
            </div> -->
        </div>
    </div>

    <div class="ec-card">
        <div class="ec-card__header">
            <span class="ec-card__icon">
                <i class="bi bi-lock"></i>
            </span>
            <div>
                <h2 class="ec-card__title">Seguridad</h2>
                <p class="ec-card__subtitle">Actualiza tu contraseña cuando necesites reforzar el acceso</p>
            </div>
        </div>

        <div class="form-grid">
            @include('admin.partials.password-input', [
                'pwId' => 'password',
                'pwLabel' => 'Nueva contraseña',
                'pwRequired' => false,
                'pwHint' => 'Dejala vacia para mantener la actual.',
            ])

            @include('admin.partials.password-input', [
                'pwId' => 'password_confirmation',
                'pwLabel' => 'Confirmar contraseña',
                'pwRequired' => false,
            ])
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('admin.profile.show') }}" class="btn btn-outline-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1">
            <i class="bi bi-floppy"></i>
            Guardar cambios
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
