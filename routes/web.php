<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClinicaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\TutorController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.choose')->name('login');
    Route::get('/login/{perfil}', [AuthController::class, 'loginForm'])->whereIn('perfil', ['funcionario', 'dono'])->name('login.perfil');
    Route::post('/login/{perfil}', [AuthController::class, 'login'])->whereIn('perfil', ['funcionario', 'dono'])->name('login.store');
    Route::get('/cadastro/{perfil}', [AuthController::class, 'registerForm'])->whereIn('perfil', ['funcionario', 'dono'])->name('register');
    Route::post('/cadastro/{perfil}', [AuthController::class, 'register'])->whereIn('perfil', ['funcionario', 'dono'])->middleware('throttle:10,1')->name('register.store');
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
