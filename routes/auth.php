<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\VerifyController;

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    // Guest routes
    Route::group(['middleware' => 'guest'], function () {
        // Login with email and password
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login'])
            ->middleware('throttle:6,1')
            ->name('handleLogin');

        // Login with socialite
        Route::get('{provider}/redirect', [LoginController::class, 'redirectToProvider'])
            ->name('redirectToProvider');
        Route::get('{provider}/callback', [LoginController::class, 'handleProviderCallback'])
            ->name('handleProviderCallback');

        // Forgot password
        Route::get('forgot-password', [PasswordController::class, 'showLinkRequestForm'])
            ->name('forgot-password');
        Route::post('forgot-password', [PasswordController::class, 'sendResetLinkEmail'])
            ->middleware('throttle:6,1')
            ->name('handleForgotPassword');

        // Reset password
        Route::get('reset-password/{id}/{token}', [PasswordController::class, 'showResetForm'])
            ->name('reset-password');
        Route::post('reset-password', [PasswordController::class, 'reset'])
            ->name('new-password');

        // Register
        Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [RegisterController::class, 'register'])
            ->middleware('throttle:6,1')
            ->name('handleRegister');
        // Verify email
        Route::get('email/verify/{id}/{hash}', [VerifyController::class, 'emailVerify'])
            ->name('email-verification.verify');
    });

    // Authenticated routes
    Route::group(['middleware' => 'auth'], function () {
        // Logout
        Route::match(['get', 'post'], '/logout', [LogoutController::class, 'logout'])->name('logout');
        // Verify email
        Route::get('/email/verify', [VerifyController::class, 'showEmailVerificationForm'])
            ->name('email-verification.notice');
    });
});
