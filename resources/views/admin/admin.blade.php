@extends('admin.layouts.app')

@php
    $gestionEmpresasActiva = request()->routeIs('admin.empresas.*') || request()->routeIs('admin.tipos-producto.*');
    $rolActual = auth()->user()?->getRoleNames()->implode(', ') ?: 'Admin';
@endphp

@push('admin-overlay')
    <div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true"></div>
@endpush

@push('admin-sidebar')
    <aside class="admin-sidebar" id="admin-sidebar" aria-label="Menu lateral de administracion">
        <nav class="sidebar-nav" aria-label="Secciones del panel">
            <ul style="list-style:none;margin:0;padding:0">
                <li class="sidebar-section-title" aria-hidden="true">Panel</li>

                <li class="sidebar-nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                        aria-current="{{ request()->routeIs('admin.dashboard') ? 'page' : 'false' }}">
                        <i class="bi bi-speedometer2" aria-hidden="true"></i>
                        <span class="nav-label">Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-section-title" aria-hidden="true">Gestion</li>

                <li class="sidebar-nav-item sidebar-nav-group">
                    <details {{ $gestionEmpresasActiva ? 'open' : '' }}>
                        <summary class="sidebar-group-trigger {{ $gestionEmpresasActiva ? 'active' : '' }}">
                            <i class="bi bi-building" aria-hidden="true"></i>
                            <span class="nav-label">Empresas y catalogo</span>
                            <i class="bi bi-chevron-down sidebar-chevron" aria-hidden="true"></i>
                        </summary>

                        <ul class="sidebar-subnav" role="list">
                            <li>
                                <a href="{{ route('admin.empresas.index') }}"
                                    class="{{ request()->routeIs('admin.empresas.*') ? 'active' : '' }}"
                                    aria-current="{{ request()->routeIs('admin.empresas.*') ? 'page' : 'false' }}">
                                    <i class="bi bi-shop" aria-hidden="true"></i>
                                    <span class="nav-label">Empresas</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.tipos-producto.index') }}"
                                    class="{{ request()->routeIs('admin.tipos-producto.*') ? 'active' : '' }}"
                                    aria-current="{{ request()->routeIs('admin.tipos-producto.*') ? 'page' : 'false' }}">
                                    <i class="bi bi-tags" aria-hidden="true"></i>
                                    <span class="nav-label">Tipos de producto</span>
                                </a>
                            </li>
                        </ul>
                    </details>
                </li>

                <li class="sidebar-nav-item">
                    <a href="{{ route('admin.perfiles-usuario.index') }}"
                        class="{{ request()->routeIs('admin.perfiles-usuario.*') ? 'active' : '' }}"
                        aria-current="{{ request()->routeIs('admin.perfiles-usuario.*') ? 'page' : 'false' }}">
                        <i class="bi bi-people" aria-hidden="true"></i>
                        <span class="nav-label">Perfiles de usuario</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user" role="button" tabindex="0">
                <div class="sidebar-user-avatar" style="overflow:hidden;padding:0;">
                    @if (auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                            alt="Avatar"
                            style="width:100%;height:100%;object-fit:cover;">
                    @else
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    @endif
                </div>

                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">
                        {{ auth()->user()->name ?? 'Administrador' }}
                    </div>
                    <div class="sidebar-user-role">
                        {{ $rolActual }}
                    </div>
                </div>
            </div>
        </div>
    </aside>
@endpush

@section('content')
    @yield('admin-content')
@endsection

@push('admin-scripts')
    <script>
        (function() {
            const toggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('admin-sidebar');
            const main = document.getElementById('main-content');
            const overlay = document.getElementById('sidebarOverlay');
            const isMobile = () => window.innerWidth < 992;
            let collapsed = false;

            if (!toggle || !sidebar || !main || !overlay) {
                return;
            }

            toggle.addEventListener('click', () => {
                if (isMobile()) {
                    const open = sidebar.classList.toggle('open');
                    overlay.classList.toggle('active', open);
                    return;
                }

                collapsed = !collapsed;
                sidebar.classList.toggle('collapsed', collapsed);
                main.classList.toggle('sidebar-collapsed', collapsed);
                document.body.classList.toggle('sidebar-is-collapsed', collapsed);
            });

            overlay.addEventListener('click', () => {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && sidebar.classList.contains('open')) {
                    overlay.click();
                }
            });

            window.addEventListener('resize', () => {
                if (!isMobile()) {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('active');
                }
            });
        })();
    </script>
@endpush
