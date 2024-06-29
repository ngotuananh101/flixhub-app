<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    // Guest routes
    Route::group(['middleware' => 'guest'], function () {
        // Login with email and password
        Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
        
        // Login with socialite
        Route::get('{provider}/redirect', [App\Http\Controllers\Auth\LoginController::class, 'redirectToProvider'])->name('redirectToProvider');
        Route::get('{provider}/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleProviderCallback'])->name('handleProviderCallback');
    });

    // Authenticated routes
    Route::group(['middleware' => 'auth'], function () {
        // Logout
        Route::match(['get', 'post'], '/logout', [App\Http\Controllers\Auth\LogoutController::class, 'logout'])->name('logout');
    });
});