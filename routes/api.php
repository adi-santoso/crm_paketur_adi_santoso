<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json(['message' => 'Hello, API!']);
});

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('auth-login');
    Route::post('refresh', [AuthController::class, 'refresh'])->name('auth-refresh');
    Route::post('logout', [AuthController::class, 'logout'])->name('auth-logout');
});
