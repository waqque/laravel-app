<?php

use App\Http\Controllers\Api\PostApiController;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\TagResource;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes (JSON Format с использованием API Resource)
|--------------------------------------------------------------------------
*/

// REST API для работы с постами (CRUD + SoftDeletes + Query Scopes)
Route::prefix('posts')->group(function () {
    Route::get('/', [PostApiController::class, 'index'])->name('api.posts.index');
    Route::post('/', [PostApiController::class, 'store'])->name('api.posts.store');
    Route::get('/{id}', [PostApiController::class, 'show'])->name('api.posts.show');
    Route::put('/{id}', [PostApiController::class, 'update'])->name('api.posts.update');
    Route::patch('/{id}', [PostApiController::class, 'update'])->name('api.posts.patch');
    Route::delete('/{id}', [PostApiController::class, 'destroy'])->name('api.posts.destroy');
    Route::post('/{id}/restore', [PostApiController::class, 'restore'])->name('api.posts.restore');
});

// Дополнительные API-эндпоинты для категорий и тегов
Route::get('/categories', function () {
    return CategoryResource::collection(Category::all());
})->name('api.categories');

Route::get('/tags', function () {
    return TagResource::collection(Tag::all());
})->name('api.tags');
