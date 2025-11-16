<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\TaskApiController;

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    Route::get('/user', [AuthApiController::class, 'me']);
    Route::post('/logout', [AuthApiController::class, 'logout']);

    // CRUD TASK
    Route::get('/tasks', [TaskApiController::class, 'index']);
    Route::post('/tasks', [TaskApiController::class, 'store']);          // Admin only
    Route::get('/tasks/{task}', [TaskApiController::class, 'show']);
    Route::put('/tasks/{task}', [TaskApiController::class, 'update']);   // User can update status only
    Route::delete('/tasks/{task}', [TaskApiController::class, 'destroy']); // Admin
});

