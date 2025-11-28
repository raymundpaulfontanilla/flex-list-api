<?php

use App\Http\Controllers\AuthenticationControlller;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthenticationControlller::class, 'register']);
Route::post('/login', [AuthenticationControlller::class, 'login']);

Route::prefix('tasks')->group(function () {
    Route::post('/create-task', [TaskController::class, 'store']);
    Route::get('/', [TaskController::class, 'index']);
    Route::get('/{id}', [TaskController::class, 'show']);
    Route::put('/{id}', [TaskController::class, 'update']);
});
