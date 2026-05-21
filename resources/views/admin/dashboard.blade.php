@extends('admin.admin')

@section('title', 'Dashboard admin')
@section('breadcrumb', 'Dashboard')


@section('admin-content')
    <div class="page-header dashboard-header">
        <h1>Panel de administracion</h1>
        <p>Accesos directos para gestionar empresas, tipos de producto y perfiles de usuario.</p>
    </div>

    @include('admin.partials.flash')

    <div class="stats-grid dashboard-stats">
        <div class="admin-card stat-card">
            <div>
                <div class="stat-card-label">Empresas</div>
                <div class="stat-card-value">{{ $stats['empresas'] }}</div>
            </div>
            <div class="stat-card-icon">
                <i class="bi bi-building"></i>
            </div>
        </div>

        <div class="admin-card stat-card">
            <div>
                <div class="stat-card-label">Tipos de producto</div>
                <div class="stat-card-value">{{ $stats['tiposProducto'] }}</div>
            </div>
            <div class="stat-card-icon">
                <i class="bi bi-tags"></i>
            </div>
        </div>

        <div class="admin-card stat-card">
            <div>
                <div class="stat-card-label">Perfiles de usuario</div>
                <div class="stat-card-value">{{ $stats['perfilesUsuario'] }}</div>
            </div>
            <div class="stat-card-icon">
                <i class="bi bi-people"></i>
            </div>
        </div>
    </div>

    <div class="admin-card dashboard-quick-actions">
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

    <div class="row g-4 dashboard-tables">
        <div class="col-12 col-xl-6">
            <div class="admin-card h-100">
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
            <div class="admin-card h-100">
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
                                        <td>{{ $perfil->fecha_boda ? \Illuminate\Support\Carbon::parse($perfil->fecha_boda)->format('d/m/Y') : '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
