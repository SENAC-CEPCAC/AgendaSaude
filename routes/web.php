<?php

use Illuminate\Support\Facades\Route;

<<<<<<< HEAD
Route::get('/teste', function () {
    return view('pesquisa.teste');
});


Route::get('/feedback', function () {
    return view('pesquisa.feedback');
});

Route::get('/satisfacaocliente', function () {
    return view('pesquisa.satisfacaocliente');
});

Route::get('/cancelado', function () {
    return view('components.cancelado');
});

Route::get('/confirmacaoagendamento', function () {
    return view('components.confirmacaoagendamento');
});

Route::get('/confirmado', function () {
    return view('components.confirmado');
});


Route::get('/teste', function () {
    return view('pesquisa.teste');
});
=======
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
>>>>>>> d093cdf2d3b5f4bf1123aab3808cd17f695a5568
