<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TaskController;

Route::middleware('throttle:api-auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware(['auth:sanctum', 'throttle:api-tasks'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('tasks', [TaskController::class, 'index']);
    Route::post('tasks', [TaskController::class, 'store']);
    Route::put('/tasks/{task}', [TaskController::class, 'update']);
    Route::delete('/tasks/{task}', [TaskController::class, 'delete']);
    Route::put('/tasks/{id}/restore', [TaskController::class, 'restore']);
});
