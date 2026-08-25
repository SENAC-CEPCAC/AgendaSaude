<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendamentoEtapa1Controller;
use App\Http\Controllers\AgendamentoEtapa2Controller;
use App\Http\Controllers\AgendamentoEtapa3Controller;
use App\Http\Controllers\AnamneseColoController;
use App\Http\Controllers\AnamneseMamaController;
use App\Http\Controllers\ListaAgendamentoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdmController;
use App\Http\Controllers\UserColaborador;
use App\Http\Controllers\LoginColaboradorController;
use App\Http\Controllers\RelatorioController;

// PAINEL PACIENTE
Route::get('/login', function () {
    return view('login.loginP');
})->name('login.paciente');

Route::get('/novasenha-paciente', function () {
    return view('login.novaSenha');
});

Route::get('/teste', function () {
    return view('pesquisa.teste');
});

Route::get('/novasenha', function () {
    return view('login.novasenha');
});

Route::get('/recuperacao', function () {
    return view('login.recuperacaoP');
});

Route::get('/agendamento/etapa-1', [AgendamentoEtapa1Controller::class, 'index'])->name('agendamento.etapa1');
Route::get('/agendamento/etapa-2', [AgendamentoEtapa2Controller::class, 'index'])->name('agendamento.etapa2');
Route::get('/agendamento/etapa-3', [AgendamentoEtapa3Controller::class, 'index'])->name('agendamento.etapa3');

Route::get('/feedback', function () {
    return view('pesquisa.feedback');
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

Route::get('/colo', function () {
    return view('anamnese.colo');
});

Route::get('/mama', function () {
    return view('anamnese.mama');
});

Route::get('/unidadesmoveis', function () {
    return view('anamnese.unidadesmoveis');
});

// PAINEL COLABORADOR & ACESSO
Route::get('/', function () {
    return view('acesso.index');
})->name('home');

Route::get('/logincolaborador', [LoginColaboradorController::class, 'index'])->name('login.colaborador');
Route::post('/logincolaborador', [LoginColaboradorController::class, 'login'])->name('login.colaborador.attempt');

Route::get('/cadastro', function () {
    return view('acesso.cadastro');
})->name('acesso.cadastro');

Route::get('/novasenha', function () {
    return view('recuperacao.novasenha');
})->name('recuperacao.novasenha');

Route::get('/recuperacao', function () {
    return view('recuperacao.recuperacao');
});

Route::post('/login', [LoginController::class, 'logar'])->name('login.attempt');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/colaborador', function () {
    return view('colaborador.colaborador');
})->name('colaborador.colaborador');

// ACESSO AOS COLABORADORES DE NIVEL - 1
Route::middleware('auth.nivel:1')->group(function () {
    Route::post('/agendasaude1', [AgendamentoEtapa1Controller::class, 'AgendamentoEtapa1Controller'])->name('agendamento.etapa1');
    Route::post('/agendasaude2', [AgendamentoEtapa2Controller::class, 'AgendamentoEtapa2Controller'])->name('agendamento.etapa2');
    Route::post('/agendasaude3', [AgendamentoEtapa3Controller::class, 'AgendamentoEtapa3Controller'])->name('agendamento.etapa3');
});

// ACESSO AOS COLABORADORES DE NIVEL - 4
Route::middleware('auth.nivel:4')->group(function () {    
    Route::get('/adm', [AdmController::class, 'index'])->name('adm.adm');
    Route::patch('/adm/{adm}', [AdmController::class, 'update'])->name('adm.update');
    Route::patch('/adm/{adm}/status', [AdmController::class, 'toggleStatus'])->name('adm.status');
    Route::delete('/adm/{adm}', [AdmController::class, 'destroy'])->name('adm.destroy');
});

Route::middleware('auth.nivel:2,3,4')->group(function () {
    Route::post('/adm/colaboradores', [UserColaborador::class, 'store'])->name('adm.colaboradores.store');
});

// GESTÃO DE AGENDAMENTOS (MATEUS)
Route::get('/agendamentos-gestao', [ListaAgendamentoController::class, 'index'])->name('agendamentos.index');
Route::get('/agendamentos/{id}', [ListaAgendamentoController::class, 'show'])->name('agendamentos.show');
Route::post('/agendamentos/{id}/validar-documento', [ListaAgendamentoController::class, 'validarDocumentos'])->name('agendamentos.validar-documento');
Route::post('/agendamentos/{id}/status-comparecimento', [ListaAgendamentoController::class, 'atualizarStatusComparecimento'])->name('agendamentos.status-comparecimento');

// RELATÓRIOS GERENCIAIS E CLÍNICOS
Route::middleware(['auth'])->group(function () {
    });
    Route::get('/relatorios', [RelatorioController::class, 'index'])->name('relatorios.index');
    Route::get('/relatorios/exportar/{tipo}', [RelatorioController::class, 'exportarCsv'])->name('relatorios.exportar');
    Route::get('/relatorios/anamnese/{id}', [RelatorioController::class, 'anamneseDetalhes'])->name('relatorios.anamnese.detalhes');
    Route::get('/relatorios/anamneses/imprimir-todas', [RelatorioController::class, 'imprimirTodasAnamneses'])->name('relatorios.anamneses.imprimir-todas');