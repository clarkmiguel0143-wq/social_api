<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\CommentController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{post}', [PostController::class, 'show']);
Route::get('/posts/{post}/comments', [CommentController::class, 'index']);

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::prefix('/users')->group(function($route) {
        $route->get('/', [UserController::class, 'index']);
        $route->get('/{user}', [UserController::class, 'show']);
        $route->put('/{user}', [UserController::class, 'update']);
        $route->patch('/{user}', [UserController::class, 'update']);
        $route->delete('/{user}', [UserController::class, 'destroy']);
    });

    Route::prefix('/posts')->group(function($route) {
        $route->get('/', [PostController::class, 'index']);
        $route->get('/{post}', [PostController::class, 'show']);
        $route->put('/{post}', [PostController::class, 'update']);
        $route->patch('/{post}', [PostController::class, 'update']);
        $route->delete('/{post}', [PostController::class, 'destroy']);
    });

    Route::post('/posts/{post}/like', [LikeController::class, 'store']);
    Route::delete('/posts/{post}/like', [LikeController::class, 'destroy']);

    Route::post('/posts/{post}/comments', [CommentController::class, 'store']);

    Route::prefix('/comments')->group(function($route) {
        $route->put('/{comment}', [CommentController::class, 'update']);
        $route->patch('/{comment}', [CommentController::class, 'update']);
        $route->delete('/{comment}', [CommentController::class, 'destroy']);
    });
});