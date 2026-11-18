<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

// Часть 1: Форма с сохранением в JSON-файл и вывод в виде таблицы
Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/submissions', [FeedbackController::class, 'index'])->name('feedback.index');
Route::get('/submissions/download/{filename}', [FeedbackController::class, 'download'])->name('feedback.download');

// Часть 2: Работа с БД через модели Eloquent (CRUD + Связи + Scopes + SoftDeletes)
Route::prefix('posts')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('posts.index');
    Route::get('/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/', [PostController::class, 'store'])->name('posts.store');
    Route::get('/{id}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');

    // Полиморфный комментарий к посту (MorphMany)
    Route::post('/{id}/comments', [CommentController::class, 'storeForPost'])->name('posts.comments.store');
});
