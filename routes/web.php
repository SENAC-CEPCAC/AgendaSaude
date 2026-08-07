<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('login.loginP');
});
Route::get('/novasenha', function () {
    return view('login.novasenha');
});
Route::get('/recuperacao', function () {
    return view('login.recuperacaoP');
});
Route::get('/', function () {
    return view('ListaAgendamento.listaAgendamento');
});
