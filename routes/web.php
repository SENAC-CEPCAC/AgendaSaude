<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendamentoEtapa1Controller;
use App\Http\Controllers\AgendamentoEtapa2Controller;
use App\Http\Controllers\AgendamentoEtapa3Controller;
use App\Http\Controllers\AnamneseColoController;
use App\Http\Controllers\AnamneseMamaController;
use App\Http\Controllers\ListaAgendamentoController;



// PAINEL PACIENTE

Route::get('/login', function () { //WILLIAM
    return views('login.loginP');
});

Route::get('/teste', function () { //WILLIAM
    return views('pesquisa.teste');
});

Route::get('/novasenha', function () { //WILLIAM
    return views('login.novasenha');
});
Route::get('/recuperacao', function () { //WILLIAM
    return views('login.recuperacaoP');
});

route::get('/agendamento/etapa-1', [AgendamentoEtapa1Controller::class, 'index'])->name('agendamento.etapa1'); //GABRIEL

route::get('/agendamento/etapa-2', [AgendamentoEtapa2Controller::class, 'index'])->name('agendamento.etapa2'); //GABRIEL

route::get('/agendamento/etapa-3', [AgendamentoEtapa3Controller::class, 'index'])->name('agendamento.etapa3'); //GABRIEL


Route::get('/feedback', function () {
    return views('pesquisa.feedback'); //ISABELA
});

//Route::get('/satisfacaocliente', function () {
//return views('pesquisa.satisfacaocliente');//ISABELA
//});

Route::get('/cancelado', function () {
    return views('components.cancelado'); //ISABELA
});

Route::get('/confirmacaoagendamento', function () {
    return viewss('components.confirmacaoagendamento'); //ISABELA
});

Route::get('/confirmado', function () {
    return views('components.confirmado'); //ISABELA
});


Route::get('/teste', function () {
    return views('pesquisa.teste'); //ISABELA
});

Route::get('/colo', function () {
    return views('anamnese.colo');
});

Route::get('/mama', function () {
    return views('anamnese.mama');
});

Route::get('/unidadesmoveis', function () {
    return views('anamnese.unidadesmoveis');
});



Route::get('/', function () {
    return views('acesso.index'); //RAFAEL
});

Route::get('/login', function () {
    return views('acesso.login'); //RAFAEL
})->name('acesso.login');

Route::get('/cadastro', function () {
    return views('acesso.cadastro'); //RAFAEL
})->name('acesso.cadastro');

Route::get('/novasenha', function () {
    return views('recuperacao.novasenha'); //RAFAEL
})->name('recuperacao.novasenha');

Route::get('/recuperacao', function () {
    return views('recuperacao.recuperacao'); //RAFAEL
})->name('recuperacao.recuperacao');

Route::get('/colaborador', function () {
    return views('colaborador.colaborador');
});

