<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::view('/', 'welcome');

Route::get('auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallBack']);


Route::prefix('auth')->group(function () {
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');

    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');

    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
        ->name('password.update');
});


Route::middleware(['auth'])->group(function() {
    Route::resource('usuarios', UserController::class);
    
    Route::get('usuarios/eliminados/{id}', [UserController::class, 'showTrashed'])->name('usuarios.eliminados.show');
    Route::post('usuarios/{id}', [UserController::class, 'restoreUser'])->name('usuarios.restore');
});

Route::middleware(['auth:sanctum', 'verified', config('jetstream.auth_session')])
    ->get('/dashboard', fn() => view('dashboard'))->name('dashboard');
