<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AgendamentoEtapa1Controller;
use App\Http\Controllers\AgendamentoEtapa2Controller;
use App\Http\Controllers\AgendamentoEtapa3Controller;
use App\Http\Controllers\AnamneseColoController;
use App\Http\Controllers\AnamneseMamaController;
use App\Http\Controllers\AnamneseDoDiaController;
use App\Http\Controllers\ListaAgendamentoController;
use App\Http\Controllers\ListaProntuarioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdmController;
use App\Http\Controllers\UserColaborador;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\LoginColaboradorController;
use App\Http\Controllers\CronogramaGestaoController;
use App\Http\Controllers\ProntuarioVisualizacaoController;

<<<<<<< HEAD
/*
|--------------------------------------------------------------------------
| PÁGINA INICIAL / ACESSO
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('acesso.index');
})->name('acesso.index');

Route::get('/index', function () {
    return view('acesso.index');
});

Route::get('/login', function () {
    return view('acesso.login');
})->name('acesso.login');

Route::post('/login', [LoginController::class, 'logar'])
    ->name('login.attempt');

Route::post('/logout', [LoginController::class, 'destroy'])
    ->name('logout');

Route::get('/cadastro', function () {
    return view('acesso.cadastro');
})->name('acesso.cadastro');

Route::get('/colaborador', function () {
    return view('colaborador.colaborador');
})->name('colaborador.colaborador');


/*
|--------------------------------------------------------------------------
| RECUPERAÇÃO DE SENHA
|--------------------------------------------------------------------------
*/

Route::get('/novasenha', function () {
    return view('recuperacao.novasenha');
})->name('recuperacao.novasenha');

Route::get('/novasenha-paciente', function () {
    return view('login.novaSenha');
})->name('novasenha.paciente');

Route::get('/recuperacao', function () {
    return view('recuperacao.recuperacao');
})->name('recuperacao.recuperacao');


/*
|--------------------------------------------------------------------------
| TESTES
|--------------------------------------------------------------------------
*/

Route::get('/teste', function () {
    return view('pesquisa.teste');
})->name('teste');


/*
|--------------------------------------------------------------------------
| LOGIN DO COLABORADOR
|--------------------------------------------------------------------------
*/

Route::get('/loginadmin', [LoginColaboradorController::class, 'index'])
    ->name('login.admin');

Route::post('/loginadmin', [LoginColaboradorController::class, 'logar'])
    ->name('login.admin.attempt');

Route::post('/logoutadmin', [LoginColaboradorController::class, 'destroy'])
    ->name('login.admin.logout');

Route::get('/logincolaborador', [LoginColaboradorController::class, 'index'])
    ->name('login.colaborador');

Route::post('/logincolaborador', [LoginColaboradorController::class, 'login'])
    ->name('login.colaborador.attempt');


/*
|--------------------------------------------------------------------------
| AGENDAMENTO - 3 ETAPAS
|--------------------------------------------------------------------------
*/

Route::get('/agendamento/etapa-1', [AgendamentoEtapa1Controller::class, 'index'])
    ->name('agendamento.etapa1');

Route::post('/agendamento/etapa-1', [AgendamentoEtapa1Controller::class, 'salvar_etapa_1'])
    ->name('agendamento.salvar_etapa_1');


Route::get('/agendamento/etapa-2', [AgendamentoEtapa2Controller::class, 'index'])
    ->name('agendamento.etapa2');

Route::post('/agendamento/etapa-2', [AgendamentoEtapa2Controller::class, 'salvar_etapa_2'])
    ->name('agendamento.salvar_etapa_2');


Route::get('/agendamento/etapa-3', [AgendamentoEtapa3Controller::class, 'index'])
    ->name('agendamento.etapa3');

Route::post('/agendamento/etapa-3', [AgendamentoEtapa3Controller::class, 'store'])
    ->name('agendamento.store');


/*
|--------------------------------------------------------------------------
| PÁGINAS DO AGENDAMENTO
|--------------------------------------------------------------------------
*/

Route::get('/feedback', function () {
    return view('pesquisa.feedback');
})->name('feedback');

Route::get('/cancelado', function () {
    return view('components.cancelado');
})->name('agendamento.cancelado');

Route::get('/confirmacaoagendamento', function () {
    return view('components.confirmacaoagendamento');
})->name('agendamento.confirmacao');

Route::get('/confirmado', function () {
    return view('components.confirmado');
})->name('agendamento.confirmado');


/*
|--------------------------------------------------------------------------
| ANAMNESES / PÁGINAS
|--------------------------------------------------------------------------
*/

Route::get('/colo', function () {
    return view('anamnese.colo');
})->name('anamnese.colo');

Route::get('/mama', function () {
    return view('anamnese.mama');
})->name('anamnese.mama');

Route::get('/unidadesmoveis', function () {
    return view('anamnese.unidadesmoveis');
})->name('anamnese.unidadesmoveis');


/*
|--------------------------------------------------------------------------
| ACESSO NÍVEL 1
|--------------------------------------------------------------------------
*/

Route::middleware('auth.nivel:1')->group(function () {

    Route::post('/agendasaude1', [
        AgendamentoEtapa1Controller::class,
        'AgendamentoEtapa1Controller'
    ])->name('agendasaude.etapa1');

    Route::post('/agendasaude2', [
        AgendamentoEtapa2Controller::class,
        'AgendamentoEtapa2Controller'
    ])->name('agendasaude.etapa2');

    Route::post('/agendasaude3', [
        AgendamentoEtapa3Controller::class,
        'AgendamentoEtapa3Controller'
    ])->name('agendasaude.etapa3');

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

Route::post('/login', [LoginController::class, 'logar'])->name('login.attempt');
Route::post('/cadastro', [LoginController::class, 'cadastrar'])->name('cadastro.store');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');



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
>>>>>>> c6463960cfaa456585db638854b2e9274e0a7f51
});


/*
|--------------------------------------------------------------------------
| ACESSO NÍVEL 2
|--------------------------------------------------------------------------
*/

Route::middleware('auth.nivel:2')->group(function () {
<<<<<<< HEAD

});


/*
|--------------------------------------------------------------------------
| ACESSO NÍVEL 3
|--------------------------------------------------------------------------
*/

Route::middleware('auth.nivel:3')->group(function () {

});


/*
|--------------------------------------------------------------------------
| ADMINISTRAÇÃO - NÍVEL 4
|--------------------------------------------------------------------------
*/

Route::middleware('auth.nivel:4')->group(function () {

    Route::get('/adm', [AdmController::class, 'index'])
        ->name('adm.adm');

    Route::patch('/adm/{adm}', [AdmController::class, 'update'])
        ->name('adm.update');

    Route::patch('/adm/{adm}/status', [AdmController::class, 'toggleStatus'])
        ->name('adm.status');

    Route::delete('/adm/{adm}', [AdmController::class, 'destroy'])
        ->name('adm.destroy');

});


/*
|--------------------------------------------------------------------------
| ACESSO NÍVEIS 2, 3 E 4
|--------------------------------------------------------------------------
*/

Route::middleware('auth.nivel:2,3,4')->group(function () {

    Route::post('/adm/colaboradores', [
        UserColaborador::class,
        'store'
    ])->name('adm.colaboradores.store');

    Route::get('/acesso_restrito', function () {
        return view('acesso_restrito.acesso_restrito');
    })->name('acesso_restrito.acesso_restrito');


    /*
    |--------------------------------------------------------------------------
    | GESTÃO DE CRONOGRAMAS E VAGAS
    |--------------------------------------------------------------------------
    */

    Route::get('/gestao-cronograma', [
        CronogramaGestaoController::class,
        'index'
    ])->name('cronograma.index');

    Route::post('/gestao-cronograma', [
        CronogramaGestaoController::class,
        'store'
    ])->name('cronograma.store');

    Route::put('/gestao-cronograma/{id}', [
        CronogramaGestaoController::class,
        'update'
    ])->name('cronograma.update');

    Route::delete('/gestao-cronograma/{id}', [
        CronogramaGestaoController::class,
        'destroy'
    ])->name('cronograma.destroy');

});


/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::middleware('auth.nivel:1,2,3')->group(function () {

    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ])->name('dash.index');

    Route::delete('/dashboard/delete/{id}', [
        DashboardController::class,
        'destroy'
    ])->name('dash.delete');

    Route::put('/dashboard/update/{id}', [
        DashboardController::class,
        'update'
    ])->name('dash.update');

});


/*
|--------------------------------------------------------------------------
| AGENDAMENTOS
|--------------------------------------------------------------------------
*/

Route::get('/agendamentos-gestao', [
    ListaAgendamentoController::class,
    'index'
])->name('agendamentos.index');

Route::get('/agendamentos/{id}', [
    ListaAgendamentoController::class,
    'show'
])->name('agendamentos.show');

Route::post('/agendamentos/{id}/validar-documento', [
    ListaAgendamentoController::class,
    'validarDocumentos'
])->name('agendamentos.validar-documento');


/*
|--------------------------------------------------------------------------
| PRONTUÁRIO ELETRÔNICO DO PACIENTE
|--------------------------------------------------------------------------
*/

Route::get('/prontuario/paciente/{id}', [
    ProntuarioVisualizacaoController::class,
    'show'
])->name('prontuario.paciente');

Route::get('/prontuario/{id}', [
    ProntuarioVisualizacaoController::class,
    'show'
])->name('prontuario.detalhes');


/*
|--------------------------------------------------------------------------
| RELATÓRIOS
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.nivel:1,2,3,4'])->group(function () {

    Route::get('/relatorios', [
        RelatorioController::class,
        'index'
    ])->name('relatorios.index');

    Route::get('/relatorios/exportar/{tipo}', [
        RelatorioController::class,
        'exportar'
    ])->name('relatorios.exportar');

    Route::get('/relatorios/anamnese/{id}', [
        RelatorioController::class,
        'anamneseDetalhes'
    ])->name('relatorios.anamnese.detalhes');

    Route::get('/relatorios/anamneses/imprimir-todas', [
        RelatorioController::class,
        'imprimirTodasAnamneses'
    ])->name('relatorios.anamneses.imprimir-todas');

});


/*
|--------------------------------------------------------------------------
| ANAMNESE - COLO
|--------------------------------------------------------------------------
*/

Route::get('/anamnese-colo/{id}/pdf', [
    AnamneseColoController::class,
    'pdf'
])->name('anamnese-colo.pdf');

Route::get('/anamnese-colo/create/{id_prontuario}', [
    AnamneseColoController::class,
    'create'
])->name('anamnese-colo.create');

Route::resource('anamnese-colo', AnamneseColoController::class)
    ->except(['create']);


/*
|--------------------------------------------------------------------------
| ANAMNESE - MAMA
|--------------------------------------------------------------------------
*/

Route::get('/anamnese-mama/{id}/pdf', [
    AnamneseMamaController::class,
    'pdf'
])->name('anamnese-mama.pdf');

Route::get('/anamnese-mama/create/{id_prontuario}', [
    AnamneseMamaController::class,
    'create'
])->name('anamnese-mama.create');

Route::resource('anamnese-mama', AnamneseMamaController::class)
    ->except(['create', 'edit', 'update']);


/*
|--------------------------------------------------------------------------
| ANAMNESE DO DIA
|--------------------------------------------------------------------------
*/

Route::get('/anamnese-dia', [
    AnamneseDoDiaController::class,
    'index'
])->name('anamnese-dia.index');

Route::get('/anamnese-dia/pdf', [
    AnamneseDoDiaController::class,
    'pdf'
])->name('anamnese-dia.pdf');
=======
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
>>>>>>> c6463960cfaa456585db638854b2e9274e0a7f51
