<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

// Страница формы (GET) и отправка данных формы (POST)
Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

// Страница вывода сохраненных данных в виде таблицы (GET)
Route::get('/submissions', [FeedbackController::class, 'index'])->name('feedback.index');

// Скачивание отдельного JSON-файла (GET)
Route::get('/submissions/download/{filename}', [FeedbackController::class, 'download'])->name('feedback.download');
