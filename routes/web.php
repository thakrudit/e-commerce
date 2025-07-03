<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;



Route::middleware('guest')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('welcome');

    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'handleLogin'])->name('auth.login');

    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'handleRegister'])->name('auth.register');

    Route::get('/forgot-password', [AuthController::class, 'passwordRequest'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'passwordEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'passwordReset'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'passwordUpdate'])->name('password.update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', [AuthController::class, 'verifyEmail'])->name('verification.notice');
    Route::post('/email/verify-resend', [AuthController::class, 'verifyEmailResend'])->middleware('throttle:6,1')->name('verification.resend'); // 6 attempts allowed in 1 min
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'emailVerified'])->middleware('signed')->name('verification.verify');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route::get('/home', [UserController::class, 'home'])->middleware(['verified', 'roalmanager:user'])->name('home');
    Route::get('/home', [UserController::class, 'home'])->middleware(['verified'])->name('home');
    
});