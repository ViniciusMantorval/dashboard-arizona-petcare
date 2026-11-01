<?php

use App\Http\Controllers\TutorController;
use App\Http\Controllers\FuncionarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::resource('tutores', TutorController::class);

Route::resource('funcionarios', FuncionarioController::class);