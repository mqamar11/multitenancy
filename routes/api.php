<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;



Route::post('login', [AuthController::class, 'login']);
// 👇 Grouped routes with middleware
Route::middleware(('auth:sanctum'))->group(function () {
Route::post('user', [AuthController::class, 'user']);
Route::post('logout', [AuthController::class, 'logout']);
    Route::prefix('posts')->group(function (): void {
        Route::get('/list', action: [PostController::class, 'index']);
        Route::post('/save', [PostController::class, 'store']);
        Route::get('/get/{id}', [PostController::class, 'show']);
        Route::put('/update/{id}', [PostController::class, 'update']);
        Route::delete('/delete/{id}', [PostController::class, 'destroy']);
    });

    Route::prefix('categories')->group(function () {
        Route::get('/list', [CategoryController::class, 'index']);
        Route::post('/save', [CategoryController::class, 'store']);
        Route::get('/get/{id}', [CategoryController::class, 'show']);
        Route::put('/update/{id}', [CategoryController::class, 'update']);
        Route::delete('/delete/{id}', [CategoryController::class, 'destroy']);
    });

});
