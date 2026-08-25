<?php

namespace App\Http\Controllers;

use App\Models\UserColaborador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdmController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->string('busca')->trim()->toString();
        $usuario = Auth::user();

        if (! $usuario && $request->session()->has('colaborador_id')) {
            $usuario = UserColaborador::find($request->session()->get('colaborador_id'));
        }

        $usuarioNome = $usuario?->nome ?? $usuario?->name ?? 'Usuário';

        $colaboradores = UserColaborador::query()
            ->when($busca, function ($query) use ($busca) {
                $query->where(function ($query) use ($busca) {
                    $query->where('nome', 'like', "%{$busca}%")
                        ->orWhere('email', 'like', "%{$busca}%");
                });
            })
            ->orderBy('nome')
            ->paginate(7)
            ->withQueryString();

        return view('adm.adm', compact('colaboradores', 'busca', 'usuarioNome'));
    }

    public function update(Request $request, UserColaborador $adm)
    {
        $dados = $request->validate([
            'permissao' => ['required', 'integer', 'between:2,4'],
        ]);

        $adm->update($dados);

        return to_route('adm.adm')->with('status', 'Permissão do colaborador atualizada.');
    }

    public function toggleStatus(UserColaborador $adm)
    {
        $adm->update(['ativo' => ! $adm->ativo]);

        return to_route('adm.adm')->with('status', 'Status do colaborador atualizado.');
    }

    public function destroy(UserColaborador $adm)
    {
        $adm->delete();

        return to_route('adm.adm')->with('status', 'Colaborador removido.');
    }
}
