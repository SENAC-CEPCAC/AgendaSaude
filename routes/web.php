<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendamentoEtapa1;
use App\Http\Controllers\AgendamentoEtapa2Controller;
use App\Http\Controllers\AgendamentoEtapa3Controller;

Route::get('/teste', function () {
    return view('pesquisa.teste');
});


route::get('/agendamento/etapa-1', [AgendamentoEtapa1::class, 'index'])->name('agendamento.etapa1');

route::get('/agendamento/etapa-2', [AgendamentoEtapa2Controller::class, 'index'])->name('agendamento.etapa2');

route::get('/agendamento/etapa-3', [AgendamentoEtapa3Controller::class, 'index'])->name('agendamento.etapa3');


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


Route::get('/colo', function () {
    return view('anamnese.colo');
});

Route::get('/mama', function () {
    return view('anamnese.mama');
});

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