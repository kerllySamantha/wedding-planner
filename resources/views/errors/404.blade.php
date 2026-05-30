<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error 404</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/error-404/404.css')}}">
</head>

<body>
    <div class="page-wrapper">

        {{-- Círculos decorativos de fondo --}}
        <div class="bg-circle bg-circle-1"></div>
        <div class="bg-circle bg-circle-2"></div>
        <div class="bg-circle bg-circle-3"></div>

        {{-- Logo esquina superior izquierda --}}
        <div class="logo-img">
            <img src="{{ asset('assets/images/logos/logo-sinfondo.png') }}" alt="8BitsandPixels">
        </div>

        {{-- Panel principal --}}
        <div class="panel-glass d-flex flex-column align-items-center justify-content-center text-center">

            {{-- Barras de señal --}}
            <div class="signal-bars mb-3" aria-label="Nivel de señal 3 de 5" role="img">
                <div class="signal-bar signal-bar--active bar-h-1"></div>
                <div class="signal-bar signal-bar--active bar-h-2"></div>
                <div class="signal-bar signal-bar--active bar-h-3"></div>
                <div class="signal-bar signal-bar--inactive bar-h-4"></div>
                <div class="signal-bar signal-bar--inactive bar-h-4"></div>
            </div>

            {{-- Número --}}
            <div class="number-404 mb-3">
                4<span class="number-0">0</span>4
            </div>

            {{-- Texto --}}
            <p class="texto-404 my-2">
                Señal perdida, esta página no responde
            </p>

            {{-- Botón volver --}}
            <a href="{{ route('login') }}" class="btn-404 mt-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    viewBox="0 0 16 16" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
                </svg>
                Volver al Login
            </a>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>