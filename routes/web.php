<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendamentoEtapa1Controller;
use App\Http\Controllers\AgendamentoEtapa2Controller;
use App\Http\Controllers\AgendamentoEtapa3Controller;
use App\Http\Controllers\AnamneseColoController;
use App\Http\Controllers\AnamneseMamaController;
use App\Http\Controllers\CadastroController;



    // PAINEL PACIENTE

Route::get('/login', function () {//WILLIAM
    return view('login.loginP');
})->name('loginPaciente');

Route::get('/teste', function () {//WILLIAM
    return view('pesquisa.teste');
});

Route::get('/novasenha', function () {//WILLIAM
    return view('login.novasenha');
});
Route::get('/recuperacao', function () {//WILLIAM
    return view('login.recuperacaoP');
});

route::get('/agendamento/etapa-1', [AgendamentoEtapa1Controller::class, 'index'])->name('agendamento.etapa1');//GABRIEL

route::get('/agendamento/etapa-2', [AgendamentoEtapa2Controller::class, 'index'])->name('agendamento.etapa2');//GABRIEL

route::get('/agendamento/etapa-3', [AgendamentoEtapa3Controller::class, 'index'])->name('agendamento.etapa3');//GABRIEL


Route::get('/feedback', function () {
    return view('pesquisa.feedback');//ISABELA
});

//Route::get('/satisfacaocliente', function () {
    //return view('pesquisa.satisfacaocliente');//ISABELA
//});

Route::get('/cancelado', function () {
    return view('components.cancelado');//ISABELA
});

Route::get('/confirmacaoagendamento', function () {
    return view('components.confirmacaoagendamento');//ISABELA
});

Route::get('/confirmado', function () {
    return view('components.confirmado');//ISABELA
});


Route::get('/teste', function () {
    return view('pesquisa.teste');//ISABELA
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
Route::get('/agendamento', function () {
    return view('ListaAgendamento.listaAgendamento');
});

Route::get('/', function () {
    return view('permissao_colaborador.index');//RAFAEL
})->name('index');

Route::get('/login', function () {
    return view('permissao_colaborador.login');//RAFAEL
})->name('permissao_colaborador.login');

Route::get('/cadastro', function () {
    return view('permissao_colaborador.cadastro');//RAFAEL
})->name('permissao_colaborador.cadastro');

Route::post('/cadastro', [CadastroController::class, 'store'])
    ->name('permissao_colaborador.cadastro.store');

Route::get('/novasenha', function () {
    return view('permissao_colaborador.novasenha');//RAFAEL
})->name('permissao_colaborador.novasenha');

Route::get('/recuperacao', function () {
    return view('permissao_colaborador.recuperacao');//RAFAEL
})->name('permissao_colaborador.recuperacao');

Route::get('/colaborador', function () {
    return view('permissao_colaborador.colaborador');
});

Route::resource('anamnese-colo', AnamneseColoController::class);
//Route::resource('anamnese-mama', AnamneseMamaController::class);
