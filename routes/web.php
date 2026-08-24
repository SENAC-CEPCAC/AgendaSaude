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
use App\Http\Controllers\LoginColaboradorController;
use App\Http\Controllers\CronogramaGestaoController;
use App\Http\Controllers\ProntuarioVisualizacaoController;



// PAINEL PACIENTE


Route::get('/login', function () { //WILLIAM
    return view('login.loginP');
})->name('login.paciente');

Route::get('/novasenha-paciente', function () {
    return view('login.novaSenha');
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

// ==========================================
// FLUXO DE AGENDAMENTO (3 ETAPAS)
// ==========================================
Route::get('/agendamento/etapa-1', [AgendamentoEtapa1Controller::class, 'index'])->name('agendamento.etapa1');
Route::post('/agendamento/etapa-1', [AgendamentoEtapa1Controller::class, 'salvar_etapa_1'])->name('agendamento.salvar_etapa_1');

Route::get('/agendamento/etapa-2', [AgendamentoEtapa2Controller::class, 'index'])->name('agendamento.etapa2');
Route::post('/agendamento/etapa-2', [AgendamentoEtapa2Controller::class, 'salvar_etapa_2'])->name('agendamento.salvar_etapa_2');

Route::get('/agendamento/etapa-3', [AgendamentoEtapa3Controller::class, 'index'])->name('agendamento.etapa3');
Route::post('/agendamento/etapa-3', [AgendamentoEtapa3Controller::class, 'store'])->name('agendamento.store');


Route::get('/feedback', function () {
    return view('pesquisa.feedback'); //ISABELA
});

//Route::get('/satisfacaocliente', function () {
//return view('pesquisa.satisfacaocliente');//ISABELA
//});

Route::get('/cancelado', function () {
    return view('components.cancelado'); //ISABELA
})->name('agendamento.cancelado');

Route::get('/confirmacaoagendamento', function () {
    return view('components.confirmacaoagendamento'); //ISABELA
})->name('agendamento.confirmacao');

Route::get('/confirmado', function () {
    return view('components.confirmado'); //ISABELA
})->name('agendamento.confirmado');

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



// ==========================================
// ACESSO COLABORADOR (LOGIN POR MATRÍCULA)
// ==========================================
Route::get('/loginadmin', [LoginColaboradorController::class, 'index'])->name('login.admin');
Route::post('/loginadmin', [LoginColaboradorController::class, 'logar'])->name('login.admin.attempt');
Route::post('/logoutadmin', [LoginColaboradorController::class, 'destroy'])->name('login.admin.logout');

// ==========================================
// 8. PAINEL COLABORADOR & ACESSO (RAFAEL)
// ==========================================
Route::get('/', function () {
    return view('acesso.index');
})->name('home');

Route::get('/login', function () {
    return view('acesso.login');
})->name('acesso.login');

Route::get('/cadastro', function () {
    return view('acesso.cadastro');
})->name('acesso.cadastro');

Route::get('/novasenha', function () {
    return view('recuperacao.novasenha');
})->name('recuperacao.novasenha');

Route::get('/recuperacao', function () {
    return view('recuperacao.recuperacao');
});

Route::get('/', function () {
    return view('acesso.index'); //RAFAEL
});

//RAFAEL
Route::get('/login', function () {
    return view('acesso.login');
})->name('acesso.login');

Route::post('/login', [LoginController::class, 'logar'])->name('login.attempt');

Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

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
})->name('colaborador.colaborador');
Route::get('/index', function () {
    return view('acesso.index');
});

Route::get('/index.php', function () {
    return view('acesso.index');
});

//ACESSO AOS COLABORADORES DE NIVEL - 2
Route::middleware('auth.nivel:2')->group(function () {
    // N2
    Route::get('/colaborador', function () {
        return view('colaborador.colaborador');
    });    
});

//ACESSO AOS COLABORADORES DE NIVEL - 4
Route::middleware('auth.nivel:4')->group(function () {    
    // N4
    Route::get('/acesso_restrito', function () {
        return view('acesso_restrito.acesso_restrito');
    })->name('acesso_restrito.acesso_restrito');

    // GESTÃO DE CRONOGRAMAS E VAGAS (EXCLUSIVO GESTOR N4)
    Route::get('/gestao-cronograma', [CronogramaGestaoController::class, 'index'])->name('cronograma.index');
    Route::post('/gestao-cronograma', [CronogramaGestaoController::class, 'store'])->name('cronograma.store');
    Route::put('/gestao-cronograma/{id}', [CronogramaGestaoController::class, 'update'])->name('cronograma.update');
    Route::delete('/gestao-cronograma/{id}', [CronogramaGestaoController::class, 'destroy'])->name('cronograma.destroy');
});


// Autenticação
Route::middleware('auth.nivel:1,2,3')->group(function () {
    // N1
    // Route::post('/agendasaude1', [AgendamentoEtapa1Controller::class, 'AgendamentoEtapa1Controller'])->name('agendamento.etapa1'); //WILLIAM
    // Route::post('/agendasaude2', [AgendamentoEtapa2Controller::class, 'AgendamentoEtapa2Controller'])->name('agendamento.etapa2'); //WILLIAM
    // Route::post('/agendasaude3', [AgendamentoEtapa3Controller::class, 'AgendamentoEtapa3Controller'])->name('agendamento.etapa3'); //WILLIAM
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

// ==========================================
// PRONTUÁRIO ELETRÔNICO DO PACIENTE (PEP)
// ==========================================
Route::get('/prontuario/paciente/{id}', [ProntuarioVisualizacaoController::class, 'show'])->name('prontuario.paciente');
Route::get('/prontuario/{id}', [ProntuarioVisualizacaoController::class, 'show'])->name('prontuario.detalhes');

/*Route::post('/agendamentos/{id}/validar-documento', [ListaAgendamentoController::class, 'validarDocumentos'])->name('agendamentos.validar-documento'); // Mateus

Route::post('/agendamentos/{id}/validar-documento', [ListaAgendamentoController::class, 'validarDocumentos'])->name('agendamentos.validar-documento'); // Mateus*/