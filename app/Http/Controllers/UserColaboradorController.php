<?php

namespace App\Http\Controllers;

use App\Models\UserColaborador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserColaboradorController extends Controller
{
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users_colaboradores,email'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
            'matricula' => ['required', 'string', 'max:100'],
            'cidade' => ['required', 'string', 'max:255'],
            'permissao' => ['required', 'integer', 'between:1,4'],
        ]);

        $dados['password'] = Hash::make($dados['password']);
        $dados['ativo'] = true;

        UserColaborador::create($dados);

        return to_route('adm.adm')->with('status', 'Colaborador cadastrado com sucesso.');
    }
}
