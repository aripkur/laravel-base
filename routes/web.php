<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::get('/', [App\Http\Controllers\WebController::class, 'dashboard'])->name("dashboard");
    Route::get('/users', [App\Http\Controllers\WebController::class, 'users'])->name("users");
    Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['guest', 'prevent-back-history'])->group(function () {
    Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'authenticate'])->name('login.verif');
});

