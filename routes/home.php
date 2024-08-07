<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'verified', 'check-account-active']], function () {
    Route::get('/', [App\Http\Controllers\Home\HomeController::class, 'index'])->name('home.index');
});
