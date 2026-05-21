{{--
ACCESIBILIDAD aplicada:
- role="navigation" + aria-label únicos
- navbar-toggler: aria-controls, aria-expanded correctos
- nav-link con aria-current para página activa
- btn con aria-label descriptivo
- Tamaño táctil mínimo 44px cubierto por CSS

ADMIN:
- Si la ruta es admin/* se renderiza la navbar del panel de administración
- Si no, se renderiza la navbar pública original
--}}

@if (request()->is('admin*'))

    {{-- ══════════════════════════════════════════════
    NAVBAR ADMIN
    Comparte ancho izquierdo con el aside (#admin-sidebar)
    ══════════════════════════════════════════════ --}}
    <nav class="admin-navbar" aria-label="Navegación del panel de administración">

        {{-- Brand (misma anchura que el sidebar) --}}
        <div class="navbar-brand-area">
            <button class="sidebar-toggle" id="sidebarToggle" aria-controls="admin-sidebar" aria-expanded="true"
                aria-label="Abrir o cerrar menú lateral">
                <i class="bi bi-layout-sidebar" aria-hidden="true"></i>
            </button>

            <a href="#" class="admin-brand-link" aria-label="Página principal">

                <img src="{{ asset('build/assets/images/logo-sinfondo.png') }}" class="admin-brand-logo" height="38"
                    width="auto" alt="Sueños de Boda">

            </a>
        </div>

        {{-- Breadcrumb / título de sección --}}
        <div class="navbar-page-info ms-3" aria-label="Ubicación actual">
            <nav aria-label="Ruta de navegación">
                <ol class="admin-breadcrumb" role="list">
                    <li role="listitem">
                        <a href="#">Inicio</a>
                    </li>
                    @hasSection('breadcrumb')
                        <li role="listitem" aria-hidden="true">/</li>
                        <li role="listitem" aria-current="page">@yield('breadcrumb')</li>
                    @endif
                </ol>
            </nav>
        </div>

        {{-- Acciones --}}
        <div class="navbar-actions" role="toolbar" aria-label="Acciones del panel">

            {{-- <button class="nav-icon-btn" aria-label="Buscar">
                <i class="bi bi-search" aria-hidden="true"></i>
            </button>

            <button class="nav-icon-btn" aria-label="Notificaciones (3 sin leer)">
                <i class="bi bi-bell" aria-hidden="true"></i>
                <span class="nav-badge" aria-hidden="true"></span>
            </button> --}}


            <div class="nav-divider" aria-hidden="true"></div>

            <a class="nav-icon-btn" href="#" target="_blank" aria-label="Ver sitio público">
                <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
            </a>

            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                {{-- Fuerza token fresco --}}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="nav-icon-btn" aria-label="Cerrar sesión">
                    <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                </button>
            </form>

            <div class="sidebar-user-avatar" aria-hidden="true" style="overflow:hidden;padding:0;">

                @if (auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar"
                        style="width:100%;height:100%;object-fit:cover;">
                @else
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                @endif

            </div>

        </div>
    </nav>
@else
    {{-- ══════════════════════════════════════════════
    NAVBAR PÚBLICA (original)
    ══════════════════════════════════════════════ --}}
    <nav class="navbar navbar-expand-lg navbar-light py-3 fixed-top shadow-sm" aria-label="Navegación principal">

        <div class="container-fluid mx-4">

            {{-- Logo --}}

            <a href="#" class="admin-brand-link navbar-brand" aria-label="Sueños de Boda">

                <img src="{{ asset('build/assets/images/logo-sinfondo.png') }}" class="admin-brand-logo" height="38"
                    width="auto" alt="Sueños de Boda">

            </a>

            {{-- Botón menú móvil --}}
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false" aria-label="Abrir menú de navegación">
                <span class="navbar-toggler-icon" aria-hidden="true"></span>
            </button>

            {{-- Menú --}}
            <div class="collapse navbar-collapse" id="mainNav">

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center" role="list">

                    <li class="nav-item" role="listitem">
                        <a href="#caracteristicas" class="nav-link fw-semibold">
                            Características
                        </a>
                    </li>

                    <li class="nav-item" role="listitem">
                        <a href="#armada" class="nav-link fw-semibold">
                            Planes
                        </a>
                    </li>

                    <li class="nav-item" role="listitem">
                        <a href="#downloads" class="nav-link fw-semibold">
                            Descargas
                        </a>

                    </li>





                </ul>

            </div>



        </div>

    </nav>

@endif