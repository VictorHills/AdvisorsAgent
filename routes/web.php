<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// SPA catch-all route
Route::view('/{any}', 'app')->where('any', '.*');
