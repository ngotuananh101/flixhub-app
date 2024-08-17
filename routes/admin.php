<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\DatatableController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TitleController;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'permission', 'check-account-active']], function () {
    /**
     * Admin Home Page
     */
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Fast login to super admin
    //    Route::get('fast-login', [HomeController::class, 'fastLogin'])->name('fast-login');

    /**
     * Handle Datatables requests
     */
    Route::group(['prefix' => 'datatables'], function () {
        Route::post('roles', [DatatableController::class, 'roles'])->name('datatables.roles');
        Route::post('users', [DatatableController::class, 'users'])->name('datatables.users');
        Route::post('titles', [DatatableController::class, 'titles'])->name('datatables.titles');
        Route::post('user-sessions/{id}', [DatatableController::class, 'userSessions'])->name('datatables.user-sessions');
    });

    /**
     * Settings
     */
    Route::get('settings/clearCache', [SettingController::class, 'clearCache'])->name('settings.clearCache');
    Route::resource('settings', SettingController::class)->only(['show', 'update']);

    /**
     * Roles
     */
    Route::resource('roles', RoleController::class)->except('show');

    /**
     * Users
     */
    Route::resource('users', UserController::class);
    Route::post('users/location', [UserController::class, 'checkLocation'])->name('users.location');

    /**
     * Titles
     */
    Route::resource('titles', TitleController::class);
});
