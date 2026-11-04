<?php

use App\Http\Controllers\PetController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\FuncionarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});


Route::resource('funcionarios', FuncionarioController::class);
Route::resource('tutores',TutorController::class)->parameters([
    'tutores' => 'tutor'
]);
Route::resource('tutores.pets',PetController::class)->shallow()->parameters([
    'tutores' => 'tutor'
]);
