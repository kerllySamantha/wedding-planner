{{--
    layouts/admin.blade.php
    ─────────────────────────────────────────────
    Hereda de app.blade.php.
    Inyecta mediante @push:
      · admin-styles  → estilos del panel (en <head>)
      · admin-sidebar → el <aside> lateral
      · admin-overlay → overlay móvil
      · admin-scripts → JS del panel (antes de </body>)
    El <header> y la navbar admin se renderizan
    automáticamente desde partials/header.blade.php
    al detectar request()->is('admin*').
--}}
@extends('admin.layouts.app')

{{-- ── Estilos del panel ────────────────────────────── --}}
{{-- @push('admin-styles')
    <style>
        :root {
            --sidebar-width: 260px;
            --navbar-height: 60px;

            --color-accent: #71a1e0;
            --color-accent-hover: #1A6DD4;

            --color-sidebar-bg: #1B3A5C;
            --color-sidebar-text: #dde7f0;
            --color-sidebar-hover-bg: #0F2D4A;

            --color-body-bg: #EEF3F9;
            --color-nav-bg: #ffffff;

            --font-ui: 'DM Sans', sans-serif;
            --font-brand: 'Syne', sans-serif;
        }

        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Syne:wght@600;700&display=swap');

        /* ───────────────────────────────────────────── */
        /* BODY */
        /* ───────────────────────────────────────────── */

        body.is-admin {
            font-family: var(--font-ui);
            background: var(--color-body-bg);
        }

        /* ───────────────────────────────────────────── */
        /* NAVBAR */
        /* ───────────────────────────────────────────── */

        .admin-navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;

            height: var(--navbar-height);

            background: var(--color-nav-bg);

            border-bottom: 1px solid #D6E4F0;

            display: flex;
            align-items: center;

            padding: 0 1.25rem 0 0;

            z-index: 1040;
        }

        .navbar-brand-area {
            width: var(--sidebar-width);
            height: 100%;

            background: var(--color-sidebar-bg);

            display: flex;
            align-items: center;

            padding: 0 1rem 0 1.25rem;

            flex-shrink: 0;
            gap: 10px;

            transition: width .28s cubic-bezier(.4, 0, .2, 1);
        }

        /* Sidebar colapsado */
        body.is-admin.sidebar-is-collapsed .navbar-brand-area {
            width: 64px;
        }

        .admin-brand-link {
            display: flex;
            align-items: center;
            line-height: 1;
        }

        .admin-brand-logo {
            height: 38px;
            width: auto;

            filter: brightness(0) invert(1);
            opacity: .9;
        }

        /* Toggle */

        .sidebar-toggle {
            width: 36px;
            height: 36px;
            min-width: 36px;

            border: none;
            background: transparent;

            border-radius: 8px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: var(--color-sidebar-text);

            font-size: 18px;

            cursor: pointer;

            flex-shrink: 0;

            transition: background .15s, color .15s;
        }

        .sidebar-toggle:hover {
            background: rgba(166, 197, 255, 0.521);
            color: #fff;
        }

        .sidebar-toggle:focus-visible {
            outline: 2px solid var(--color-accent);
            outline-offset: 2px;
        }

        /* Navbar info */

        .navbar-page-info {
            display: flex;
            align-items: center;

            padding-left: 1.25rem;
        }

        /* Breadcrumb */

        .admin-breadcrumb {
            list-style: none;

            margin: 0;
            padding: 0;

            display: flex;
            align-items: center;

            gap: 6px;

            font-size: 12px;

            color: #7898B2;
        }

        .admin-breadcrumb a {
            color: #7898B2;
            text-decoration: none;
        }

        .admin-breadcrumb a:hover {
            color: var(--color-accent);
        }

        .admin-breadcrumb [aria-current="page"] {
            color: #1B3A5C;
            font-weight: 500;
        }

        /* Navbar actions */

        .navbar-actions {
            display: flex;
            align-items: center;

            gap: 6px;

            margin-left: auto;
        }

        .nav-icon-btn {
            width: 36px;
            height: 36px;

            border: none;
            background: transparent;

            border-radius: 8px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #4A6C85;

            font-size: 17px;

            cursor: pointer;

            text-decoration: none;

            transition: background .15s, color .15s;

            position: relative;
        }

        .nav-icon-btn:hover {
            background: #EEF3F9;
            color: var(--color-accent);
        }

        .nav-icon-btn:focus-visible {
            outline: 2px solid var(--color-accent);
            outline-offset: 2px;
        }

        .nav-badge {
            position: absolute;

            top: 5px;
            right: 5px;

            width: 7px;
            height: 7px;

            background: var(--color-accent);

            border-radius: 50%;

            border: 1.5px solid #fff;
        }

        .nav-divider {
            width: 1px;
            height: 24px;

            background: #D6E4F0;

            margin: 0 4px;
        }

        /* Avatar */

        .nav-avatar {
            width: 32px;
            height: 32px;

            border-radius: 50%;

            background: linear-gradient(135deg,
                    var(--color-accent),
                    #1048A0);

            display: flex;
            align-items: center;
            justify-content: center;

            color: #fff;

            font-size: 12px;
            font-weight: 600;

            cursor: pointer;

            border: 2px solid transparent;

            transition: border-color .15s;

            flex-shrink: 0;
        }

        .nav-avatar:hover {
            border-color: var(--color-accent);
        }

        /* ───────────────────────────────────────────── */
        /* SIDEBAR */
        /* ───────────────────────────────────────────── */

        .admin-sidebar {
            position: fixed;

            top: var(--navbar-height);
            left: 0;

            width: var(--sidebar-width);
            height: calc(100vh - var(--navbar-height));

            background: var(--color-sidebar-bg);

            display: flex;
            flex-direction: column;

            overflow-y: auto;
            overflow-x: hidden;

            z-index: 1030;

            transition:
                transform .28s cubic-bezier(.4, 0, .2, 1),
                width .28s cubic-bezier(.4, 0, .2, 1);

            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, .06) transparent;
        }

        /* ───────────────────────────────────────────── */
        /* SIDEBAR COLLAPSED */
        /* ───────────────────────────────────────────── */

        .admin-sidebar.collapsed {
            width: 64px;
        }

        /* Ocultar textos */

        .admin-sidebar.collapsed .nav-label,
        .admin-sidebar.collapsed .sidebar-section-title,
        .admin-sidebar.collapsed .sidebar-user-info,
        .admin-sidebar.collapsed .nav-badge-pill,
        .admin-sidebar.collapsed .sidebar-chevron {
            opacity: 0;

            width: 0;

            overflow: hidden;

            pointer-events: none;
        }

        /* Padding uniforme */

        .admin-sidebar.collapsed .sidebar-nav-item,
        .admin-sidebar.collapsed .sidebar-nav-item.sidebar-nav-group {
            padding: 0 6px;
        }

        /* Links */

        .admin-sidebar.collapsed .sidebar-nav-item>a,
        .admin-sidebar.collapsed .sidebar-group-trigger,
        .admin-sidebar.collapsed .sidebar-subnav li a {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 100%;

            padding: 10px 0;

            gap: 0;
        }

        /* Iconos centrados */

        .admin-sidebar.collapsed .sidebar-nav-item a i,
        .admin-sidebar.collapsed .sidebar-group-trigger i:first-child,
        .admin-sidebar.collapsed .sidebar-subnav li a i {
            width: 20px;
            min-width: 20px;

            margin: 0;

            text-align: center;

            flex-shrink: 0;
        }

        /* Footer */

        .admin-sidebar.collapsed .sidebar-user {
            justify-content: center;
            padding: 8px 0;
        }

        /* Ocultar subnav */

        .admin-sidebar.collapsed .sidebar-subnav {
            display: none;
        }

        /* ───────────────────────────────────────────── */
        /* SIDEBAR NAV */
        /* ───────────────────────────────────────────── */

        .sidebar-nav {
            padding: 1rem 0;
            flex: 1;
        }

        .sidebar-section-title {
            font-size: 10px;
            font-weight: 600;

            color: rgba(155, 189, 217, .4);

            letter-spacing: .12em;
            text-transform: uppercase;

            padding: 1.25rem 1.25rem .5rem;

            transition: opacity .2s, width .2s;

            white-space: nowrap;
        }

        .sidebar-nav-item {
            list-style: none;

            padding: 0 .5rem;

            margin-bottom: 2px;
        }

        /* Links */

        .sidebar-nav-item a {
            display: flex;
            align-items: center;

            gap: 10px;

            padding: 9px 12px;

            border-radius: 8px;

            color: var(--color-sidebar-text);

            text-decoration: none;

            font-size: 13.5px;
            font-weight: 400;

            transition: background .15s, color .15s;

            white-space: nowrap;

            overflow: hidden;
        }

        /* Iconos */

        .sidebar-nav-item a i {
            font-size: 17px;

            width: 20px;
            min-width: 20px;

            text-align: center;

            flex-shrink: 0;
        }

        /* Hover */

        .sidebar-nav-item a:hover {
            background: var(--color-sidebar-hover-bg);
            color: #fff;
        }

        /* Active */

        .sidebar-nav-item a.active {
            background: var(--color-accent);
            color: #fff;

            font-weight: 500;
        }

        /* Focus */

        .sidebar-nav-item a:focus-visible {
            outline: 2px solid var(--color-accent);
            outline-offset: 2px;
        }

        /* Labels */

        .nav-label {
            transition: opacity .2s, width .2s;

            white-space: nowrap;

            overflow: hidden;
        }

        /* Pills */

        .nav-badge-pill {
            margin-left: auto;

            background: rgba(47, 128, 237, .15);

            color: #7EC8F8;

            font-size: 10px;
            font-weight: 600;

            padding: 2px 7px;

            border-radius: 20px;

            flex-shrink: 0;

            transition: opacity .2s, width .2s;

            white-space: nowrap;
        }

        .sidebar-nav-item a.active .nav-badge-pill {
            background: rgba(255, 255, 255, .2);
            color: #fff;
        }

        /* ───────────────────────────────────────────── */
        /* SIDEBAR FOOTER */
        /* ───────────────────────────────────────────── */

        .sidebar-footer {
            border-top: 1px solid rgba(255, 255, 255, .06);

            padding: .875rem .5rem;
        }

        .sidebar-user {
            display: flex;
            align-items: center;

            gap: 10px;

            padding: 8px 12px;

            border-radius: 8px;

            cursor: pointer;

            transition: background .15s;
        }

        .sidebar-user:hover {
            background: rgba(255, 255, 255, .05);
        }

        /* Avatar */

        .sidebar-user-avatar {
            width: 32px;
            height: 32px;

            border-radius: 50%;

            background: linear-gradient(135deg,
                    var(--color-accent),
                    #1048A0);

            display: flex;
            align-items: center;
            justify-content: center;

            color: #fff;

            font-size: 12px;
            font-weight: 600;

            flex-shrink: 0;

            overflow: hidden;
        }

        .sidebar-user-info {
            transition: opacity .2s, width .2s;

            overflow: hidden;
        }

        .sidebar-user-name {
            font-size: 13px;
            font-weight: 500;

            color: #D6EAF8;

            line-height: 1.2;
        }

        .sidebar-user-role {
            font-size: 11px;

            color: rgba(155, 189, 217, .6);
        }

        /* ───────────────────────────────────────────── */
        /* MAIN CONTENT */
        /* ───────────────────────────────────────────── */

        body.is-admin #main-content {
            margin-left: var(--sidebar-width);

            min-height: calc(100vh - var(--navbar-height));

            padding: 2rem;

            transition: margin-left .28s cubic-bezier(.4, 0, .2, 1);
        }

        /* Main colapsado */

        body.is-admin #main-content.sidebar-collapsed {
            margin-left: 64px;
        }

        /* ───────────────────────────────────────────── */
        /* PAGE HEADER */
        /* ───────────────────────────────────────────── */

        .page-header {
            margin-bottom: 1.75rem;
        }

        .page-header h1 {
            font-family: var(--font-brand);

            font-size: 22px;
            font-weight: 700;

            color: #0D2A42;

            margin: 0 0 4px;
        }

        .page-header p {
            font-size: 13.5px;

            color: #6A8EA8;

            margin: 0;
        }

        /* ───────────────────────────────────────────── */
        /* CARDS */
        /* ───────────────────────────────────────────── */

        .admin-card {
            background: #fff;

            border-radius: 12px;

            border: 1px solid #D6E4F0;

            padding: 1.25rem 1.5rem;
        }

        /* ───────────────────────────────────────────── */
        /* OVERLAY */
        /* ───────────────────────────────────────────── */

        .sidebar-overlay {
            display: none;

            position: fixed;

            inset: 0;

            background: rgba(0, 0, 0, .45);

            z-index: 1025;
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* ───────────────────────────────────────────── */
        /* DROPDOWN GROUPS */
        /* ───────────────────────────────────────────── */

        .sidebar-nav-group details {
            width: 100%;
        }

        .sidebar-nav-group summary {
            list-style: none;
        }

        .sidebar-nav-group summary::-webkit-details-marker {
            display: none;
        }

        /* Trigger */

        .sidebar-group-trigger {
            display: flex;
            align-items: center;

            gap: 10px;

            padding: 9px 12px;

            border-radius: 8px;

            color: var(--color-sidebar-text);

            font-size: 13.5px;
            font-weight: 400;

            cursor: pointer;

            transition: background .15s, color .15s;

            white-space: nowrap;

            overflow: hidden;

            user-select: none;
        }

        .sidebar-group-trigger:hover {
            background: var(--color-sidebar-hover-bg);
            color: #fff;
        }

        .sidebar-group-trigger.active {
            color: #fff;
        }

        /* Icono */

        .sidebar-group-trigger i:first-child {
            font-size: 17px;

            width: 20px;
            min-width: 20px;

            text-align: center;

            flex-shrink: 0;
        }

        /* Chevron */

        .sidebar-chevron {
            margin-left: auto;

            font-size: 12px;

            transition:
                transform .2s,
                opacity .2s,
                width .2s;

            flex-shrink: 0;
        }

        details[open] .sidebar-chevron {
            transform: rotate(180deg);
        }

        /* ───────────────────────────────────────────── */
        /* SUBNAV */
        /* ───────────────────────────────────────────── */

        .sidebar-subnav {
            list-style: none;

            margin: 2px 0 0;

            padding: 0;
        }

        /* Links */

        .sidebar-subnav li a {
            display: flex;
            align-items: center;

            gap: 10px;

            padding: 8px 12px 8px 36px;

            border-radius: 8px;

            color: var(--color-sidebar-text);

            text-decoration: none;

            font-size: 13px;

            transition: background .15s, color .15s;

            white-space: nowrap;

            overflow: hidden;
        }

        /* Iconos */

        .sidebar-subnav li a i {
            font-size: 15px;

            width: 18px;
            min-width: 18px;

            text-align: center;

            flex-shrink: 0;
        }

        /* Hover */

        .sidebar-subnav li a:hover {
            background: var(--color-sidebar-hover-bg);
            color: #fff;
        }

        /* Active */

        .sidebar-subnav li a.active {
            background: var(--color-accent);
            color: #fff;

            font-weight: 500;
        }


        /* ───────────────────────────────────────────── */
        /* FIX ICONOS SIDEBAR COLLAPSADO */
        /* ───────────────────────────────────────────── */

        .admin-sidebar.collapsed .sidebar-nav-item {
            padding: 0 !important;
        }

        .admin-sidebar.collapsed .sidebar-nav-item>a,
        .admin-sidebar.collapsed .sidebar-group-trigger {
            width: 64px !important;
            height: 44px;

            padding: 0 !important;
            margin: 0 !important;

            display: flex !important;
            align-items: center !important;
            justify-content: center !important;

            gap: 0 !important;
        }

        /* Iconos principales */
        .admin-sidebar.collapsed .sidebar-nav-item>a>i,
        .admin-sidebar.collapsed .sidebar-group-trigger>i:first-child {
            margin: 0 !important;

            width: auto !important;
            min-width: auto !important;

            display: flex !important;
            align-items: center !important;
            justify-content: center !important;

            font-size: 18px;

            line-height: 1 !important;
        }

        /* Ocultar elementos */
        .admin-sidebar.collapsed .nav-label,
        .admin-sidebar.collapsed .sidebar-chevron,
        .admin-sidebar.collapsed .nav-badge-pill {
            display: none !important;
        }

        /* ───────────────────────────────────────────── */
        /* RESPONSIVE */
        /* ───────────────────────────────────────────── */

        @media (max-width: 991px) {

            .admin-sidebar {
                transform: translateX(-100%);

                width: var(--sidebar-width) !important;
            }

            .admin-sidebar.open {
                transform: translateX(0);
            }

            body.is-admin #main-content {
                margin-left: 0;
            }

            .navbar-brand-area {
                width: auto;
            }
        }

        
    </style>
@endpush --}}

{{-- ── Overlay móvil ────────────────────────────────── --}}
@push('admin-overlay')
    <div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true"></div>
@endpush

{{-- ── Aside lateral ────────────────────────────────── --}}
@push('admin-sidebar')
    <aside class="admin-sidebar" id="admin-sidebar" aria-label="Menú lateral de administración">

        <nav class="sidebar-nav" aria-label="Secciones del panel">
            <ul style="list-style:none;margin:0;padding:0">

                <li class="sidebar-section-title" aria-hidden="true">General</li>

                <li class="sidebar-nav-item">
                    <a href="#">
                        <i class="bi bi-speedometer2"></i>

                        <span class="nav-label">
                            Dashboard
                        </span>
                    </a>
                </li>

                <li class="sidebar-nav-item">
                    <a href="#">
                        <i class="bi bi-file-earmark-bar-graph"></i>

                        <span class="nav-label">
                            Informes
                        </span>
                    </a>
                </li>

                <li class="sidebar-nav-item">
                    <a href="#">
                        <i class="bi bi-receipt-cutoff"></i>

                        <span class="nav-label">
                            Facturación
                        </span>
                    </a>
                </li>

                {{-- ── Landing ── --}}
                <li class="sidebar-section-title" aria-hidden="true">Contenido</li>

                <li class="sidebar-nav-item sidebar-nav-group">

                    <details>

                        <summary class="sidebar-group-trigger">

                            <i class="bi bi-layout-text-window-reverse"></i>

                            <span class="nav-label">Landing</span>

                            <i class="bi bi-chevron-down sidebar-chevron"></i>

                        </summary>

                        <ul class="sidebar-subnav" role="list">

                            <li>
                                <a href="#">
                                    <i class="bi bi-image"></i>
                                    <span class="nav-label">Hero</span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="bi bi-stars"></i>
                                    <span class="nav-label">Beneficios</span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="bi bi-tag"></i>
                                    <span class="nav-label">Precios</span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="bi bi-list-ol"></i>
                                    <span class="nav-label">Pasos</span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="bi bi-shield-check"></i>
                                    <span class="nav-label">Seguridad</span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="bi bi-lightbulb"></i>
                                    <span class="nav-label">Concepto</span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="bi bi-grid"></i>
                                    <span class="nav-label">Características</span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="bi bi-journal-text"></i>
                                    <span class="nav-label">Ley control horario</span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="bi bi-question-circle"></i>
                                    <span class="nav-label">FAQ</span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="bi bi-play-circle"></i>
                                    <span class="nav-label">Demo</span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="bi bi-envelope"></i>
                                    <span class="nav-label">Contacto</span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="bi bi-phone"></i>
                                    <span class="nav-label">Aplicaciones</span>
                                </a>
                            </li>

                        </ul>

                    </details>

                </li>

                {{-- ── Configuración ── --}}
                <li class="sidebar-nav-item sidebar-nav-group">

                    <details>

                        <summary class="sidebar-group-trigger">

                            <i class="bi bi-gear"></i>

                            <span class="nav-label">
                                Composición
                            </span>

                            <i class="bi bi-chevron-down sidebar-chevron"></i>

                        </summary>

                        <ul class="sidebar-subnav" role="list">

                            <li>
                                <a href="#">
                                    <i class="bi bi-list"></i>

                                    <span class="nav-label">
                                        Navbar
                                    </span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="bi bi-save"></i>

                                    <span class="nav-label">
                                        Footer
                                    </span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="bi bi-layers"></i>

                                    <span class="nav-label">
                                        Secciones
                                    </span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="bi bi-window"></i>

                                    <span class="nav-label">
                                        Modales
                                    </span>
                                </a>
                            </li>

                        </ul>

                    </details>

                </li>

                {{-- ── Usuarios ── --}}
                <li class="sidebar-section-title" aria-hidden="true">Usuarios</li>

                <li class="sidebar-nav-item">
                    <a href="#">

                        <i class="bi bi-people"></i>

                        <span class="nav-label">
                            Usuarios
                        </span>

                    </a>
                </li>

                <li class="sidebar-nav-item">
                    <a href="#">

                        <i class="bi bi-calendar-check"></i>

                        <span class="nav-label">
                            Solicitudes demo
                        </span>

                    </a>
                </li>

                <li class="sidebar-nav-item">
                    <a href="#">

                        <i class="bi bi-person-circle"></i>

                        <span class="nav-label">
                            Mi perfil
                        </span>

                    </a>
                </li>

                {{-- ── Sistema ── --}}
                <li class="sidebar-section-title" aria-hidden="true">Sistema</li>

                <li class="sidebar-nav-item">
                    <a href="#">

                        <i class="bi bi-gear"></i>

                        <span class="nav-label">
                            Configuración
                        </span>

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

                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}

                    @endif

                </div>

                <div class="sidebar-user-info">

                    <div class="sidebar-user-name">
                        {{ auth()->user()->name ?? 'Administrador' }}
                    </div>

                    <div class="sidebar-user-role">
                        {{ auth()->user()->role ?? 'Admin' }}
                    </div>

                </div>

            </div>

        </div>

    </aside>
@endpush

{{-- ── Contenido ────────────────────────────────────── --}}
@section('content')
    @yield('admin-content')
@endsection

{{-- ── Scripts ──────────────────────────────────────── --}}
@push('admin-scripts')
    <script>
        (function() {

            const toggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('admin-sidebar');
            const main = document.getElementById('main-content');
            const overlay = document.getElementById('sidebarOverlay');

            const isMobile = () => window.innerWidth < 992;

            let collapsed = false;

            if (!toggle || !sidebar) return;

            toggle.addEventListener('click', () => {

                if (isMobile()) {

                    const open = sidebar.classList.toggle('open');

                    overlay.classList.toggle('active', open);

                } else {

                    collapsed = !collapsed;

                    sidebar.classList.toggle('collapsed', collapsed);

                    main.classList.toggle('sidebar-collapsed', collapsed);

                    document.body.classList.toggle('sidebar-is-collapsed', collapsed);

                }

            });

            overlay.addEventListener('click', () => {

                sidebar.classList.remove('open');

                overlay.classList.remove('active');

            });

            document.addEventListener('keydown', e => {

                if (e.key === 'Escape' && sidebar.classList.contains('open')) {

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