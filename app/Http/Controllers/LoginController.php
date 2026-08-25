<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('acesso.login');
    }

    public function cadastrar(Request $request)
    {
        $dados = $request->validate([
            'nome_completo' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'max:14', 'unique:users,cpf'],
            'celular' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
        ]);

        $dados['name'] = $dados['nome_completo'];
        $dados['telefone'] = $dados['celular'];
        unset($dados['nome_completo'], $dados['celular']);
        $dados['nivel'] = 1;
        $dados['password'] = Hash::make($dados['password']);

        \App\Models\User::create($dados);

        return to_route('acesso.login')->with('status', 'Cadastro realizado com sucesso.');
    }

    public function atualizarSenha(Request $request)
    {
        $dados = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $usuario = \App\Models\User::where('email', $dados['email'])->first();

        if (! $usuario) {
            return back()->withInput()->withErrors(['email' => 'Usuário não encontrado.']);
        }

        $usuario->password = Hash::make($dados['password']);
        $usuario->save();

        return to_route('acesso.login')->with('status', 'Senha alterada com sucesso.');
    }

    public function logar(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        $authenticated = false;

        try {
            $authenticated = Auth::attempt($credentials);
        } catch (QueryException $exception) {
            report($exception);
        }

        if (!$authenticated) {
            return redirect()->route('acesso.login')
                    ->withErrors('Usuário ou senha inválidos');
        }

        $request->session()->regenerate();

        if ((int) Auth::user()->nivel === 4) {
            return to_route('adm.adm');
        }

        return to_route('agendamento.agendamentos');
    }

    public function destroy()
    {
        Auth::logout();
        request()->session()->forget('colaborador_id');
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return to_route('acesso.index');
    }
}
