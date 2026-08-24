<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendamentoEtapa1Controller;
use App\Http\Controllers\AgendamentoEtapa2Controller;
use App\Http\Controllers\AgendamentoEtapa3Controller;
use App\Http\Controllers\AnamneseColoController;
use App\Http\Controllers\AnamneseMamaController;
use App\Http\Controllers\AnamneseDoDiaController;
//use App\Http\Controllers\CnesUnidadeController;
use App\Http\Controllers\ListaAgendamentoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdmController;
use App\Http\Controllers\UserColaborador;
use App\Http\Controllers\LoginColaboradorController;
use App\Http\Controllers\RelatorioController;



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



// ==========================================
// 8. PAINEL COLABORADOR & ACESSO (RAFAEL)
// ==========================================
Route::get('/', function () {
    return view('acesso.index');
})->name('home');

Route::get('/login', function () {
    return view('acesso.login');
})->name('acesso.login');

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

Route::get('/', function () {
    return view('acesso.index');
})->name('acesso.index');

//ACESSO AOS COLABORADORES DE NIVEL - 1
Route::middleware('auth.nivel:1')->group(function () {
    // N1
    Route::post('/agendasaude1', [AgendamentoEtapa1Controller::class, 'AgendamentoEtapa1Controller'])->name('agendamento.etapa1'); //WILLIAM
    Route::post('/agendasaude2', [AgendamentoEtapa2Controller::class, 'AgendamentoEtapa2Controller'])->name('agendamento.etapa2'); //WILLIAM
    Route::post('/agendasaude3', [AgendamentoEtapa3Controller::class, 'AgendamentoEtapa3Controller'])->name('agendamento.etapa3'); //WILLIAM
        
});

//ACESSO AOS COLABORADORES DE NIVEL - 2
Route::middleware('auth.nivel:2')->group(function () {
    // N2
   
});

//ACESSO AOS COLABORADORES DE NIVEL - 3
Route::middleware('auth.nivel:3')->group(function () {
    // N3
    
     
});

//ACESSO AOS COLABORADORES DE NIVEL - 4
Route::middleware('auth.nivel:4')->group(function () {    
    // N4
    Route::get('/adm', [AdmController::class, 'index'])->name('adm.adm');
    Route::patch('/adm/{adm}', [AdmController::class, 'update'])->name('adm.update');
    Route::patch('/adm/{adm}/status', [AdmController::class, 'toggleStatus'])->name('adm.status');
    Route::delete('/adm/{adm}', [AdmController::class, 'destroy'])->name('adm.destroy');
});

Route::middleware('auth.nivel:2,3,4')->group(function () {
    Route::post('/adm/colaboradores', [UserColaborador::class, 'store'])->name('adm.colaboradores.store');
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
