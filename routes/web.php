<?php

use Illuminate\Support\Facades\Route;

Route::get('/colo', function () {
    return view('anamnese.colo');
});

Route::get('/mama', function () {
    return view('anamnese.mama');
});