<form action="{{ $isEdit ? route('admin.categorias.update', $categoria) : route('admin.categorias.store') }}"
    method="POST"
    enctype="multipart/form-data"
    class="d-grid gap-4 admin-form">
    @csrf

    @if ($isEdit)
        @method('PUT')
    @endif

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
                placeholder="Se genera automáticamente si lo dejas vacío">
        </div>

        <div class="full-span">
            <label for="icono" class="form-label">Imagen / Icono</label>

            <div class="category-image-upload">
                <div class="category-image-preview">
                    @if (!empty($categoria->icono))
                        <img src="{{ asset('storage/' . $categoria->icono) }}" alt="{{ $categoria->nombre }}">
                    @else
                        <i class="bi bi-image"></i>
                    @endif
                </div>

                <div class="category-image-content">
                    <input type="file" id="icono" name="icono"
                        class="form-control @error('icono') is-invalid @enderror"
                        accept="image/png,image/jpeg,image/jpg,image/webp,image/svg+xml">

                    <div class="form-text">
                        Sube una imagen profesional para representar la categoría. Formatos permitidos:
                        JPG, PNG, WEBP o SVG.
                    </div>

                    @error('icono')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="full-span">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="6" class="form-control"
                placeholder="Describe el uso de esta categoría dentro del catálogo.">{{ old('descripcion', $categoria->descripcion) }}</textarea>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ $isEdit ? route('admin.categorias.show', $categoria) : route('admin.categorias.index') }}"
            class="btn btn-outline-secondary">Cancelar</a>

        <button type="submit" class="btn btn-primary">
            {{ $isEdit ? 'Guardar cambios' : 'Crear categoría' }}
        </button>
    </div>
</form>