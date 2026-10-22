<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

// Маршруты приложения
Route::get('/', [MainController::class, 'index'])->name('home');
Route::get('/form', [MainController::class, 'form'])->name('form');
Route::post('/form', [MainController::class, 'store'])->name('form.store');
Route::get('/data', [MainController::class, 'data'])->name('data');
