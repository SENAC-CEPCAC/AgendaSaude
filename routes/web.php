<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('login.login');
});

Route::get('/novasenha', function () {
    return view('login.novasenha');
});
Route::get('/recuperacao', function () {
    return view('login.recuperacao');
})->name('login.recuperacao');

Route::get('/listaAgendamento', function () {
    return view('ListaAgendamento.listaAgendamento');
});
Route::get('/cadastro', function () {
    return view('login.cadastro');
});