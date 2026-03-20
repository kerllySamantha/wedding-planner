<?php

use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\Api\InvitadoController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\NotificacionController;
use App\Http\Controllers\Api\PoblacionController;
use App\Http\Controllers\Api\PresupuestoController;
use App\Http\Controllers\Api\ProvinciaController;
use App\Http\Controllers\Api\ReseniaController;
use App\Http\Controllers\Api\BodaController;
use App\Http\Controllers\Api\MensajeController;
use App\Http\Controllers\Api\ReservaController;
use App\Http\Controllers\Api\PerfilUsuarioController;
use App\Http\Controllers\Api\PedirPresupuestoController;
use App\Http\Controllers\Api\ProductoController;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SubirImagenController;
use App\Http\Controllers\Api\TipoProductoController;
use App\Http\Controllers\Api\ItemPresupuestoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/empresas/{id}/resenias', [ReseniaController::class, 'getReseniaEmpresa']);
Route::get('/empresas/{id}/resenias-filtradas', [ReseniaController::class, 'getReseniasValoradas']);
Route::get('pedirPresupuestos/empresas/{empresa}', [PedirPresupuestoController::class, 'getPedirPresupuestosEmpresa']);

Route::get('/bodas/usuario/{id}', [BodaController::class, 'getBodaByUserId']);
Route::get('/perfiles/usuario/{id}', [PerfilUsuarioController::class, 'getPerfilByUserId']);
Route::get('provincias/poblacion/{id}', [ProvinciaController::class, 'getByProvincia']);
Route::get('categorias/tipo/{id}', [CategoriaController::class, 'getByCategoria']);
Route::get('/detalles/presupuesto/{id}', [ItemPresupuestoController::class, 'getByPresupuesto']);
Route::get('/presupuestos/boda/{id}', [PresupuestoController::class, 'getPresupuestoByBoda']);
Route::prefix('reservas')->group(function () {
    Route::get('calendario/empresa/{id}', [ReservaController::class, 'getCalendario']);
    Route::get('empresa/{id}', [ReservaController::class, 'getReservaEmpresa']);
    Route::get('empresa/{id}/estado/{estado}', [ReservaController::class, 'getRersevaPorConfirmar']);
});
Route::get('/empresa/usuario/{user}', [EmpresaController::class, 'getEmpresaPorUsuario']);


Route::apiResource('bodas', BodaController::class);
Route::apiResource('empresas', EmpresaController::class);
Route::apiResource('categorias', CategoriaController::class);
Route::apiResource('invitados', InvitadoController::class);
Route::apiResource('resenias', ReseniaController::class);
Route::apiResource('perfiles', PerfilUsuarioController::class);
Route::apiResource('usuarios', UserController::class);
Route::apiResource('mensajes', MensajeController::class);
Route::apiResource('provincias', ProvinciaController::class)->only(['index', 'show']);
Route::apiResource('poblaciones', PoblacionController::class)->only('index');
Route::apiResource('tipos', TipoProductoController::class);
Route::apiResource('productos', ProductoController::class);
Route::apiResource('presupuestos', PresupuestoController::class);
Route::apiResource('detalles', ItemPresupuestoController::class);
Route::apiResource('reservas', ReservaController::class);
Route::apiResource('pedirPresupuestos', PedirPresupuestoController::class);
Route::apiResource('notificaciones', NotificacionController::class)
    ->parameters(['notificaciones' => 'notificacion']);

Route::post('imagenes', [SubirImagenController::class, 'store']);
// Rutas públicas
Route::post('/login', [LoginController::class, 'login']);

// Rutas protegidas con Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
 
});

Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::post('/reservas/{id}/cancelar', [ReservaController::class, 'cancelar']);

Route::patch('pedirPresupuestos/{pedirPresupuesto}/respuesta', [PedirPresupuestoController::class, 'responder']);



Route::get('/test-reverb', function () {
    broadcast(new \App\Events\TestEvent("Hola Angular"));
    return "OK";
});


// Route::apiResource('servicios', ServicioController::class)->only('index');
