<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgendamentosController extends Controller
{
    <?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AgendamentoController extends Controller
{
    /**
     * Exibe a lista de agendamentos do paciente logado.
     */
    public function index(): View
    {
        $agendamentos = Agendamento::where('paciente_id', Auth::id())
            ->orderBy('data_hora')
            ->get()
            ->map(function (Agendamento $agendamento) {
                return [
                    'id'            => $agendamento->id,
                    'especialidade' => $agendamento->especialidade,
                    'data'          => $agendamento->data_hora->translatedFormat('d M Y'),
                    'hora'          => $agendamento->data_hora->format('H:i'),
                    'status'        => $agendamento->status, // confirmado | espera | cancelado
                    'unidade'       => $agendamento->unidade,
                    'endereco'      => $agendamento->endereco,
                ];
            });

        return view('agendamentos.index', compact('agendamentos'));
    }

    /**
     * Encaminha o paciente para o fluxo de remarcação de um agendamento.
     */
    public function remarcar(Agendamento $agendamento): View|RedirectResponse
    {
        $this->autorizarAcesso($agendamento);

        if (! $agendamento->podeSerAlterado()) {
            return back()->with('erro', 'Remarcações só podem ser feitas com no mínimo 24 horas de antecedência.');
        }

        return view('agendamentos.remarcar', compact('agendamento'));
    }

    /**
     * Cancela um agendamento, respeitando a regra das 24h de antecedência.
     */
    public function cancelar(Request $request, Agendamento $agendamento): RedirectResponse
    {
        $this->autorizarAcesso($agendamento);

        if (! $agendamento->podeSerAlterado()) {
            return back()->with('erro', 'Cancelamentos só podem ser feitos com no mínimo 24 horas de antecedência.');
        }

        $agendamento->update(['status' => 'cancelado']);

        return redirect()
            ->route('agendamentos.index')
            ->with('sucesso', 'Agendamento cancelado com sucesso. A vaga foi liberada.');
    }

    /**
     * Garante que o agendamento pertence ao paciente autenticado.
     */
    private function autorizarAcesso(Agendamento $agendamento): void
    {
        abort_unless($agendamento->paciente_id === Auth::id(), 403);
    }
}

