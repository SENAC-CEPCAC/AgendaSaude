<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendamentoEtapa1;
use App\Http\Controllers\AgendamentoEtapa2Controller;
use App\Http\Controllers\AgendamentoEtapa3Controller;

Route::get('/', function () {
    return view('welcome');
});

route::get('/agendamento/etapa-1', [AgendamentoEtapa1::class, 'index'])->name('agendamento.etapa1');

route::get('/agendamento/etapa-2', [AgendamentoEtapa2Controller::class, 'index'])->name('agendamento.etapa2');

route::get('/agendamento/etapa-3', [AgendamentoEtapa3Controller::class, 'index'])->name('agendamento.etapa3');