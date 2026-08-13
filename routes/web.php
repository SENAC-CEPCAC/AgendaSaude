<?php

use Illuminate\Support\Facades\Route;

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
<<<<<<< HEAD

Route::get('/login', function () {
    return view('login.loginP');
});
Route::get('/novasenha', function () {
    return view('login.novasenha');
});
Route::get('/recuperacao', function () {
    return view('login.recuperacaoP');
});
Route::get('/agendamento', function () {
    return view('ListaAgendamento.listaAgendamento');
});
=======
>>>>>>> 8dc4c6f5a053afc8d62d97dc67fc291230fe52c9
