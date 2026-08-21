<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AgendamentoEtapa1Controller;
use App\Http\Controllers\AgendamentoEtapa2Controller;
use App\Http\Controllers\AgendamentoEtapa3Controller;
use App\Http\Controllers\ListaProntuarioController;
use App\Http\Controllers\ListaAgendamentoController;
use App\Http\Controllers\AnamneseColoController;
use App\Http\Controllers\AnamneseMamaController;
//use App\Http\Controllers\CnesUnidadeController;

/*
|--------------------------------------------------------------------------
| Rotas Web - Agenda Saúde
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. FLUXO DE AGENDAMENTO DO PACIENTE (GABRIEL)
// ==========================================
Route::get('/agendamento/etapa-1', [AgendamentoEtapa1Controller::class, 'index'])->name('agendamento.etapa1');
Route::post('/agendamento/etapa-1', [AgendamentoEtapa1Controller::class, 'salvar_etapa_1'])->name('agendamento.salvar_etapa_1');

Route::get('/agendamento/etapa-2', [AgendamentoEtapa2Controller::class, 'index'])->name('agendamento.etapa2');
Route::post('/agendamento/etapa-2', [AgendamentoEtapa2Controller::class, 'salvar_etapa_2'])->name('agendamento.salvar_etapa_2');

Route::get('/agendamento/etapa-3', [AgendamentoEtapa3Controller::class, 'index'])->name('agendamento.etapa3');
Route::post('/agendamento/etapa-3', [AgendamentoEtapa3Controller::class, 'store'])->name('agendamento.store');

Route::get('/confirmado', function () {
    return view('components.confirmado');
})->name('agendamento.confirmado');

Route::get('/confirmacaoagendamento', function () {
    return view('components.confirmacaoagendamento');
})->name('agendamento.confirmacao');

Route::get('/cancelado', function () {
    return view('components.cancelado');
})->name('agendamento.cancelado');


// ==========================================
// 2. TRIAGEM ADMINISTRATIVA N1 (GABRIEL)
// ==========================================
Route::get('/agendamento', [ListaProntuarioController::class, 'index'])->name('triagem.index');
Route::patch('/agendamento/{id}/status', [ListaProntuarioController::class, 'atualizar_status'])->name('triagem.atualizar_status');
Route::post('/agendamento/{id}/avaliar-documento', [ListaProntuarioController::class, 'avaliar_documento'])->name('triagem.avaliar_documento');
Route::post('/agendamento/{id}/reanexar-documento', [ListaProntuarioController::class, 'reanexar_documento'])->name('triagem.reanexar_documento');


// ==========================================
// 3. GESTÃO DE AGENDAMENTOS (MATEUS)
// ==========================================
Route::get('/agendamentos-gestao', [ListaAgendamentoController::class, 'index'])->name('agendamentos.index');
Route::get('/agendamentos/{id}', [ListaAgendamentoController::class, 'show'])->name('agendamentos.show');
Route::post('/agendamentos/{id}/validar-documento', [ListaAgendamentoController::class, 'validarDocumentos'])->name('agendamentos.validar-documento');
Route::post('/agendamentos/{id}/confirmar-paciente', [ListaAgendamentoController::class, 'confirmarHorarioPeloPaciente'])->name('agendamentos.confirmar-paciente');
Route::post('/agendamentos/{id}/cancelar-paciente', [ListaAgendamentoController::class, 'cancelarPeloPaciente'])->name('agendamentos.cancelar-paciente');


// ==========================================
// 4. PAINEL DE GESTÃO / DASHBOARD
// ==========================================
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


// ==========================================
// 5. AUTENTICAÇÃO PACIENTE (WILLIAM)
// ==========================================
Route::get('/login-paciente', function () {
    return view('login.loginP');
})->name('login.paciente');

Route::get('/novasenha-paciente', function () {
    return view('login.novasenha');
});

Route::get('/recuperacao-paciente', function () {
    return view('login.recuperacaoP');
});


// ==========================================
// 6. SATISFAÇÃO & FEEDBACK (ISABELA)
// ==========================================
Route::get('/feedback', function () {
    return view('pesquisa.feedback');
})->name('pesquisa.feedback');

Route::get('/teste', function () {
    return view('pesquisa.teste');
});


Route::get('/unidadesmoveis', function () {
    return view('anamnese.unidadesmoveis');
})->name('anamnese.unidadesmoveis');


// ==========================================
// 8. PAINEL COLABORADOR & ACESSO (RAFAEL)
// ==========================================
Route::get('/', function () {
    return view('permissao_colaborador.index');
})->name('home');

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
    return view('colaborador.colaborador');
});

Route::get('/index', function () {
    return view('acesso.index');
});


// ==========================================
// 9. ANAMNESE 
// ==========================================
Route::get('/anamnese-colo/{id}/pdf', [AnamneseColoController::class, 'pdf'])->name('anamnese-colo.pdf');
Route::get('/anamnese-colo/create/{id_prontuario}', [AnamneseColoController::class, 'create'])->name('anamnese-colo.create');
Route::resource('anamnese-colo', AnamneseColoController::class)->except(['create']);

Route::get('/anamnese-mama/{id}/pdf', [AnamneseMamaController::class, 'pdf'])->name('anamnese-mama.pdf');
Route::get('/anamnese-mama/create/{id_prontuario}', [AnamneseMamaController::class, 'create'])->name('anamnese-mama.create');
Route::resource('anamnese-mama', AnamneseMamaController::class)->except(['create']);

Route::get('/unidadesmoveis', function () {
    return view('anamnese.unidadesmoveis');
})->name('anamnese.unidadesmoveis');