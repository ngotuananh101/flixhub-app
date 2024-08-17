<?php

use Illuminate\Support\Facades\Route;

include __DIR__ . '/auth.php';
include __DIR__ . '/admin.php';
include __DIR__ . '/home.php';

Route::get('/dev', function () {
    $position = Location::get('42.116.202.251');
    dd($position);
});
