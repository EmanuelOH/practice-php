<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::view('/', 'welcome');

Route::middleware(['auth'])->group(function() {
    Route::resource('usuarios', UserController::class);
    
    Route::get('usuarios/eliminados/{id}', [UserController::class, 'showTrashed'])->name('usuarios.eliminados.show');
    Route::post('usuarios/{id}', [UserController::class, 'restoreUser'])->name('usuarios.restore');
});

Route::middleware(['auth:sanctum', 'verified', config('jetstream.auth_session')])
    ->get('/dashboard', fn() => view('dashboard'))->name('dashboard');
