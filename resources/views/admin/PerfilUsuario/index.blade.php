@extends('admin.admin')

@section('title', 'Perfiles de usuario')
@section('breadcrumb', 'Perfiles de usuario')

@section('admin-content')
    <div class="crud-toolbar">
        <div class="page-header mb-0">
            <h1>Perfiles de usuario</h1>
            <p>Gestión de usuarios finales y sus datos de boda.</p>
        </div>
        <div class="crud-actions">
            <a href="{{ route('admin.perfiles-usuario.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-1">
                <i class="bi bi-person-plus-fill"></i> Nuevo perfil
            </a>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="admin-card">
        @if ($perfiles->isEmpty())
            <div class="empty-state py-5 text-center">
                <i class="bi bi-people" style="font-size:2.5rem;color:#b8cfe8;display:block;margin-bottom:.75rem;"></i>
                <p class="mb-0" style="color:#6f8da5;">No hay perfiles de usuario registrados todavía.</p>
                <a href="{{ route('admin.perfiles-usuario.create') }}" class="btn btn-primary btn-sm mt-3">
                    <i class="bi bi-person-plus-fill me-1"></i>Crear el primero
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-admin align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width:35%">Usuario</th>
                            <th>Contacto</th>
                            <th>Población</th>
                            <th>Boda</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($perfiles as $perfil)
                            @php
                                $name   = $perfil->user->name ?? 'Usuario';
                                $words  = explode(' ', trim($name));
                                $inits  = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                                $palette = ['#1459b8','#7b2ff7','#0e7490','#0369a1','#6d28d9','#0f766e'];
                                $bg     = $palette[abs(crc32($name)) % count($palette)];

                                $fechaBoda = $perfil->fecha_boda
                                    ? \Illuminate\Support\Carbon::parse($perfil->fecha_boda)
                                    : null;
                                $dias = $fechaBoda
                                    ? (int) now()->startOfDay()->diffInDays($fechaBoda->copy()->startOfDay(), false)
                                    : null;
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="pu-avatar" style="--pu-avatar-bg:{{ $bg }}">{{ $inits }}</span>
                                        <div>
                                            <div class="fw-semibold" style="color:var(--admin-text)">{{ $name }}</div>
                                            <div class="muted" style="font-size:.8rem">{{ $perfil->user->email ?? '—' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="color:var(--admin-text)">
                                        <i class="bi bi-telephone me-1 text-muted" style="font-size:.75rem"></i>{{ $perfil->telefono ?: '—' }}
                                    </div>
                                    <div class="muted" style="font-size:.8rem">{{ $perfil->direccion ?: '—' }}</div>
                                </td>
                                <td>
                                    <div style="color:var(--admin-text)">{{ $perfil->poblacion->nombre ?? '—' }}</div>
                                    <div class="muted" style="font-size:.8rem">{{ $perfil->poblacion->provincia->nombre ?? '' }}</div>
                                </td>
                                <td>
                                    @if ($fechaBoda)
                                        @if ($dias === 0)
                                            <span class="wedding-badge wedding-badge--today">
                                                <i class="bi bi-balloon-heart-fill"></i> ¡Hoy!
                                            </span>
                                        @elseif ($dias > 0 && $dias <= 30)
                                            <span class="wedding-badge wedding-badge--soon">
                                                <i class="bi bi-clock"></i> {{ $dias }}d
                                            </span>
                                        @elseif ($dias > 30)
                                            <span class="wedding-badge wedding-badge--upcoming">
                                                <i class="bi bi-calendar-heart"></i> {{ $fechaBoda->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="wedding-badge wedding-badge--past">
                                                <i class="bi bi-calendar-check"></i> {{ $fechaBoda->format('d/m/Y') }}
                                            </span>
                                        @endif
                                    @else
                                        <span class="muted">—</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="table-actions">
                                        <a href="{{ route('admin.perfiles-usuario.show', $perfil) }}"
                                            class="btn btn-sm btn-outline-secondary btn-icon"
                                            title="Ver detalle" aria-label="Ver detalle">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.perfiles-usuario.edit', $perfil) }}"
                                            class="btn btn-sm btn-outline-primary btn-icon"
                                            title="Editar" aria-label="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.perfiles-usuario.destroy', $perfil) }}" method="POST"
                                            onsubmit="return confirm('Se eliminará este perfil y su boda asociada. ¿Continuar?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-outline-danger btn-icon"
                                                title="Eliminar" aria-label="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $perfiles->links() }}
            </div>
        @endif
    </div>
@endsection
