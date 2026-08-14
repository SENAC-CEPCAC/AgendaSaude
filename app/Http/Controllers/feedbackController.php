<?php

namespace App\Http\Controllers;

use App\Models\FatoFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    /**
     * Lista todos os feedbacks.
     */
    public function index()
    {
        $feedbacks = FatoFeedback::latest('id_feedback')->paginate(15);

        return view('feedback.index', compact('feedbacks'));
    }

    /**
     * Formulário de criação de um novo feedback (pós-atendimento).
     */
    public function create()
    {
        return view('feedback.create');
    }

    /**
     * Salva um novo feedback no banco.
     */
    public function store(Request $request)
    {
        $dados = $this->validarDados($request);

        FatoFeedback::create($dados);

        return redirect()
            ->route('feedback.index')
            ->with('sucesso', 'Feedback enviado com sucesso!');
    }

    /**
     * Exibe um feedback específico.
     */
    public function show(FatoFeedback $feedback)
    {
        return view('feedback.show', compact('feedback'));
    }

    /**
     * Formulário de edição de um feedback.
     */
    public function edit(FatoFeedback $feedback)
    {
        return view('feedback.edit', compact('feedback'));
    }

    /**
     * Atualiza um feedback existente.
     */
    public function update(Request $request, FatoFeedback $feedback)
    {
        $dados = $this->validarDados($request);

        $feedback->update($dados);

        return redirect()
            ->route('feedback.index')
            ->with('sucesso', 'Feedback atualizado com sucesso!');
    }

    /**
     * Remove um feedback.
     */
    public function destroy(FatoFeedback $feedback)
    {
        $feedback->delete();

        return redirect()
            ->route('feedback.index')
            ->with('sucesso', 'Feedback removido com sucesso!');
    }

    /**
     * Validação centralizada dos dados do formulário.
     */
    private function validarDados(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'avaliacao'                    => 'required|integer|min:1|max:5',
            'tempo_espera'                 => 'required|string|max:45',
            'atendimento_equipe'           => 'required|string|max:45',
            'clareza_informacoes'          => 'required|string|max:45',
            'facilidade_agendamento'       => 'required|string|max:45',
            'comentario'                   => 'nullable|string|max:220',
            'id_prontuario_id_prontuario'  => 'required|integer|exists:prontuario,id_prontuario',
        ]);

        return $validator->validate();
    }
}