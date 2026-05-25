<div class="row g-4">

    {{-- Nombre --}}
    <div class="col-md-6">

        <label class="form-label fw-bold">

            Nombre

        </label>

        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $user->name ?? '') }}">

        @error('name')
            <div class="invalid-feedback d-block">

                {{ $message }}

            </div>
        @enderror

    </div>

    {{-- Email --}}
    <div class="col-md-6">

        <label class="form-label fw-bold">

            Email

        </label>

        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $user->email ?? '') }}">

        @error('email')
            <div class="invalid-feedback d-block">

                {{ $message }}

            </div>
        @enderror

    </div>

    {{-- Password --}}
    <div class="col-md-6">

        <label class="form-label fw-bold">

            Contraseña

        </label>

        <div class="input-group">

            <input type="text" name="password" id="password"
                class="form-control @error('password') is-invalid @enderror">

            <button type="button" class="btn btn-outline-secondary" id="generatePasswordBtn">

                <i class="bi bi-magic"></i>

                Generar

            </button>

        </div>

        @isset($user)
            <small class="text-muted d-block">

                Déjalo vacío para mantener la actual

            </small>
        @endisset

        @error('password')
            <div class="invalid-feedback d-block">

                {{ $message }}

            </div>
        @enderror

    </div>

    {{-- Rol --}}
    <div class="col-md-6">

        <label class="form-label fw-bold">

            Rol

        </label>

        <select name="role" class="form-select @error('role') is-invalid @enderror">

            @foreach ($roles as $role)
                <option value="{{ $role->name }}"
                    {{ old('role', isset($user) ? $user->roles->first()?->name : '') === $role->name ? 'selected' : '' }}>

                    {{ ucfirst($role->name) }}

                </option>
            @endforeach

        </select>

        @error('role')
            <div class="invalid-feedback d-block">

                {{ $message }}

            </div>
        @enderror

    </div>

    {{-- Estado --}}
    <div class="col-12">

        <div class="form-check">

            <input type="hidden" name="is_active" value="0">

            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active"
                {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}>

            <label for="is_active" class="form-check-label">

                Usuario activo

            </label>

        </div>

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const button = document.getElementById('generatePasswordBtn');

        const input = document.getElementById('password');

        if (!button || !input) {
            return;
        }

        button.addEventListener('click', function() {

            const upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            const lower = 'abcdefghijklmnopqrstuvwxyz';
            const numbers = '0123456789';
            const symbols = '@#$%&*!?';
            const all = upper + lower + numbers + symbols;

            let password = '';

            password += upper[Math.floor(Math.random() * upper.length)];
            password += lower[Math.floor(Math.random() * lower.length)];
            password += numbers[Math.floor(Math.random() * numbers.length)];
            password += symbols[Math.floor(Math.random() * symbols.length)];

            for (let i = 4; i < 12; i++) {

                password += all.charAt(
                    Math.floor(Math.random() * all.length)
                );
            }

            password = password
                .split('')
                .sort(() => Math.random() - 0.5)
                .join('');

            input.value = password;
        });
    });
</script>
