<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgendamentoEtapa1 extends Controller
{
    public function index()
    {
        return view('fluxo_agendamento.etapa_1');
    }
}
