 <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Iniciar Sesión</title>
        @vite(['resources/css/auth/auth.css'])
    </head>
    <body>

        <div class="login-wrapper">

            {{-- Panel izquierdo decorativo --}}
            <aside class="login-panel">
                <div class="panel__noise"></div>
                <div class="panel__grid"></div>

                <div class="panel__content">
                    <div class="panel__logo">
                        <div class="logo-mark">
                            <span></span><span></span><span></span>
                        </div>
                    </div>

                    <div class="panel__text">
                        <h2>Bienvenido<br>de nuevo.</h2>
                        <p>Accede al panel de administración para gestionar tu plataforma de forma segura.</p>
                    </div>

                    <div class="panel__orbs">
                        <div class="orb orb--1"></div>
                        <div class="orb orb--2"></div>
                        <div class="orb orb--3"></div>
                    </div>

                    <div class="panel__footer">
                        <span>Sistema de gestión v2.0</span>
                        <span>© {{ date('Y') }}</span>
                    </div>
                </div>
            </aside>

            {{-- Panel derecho: formulario --}}
            <main class="login-form-area">

                <div class="form-container">

                    <div class="form-header">
                        <div class="form-header__tag">Panel Administrativo</div>
                        <h1>Iniciar sesión</h1>
                        <p>Ingresa tus credenciales para continuar</p>
                    </div>

                    {{-- Error global de autenticación --}}
                    @if ($errors->has('auth'))
                        <div class="alert alert--error" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            <span>{{ $errors->first('auth') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="login-form" novalidate>
                        @csrf

                        {{-- Email --}}
                        <div class="field @error('email') field--error @enderror">
                            <label for="email" class="field__label">Correo electrónico</label>
                            <div class="field__input-wrap">
                                <svg class="field__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                                </svg>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="field__input"
                                    placeholder="admin@ejemplo.com"
                                    value="{{ old('email') }}"
                                    autocomplete="email"
                                    autofocus
                                    required
                                >
                            </div>
                            @error('email')
                                <span class="field__error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="field @error('password') field--error @enderror">
                            <label for="password" class="field__label">Contraseña</label>
                            <div class="field__input-wrap">
                                <svg class="field__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                </svg>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="field__input"
                                    placeholder="••••••••"
                                    autocomplete="current-password"
                                    required
                                >
                                <button type="button" class="field__toggle-pass" aria-label="Mostrar contraseña" onclick="togglePassword()">
                                    <svg id="eye-show" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    <svg id="eye-hide" class="hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <span class="field__error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Remember + Forgot --}}
                        <div class="form-extras">
                            <label class="checkbox">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span class="checkbox__box"></span>
                                <span class="checkbox__label">Recordarme</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot-link">¿Olvidaste tu contraseña?</a>
                            @endif
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn-submit">
                            <span class="btn-submit__text">Ingresar al panel</span>
                            <span class="btn-submit__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                                </svg>
                            </span>
                        </button>

                    </form>

                </div>

            </main>

        </div>

        <script>
            function togglePassword() {
                const input = document.getElementById('password');
                const eyeShow = document.getElementById('eye-show');
                const eyeHide = document.getElementById('eye-hide');
                if (input.type === 'password') {
                    input.type = 'text';
                    eyeShow.classList.add('hidden');
                    eyeHide.classList.remove('hidden');
                } else {
                    input.type = 'password';
                    eyeShow.classList.remove('hidden');
                    eyeHide.classList.add('hidden');
                }
            }
        </script>

    </body>
    </html>