<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/test-reverb', function () {
    broadcast(new \App\Events\TestEvent("Hola Angular"));
    return "OK";
});

use App\Helpers\Helper;

Route::get('/test-helper', function () {
    return Helper::colorPorEstado('pendiente');
});


require __DIR__.'/auth.php';
