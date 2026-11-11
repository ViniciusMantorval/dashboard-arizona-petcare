<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClinicaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\TutorController;
use Illuminate\Support\Facades\Route;

Route::pattern('perfil', 'funcionario|dono');

Route::get('/', fn () => redirect()->route(auth()->check() ? 'dashboard' : 'login'))->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1')->name('login.store');

    Route::get('/cadastro/{perfil}', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/cadastro/{perfil}', [AuthController::class, 'register'])->middleware('throttle:10,1')->name('register.store');

    Route::view('/recuperar-senha', 'auth.recuperar-senha')->name('password.request');
    Route::post('/recuperar-senha', [PasswordResetController::class, 'enviarLink'])->middleware('throttle:5,1')->name('password.email');
    Route::get('/redefinir-senha/{token}', [PasswordResetController::class, 'formulario'])->name('password.reset');
    Route::post('/redefinir-senha', [PasswordResetController::class, 'atualizar'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dono/dashboard', [DashboardController::class, 'dono'])->middleware('perfil:dono')->name('dashboard.dono');
    Route::get('/funcionario/dashboard', [DashboardController::class, 'funcionario'])->middleware('perfil:funcionario')->name('dashboard.funcionario');
    Route::post('/clinicas', [ClinicaController::class, 'store'])->middleware('perfil:dono')->name('clinicas.store');
    Route::resource('funcionarios', FuncionarioController::class)->middleware('perfil:dono');
    Route::resource('tutores', TutorController::class)->parameters(['tutores' => 'tutor']);
    Route::resource('tutores.pets', PetController::class)->shallow()->parameters(['tutores' => 'tutor']);
});