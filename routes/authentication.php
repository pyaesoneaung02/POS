<?php

use App\Http\Controllers\Authentication\AuthenticatedSessionController;
use App\Http\Controllers\Authentication\RegisterUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    //Register
    Route::get('register',[RegisterUserController::class, 'create'])->name('authRegister')->middleware('admin');
    Route::post('register', [RegisterUserController::class, 'store']);

    //Login Process
    Route::get('login',[AuthenticatedSessionController::class, 'create'])->name('authLogin')->middleware('admin');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    //logout Process
    Route::get('logout',[AuthenticatedSessionController::class,'destroy'])->name('getCustomLogout');
    Route::post('logout',[AuthenticatedSessionController::class,'destroy'])->name('customLogout');
});
