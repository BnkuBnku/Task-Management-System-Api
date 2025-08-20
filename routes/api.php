<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    # User
    // Route::group(['prefix' => 'user'], function () {
    //     Route::match(['GET', 'POST'],'fetch', [UserController::class, 'fetch']);
    //     Route::post('store', [UserController::class, 'store']);
    //     Route::patch('update/{id}', [UserController::class, 'update']);
    //     Route::delete('delete/{id}', [UserController::class, 'delete']);
    // });

    # Task
    Route::group(['prefix' => 'task'], function () {
        Route::match(['GET', 'POST'],'fetch', [TaskController::class, 'fetch']);
        Route::post('store', [TaskController::class, 'store']);
        Route::patch('update/{id}', [TaskController::class, 'update']);
        Route::delete('delete/{id}', [TaskController::class, 'delete']);
    });

    # Dashboard
    // Route::group(['prefix' => 'dashboard'], function () {
    //     Route::get('cards', [DashboardController::class, 'cards']);
    //     Route::match(['get', 'post'], 'graphs', [DashboardController::class, 'graphs']);
    //     Route::match(['get', 'post'], 'graphs/registration', [DashboardController::class, 'registration_stats_graph']);
    //     Route::match(['get', 'post'], 'graphs/application_proper', [DashboardController::class, 'application_proper_graph']);
    // });

    # Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});
