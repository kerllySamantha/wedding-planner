<!DOCTYPE html>
<html lang="es">

<head>
    @include('partials.head')
    {{-- @stack('admin-styles') --}}
    <link rel="stylesheet" href="{{ asset('css/admin/admin-styles.css') }}">
</head>

<body class="{{ request()->is('admin*') ? 'is-admin' : '' }}">

    {{-- Skip link --}}
    <a class="skip-link visually-hidden-focusable" href="#main-content">
        Saltar al contenido principal
    </a>

    <header role="banner">
        @include('admin.partials.header')
    </header>

    {{-- El sidebar solo se inyecta desde layouts/admin.blade.php --}}
    @stack('admin-sidebar')

    {{-- Overlay móvil (solo admin) --}}
    @stack('admin-overlay')

    <main id="main-content" tabindex="-1">
        @yield('content')
    </main>

    @unless(request()->is('admin*'))
        {{-- @include('partials.footer') --}}
    @endunless

    @include('partials.scripts')
    @stack('admin-scripts')

    {{-- Panel de accesibilidad flotante --}}
    <x-accessibility-panel />

</body>

</html>