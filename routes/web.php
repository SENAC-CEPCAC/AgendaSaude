<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendamentoEtapa1Controller;
use App\Http\Controllers\AgendamentoEtapa2Controller;
use App\Http\Controllers\AgendamentoEtapa3Controller;
use App\Http\Controllers\AnamneseColoController;
use App\Http\Controllers\AnamneseMamaController;
use App\Http\Controllers\ListaAgendamentoController;
use App\Http\Controllers\ListaProntuarioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdmController;
use App\Http\Controllers\UserColaborador;
use App\Http\Controllers\LoginColaboradorController;
use App\Http\Controllers\CadastroController;

<<<<<<< HEAD
=======


// PAINEL PACIENTE


Route::get('/login', function () { //WILLIAM
    return view('login.loginP');
})->name('login.paciente');

Route::get('/novasenha-paciente', function () { //WILLIAM
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
>>>>>>> ce165b0dfac050816667e66c5942f8d99568b1c8


Route::get('/satisfacaocliente', function () {
    return view('pesquisa.satisfacaocliente'); //ISABELA
});

Route::get('/teste', function () {
    return view('pesquisa.teste'); //ISABELA
});

Route::get('/unidadesmoveis', function () {
    return view('anamnese.unidadesmoveis'); //ISABELA
});

Route::get('/feedback', function () {
    return view('pesquisa.feedback'); //ISABELA
});

Route::post('/cadastro/store', [CadastroController::class, 'store'])->name('acesso.cadastro.store');

// ==========================================
// 8. PAINEL COLABORADOR & ACESSO (RAFAEL)
// ==========================================
Route::get('/', function () {
    return view('acesso.index');
})->name('home');

Route::get('/login', function () {
    return view('acesso.login');
})->name('acesso.login');

Route::get('/logincolaborador', [
    LoginColaboradorController::class,
    'index'
])->name('login.colaborador');
Route::post('/logincolaborador', [
    LoginColaboradorController::class,
    'login'
])->name('login.colaborador.attempt');

Route::get('/cadastro', function () {
    return view('acesso.cadastro');
})->name('acesso.cadastro');

Route::get('/novasenha', function () {
    return view('recuperacao.novasenha');
})->name('recuperacao.novasenha');
Route::post('/novasenha', [LoginColaboradorController::class, 'atualizarSenha'])->name('recuperacao.senha.atualizar');

Route::get('/recuperacao', function () {
    return view('recuperacao.recuperacao');
})->name('recuperacao.recuperacao');

//RAFAEL
Route::get('/', function () {
    return view('acesso.index');
})->name('acesso.index');

Route::get('/login', function () {
    return view('acesso.login');
})->name('acesso.login');



//ACESSO ÀS PÁGINAS DO FLUXO DE AGENDAMENTO
Route::middleware('auth.nivel:1,2,3,4')->group(function () {
    Route::get('/agendamentos-gestao', [ListaAgendamentoController::class, 'index'])->name('agendamentos.index'); // Mateus
    Route::get('/agendamentos/{id}', [ListaAgendamentoController::class, 'show'])->name('agendamentos.show'); // Mateus
    Route::post('/agendamentos/{id}/validar-documento', [ListaAgendamentoController::class, 'validarDocumentos'])->name('agendamentos.validar-documento'); // Mateus

    route::get('/agendamento/etapa-1', [
        AgendamentoEtapa1Controller::class,
        'index'
    ])->name('agendamento.etapa1'); //GABRIEL
    route::post('/agendamento/etapa-1', [
        AgendamentoEtapa1Controller::class,
        'salvar_etapa_1'
    ])->name('agendamento.salvar_etapa_1');
    route::get('/agendamento/etapa-2', [
        AgendamentoEtapa2Controller::class,
        'index'
    ])->name('agendamento.etapa2'); //GABRIEL
    route::post('/agendamento/etapa-2', [
        AgendamentoEtapa2Controller::class,
        'salvar_etapa_2'
    ])->name('agendamento.salvar_etapa_2');
    route::get('/agendamento/etapa-3', [
        AgendamentoEtapa3Controller::class,
        'index'
    ])->name('agendamento.etapa3'); //GABRIEL
    route::post('/agendamento/etapa-3', [
        AgendamentoEtapa3Controller::class,
        'store'
    ])->name('agendamento.store');
    Route::get('/confirmado', function () {
        return view('components.confirmado');
    })->name('agendamento.confirmado');
});

//ACESSO AOS COLABORADORES DE NIVEL - 2
Route::middleware('auth.nivel:2')->group(function () {
    // N2    
    Route::get('/cancelado', function () {
        return view('components.cancelado'); //ISABELA
    });

    Route::get('/confirmacaoagendamento', function () {
        return view('components.confirmacaoagendamento'); //ISABELA
    });
});

//ACESSO AOS COLABORADORES DE NIVEL - 3
Route::middleware('auth.nivel:3,4')->group(function () {
    // N3
    Route::get('/prontuario', [ListaProntuarioController::class, 'index'])
        ->name('triagem.index');

    Route::get('/colo', [AnamneseColoController::class, 'index'])
        ->name('anamnese.colo');

    Route::get('/mama', [AnamneseMamaController::class, 'index'])
        ->name('anamnese.mama');

    Route::get('/dashboard', function () {
        return view('painel_adm.dashboard');
    })->name('painel_adm.dashboard');
});

//ACESSO AOS COLABORADORES DE NIVEL - 4
Route::middleware('auth.nivel:4')->group(function () {
    // N4
    Route::get('/adm', [AdmController::class, 'index'])->name('adm.adm');
    Route::patch('/adm/{adm}', [AdmController::class, 'update'])->name('adm.update');
    Route::patch('/adm/{adm}/status', [AdmController::class, 'toggleStatus'])->name('adm.status');
    Route::delete('/adm/{adm}', [AdmController::class, 'destroy'])->name('adm.destroy');

    Route::post('/adm/colaboradores', [UserColaborador::class, 'store'])->name('adm.colaboradores.store');

    Route::get('/colaborador', function () {
        return view('colaborador.colaborador');
    })->name('colaborador.colaborador');

    Route::get('/dashboard', function () {
        return view('painel_adm.dashboard');
    })->name('painel_adm.dashboard');
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
Route::resource('anamnese-mama', AnamneseMamaController::class)->except(['create', 'edit', 'update']);

Route::get('/anamnese-dia', [AnamneseDoDiaController::class, 'index'])
    ->name('anamnese-dia.index');

Route::get('/anamnese-dia/pdf', [AnamneseDoDiaController::class, 'pdf'])
    ->name('anamnese-dia.pdf');

Route::get('/unidadesmoveis', function () {
    return view('anamnese.unidadesmoveis');
})->name('anamnese.unidadesmoveis');
