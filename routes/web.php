<?php

use App\Helpers\Helper;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Mail\EnvioEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });





/*
|--------------------------------------------------------------------------
| RUTAS DE PRUEBA
|--------------------------------------------------------------------------
*/

Route::get('/test-reverb', function () {
    broadcast(new \App\Events\TestEvent("Hola Angular"));
    return "OK";
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
| AUTH
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get(
        '/login',
        [AuthenticationController::class, 'showLogin']
    )->name('login');

    Route::post(
        '/login',
        [AuthenticationController::class, 'login']
    )->name('login.post');
});

Route::middleware('auth')->group(function () {

    Route::post(
        '/logout',
        [AuthenticationController::class, 'logout']
    )->name('logout');

    /*
    |--------------------------------------------------------------------------
    | PERFIL
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })->name('dashboard');
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

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', function () {
            return view('admin.admin');
        })->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | PERFIL ADMIN
        |--------------------------------------------------------------------------
        */

        // Route::get(
        //     'perfil',
        //     [UserController::class, 'profile']
        // )->name('profile');

        // Route::put(
        //     'perfil',
        //     [UserController::class, 'updateProfile']
        // )->name('profile.update');

        /*
        |--------------------------------------------------------------------------
        | GESTIÓN WEB
        |--------------------------------------------------------------------------
        */

        Route::middleware('permission:gestionar web')
            ->group(function () {

                Route::resource(
                    'users',
                    UserController::class
                )->only([
                    'index',
                    'create',
                    'store',
                    'edit',
                    'update'
                ]);
            });
    });

/*
|--------------------------------------------------------------------------
| RUTAS DE AUTENTICACIÓN BREEZE
|--------------------------------------------------------------------------
*/


require __DIR__.'/auth.php';
