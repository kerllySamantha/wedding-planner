<form action="{{ $isEdit ? route('admin.categorias.update', $categoria) : route('admin.categorias.store') }}"
    method="POST"
    enctype="multipart/form-data"
    class="d-grid gap-4 admin-form">
    @csrf

    @if ($isEdit)
        @method('PUT')
    @endif

    @php
        $iconoManual = old('icono');
        $existingPreviewUrl = $categoria->iconPreviewUrl();
        $existingPreviewClass = $categoria->iconPreviewClass();
        $initialManualValue = $iconoManual ?? ($categoria->isBootstrapIcon() || $categoria->isExternalIconUrl() ? $categoria->icono : '');
    @endphp

    <div class="form-grid">
        <div>
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" id="nombre" name="nombre" class="form-control"
                value="{{ old('nombre', $categoria->nombre) }}" required>
        </div>

        <div>
            <label for="slug" class="form-label">Slug</label>
            <input type="text" id="slug" name="slug" class="form-control"
                value="{{ old('slug', $categoria->slug) }}"
                placeholder="Se genera automaticamente si lo dejas vacio">
        </div>

        <div class="full-span">
            <label for="icono" class="form-label">Icono</label>

            <div class="category-icon-editor">
                <div class="category-icon-preview-card"
                    id="categoryIconPreview"
                    data-existing-url="{{ $existingPreviewUrl ?? '' }}"
                    data-existing-class="{{ $existingPreviewClass }}"
                    data-default-class="bi bi-grid-1x2">

                    <div class="category-icon-preview-visual">
                        <img id="categoryIconPreviewImg"
                            src="{{ $existingPreviewUrl ?? '' }}"
                            alt="Previsualizacion del icono"
                            class="{{ $existingPreviewUrl ? '' : 'd-none' }}">

                        <i id="categoryIconPreviewGlyph"
                            class="{{ $existingPreviewUrl ? 'd-none ' : '' }}{{ $existingPreviewClass }}"></i>
                    </div>

                    <div class="category-icon-preview-copy">
                        <strong id="categoryIconPreviewLabel">
                            {{ $existingPreviewUrl ? 'Imagen actual' : ($categoria->isBootstrapIcon() ? 'Icono Bootstrap actual' : 'Vista previa del icono') }}
                        </strong>
                       
                    </div>
                </div>

                <div class="category-icon-editor__fields mx-5">
                    <div>
                        <label for="icono" class="form-label">Clase Bootstrap Icons o URL</label>
                        <input type="text"
                            id="icono"
                            name="icono"
                            class="form-control @error('icono') is-invalid @enderror"
                            value="{{ $initialManualValue }}"
                            placeholder="bi bi-camera-fill o https://ejemplo.com/icono.png">

                    

                        @error('icono')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-5">
                        <label for="icono_file" class="form-label">Subir imagen</label>
                        <input type="file"
                            id="icono_file"
                            name="icono_file"
                            class="form-control @error('icono_file') is-invalid @enderror"
                            accept="image/png,image/jpeg,image/jpg,image/webp,image/svg+xml">


                        @error('icono_file')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="full-span">
            <label for="descripcion" class="form-label">Descripcion</label>
            <textarea id="descripcion" name="descripcion" rows="6" class="form-control"
                placeholder="Describe el uso de esta categoria dentro del catalogo.">{{ old('descripcion', $categoria->descripcion) }}</textarea>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ $isEdit ? route('admin.categorias.show', $categoria) : route('admin.categorias.index') }}"
            class="btn btn-outline-secondary">Cancelar</a>

        <button type="submit" class="btn btn-primary">
            {{ $isEdit ? 'Guardar cambios' : 'Crear categoria' }}
        </button>
    </div>
</form>

@push('admin-scripts')
<script>
    (function () {
        const preview = document.getElementById('categoryIconPreview');
        const textInput = document.getElementById('icono');
        const fileInput = document.getElementById('icono_file');

        if (!preview || !textInput || !fileInput) {
            return;
        }

        const img = document.getElementById('categoryIconPreviewImg');
        const glyph = document.getElementById('categoryIconPreviewGlyph');
        const label = document.getElementById('categoryIconPreviewLabel');
        const hint = document.getElementById('categoryIconPreviewHint');
        const existingUrl = preview.dataset.existingUrl || '';
        const existingClass = preview.dataset.existingClass || 'bi bi-grid-1x2';
        const defaultClass = preview.dataset.defaultClass || 'bi bi-grid-1x2';

        function isUrl(value) {
            try {
                const url = new URL(value);
                return url.protocol === 'http:' || url.protocol === 'https:';
            } catch (error) {
                return false;
            }
        }

        function isBootstrap(value) {
            return /^bi(?:\s|$|-)/.test(value.trim());
        }

        function showImage(src, title, subtitle) {
            img.src = src;
            img.classList.remove('d-none');
            glyph.classList.add('d-none');
            label.textContent = title;
            hint.textContent = subtitle;
        }

        function showIcon(iconClass, title, subtitle) {
            glyph.className = iconClass + ' category-icon-preview-glyph';
            glyph.classList.remove('d-none');
            img.classList.add('d-none');
            label.textContent = title;
            hint.textContent = subtitle;
        }

        function updatePreview() {
            const manualValue = textInput.value.trim();

            if (fileInput.files && fileInput.files[0]) {
                const objectUrl = URL.createObjectURL(fileInput.files[0]);
                showImage(objectUrl, fileInput.files[0].name, 'Imagen local seleccionada para subir.');
                return;
            }

            if (manualValue !== '') {
                if (isUrl(manualValue)) {
                    showImage(manualValue, 'Imagen remota', manualValue);
                    return;
                }

                if (isBootstrap(manualValue)) {
                    showIcon(manualValue, 'Icono Bootstrap', manualValue);
                    return;
                }

                showIcon(defaultClass, 'Valor no reconocido', 'Usa una clase `bi ...`, una URL valida o sube una imagen.');
                return;
            }

            if (existingUrl) {
                showImage(existingUrl, 'Imagen actual', 'Se mantendra la imagen guardada si no haces cambios.');
                return;
            }

            showIcon(existingClass, 'Icono actual', 'Se mantendra el icono actual si no haces cambios.');
        }

        textInput.addEventListener('input', updatePreview);
        fileInput.addEventListener('change', updatePreview);
        updatePreview();
    })();
</script>
@endpush
