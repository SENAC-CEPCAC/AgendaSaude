<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('permissao_colaborador.index');
});

Route::get('/login', function () {
    return view('permissao_colaborador.login');
})->name('permissao_colaborador.login');

Route::get('/cadastro', function () {
    return view('permissao_colaborador.cadastro');
})->name('permissao_colaborador.cadastro');

Route::get('/novasenha', function () {
    return view('permissao_colaborador.novasenha');
})->name('permissao_colaborador.novasenha');

Route::get('/recuperacao', function () {
    return view('permissao_colaborador.recuperacao');
})->name('permissao_colaborador.recuperacao');

Route::get('/colaborador', function () {
    return view('permissao_colaborador.colaborador');
});

