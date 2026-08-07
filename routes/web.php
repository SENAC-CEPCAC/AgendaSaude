<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('permissao_colaborador.index');
});

Route::get('/login', function () {
    return view('permissao_colaborador.login');
})->name('permissao_colaborador.login');

Route::get('/colaborador', function () {
    return view('permissao_colaborador.colaborador');
});
