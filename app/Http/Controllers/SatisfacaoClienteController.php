<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SatisfacaoClienteController extends Controller
{
 <?php
// app/Http/Controllers/SatisfacaoController.php

namespace App\Http\Controllers;

use App\Models\Satisfacao;
use Illuminate\Http\Request;

class SatisfacaoController extends Controller
{
    /**
     * Exibe a tela de pesquisa de satisfação (NPS).
     */
    public function index($agendamentoId = null)
    {
        return view('satisfacao.index', [
            'agendamentoId' => $agendamentoId,
        ]);
    }

    /**
     * Salva a resposta da pesquisa de satisfação.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'agendamento_id' => ['nullable', 'exists:agendamentos,id'],
            'nota_nps'       => ['required', 'integer', 'min:0', 'max:10'],
            'motivos'        => ['nullable', 'array'],
            'motivos.*'      => ['string'],
            'comentario'     => ['nullable', 'string', 'max:1000'],
        ]);

        Satisfacao::create($validated);

        return redirect()
            ->route('satisfacao.obrigado')
            ->with('success', 'Obrigado pela sua avaliação!');
    }

    /**
     * Tela de agradecimento após envio (opcional).
     */
    public function obrigado()
    {
        return view('satisfacao.obrigado');
    }
}
