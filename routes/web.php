<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendamentoEtapa1;
use App\Http\Controllers\AgendamentoEtapa2Controller;
use App\Http\Controllers\AgendamentoEtapa3Controller;

Route::get('/teste', function () {
    return view('pesquisa.teste');
});

<<<<<<< HEAD
route::get('/agendamento/etapa-1', [AgendamentoEtapa1::class, 'index'])->name('agendamento.etapa1');

route::get('/agendamento/etapa-2', [AgendamentoEtapa2Controller::class, 'index'])->name('agendamento.etapa2');

route::get('/agendamento/etapa-3', [AgendamentoEtapa3Controller::class, 'index'])->name('agendamento.etapa3');
=======

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
>>>>>>> d27092e2fe0032ac7be9b23406293ffcb35aa837
