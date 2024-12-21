<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('refresh', [AuthController::class, 'refresh'])->name('auth.refresh');
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::middleware(['auth:api'])->group(function (){
   Route::prefix('companies')->group(function (){
       Route::get('/', [CompanyController::class, 'index'])->name('company.index');
       Route::get('/{id}', [CompanyController::class, 'show'])->name('company.show');
       Route::post('/', [CompanyController::class, 'store'])->name('company.store');
       Route::put('/{id}', [CompanyController::class, 'update'])->name('company.update');
       Route::delete('/{id}', [CompanyController::class, 'destroy'])->name('company.destroy');
   });
});
