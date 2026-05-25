@extends('admin.admin')

@section('title', isset($user) ? 'Editar usuario' : 'Crear usuario')
@section('breadcrumb', isset($user) ? 'Editar usuario' : 'Crear usuario')

@section('admin-content')

    <div class="page-header">

        <h1>

            {{ isset($user) ? 'Editar usuario' : 'Crear usuario' }}

        </h1>

    </div>

    <div class="admin-card">

        <form
            action="{{ route('admin.profile.update') }}"
            method="POST">

            @csrf
            @method('PUT')

            @include('admin.perfil._form')

            <div class="mt-4 d-flex flex-column flex-sm-row gap-2">

                <button type="submit"
                    class="btn btn-primary d-inline-flex align-items-center justify-content-center gap-2 fw-semibold py-2 px-4"
                    style="border-radius: 10px; letter-spacing: 0.3px; transition: all 0.2s ease; white-space: nowrap;">
                    <i class="bi bi-floppy-fill fs-5"></i>
                    Guardar cambios
                </button>

                <a href="{{ route('admin.profile.show') }}"
                    class="btn btn-light d-inline-flex align-items-center justify-content-center gap-2 fw-semibold py-2 px-4"
                    style="border-radius: 10px; letter-spacing: 0.3px; transition: all 0.2s ease; white-space: nowrap;">
                    <i class="bi bi-x-circle fs-5"></i>
                    Cancelar
                </a>

            </div>

        </form>

    </div>

@endsection
