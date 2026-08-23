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

Route::get('/recuperacao', function () {
    return view('recuperacao.recuperacao');
});

//RAFAEL
Route::get('/', function () {
    return view('acesso.index');
})->name('acesso.index');

Route::get('/login', function () {
    return view('acesso.login');
})->name('acesso.login');

Route::post('/login', [LoginController::class, 'logar'])->name('login.attempt');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');



//ACESSO AOS COLABORADORES DE NIVEL - 1
Route::middleware('auth.nivel:1,3')->group(function () {
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

    Route::get('/agendamentos-gestao', [ListaAgendamentoController::class, 'index'])->name('agendamentos.index'); // Mateus

    Route::get('/agendamentos/{id}', [ListaAgendamentoController::class, 'show'])->name('agendamentos.show'); // Mateus

    Route::post('/agendamentos/{id}/validar-documento', [ListaAgendamentoController::class, 'validarDocumentos'])->name('agendamentos.validar-documento'); // Mateus

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

});

//ACESSO AOS COLABORADORES DE NIVEL - 3
Route::middleware('auth.nivel:3')->group(function () {
    // N3
    Route::get('/prontuario', [ListaProntuarioController::class, 'index'])
        ->name('triagem.index');

    Route::get('/colo', function () {
        return view('anamnese.colo');
    });

    Route::get('/mama', function () {
        return view('anamnese.mama');
    });

    

});

//ACESSO AOS COLABORADORES DE NIVEL - 4
Route::middleware('auth.nivel:4')->group(function () {
    // N4
    Route::get('/adm', [AdmController::class, 'index'])->name('adm.adm');
    Route::patch('/adm/{adm}', [AdmController::class, 'update'])->name('adm.update');
    Route::patch('/adm/{adm}/status', [AdmController::class, 'toggleStatus'])->name('adm.status');
    Route::delete('/adm/{adm}', [AdmController::class, 'destroy'])->name('adm.destroy');
});

Route::middleware('auth.nivel:4')->group(function () {
    Route::post('/adm/colaboradores', [UserColaborador::class, 'store'])->name('adm.colaboradores.store');

    Route::get('/colaborador', function () {
        return view('colaborador.colaborador');
    })->name('colaborador.colaborador');
});
