<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgendamentoEtapa3Controller extends Controller
{
    public function index()
    {
        return view('fluxo_agendamento.etapa_3');
    }
}
