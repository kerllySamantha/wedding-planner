@if (request()->is('admin*'))
    <nav class="admin-navbar" aria-label="Navegacion del panel de administracion">
        <div class="navbar-brand-area">
            <button class="sidebar-toggle" id="sidebarToggle" aria-controls="admin-sidebar" aria-expanded="true"
                aria-label="Abrir o cerrar menu lateral">
                <i class="bi bi-layout-sidebar" aria-hidden="true"></i>
            </button>

            <a href="{{ route('admin.dashboard') }}" class="admin-brand-link" aria-label="Pagina principal del panel">
                <img src="{{ Vite::asset('resources/images/logo-sinfondo.png') }}" class="admin-brand-logo" height="38"
                    width="auto" alt="Suenos de Boda">
            </a>
        </div>

        <div class="navbar-page-info ms-3" aria-label="Ubicacion actual">
            <nav aria-label="Ruta de navegacion">
                <ol class="admin-breadcrumb" role="list">
                    <li role="listitem">
                        <a href="{{ route('admin.dashboard') }}">Inicio</a>
                    </li>
                    @hasSection('breadcrumb')
                        <li role="listitem" aria-hidden="true">/</li>
                        <li role="listitem" aria-current="page">@yield('breadcrumb')</li>
                    @endif
                </ol>
            </nav>
        </div>

        <div class="navbar-actions" role="toolbar" aria-label="Acciones del panel">
            <div class="nav-divider" aria-hidden="true"></div>

            <a class="nav-icon-btn" href="{{ url('/') }}" aria-label="Ir al inicio de la aplicacion">
                <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
            </a>

            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="nav-icon-btn" aria-label="Cerrar sesion">
                    <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                </button>
            </form>

            <div class="sidebar-user-avatar" aria-hidden="true" style="overflow:hidden;padding:0;">
                @if (auth()->user()->fotoPerfil)
                    <img src="{{ asset('storage/' . auth()->user()->fotoPerfil) }}" alt="Avatar"
                        style="width:100%;height:100%;object-fit:cover;">
                @else
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                @endif
            </div>
        </div>
    </nav>
@else
    <nav class="navbar navbar-expand-lg navbar-light py-3 fixed-top shadow-sm" aria-label="Navegacion principal">
        <div class="container-fluid mx-4">
            <a href="{{ url('/') }}" class="admin-brand-link navbar-brand" aria-label="Suenos de Boda">
                <img ssrc="{{ Vite::asset('resources/images/logo-sinfondo.png') }}" class="admin-brand-logo" height="38"
                    width="auto" alt="Suenos de Boda">
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false" aria-label="Abrir menu de navegacion">
                <span class="navbar-toggler-icon" aria-hidden="true"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center" role="list">
                    <li class="nav-item" role="listitem">
                        <a href="#caracteristicas" class="nav-link fw-semibold">Caracteristicas</a>
                    </li>
                    <li class="nav-item" role="listitem">
                        <a href="#armada" class="nav-link fw-semibold">Planes</a>
                    </li>
                    <li class="nav-item" role="listitem">
                        <a href="#downloads" class="nav-link fw-semibold">Descargas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
@endif