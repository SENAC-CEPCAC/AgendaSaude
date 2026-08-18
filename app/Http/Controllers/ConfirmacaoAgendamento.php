<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfirmacaoAgendamento extends Controller
{
    
 
namespace App\Http\Controllers;
 
use App\Models\Agendamento;
use Illuminate\Http\RedirectResponse;
 
class AgendamentoController extends Controller
{
    public function confirmar(Agendamento $agendamento): RedirectResponse
    {
        $agendamento->update([
            'status' => 'confirmado',
        ]);
 
        return redirect()
            ->route('agendamentos.index')
            ->with('success', 'Agendamento confirmado com sucesso.');
    }
}
 


}
