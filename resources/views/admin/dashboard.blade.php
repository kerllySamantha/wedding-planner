@extends('admin.admin')
@section('title', 'Dashboard admin')
@section('breadcrumb', 'Dashboard')

@push('admin-styles')
    @vite(['resources/css/dashboard/dashboard.css'])
@endpush




@section('admin-content')
    <section class="dashboard-shell">
        <div class="page-header dashboard-header">
            <h1>Bienvenido de nuevo, {{ auth()->user()->name ?? 'Admin' }}</h1>
            <p>Aquí está tu resumen de actividad del panel de administración.</p>
        </div>

    @include('admin.partials.flash')

        <div class="stats-grid dashboard-stats dashboard-section dashboard-section--stats">
        <div class="admin-card stat-card stat-card--empresas">
            <div>
                <div class="stat-card-label">Empresas</div>
                <div class="stat-card-value">{{ $stats['empresas'] }}</div>
            </div>
            <div class="stat-card-icon">
                <i class="bi bi-building"></i>
            </div>
        </div>

        <div class="admin-card stat-card stat-card--tipos">
            <div>
                <div class="stat-card-label">Tipos de producto</div>
                <div class="stat-card-value">{{ $stats['tiposProducto'] }}</div>
            </div>
            <div class="stat-card-icon">
                <i class="bi bi-tags"></i>
            </div>
        </div>

        <div class="admin-card stat-card stat-card--perfiles">
            <div>
                <div class="stat-card-label">Perfiles de usuario</div>
                <div class="stat-card-value">{{ $stats['perfilesUsuario'] }}</div>
            </div>
            <div class="stat-card-icon">
                <i class="bi bi-people"></i>
            </div>
        </div>
        </div>

        <div class="admin-card dashboard-quick-actions dashboard-section dashboard-section--actions">
        <div class="crud-toolbar dashboard-toolbar">
            <div>
                <h2 class="h5 mb-1">Acciones rapidas</h2>
                <p class="muted mb-0">Cada acceso lleva al CRUD correspondiente del panel admin.</p>
            </div>
            <div class="crud-actions dashboard-actions">
                <a href="{{ route('admin.empresas.index') }}" class="btn btn-primary">Gestionar empresas</a>
                <a href="{{ route('admin.tipos-producto.index') }}" class="btn btn-outline-primary">Tipos de producto</a>
                <a href="{{ route('admin.perfiles-usuario.index') }}" class="btn btn-outline-primary">Perfiles de usuario</a>
            </div>
        </div>
        </div>

        {{-- ── GRÁFICOS ── --}}
        <div class="dashboard-charts dashboard-section">
            <div class="row g-4">

                {{-- Doughnut: Usuarios por rol --}}
                <div class="col-12 col-md-6">
                    <div class="dashboard-chart-card">
                        <div class="dashboard-chart-card__header">
                            <span class="dashboard-chart-card__icon"><i class="bi bi-people-fill"></i></span>
                            <div>
                                <div class="dashboard-chart-card__title">Usuarios por rol</div>
                                <div class="dashboard-chart-card__subtitle">Distribución de roles registrados</div>
                            </div>
                        </div>
                        <div class="dashboard-chart-card__body" style="height:340px">
                            <canvas id="usuariosPorRol"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Horizontal bar: Servicios por categoría --}}
                <div class="col-12 col-md-6">
                    <div class="dashboard-chart-card">
                        <div class="dashboard-chart-card__header">
                            <span class="dashboard-chart-card__icon"><i class="bi bi-grid-fill"></i></span>
                            <div>
                                <div class="dashboard-chart-card__title">Servicios por categoría</div>
                                <div class="dashboard-chart-card__subtitle">Número de servicios en cada categoría</div>
                            </div>
                        </div>
                        <div class="dashboard-chart-card__body" style="height:340px">
                            <canvas id="serviciosPorCategoria"></canvas>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row g-4 mt-4">

                {{-- Line: Altas por mes — fila propia --}}
                <div class="col-12">
                    <div class="dashboard-chart-card">
                        <div class="dashboard-chart-card__header">
                            <span class="dashboard-chart-card__icon"><i class="bi bi-graph-up-arrow"></i></span>
                            <div>
                                <div class="dashboard-chart-card__title">Altas por mes</div>
                                <div class="dashboard-chart-card__subtitle">Evolución mensual de usuarios y servicios registrados</div>
                            </div>
                        </div>
                        <div class="dashboard-chart-card__body" style="height:360px">
                            <canvas id="altasPorMes"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Horizontal bar: Top categorías — fila propia --}}
                <div class="col-12">
                    <div class="dashboard-chart-card">
                        <div class="dashboard-chart-card__header">
                            <span class="dashboard-chart-card__icon"><i class="bi bi-trophy-fill"></i></span>
                            <div>
                                <div class="dashboard-chart-card__title">Top categorías</div>
                                <div class="dashboard-chart-card__subtitle">Las categorías más populares por número de servicios</div>
                            </div>
                        </div>
                        <div class="dashboard-chart-card__body" style="height:340px">
                            <canvas id="topCategorias"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row g-4 dashboard-tables dashboard-section dashboard-section--tables">
        <div class="col-12 col-xl-6">
            <div class="admin-card h-100 dashboard-panel dashboard-panel--empresas">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h2 class="h5 mb-1">Ultimas empresas</h2>
                        <p class="muted mb-0">Registros mas recientes dados de alta.</p>
                    </div>
                    <a href="{{ route('admin.empresas.index') }}" class="btn btn-sm btn-outline-secondary">Ver todas</a>
                </div>

                @if ($ultimasEmpresas->isEmpty())
                    <div class="empty-state">Todavia no hay empresas registradas.</div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Empresa</th>
                                    <th>Usuario</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ultimasEmpresas as $empresa)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $empresa->nombre_empresa }}</div>
                                            <div class="muted">{{ $empresa->tipo_servicio }}</div>
                                        </td>
                                        <td>{{ $empresa->usuario->email ?? 'Sin usuario' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-12 col-xl-6">
            <div class="admin-card h-100 dashboard-panel dashboard-panel--perfiles">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h2 class="h5 mb-1">Ultimos perfiles</h2>
                        <p class="muted mb-0">Usuarios finales creados desde el panel.</p>
                    </div>
                    <a href="{{ route('admin.perfiles-usuario.index') }}" class="btn btn-sm btn-outline-secondary">Ver todos</a>
                </div>

                @if ($ultimosPerfiles->isEmpty())
                    <div class="empty-state">Todavia no hay perfiles de usuario registrados.</div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Fecha boda</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ultimosPerfiles as $perfil)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $perfil->user->name ?? 'Sin usuario' }}</div>
                                            <div class="muted">{{ $perfil->user->email ?? 'Sin email' }}</div>
                                        </td>
                                        <td>{{ $perfil->fecha_boda?->format('d/m/Y') ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
        </div>
        
    </section>
@endsection

@push('admin-scripts')
    <script>
        window.dashboardData = @js([
            'usuariosPorRol' => $usuariosPorRol,
            'serviciosPorCategoria' => $serviciosPorCategoria,
            'altasUsuariosPorMes' => $altasUsuariosPorMes,
            'altasServiciosPorMes' => $altasServiciosPorMes,
            'topCategorias' => $topCategorias,
        ]);
    </script>

    @vite(['resources/js/dashboard.js'])
@endpush