<?php

use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\Api\InvitadoController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PoblacionController;
use App\Http\Controllers\Api\ProvinciaController;
use App\Http\Controllers\Api\ReseniaController;
use App\Http\Controllers\Api\BodaController;
use App\Http\Controllers\Api\MensajeController;
use App\Http\Controllers\Api\ReservaController;
use App\Http\Controllers\Api\PerfilUsuarioController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\ServicioController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SubirImagenController;
use App\Http\Controllers\Api\TipoProductoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('bodas', BodaController::class);
Route::apiResource('empresas', EmpresaController::class);
Route::apiResource('categorias', CategoriaController::class);
Route::apiResource('invitados', InvitadoController::class);
Route::apiResource('reservas', ReservaController::class);
Route::apiResource('resenias', ReseniaController::class);
Route::apiResource('perfiles', PerfilUsuarioController::class);
Route::apiResource('usuarios', UserController::class);
Route::apiResource('mensajes', MensajeController::class);
Route::apiResource('provincias', ProvinciaController::class)->only(['index', 'show']);
Route::apiResource('poblaciones', PoblacionController::class)->only('index');
Route::apiResource('tipos', TipoProductoController::class);
Route::apiResource('productos', ProductoController::class);

Route::post('imagenes', [SubirImagenController::class, 'store']);
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);

Route::get('/bodas/usuario/{id}', [BodaController::class, 'getBodaByUserId']);
Route::get('/perfiles/usuario/{id}', [PerfilUsuarioController::class, 'getPerfilByUserId']);
Route::get('provincias/poblacion/{id}',[ ProvinciaController::class, 'getByProvincia']);
Route::get('categorias/tipo/{id}', [CategoriaController::class, 'getByCategoria']);
// Route::apiResource('servicios', ServicioController::class)->only('index');
