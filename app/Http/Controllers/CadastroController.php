<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\Cadastro;
=======
use App\Models\Paciente;
>>>>>>> a99c217a251b99d0ecb4834ca4e4330e2b728ca1
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CadastroController extends Controller
{
    public function store(Request $request)
    {
        // Sanitizar CPF, Cartão SUS e Celular antes da validação
        $cpfLimpo = preg_replace('/\D/', '', (string) $request->input('cpf', ''));
        $susLimpo = preg_replace('/\D/', '', (string) $request->input('cartao_sus', ''));
        $celularLimpo = preg_replace('/\D/', '', (string) $request->input('celular', ''));

        $request->merge([
            'cpf_limpo' => $cpfLimpo,
            'cartao_sus_limpo' => $susLimpo,
            'celular_limpo' => $celularLimpo,
        ]);

        $dados = $request->validate([
            // DADOS DO PACIENTE
            'nome_completo' => ['required', 'string', 'max:150'],
            'apelido' => ['nullable', 'string', 'max:50'],
            'nome_mae' => ['required', 'string', 'max:150'],
            'cpf_limpo' => ['required', 'string', 'size:11'],
            'cartao_sus_limpo' => ['required', 'string', 'min:15', 'max:15'],
            'celular_limpo' => ['required', 'string', 'min:10', 'max:11'],
            'data_nascimento' => ['required', 'date'],
            'sexo' => ['required', 'in:masculino,feminino,outro,M,F,O'],
            'raca_cor' => ['required', 'string', 'max:20'],
            'escolaridade' => ['required', 'string', 'max:50'],

            // CONTA
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nome_completo.required' => 'O nome completo é obrigatório.',
            'nome_mae.required' => 'O nome da mãe é obrigatório.',
            'cpf_limpo.required' => 'O CPF é obrigatório.',
            'cpf_limpo.size' => 'O CPF deve ter 11 dígitos.',
            'cartao_sus_limpo.required' => 'O Cartão SUS é obrigatório.',
            'cartao_sus_limpo.min' => 'O Cartão SUS deve ter 15 dígitos.',
            'cartao_sus_limpo.max' => 'O Cartão SUS deve ter 15 dígitos.',
            'celular_limpo.required' => 'O número de celular é obrigatório.',
            'celular_limpo.min' => 'O celular deve ter DDD + número.',
            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.unique' => 'Este e-mail já está em uso.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'password.confirmed' => 'A confirmação de senha não confere.',
        ]);

        $sexoMap = [
            'masculino' => 'M',
            'feminino' => 'F',
            'outro' => 'O',
            'M' => 'M',
            'F' => 'F',
            'O' => 'O',
        ];

        DB::transaction(function () use ($dados, $cpfLimpo, $susLimpo, $celularLimpo, $sexoMap) {
            // 1. Cadastrar ou atualizar dados do paciente
            Paciente::updateOrCreate(
                ['cpf_paciente' => $cpfLimpo],
                [
                    'cartao_sus' => $susLimpo,
                    'nome_completo' => $dados['nome_completo'],
                    'nome_mae' => $dados['nome_mae'],
                    'apelido' => $dados['apelido'] ?? null,
                    'data_nascimento' => Carbon::parse($dados['data_nascimento'])->format('Y-m-d'),
                    'sexo' => $sexoMap[$dados['sexo']] ?? 'O',
                    'raca_cor' => $dados['raca_cor'],
                    'escolaridade' => $dados['escolaridade'],
                    'termo_lgpd_aceito' => true,
                    'data_cadastro' => now(),
                ]
            );

            // 2. Cadastrar telefone do paciente
            DB::table('dim_telefones_paciente')->updateOrInsert(
                [
                    'cpf_paciente' => $cpfLimpo,
                    'tipo' => 'celular',
                ],
                [
                    'numero' => $celularLimpo,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // 3. Cadastrar usuário no sistema
            User::create([
                'name' => $dados['nome_completo'],
                'email' => $dados['email'],
                'password' => Hash::make($dados['password']),
                'cpf_paciente' => $cpfLimpo,
                'cpf' => $cpfLimpo,
                'telefone' => $celularLimpo,
                'nivel' => 1,
            ]);
        });

        return redirect()
            ->route('acesso.login')
            ->with('success', 'Cadastro realizado com sucesso! Faça login para continuar.');
    }
}