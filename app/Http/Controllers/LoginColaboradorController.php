<?php

namespace App\Http\Controllers;

use App\Models\UserColaborador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginColaboradorController extends Controller
{
    public function index()
    {
        return view('acesso.logincolaborador');
    }

    public function login(Request $request)
    {
        $dados = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $colaborador = UserColaborador::where('email', $dados['email'])->first();
        
        if (! $colaborador || ! $colaborador->ativo || ! password_verify($dados['password'], $colaborador->password)) {
            return back()->withErrors(['email' => 'E-mail ou senha inválidos.'])->withInput();
        }

        auth()->logout();
        $request->session()->put('colaborador_id', $colaborador->getKey());
        $request->session()->regenerate();

        return match ((int) $colaborador->permissao) {
            4 => to_route('adm.adm'),
            2 => to_route('agendamentos.index'),
            3 => to_route('triagem.index'),
            default => back()->withErrors(['email' => 'Nível de acesso inválido.']),
        };
    }
<<<<<<< HEAD
}
=======

    public function atualizarSenha(Request $request)
    {
        $dados = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $colaborador = UserColaborador::where('email', $dados['email'])->first();

        if (! $colaborador) {
            return back()->withInput()->withErrors(['email' => 'Colaborador não encontrado.']);
        }

        $colaborador->password = Hash::make($dados['password']);
        $colaborador->save();

        return to_route('login.colaborador')->with('status', 'Senha alterada com sucesso.');
    }
}
>>>>>>> c6463960cfaa456585db638854b2e9274e0a7f51
