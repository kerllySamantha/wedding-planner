<?php

use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\Api\InvitadoController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\NotificacionController;
use App\Http\Controllers\Api\PoblacionController;
use App\Http\Controllers\Api\PresupuestoController;
use App\Http\Controllers\Api\PresupuestoPdfController;
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
use App\Http\Controllers\Api\NotaBodaController;
use App\Http\Controllers\Api\TipoProductoController;
use App\Http\Controllers\Api\ItemPresupuestoController;
use App\Http\Controllers\Api\StripeController;
use App\Http\Controllers\Api\WebhookController;
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
Route::get('/notas-boda/boda/{boda}', [NotaBodaController::class, 'getByBoda']);
Route::get('/perfiles/usuario/{id}', [PerfilUsuarioController::class, 'getPerfilByUserId']);
Route::get('provincias/poblacion/{id}', [ProvinciaController::class, 'getByProvincia']);
Route::get('categorias/tipo/{id}', [CategoriaController::class, 'getByCategoria']);
Route::get('/detalles/presupuesto/{id}', [ItemPresupuestoController::class, 'getByPresupuesto']);
Route::get('/presupuestos/boda/{id}', [PresupuestoController::class, 'getPresupuestoByBoda']);
Route::get('/presupuestos/boda/{id}/pdf', [PresupuestoPdfController::class, 'generarPorBoda']);
Route::prefix('reservas')->group(function () {
    Route::get('calendario/empresa/{id}', [ReservaController::class, 'getCalendario']);
    Route::get('empresa/{id}', [ReservaController::class, 'getReservaEmpresa']);
    Route::get('empresa/{id}/estado/{estado}', [ReservaController::class, 'getRersevaPorConfirmar']);
});
Route::get('/empresa/usuario/{user}', [EmpresaController::class, 'getEmpresaPorUsuario']);
Route::get('/empresa/{id}/estadisticas', [EmpresaController::class, 'estadisticas']);
Route::get('empresas/{empresa}/productos', [EmpresaController::class, 'productos']);
Route::get('/poblaciones/{poblacion}', [PoblacionController::class, 'show'])
    ->name('poblaciones.show');


Route::apiResource('bodas', BodaController::class);
Route::apiResource('empresas', EmpresaController::class);
Route::apiResource('categorias', CategoriaController::class);
Route::apiResource('invitados', InvitadoController::class);
Route::apiResource('resenias', ReseniaController::class);
Route::apiResource('perfiles', PerfilUsuarioController::class);
Route::apiResource('usuarios', UserController::class);
Route::apiResource('mensajes', MensajeController::class);
Route::apiResource('provincias', ProvinciaController::class)->only(['index', 'show']);
Route::apiResource('poblaciones', PoblacionController::class)->only(['index']);
Route::apiResource('tipos', TipoProductoController::class);
Route::apiResource('productos', ProductoController::class)->
parameters(['productos' => 'producto'])->only('index');
Route::apiResource('presupuestos', PresupuestoController::class);
Route::apiResource('detalles', ItemPresupuestoController::class);
Route::apiResource('reservas', ReservaController::class);
Route::apiResource('pedirPresupuestos', PedirPresupuestoController::class);
Route::apiResource('notas-boda', NotaBodaController::class);
Route::apiResource('notificaciones', NotificacionController::class)
    ->parameters(['notificaciones' => 'notificacion']);

Route::post('imagenes', [SubirImagenController::class, 'store']);
Route::post('/login', [LoginController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
 
});

Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::post('/reservas/{id}/cancelar', [ReservaController::class, 'cancelar']);
Route::post('/reservas/{id}/confirmar', [ReservaController::class, 'confirmar'])
    ->middleware('auth:sanctum');

Route::patch('pedirPresupuestos/{pedirPresupuesto}/respuesta', [PedirPresupuestoController::class, 'responder'])
    ->middleware('auth:sanctum');
Route::patch('pedirPresupuestos/{pedirPresupuesto}/aceptar', [PedirPresupuestoController::class, 'aceptarPorUsuario'])
    ->middleware('auth:sanctum');
Route::patch('pedirPresupuestos/{pedirPresupuesto}/rechazar', [PedirPresupuestoController::class, 'rechazarPorUsuario'])
    ->middleware('auth:sanctum');



Route::get('/test-reverb', function () {
    broadcast(new \App\Events\TestEvent("Hola Angular"));
    return "OK";
});

Route::post('stripe/webhook', [WebhookController::class, 'handle']);
Route::post('stripe/create-payment-intent', [StripeController::class, 'createPaymentIntent'])
    ->middleware('auth:sanctum');


// Route::apiResource('servicios', ServicioController::class)->only('index');
