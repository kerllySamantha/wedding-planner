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
                <i class="bi bi-building-gear ec-page-title__icon" aria-hidden="true"></i>
                {{ $isEdit ? 'Editar empresa' : 'Nueva empresa' }}
            </h1>
            <p class="ec-page-subtitle">Gestiona la cuenta asociada, los datos de servicio y los archivos visuales.</p>
        </div>
        <a href="{{ route('admin.empresas.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-2">
            <i class="bi bi-arrow-left-short" aria-hidden="true"></i>
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
                <span class="ec-card__icon"><i class="bi bi-person" aria-hidden="true"></i></span>
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
                <span class="ec-card__icon"><i class="bi bi-building" aria-hidden="true"></i></span>
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
                <span class="ec-card__icon"><i class="bi bi-file-image" aria-hidden="true"></i></span>
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
                        <i class="bi bi-cloud-plus" aria-hidden="true"></i>
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
                        <i class="bi bi-plus-circle-fill" aria-hidden="true"></i>
                        <span>Haz clic para subir fotos</span>
                        <small>Múltiples archivos · máx. 3 MB por foto</small>
                    </label>

                    <p class="ec-hint mt-2">
                        <i class="bi bi-info-circle" aria-hidden="true"></i>
                        Las nuevas fotos se añadirán a la galería existente.
                    </p>

                    @if (! empty($fotosEmpresa))
                        <div class="ec-thumbs mt-2">
                            @foreach ($fotosEmpresa as $index => $foto)
                                <div class="ec-thumb ec-thumb--deletable">
                                    <img
                                        src="{{ is_array($foto) ? ($foto['url'] ?? asset('storage/' . ($foto['path'] ?? ''))) : asset('storage/' . $foto) }}"
                                        alt="Foto de empresa"
                                    >
                                    @if ($isEdit)
                                        <button
                                            type="button"
                                            class="ec-thumb__delete"
                                            data-delete-url="{{ route('admin.empresas.fotos.destroy', [$empresa->id, $index]) }}"
                                            aria-label="Eliminar foto"
                                            title="Eliminar foto"
                                        ><i class="bi bi-x" aria-hidden="true"></i></button>
                                    @endif
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
                <i class="bi bi-floppy" aria-hidden="true"></i>
                Los cambios se guardarán al confirmar
            </p>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.empresas.index') }}" class="btn btn-outline-secondary btn-sm">Cancelar</a>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-check2-circle" aria-hidden="true"></i>
                    {{ $isEdit ? 'Guardar cambios' : 'Crear empresa' }}
                </button>
            </div>
        </div>

    </form>

@if ($isEdit)
    {{-- Modal de confirmación para eliminar foto --}}
    <div class="modal fade" id="confirmDeleteFotoModal" tabindex="-1" aria-labelledby="confirmDeleteFotoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-semibold" id="confirmDeleteFotoModalLabel">
                        <i class="bi bi-camera-video-off text-danger me-1" aria-hidden="true"></i>
                        Eliminar foto
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0 text-secondary">¿Seguro que quieres eliminar esta foto? La imagen se borrará definitivamente.</p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteFotoForm" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash me-1" aria-hidden="true"></i>
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- Lightbox: visor de imagen a tamaño completo --}}
<div class="modal fade" id="imagenLightbox" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0" style="background:rgba(0,0,0,0.88);">
            <button
                type="button"
                class="btn-close btn-close-white ms-auto mt-2 me-2"
                data-bs-dismiss="modal"
                aria-label="Cerrar"
            ></button>
            <div class="modal-body p-3 text-center">
                <img
                    id="imagenLightboxImg"
                    src=""
                    alt=""
                    style="max-width:100%;max-height:75vh;border-radius:0.5rem;object-fit:contain;"
                >
            </div>
        </div>
    </div>
</div>

@endsection

@push('admin-scripts')
<script>
(function () {
    // ── Preview de logo ──────────────────────────────────────────────
    const logoInput = document.getElementById('logo');
    if (logoInput) {
        logoInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const zone   = this.closest('.ec-upload');
            const field  = this.closest('.ec-field');

            zone.classList.add('ec-upload--selected');
            zone.querySelector('span').textContent = file.name;
            const icon = zone.querySelector('i');
            if (icon) { icon.className = 'bi bi-check-circle'; }

            let preview = field.querySelector('.ec-preview-new');
            if (!preview) {
                preview = document.createElement('div');
                preview.className = 'ec-preview-new mt-2';
                zone.after(preview);
            }

            const reader = new FileReader();
            reader.onload = (ev) => {
                preview.innerHTML =
                    '<p class="ec-hint mb-2"><i class="bi bi-stars" aria-hidden="true"></i> Nueva imagen seleccionada</p>' +
                    '<div class="ec-thumbs">' +
                        '<div class="ec-thumb ec-thumb--lg">' +
                            '<img src="' + ev.target.result + '" alt="Vista previa del logo">' +
                        '</div>' +
                    '</div>';
            };
            reader.readAsDataURL(file);
        });
    }

    // ── Lightbox: clic en miniatura para ver a tamaño completo ───────
    const lightboxModal = document.getElementById('imagenLightbox');
    const lightboxImg   = document.getElementById('imagenLightboxImg');
    let bsLightbox = null;
    if (lightboxModal && lightboxImg) {
        bsLightbox = new bootstrap.Modal(lightboxModal);
        document.addEventListener('click', function (e) {
            if (e.target.tagName === 'IMG' && e.target.closest('.ec-thumbs')) {
                lightboxImg.src = e.target.src;
                lightboxImg.alt = e.target.alt || '';
                bsLightbox.show();
            }
        });
    }

    // ── Eliminar foto individual (fotos ya guardadas) ────────────────
    const deleteModal = document.getElementById('confirmDeleteFotoModal');
    const deleteFotoForm = document.getElementById('deleteFotoForm');
    if (deleteModal && deleteFotoForm) {
        const bsModal = new bootstrap.Modal(deleteModal);
        document.querySelectorAll('.ec-thumb__delete[data-delete-url]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                deleteFotoForm.action = this.dataset.deleteUrl;
                bsModal.show();
            });
        });
    }

    // ── Preview de galería con X por archivo ─────────────────────────
    const fotosInput = document.getElementById('fotos');
    if (fotosInput) {
        let allFiles = [];
        const zone  = fotosInput.closest('.ec-upload');
        const field = fotosInput.closest('.ec-field');

        function drawGalleryPreview() {
            const count = allFiles.length;
            const plural = count !== 1;

            if (count === 0) {
                zone.classList.remove('ec-upload--selected');
                zone.querySelector('span').textContent = 'Haz clic para subir fotos';
                const iconEl = zone.querySelector('i');
                if (iconEl) { iconEl.className = 'bi bi-file-image'; }
                const old = field.querySelector('.ec-preview-new');
                if (old) old.remove();
                return;
            }

            zone.classList.add('ec-upload--selected');
            zone.querySelector('span').textContent =
                count + ' archivo' + (plural ? 's' : '') + ' seleccionado' + (plural ? 's' : '');
            const iconEl = zone.querySelector('i');
            if (iconEl) { iconEl.className = 'bi bi-check-circle'; }

            let preview = field.querySelector('.ec-preview-new');
            if (!preview) {
                preview = document.createElement('div');
                preview.className = 'ec-preview-new mt-2';
                zone.after(preview);
            }

            preview.innerHTML =
                '<p class="ec-hint mb-2"><i class="bi bi-stars" aria-hidden="true"></i> ' +
                count + ' foto' + (plural ? 's' : '') + ' nueva' + (plural ? 's' : '') + ' seleccionada' + (plural ? 's' : '') +
                '</p><div class="ec-thumbs"></div>';

            const grid = preview.querySelector('.ec-thumbs');
            allFiles.forEach(function (file, idx) {
                const url = URL.createObjectURL(file);
                const thumb = document.createElement('div');
                thumb.className = 'ec-thumb ec-thumb--lg ec-thumb--deletable';
                thumb.innerHTML =
                    '<img src="' + url + '" alt="' + file.name + '">' +
                    '<button type="button" class="ec-thumb__delete" aria-label="Quitar foto">' +
                        '<i class="bi bi-x" aria-hidden="true"></i>' +
                    '</button>';

                thumb.querySelector('.ec-thumb__delete').addEventListener('click', function (e) {
                    e.stopPropagation();
                    allFiles.splice(idx, 1);
                    if (typeof DataTransfer !== 'undefined') {
                        const dt = new DataTransfer();
                        allFiles.forEach(function (f) { dt.items.add(f); });
                        fotosInput.files = dt.files;
                    }
                    drawGalleryPreview();
                });

                grid.appendChild(thumb);
            });
        }

        fotosInput.addEventListener('change', function () {
            const newFiles = Array.from(this.files);
            if (!newFiles.length) return;

            const maxBytes = 3072 * 1024;
            const oversized = newFiles.filter(function (f) { return f.size > maxBytes; });

            if (oversized.length) {
                const names = oversized.map(function (f) { return f.name; }).join(', ');
                let errEl = field.querySelector('.ec-size-error');
                if (!errEl) {
                    errEl = document.createElement('p');
                    errEl.className = 'ec-size-error text-danger small mt-1';
                    field.appendChild(errEl);
                }
                errEl.textContent = 'Las siguientes fotos superan el límite de 3 MB y no se añadirán: ' + names;
            } else {
                const errEl = field.querySelector('.ec-size-error');
                if (errEl) errEl.remove();
            }

            newFiles.forEach(function (f) {
                if (f.size <= maxBytes && !allFiles.some(function (x) { return x.name === f.name && x.size === f.size; })) {
                    allFiles.push(f);
                }
            });

            if (typeof DataTransfer !== 'undefined') {
                const dt = new DataTransfer();
                allFiles.forEach(function (f) { dt.items.add(f); });
                fotosInput.files = dt.files;
            }

            drawGalleryPreview();
        });
    }
})();
</script>
@endpush