<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    // Admin role access to manage posts
    Route::middleware('role:admin')->group(function () {
        Route::resource('posts', PostController::class);
    });

    // Authors can only create, update, or delete their own posts
    // Route::middleware('role:author')->group(function () {

    // });
    Route::post('posts/{id}/comments', [CommentController::class, 'store']);
});
