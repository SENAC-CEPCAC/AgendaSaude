<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CadastroController extends Controller
{
    public function store(Request $request)
    {
        $dados = $request->validate([

            // DADOS DO PACIENTE

            'nome_completo' => [
                'required',
                'string',
                'max:150'
            ],

            'apelido' => [
                'nullable',
                'string',
                'max:50'
            ],

            'nome_mae' => [
                'required',
                'string',
                'max:150'
            ],

            'cpf' => [
                'required',
                'string',
                'max:14',
            ],

            'cartao_sus' => [
                'required',
                'string',
                'digits:15',
            ],

            'celular' => [
                'required',
                'string',
                'digits:11',
            ],

            'data_nascimento' => [
                'required',
                'date'
            ],

            'sexo' => [
                'required',
                'in:masculino,feminino,outro'
            ],

            'raca_cor' => [
                'required',
                'string',
                'max:20'
            ],

            'escolaridade' => [
                'required',
                'string',
                'max:50'
            ],


            // CONTA

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email'
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed'
            ],

        ]);


        DB::transaction(function () use ($dados) {

            /*
            |--------------------------------------------------------------------------
            | CPF
            |--------------------------------------------------------------------------
            */

            $cpf = preg_replace(
                '/\D/',
                '',
                $dados['cpf']
            );


            /*
            |--------------------------------------------------------------------------
            | CARTÃO SUS
            |--------------------------------------------------------------------------
            */

            $cartaoSus = preg_replace(
                '/\D/',
                '',
                $dados['cartao_sus']
            );


            /*
            |--------------------------------------------------------------------------
            | DATA
            |--------------------------------------------------------------------------
            */

            $dataNascimento = Carbon::parse($dados['data_nascimento'])
                ->format('Y-m-d');

            $sexo = [
                'masculino' => 'M',
                'feminino' => 'F',
                'outro' => 'O',
            ][$dados['sexo']];


            /*
            |--------------------------------------------------------------------------
            | PACIENTE
            |--------------------------------------------------------------------------
            */

            $paciente = Patient::create([

                'nome_completo' =>
                    $dados['nome_completo'],

                'apelido' =>
                    $dados['apelido'] ?? null,

                'nome_mae' =>
                    $dados['nome_mae'],

                'cpf' =>
                    $cpf,

                'cartao_sus' =>
                    $cartaoSus,

                'data_nascimento' =>
                    $dataNascimento,

                'sexo' =>
                    $sexo,

                'raca_cor' =>
                    $dados['raca_cor'],

                'escolaridade' =>
                    $dados['escolaridade'],

                'termo_lgpd_aceito' =>
                    true,

            ]);

            DB::table('dim_telefones_paciente')->insert([
                'id_paciente' => $paciente->id_paciente,
                'numero' => $dados['celular'],
                'tipo' => 'celular',
                'created_at' => now(),
                'updated_at' => now(),
            ]);


            /*
            |--------------------------------------------------------------------------
            | USUÁRIO
            |--------------------------------------------------------------------------
            */

            User::create([

                'name' =>
                    $dados['nome_completo'],

                'email' =>
                    $dados['email'],

                'password' =>
                    Hash::make(
                        $dados['password']
                    ),

            ]);

        });


        return redirect()
            ->route('permissao_colaborador.login')
            ->with(
                'success',
                'Cadastro realizado com sucesso!'
            );
    }
}