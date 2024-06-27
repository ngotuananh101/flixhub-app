<?php

use Illuminate\Support\Facades\Route;

include __DIR__ . '/auth.php';
include __DIR__ . '/admin.php';

// Test route
Route::get('/', function () {
    echo 'Hello World';
});
