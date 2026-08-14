<?php

namespace App\Http\Controllers;

use App\Models\Agendamento; // Substitua pela Model base que você está usando
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Necessário para usar o DB::raw no CONCAT

class ListaAgendamentoController extends Controller
{
    // public function index()
    // {
    //     // $showAgendamentos = Agendamento::orderBy('id', 'asc')->get();

    //     $showAgendamentos = Agendamento::select(
    //             'agendamentos.id as numero_agendamento',
    //             'pacientes.cpf as cpf_paciente',
    //             DB::raw("CONCAT(pacientes.nome, ' ', pacientes.sobrenome) as nome_paciente"),
    //             'agendamentos.horario_agendamento',
    //             'agendamentos.status'
    //         )
    //         ->join('pacientes', 'agendamentos.paciente_id', '=', 'pacientes.id')
    //         ->orderBy('agendamentos.horario_agendamento', 'desc')
    //         ->get();
        
    //     // Retorna para a view (ajuste o caminho da sua pasta/arquivo blade)
    //     return view('listaagendamentos.index')->with('showAgendamentos', $showAgendamentos);
    // }
}