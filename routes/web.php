<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\FuncionarioController;
Route::get('/', function () {
    return view('home');
});

Route::resource('funcionarios', FuncionarioController::class);
