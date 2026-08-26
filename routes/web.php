<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AgendamentoEtapa1Controller;
use App\Http\Controllers\AgendamentoEtapa2Controller;
use App\Http\Controllers\AgendamentoEtapa3Controller;
use App\Http\Controllers\AnamneseColoController;
use App\Http\Controllers\AnamneseMamaController;
use App\Http\Controllers\ListaAgendamentoController;
use App\Http\Controllers\ListaProntuarioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdmController;
use App\Http\Controllers\UserColaboradorController;
use App\Http\Controllers\LoginColaboradorController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\AnamneseDoDiaController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\CronogramaGestaoController;
use App\Http\Controllers\ProntuarioVisualizacaoController;
use App\Http\Controllers\CnesUnidadeController;
use App\Http\Controllers\FeedbackController;
<<<<<<< HEAD
use App\Http\Controllers\PoliticaController;
=======
use App\Http\Controllers\PacientePerfilController;
>>>>>>> 4d75c02 (tela perfil, e tela hiostorico agendamento)

// ==========================================
// 1. ÁREA PÚBLICA & ACESSO
// ==========================================
Route::get('/', function () {
    return view('acesso.index');
})->name('acesso.index');

Route::get('/home', function () {
    return redirect()->route('acesso.index');
})->name('home');

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
//Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
//Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/satisfacaocliente', function () {
    return view('pesquisa.satisfacaocliente');
})->name('pesquisa.satisfacaocliente');



Route::get('/politica', [PoliticaController::class, 'politica'])->name('politica');

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
    Route::post('/agendamentos/{id}/cancelar', [ListaAgendamentoController::class, 'cancelarPeloPaciente'])->name('agendamentos.cancelar');

    // Perfil do Paciente
    Route::get('/perfil', [PacientePerfilController::class, 'index'])->name('paciente.perfil');
    Route::put('/perfil', [PacientePerfilController::class, 'update'])->name('paciente.perfil.update');
});

// ==========================================
// 3. OPERADOR / RECEPÇÃO (NÍVEL 2, 3, 4)
// ==========================================
Route::middleware('auth.nivel:2,3,4')->group(function () {
    Route::get('/agendamentos-gestao', [ListaAgendamentoController::class, 'index'])->name('agendamentos.index');
    Route::get('/agendamentos/{id}', [ListaAgendamentoController::class, 'show'])->name('agendamentos.show');
    Route::post('/agendamentos/{id}/validar-documento', [ListaAgendamentoController::class, 'validarDocumentos'])->name('agendamentos.validar-documento');
    Route::post('/agendamentos/{id}/status-comparecimento', [ListaAgendamentoController::class, 'atualizarStatusComparecimento'])->name('agendamentos.status-comparecimento');
});

// ==========================================
// 4. TRIAGEM & ENFERMAGEM (NÍVEL 3, 4)
// ==========================================
Route::middleware('auth.nivel:3,4')->group(function () {
    Route::get('/prontuario', [ListaProntuarioController::class, 'index'])->name('triagem.index');
    Route::get('/prontuario/{id}/detalhes', [ProntuarioVisualizacaoController::class, 'show'])->name('triagem.show');
    Route::patch('/prontuario/{id}/status', [ListaProntuarioController::class, 'atualizar_status'])->name('triagem.status');
    Route::post('/prontuario/{id}/avaliar-documento', [ListaProntuarioController::class, 'avaliar_documento'])->name('triagem.avaliar-documento');
    Route::post('/prontuario/{id}/reanexar-documento', [ListaProntuarioController::class, 'reanexar_documento'])->name('triagem.reanexar-documento');

    Route::get('/colo', [AnamneseColoController::class, 'index'])->name('anamnese.colo');
    Route::get('/mama', [AnamneseMamaController::class, 'index'])->name('anamnese.mama');

    Route::get('/anamnese-colo/{id}/pdf', [AnamneseColoController::class, 'pdf'])->name('anamnese-colo.pdf');
    Route::get('/anamnese-colo/create/{id_prontuario}', [AnamneseColoController::class, 'create'])->name('anamnese-colo.create');
    Route::resource('anamnese-colo', AnamneseColoController::class)->except(['create']);

    Route::get('/anamnese-mama/{id}/pdf', [AnamneseMamaController::class, 'pdf'])->name('anamnese-mama.pdf');
    Route::get('/anamnese-mama/create/{id_prontuario}', [AnamneseMamaController::class, 'create'])->name('anamnese-mama.create');
    Route::resource('anamnese-mama', AnamneseMamaController::class)->except(['create', 'edit', 'update']);

    Route::get('/anamnese-dia', [AnamneseDoDiaController::class, 'index'])->name('anamnese-dia.index');
    Route::get('/anamnese-dia/pdf', [AnamneseDoDiaController::class, 'pdf'])->name('anamnese-dia.pdf');

    // Relatórios
    Route::get('/relatorios', [RelatorioController::class, 'index'])->name('relatorios.index');
    Route::get('/relatorios/exportar/{tipo}', [RelatorioController::class, 'exportar'])->name('relatorios.exportar');
    Route::get('/relatorios/anamnese/{id}', [RelatorioController::class, 'anamneseDetalhes'])->name('relatorios.anamnese.detalhes');
    Route::get('/relatorios/anamneses/imprimir-todas', [RelatorioController::class, 'imprimirTodasAnamneses'])->name('relatorios.anamneses.imprimir-todas');
});

// ==========================================
// 5. GESTÃO & ADMINISTRAÇÃO (NÍVEL 4)
// ==========================================
Route::middleware('auth.nivel:4')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('painel_adm.dashboard');

    Route::get('/adm', [AdmController::class, 'index'])->name('adm.adm');
    Route::patch('/adm/{adm}', [AdmController::class, 'update'])->name('adm.update');
    Route::patch('/adm/{adm}/status', [AdmController::class, 'toggleStatus'])->name('adm.status');
    Route::delete('/adm/{adm}', [AdmController::class, 'destroy'])->name('adm.destroy');
    Route::post('/adm/colaboradores', [UserColaboradorController::class, 'store'])->name('adm.colaboradores.store');
    Route::post('/permissao-colaborador/cadastro/store', [UserColaboradorController::class, 'store'])->name('permissao_colaborador.cadastro.store');

    // Gestão de Cronogramas e Vagas
    Route::get('/cronograma', [CronogramaGestaoController::class, 'index'])->name('cronograma.index');
    Route::post('/cronograma', [CronogramaGestaoController::class, 'store'])->name('cronograma.store');
    Route::put('/cronograma/{id}', [CronogramaGestaoController::class, 'update'])->name('cronograma.update');
    Route::delete('/cronograma/{id}', [CronogramaGestaoController::class, 'destroy'])->name('cronograma.destroy');

    // Gestão de Unidades Móveis (CNES)
    Route::get('/unidadesmoveis', [CnesUnidadeController::class, 'index'])->name('unidadesmoveis.index');
    Route::post('/unidadesmoveis', [CnesUnidadeController::class, 'store'])->name('unidadesmoveis.store');
    Route::put('/unidadesmoveis/{cnesUnidade}', [CnesUnidadeController::class, 'update'])->name('unidadesmoveis.update');
    Route::delete('/unidadesmoveis/{cnesUnidade}', [CnesUnidadeController::class, 'destroy'])->name('unidadesmoveis.destroy');

    Route::get('/agendamentos/{id}/documento/{tipo}', [\App\Http\Controllers\ListaAgendamentoController::class, 'verDocumento'])->name('agendamentos.documento');
});

Route::middleware('auth.nivel:2,3,4')->group(function () {
    Route::post('/adm/colaboradores', [UserColaboradorController::class, 'store'])->name('adm.colaboradores.store');
});


Route::get('/agendamentos-gestao', [ListaAgendamentoController::class, 'index'])->name('agendamentos.index'); // Mateus
Route::get('/agendamentos/{id}', [ListaAgendamentoController::class, 'show'])->name('agendamentos.show'); // Mateus

Route::post('/agendamentos/{id}/validar-documento', [ListaAgendamentoController::class, 'validarDocumentos'])->name('agendamentos.validar-documento'); // Mateus


Route::post('/agendamentos/{id}/validar-documento', [ListaAgendamentoController::class, 'validarDocumentos'])->name('agendamentos.validar-documento'); // Mateus


Route::middleware(['auth'])->group(function () {
    }); //Mateus
    // Visualização principal dos Relatórios (com abas e filtros)
    Route::get('/relatorios', [RelatorioController::class, 'index'])->name('relatorios.index');

    // Download/Exportação dos relatórios (CSV/Excel)
    Route::get('/relatorios/exportar/{tipo}', [RelatorioController::class, 'exportar'])->name('relatorios.exportar');

    // Visualização individual de Anamnese via JSON/Modal
    Route::get('/relatorios/anamnese/{id}', [RelatorioController::class, 'anamneseDetalhes'])->name('relatorios.anamnese.detalhes');
    
Route::get('/relatorios/anamneses/imprimir-todas', [RelatorioController::class, 'imprimirTodasAnamneses'])->name('relatorios.anamneses.imprimir-todas'); //Mateus

// ==========================================
// 9. ANAMNESE 
// ==========================================
Route::get('/anamnese-colo/{id}/pdf', [AnamneseColoController::class, 'pdf'])->name('anamnese-colo.pdf');
Route::get('/anamnese-colo/create/{id_prontuario}', [AnamneseColoController::class, 'create'])->name('anamnese-colo.create');
Route::resource('anamnese-colo', AnamneseColoController::class)->except(['create']);

Route::get('/anamnese-mama/{id}/pdf', [AnamneseMamaController::class, 'pdf'])->name('anamnese-mama.pdf');
Route::get('/anamnese-mama/create/{id_prontuario}', [AnamneseMamaController::class, 'create'])->name('anamnese-mama.create');
Route::get('/anamnese-mama/agendamentos', [AnamneseMamaController::class, 'selecionarProntuario'])->name('anamnese-mama.selecionar');
Route::resource('anamnese-mama', AnamneseMamaController::class)->except(['create']);


Route::get('/anamnese-dia', [AnamneseDoDiaController::class, 'index'])
    ->name('anamnese-dia.index');

Route::get('/anamnese-dia/pdf', [AnamneseDoDiaController::class, 'pdf'])
    ->name('anamnese-dia.pdf');

Route::get('/unidadesmoveis', function () {
    return view('anamnese.unidadesmoveis');
})->name('anamnese.unidadesmoveis');


Route::get('/anamnese-paciente', [AnamneseDoDiaController::class, 'anamnesePaciente'])->name('anamnese.paciente');

