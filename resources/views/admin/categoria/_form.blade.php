<form action="{{ $isEdit ? route('admin.categorias.update', $categoria) : route('admin.categorias.store') }}" method="POST"
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
                value="{{ old('slug', $categoria->slug) }}" placeholder="Se genera automaticamente si lo dejas vacio">
        </div>

        <div class="full-span">
            <label for="icono" class="form-label">Icono</label>
            <div class="icon-input-group">
                <span class="entity-icon-chip entity-icon-chip--input">
                    <i class="{{ old('icono', $categoria->icono ?: 'bi bi-grid-1x2') }}"></i>
                </span>
                <input type="text" id="icono" name="icono" class="form-control"
                    value="{{ old('icono', $categoria->icono) }}" placeholder="Ejemplo: bi bi-camera-fill">
            </div>
            <div class="form-text">Usa una clase de Bootstrap Icons para mantener el lenguaje visual del panel.</div>
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
