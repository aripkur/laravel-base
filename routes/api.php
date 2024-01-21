<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware(['throttle:5,1'])->group(function () {
    Route::get('/captcha', [App\Http\Controllers\AuthController::class, 'captcha']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/users', [App\Http\Controllers\Api\UserController::class, 'listing']);
    Route::post('/users-save', [App\Http\Controllers\Api\UserController::class, 'save']);
    Route::post('/users-reset-password', [App\Http\Controllers\Api\UserController::class, 'resetPassword']);
    Route::get('/users/{username}', [App\Http\Controllers\Api\UserController::class, 'show']);
    Route::delete('/users', [App\Http\Controllers\Api\UserController::class, 'delete']);
});
