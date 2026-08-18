<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ConfirmadoController extends Controller
{
    /**
     * Exibe a tela "CONFIRMADO".
     * Rota: GET /agendamentos/{id}/confirmado
     */
    public function show(int $id): View
    {
        $agendamento = Agendamento::findOrFail($id);

        return view('agendamentos.confirmado', [
            'agendamento' => $agendamento,
        ]);
    }

    /**
     * Confirma o agendamento e redireciona para a tela de confirmação.
     * Rota: PATCH /agendamentos/{id}/confirmar
     */
    public function confirmar(Request $request, int $id): RedirectResponse
    {
        $agendamento = Agendamento::findOrFail($id);

        $agendamento->update([
            'status' => 'confirmado',
        ]);

        return redirect()
            ->route('agendamentos.confirmado.show', $agendamento->id)
            ->with('mensagem_confirmacao', 'AGENDAMENTO CONFIRMADO');
    }
}