<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AgendamentoEtapa1Controller;
use App\Http\Controllers\AgendamentoEtapa2Controller;
use App\Http\Controllers\AgendamentoEtapa3Controller;
use App\Http\Controllers\AnamneseColoController;
use App\Http\Controllers\AnamneseMamaController;
use App\Http\Controllers\ListaAgendamentoController;
use App\Http\Controllers\CadastroController;



// PAINEL PACIENTE

Route::get('/login', function () { //WILLIAM
    return view('login.loginP');
})->name('loginPaciente');

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
    return view('components.cancelado'); //ISABELA
});

Route::get('/confirmacaoagendamento', function () {
    return view('components.confirmacaoagendamento'); //ISABELA
});

Route::get('/confirmado', function () {
    return view('components.confirmado'); //ISABELA
});


Route::get('/teste', function () {
    return view('pesquisa.teste'); //ISABELA
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


Route::get('/login', function () {
    return view('login.loginP');
});
Route::get('/novasenha', function () {
    return view('login.novasenha');
});
Route::get('/recuperacao', function () {
    return view('login.recuperacaoP');
});

// ==========================================
// 1. ÁREA PÚBLICA & ACESSO
// ==========================================
Route::get('/', function () {
    return view('acesso.index'); //RAFAEL
});

Route::get('/login', function () {
    return view('acesso.login');
})->name('acesso.login');
Route::post('/login', [LoginController::class, 'logar'])->name('acesso.login.post');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/cadastro', function () {
    return view('acesso.cadastro');
})->name('acesso.cadastro');
Route::post('/cadastro/store', [CadastroController::class, 'store'])->name('acesso.cadastro.store');

Route::get('/logincolaborador', [LoginColaboradorController::class, 'index'])->name('login.colaborador');
Route::post('/logincolaborador', [LoginColaboradorController::class, 'login'])->name('login.colaborador.attempt');
Route::post('/login-admin', [LoginColaboradorController::class, 'login'])->name('login.admin.attempt');

Route::get('/recuperacao', function () {
    return view('recuperacao.recuperacao');
})->name('recuperacao.recuperacao');

Route::get('/novasenha', function () {
    return view('recuperacao.novasenha');
})->name('recuperacao.novasenha');
Route::post('/novasenha', [LoginController::class, 'atualizarSenha'])->name('recuperacao.senha.atualizar');

// Layout Padrão e Telas de Teste/Colaborador
Route::get('/layoutpadrao', function () {
    return view('LayoutPadrao.layoutpadrao');
})->name('layoutpadrao.layoutpadrao');

Route::get('/colaborador', function () {
    return view('colaborador.colaborador');
})->name('colaborador.colaborador');

Route::get('/teste', function () {
    return view('pesquisa.teste');
})->name('pesquisa.teste');

// Pesquisa de Satisfação / Feedback
Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/satisfacaocliente', function () {
    return view('pesquisa.satisfacaocliente');
})->name('pesquisa.satisfacaocliente');

// ==========================================
// 2. PACIENTE (NÍVEL 1) & FLUXO DE AGENDAMENTO
// ==========================================
Route::middleware('auth.nivel:1,2,3,4')->group(function () {
    Route::get('/agendamento/etapa-1', [AgendamentoEtapa1Controller::class, 'index'])->name('agendamento.etapa1');
    Route::post('/agendamento/etapa-1', [AgendamentoEtapa1Controller::class, 'salvar_etapa_1'])->name('agendamento.salvar_etapa_1');

    Route::get('/agendamento/etapa-2', [AgendamentoEtapa2Controller::class, 'index'])->name('agendamento.etapa2');
    Route::post('/agendamento/etapa-2', [AgendamentoEtapa2Controller::class, 'salvar_etapa_2'])->name('agendamento.salvar_etapa_2');

    Route::get('/agendamento/etapa-3', [AgendamentoEtapa3Controller::class, 'index'])->name('agendamento.etapa3');
    Route::post('/agendamento/etapa-3', [AgendamentoEtapa3Controller::class, 'store'])->name('agendamento.store');

    Route::get('/confirmado', function () {
        return view('components.confirmado');
    })->name('agendamento.confirmado');

    Route::get('/agendamentos', [ListaAgendamentoController::class, 'index'])->name('agendamento.agendamentos');
});

Route::get('/agendamentos-gestao', [ListaAgendamentoController::class, 'index'])->name('agendamentos.index'); // Mateus
Route::get('/agendamentos/{id}', [ListaAgendamentoController::class, 'show'])->name('agendamentos.show'); // Mateus
Route::post('/agendamentos/{id}/validar-documento', [ListaAgendamentoController::class, 'validarDocumentos'])->name('agendamentos.validar-documento'); // Mateus

Route::resource('anamnese-colo', AnamneseColoController::class);
//Route::resource('anamnese-mama', AnamneseMamaController::class);
