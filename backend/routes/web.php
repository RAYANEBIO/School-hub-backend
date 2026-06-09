<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClasseController;

Route::get('/', function () {
    return view('welcome');
});

// Affichage des classes
Route::get('/classes', [ClasseController::class, 'index']);

// Ajout d'une classe
Route::post('/classes', [ClasseController::class, 'store']);
