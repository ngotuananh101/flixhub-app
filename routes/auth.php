<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    // Guest routes
    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
        Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
        Route::get('password/reset', [App\Http\Controllers\Auth\PasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('password/email', [App\Http\Controllers\Auth\PasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('password/reset/{token}', [App\Http\Controllers\Auth\PasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('password/reset', [App\Http\Controllers\Auth\PasswordController::class, 'reset'])->name('password.update');
    });
});