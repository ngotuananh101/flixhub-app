<?php

use Illuminate\Support\Facades\Route;

include __DIR__ . '/admin.php';

Route::get('/', function () {
    // Test mongodb connection
    $name = \Illuminate\Support\Facades\DB::connection('mongodb')->getDatabaseName();
    echo $name;
});
