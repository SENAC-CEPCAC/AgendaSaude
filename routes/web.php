<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendamentoEtapa1;

Route::get('/', function () {
    return view('welcome');
});

route::get('/agendamento/etapa-1', [AgendamentoEtapa1::class, 'index'])->name('agendamento.etapa1');