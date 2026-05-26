<?php

use App\Helpers\Helper;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\PerfilUsuarioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TipoProductoController;
use App\Mail\EnvioEmail;
use App\Models\Empresa as EmpresaModel;
use App\Models\PerfilUsuario as PerfilUsuarioModel;
use App\Models\TipoProducto as TipoProductoModel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PAGINA DE INICIO
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| RUTAS DE PRUEBA
|--------------------------------------------------------------------------
*/

Route::get('/test-reverb', function () {
    broadcast(new \App\Events\TestEvent('Hola Angular'));

    return 'OK';
});

Route::get('/test-helper', function () {
    return Helper::colorPorEstado('pendiente');
});

Route::get('/test-mail', function () {
    Mail::to('prueba@example.com')->send(new EnvioEmail());

    return 'Correo enviado';
});

Route::get('/test-webp', function () {
    $path = storage_path('app/public/imagenes/usuario_4/imagen_5.webp');

    return response()->file($path);
});

/*
|--------------------------------------------------------------------------
| AUTH - Solo para invitados
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticationController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthenticationController::class, 'login'])
        ->name('login.post');
});

/*
|--------------------------------------------------------------------------
| AUTH - Solo para autenticados
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticationController::class, 'logout'])
        ->name('logout');

    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })->name('dashboard');

    Route::get('/profile/edit', [ProfileController::class, 'editBreeze'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'updateBreeze'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| PANEL ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::middleware('permission:gestionar usuarios')->group(function () {
            Route::resource('perfiles-usuario', PerfilUsuarioController::class)
                ->parameters(['perfiles-usuario' => 'perfilUsuario']);
        });

        Route::middleware('permission:gestionar empresas')->group(function () {
            Route::resource('empresas', EmpresaController::class);
            Route::resource('categorias', CategoriaController::class);

            Route::delete('empresas/{empresa}/fotos/{fotoIndex}', [EmpresaController::class, 'destroyFoto'])
                ->name('empresas.fotos.destroy');

            Route::resource('tipos-producto', TipoProductoController::class)
                ->parameters(['tipos-producto' => 'tipoProducto']);

            Route::get('mi-perfil', [ProfileController::class, 'show'])->name('profile.show');
            Route::get('mi-perfil/editar', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::put('mi-perfil', [ProfileController::class, 'update'])->name('profile.update');
        });
    });

/*
|--------------------------------------------------------------------------
| RUTAS DE AUTENTICACION BREEZE
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
