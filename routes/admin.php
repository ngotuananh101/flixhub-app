<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\DatatableController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TitleController;

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'datatables'], function () {
        Route::post('titles', [DatatableController::class, 'titles'])->name('datatables.titles');
    });

    Route::get('settings/clearCache', [SettingController::class, 'clearCache'])->name('settings.clearCache');
    Route::resource('settings', SettingController::class)->only(['show', 'update']);

    Route::resource('titles', TitleController::class);
});
