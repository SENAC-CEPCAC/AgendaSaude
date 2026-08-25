<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendamentoEtapa1Controller;
use App\Http\Controllers\AgendamentoEtapa2Controller;
use App\Http\Controllers\AgendamentoEtapa3Controller;
use App\Http\Controllers\AnamneseColoController;
use App\Http\Controllers\AnamneseMamaController;
use App\Http\Controllers\ListaAgendamentoController;
use App\Http\Controllers\PoliticaPrivacidadeController;



// PAINEL PACIENTE

Route::get('/login', function () { //WILLIAM
    return view('login.loginP');
});

Route::get('/teste', function () { //WILLIAM
    return view('pesquisa.teste');
});

Route::get('/novasenha', function () { //WILLIAM
    return view('login.novasenha');
});
Route::get('/recuperacao', function () { //WILLIAM
    return view('login.recuperacaoP');
});

route::get('/agendamento/etapa-1', [AgendamentoEtapa1Controller::class, 'index'])->name('agendamento.etapa1'); //GABRIEL

route::get('/agendamento/etapa-2', [AgendamentoEtapa2Controller::class, 'index'])->name('agendamento.etapa2'); //GABRIEL

route::get('/agendamento/etapa-3', [AgendamentoEtapa3Controller::class, 'index'])->name('agendamento.etapa3'); //GABRIEL


Route::get('/feedback', function () {
    return view('pesquisa.feedback'); //ISABELA
});

//Route::get('/satisfacaocliente', function () {
//return view('pesquisa.satisfacaocliente');//ISABELA
//});

Route::get('/cancelado', function () {
    return view('components.cancelado'); //ISABELA ok
});

use App\Http\Controllers\AgendamentoController;

Route::patch('/agendamentos/{agendamento}/confirmar', [AgendamentoController::class, 'confirmar'])
    ->name('agendamentos.confirmar'); //ISABELA ok


Route::get('/confirmado', function () {
    return view('components.confirmado'); //ISABELA
});


Route::get('/teste', function () {
    return view('pesquisa.teste'); //ISABELA 
});


// Política de Privacidade
Route::get('/politica-de-privacidade', [PoliticaPrivacidadeController::class, 'privacidade'])->name('privacidade');


Route::get('/colo', function () {
    return view('anamnese.colo');
});

Route::get('/mama', function () {
    return view('anamnese.mama');
});

Route::get('/unidadesmoveis', function () {
    return view('anamnese.unidadesmoveis');
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

Route::get('/', function () {
    return view('acesso.index'); //RAFAEL
});

Route::get('/login', function () {
    return view('acesso.login'); //RAFAEL
})->name('acesso.login');

Route::get('/cadastro', function () {
    return view('acesso.cadastro'); //RAFAEL
})->name('acesso.cadastro');

Route::get('/novasenha', function () {
    return view('recuperacao.novasenha'); //RAFAEL
})->name('recuperacao.novasenha');

Route::get('/recuperacao', function () {
    return view('recuperacao.recuperacao'); //RAFAEL
})->name('recuperacao.recuperacao');

Route::get('/colaborador', function () {
    return view('colaborador.colaborador');
});
Route::get('/index', function () {
    return view('acesso.index');
});

// Autenticação
Route::middleware('auth.nivel:1,2,3,4')->group(function () {
    // N1
    Route::post('/AgendaSaude', [AgendamentoEtapa1Controller::class, 'AgendamentoEtapa1Controller'])->name('agendamento.etapa1'); //WILLIAM

    route::post('/AgendaSaude', [AgendamentoEtapa2Controller::class, 'AgendamentoEtapa2Controller'])->name('agendamento.etapa2'); //WILLIAM

    route::post('/AgendaSaude', [AgendamentoEtapa3Controller::class, 'AgendamentoEtapa3Controller'])->name('agendamento.etapa3'); //WILLIAM
    // N2 

    // N3 

    // N4



    //Route::post('/imcCalcular', [ImcController::class, 'calcularImc'])->name('imc.calcular');

    //Route::post('/imc', [ImcController::class, 'store'])->name('imc.store');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dash.index');
    Route::delete('/dashboard/delete/{id}', [DashboardController::class, 'destroy'])->name('dash.delete');
    Route::put('/dashboard/update/{id}', [DashboardController::class, 'update'])->name('dash.update');
});

Route::get('/agendamentos-gestao', [ListaAgendamentoController::class, 'index'])->name('agendamentos.index'); // Mateus
Route::get('/agendamentos/{id}', [ListaAgendamentoController::class, 'show'])->name('agendamentos.show'); // Mateus
Route::post('/agendamentos/{id}/validar-documento', [ListaAgendamentoController::class, 'validarDocumentos'])->name('agendamentos.validar-documento'); // Mateus
