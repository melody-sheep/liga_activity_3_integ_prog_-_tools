<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::any('/debug-url', function() {
    return [
        'url' => request()->fullUrl(),
        'method' => request()->method(),
        'path' => request()->path(),
    ];
});