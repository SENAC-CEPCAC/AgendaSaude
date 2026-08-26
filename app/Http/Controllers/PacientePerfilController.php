<?php

namespace App\Http\Controllers;

use App\Models\EnderecoPaciente;
use App\Models\Paciente;
use App\Models\TelefonePaciente;
use App\Models\User;
use App\Models\UserColaborador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PacientePerfilController extends Controller
{
    /**
     * Exibe a página do perfil do usuário logado (Níveis 1, 2, 3 e 4).
     */
    public function index()
    {
        $usuario = Auth::user();
        $isColaborador = false;
        $colaborador = null;

        if (!$usuario && session('colaborador_id')) {
            $colaborador = UserColaborador::find(session('colaborador_id'));
            $usuario = $colaborador;
            $isColaborador = true;
        } elseif ($usuario instanceof UserColaborador) {
            $colaborador = $usuario;
            $isColaborador = true;
        }

        if (!$usuario) {
            return redirect()->route('acesso.login')->withErrors(['email' => 'Por favor, faça login para acessar seu perfil.']);
        }

        $nivelUsuario = (int) ($usuario->nivel ?? $usuario->permissao ?? 1);

        // Se for nível 2, 3 ou 4 e ainda não tiver o objeto colaborador carregado
        if ($nivelUsuario >= 2 && !$colaborador) {
            $colaborador = UserColaborador::where('email', $usuario->email)->first();
            if ($colaborador) {
                $isColaborador = true;
            }
        }

        $cpfLimpo = preg_replace('/\D/', '', (string) ($usuario->cpf_paciente ?? $usuario->cpf ?? ''));

        $paciente = null;
        $telefone = null;
        $endereco = null;

        // Se for paciente (ou tiver vínculo com dim_pacientes)
        if (!empty($cpfLimpo)) {
            $paciente = Paciente::with(['endereco', 'telefones'])->where('cpf_paciente', $cpfLimpo)->first();

            if ($paciente && $paciente->telefones) {
                $telefone = $paciente->telefones->where('tipo', 'celular')->first() ?? $paciente->telefones->first();
            }

            $endereco = $paciente?->endereco;
        }

        return view('paciente.perfil', [
            'usuario' => $usuario,
            'colaborador' => $colaborador,
            'isColaborador' => $isColaborador || ($nivelUsuario >= 2),
            'nivelUsuario' => $nivelUsuario,
            'paciente' => $paciente,
            'telefone' => $telefone,
            'endereco' => $endereco,
            'cpfLimpo' => $cpfLimpo,
        ]);
    }

    /**
     * Atualiza os dados permitidos do perfil de acordo com o nível de acesso.
     */
    public function update(Request $request)
    {
        $usuario = Auth::user();
        $colaborador = null;

        if (!$usuario && session('colaborador_id')) {
            $colaborador = UserColaborador::find(session('colaborador_id'));
            $usuario = $colaborador;
        } elseif ($usuario instanceof UserColaborador) {
            $colaborador = $usuario;
        }

        if (!$usuario) {
            return redirect()->route('acesso.login');
        }

        $nivelUsuario = (int) ($usuario->nivel ?? $usuario->permissao ?? 1);
        if ($nivelUsuario >= 2 && !$colaborador) {
            $colaborador = UserColaborador::where('email', $usuario->email)->first();
        }

        // =========================================================================
        // 1. FLUXO PARA COLABORADORES / GESTORES (NÍVEIS 2, 3 E 4)
        // =========================================================================
        if ($nivelUsuario >= 2) {
            $colaboradorId = $colaborador?->id;
            $userId = ($usuario instanceof User) ? $usuario->id : null;

            $dadosValidados = $request->validate([
                'nome' => ['required', 'string', 'max:150'],
                'cidade' => ['required', 'string', 'max:100'],
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    $colaboradorId ? Rule::unique('users_colaboradores', 'email')->ignore($colaboradorId) : 'nullable',
                ],
                'current_password' => ['nullable', 'required_with:password'],
                'password' => ['nullable', 'required_with:current_password', 'string', 'min:8', 'confirmed', 'different:current_password'],
            ], [
                'nome.required' => 'O nome completo é obrigatório.',
                'cidade.required' => 'A cidade de atuação é obrigatória.',
                'email.required' => 'O e-mail é obrigatório.',
                'email.email' => 'Informe um e-mail válido.',
                'email.unique' => 'Este e-mail já está em uso por outro colaborador.',
                'current_password.required_with' => 'Informe sua senha atual para autorizar a definição de uma nova senha.',
                'password.required_with' => 'Informe a nova senha desejada.',
                'password.different' => 'A nova senha deve ser diferente da sua senha atual.',
                'password.min' => 'A nova senha deve ter no mínimo 8 caracteres.',
                'password.confirmed' => 'A confirmação da nova senha não confere.',
            ]);

            // Se solicitou troca de senha, valida a senha atual
            if (!empty($dadosValidados['password'])) {
                $senhaAtualValida = false;
                $currentHash = $colaborador?->password ?? $usuario->password;

                if (Hash::check($request->input('current_password'), $currentHash)) {
                    $senhaAtualValida = true;
                }

                if (!$senhaAtualValida) {
                    return back()->withErrors(['current_password' => 'A senha atual informada está incorreta.'])->withInput();
                }
            }

            DB::transaction(function () use ($colaborador, $usuario, $dadosValidados) {
                $updateColab = [
                    'nome' => $dadosValidados['nome'],
                    'email' => $dadosValidados['email'],
                    'cidade' => $dadosValidados['cidade'],
                ];

                if (!empty($dadosValidados['password'])) {
                    $updateColab['password'] = Hash::make($dadosValidados['password']);
                }

                if ($colaborador) {
                    $colaborador->update($updateColab);
                }

                // Sincroniza também na tabela users se existir registro de login comum
                $userByEmail = User::where('email', $usuario->email)->orWhere('id', $usuario->id ?? 0)->first();
                if ($userByEmail) {
                    $updateUser = [
                        'name' => $dadosValidados['nome'],
                        'email' => $dadosValidados['email'],
                    ];
                    if (!empty($dadosValidados['password'])) {
                        $updateUser['password'] = Hash::make($dadosValidados['password']);
                    }
                    $userByEmail->update($updateUser);
                }
            });

            return redirect()
                ->route('paciente.perfil')
                ->with('success', 'Seus dados de colaborador foram atualizados com sucesso!');
        }

        // =========================================================================
        // 2. FLUXO PARA PACIENTES (NÍVEL 1)
        // =========================================================================
        $cpfLimpo = preg_replace('/\D/', '', (string) ($usuario->cpf_paciente ?? $usuario->cpf ?? ''));
        $celularLimpo = preg_replace('/\D/', '', (string) $request->input('celular', ''));
        $cepLimpo = preg_replace('/\D/', '', (string) $request->input('cep', ''));

        $request->merge([
            'celular_limpo' => $celularLimpo,
            'cep_limpo' => $cepLimpo,
        ]);

        $dadosValidados = $request->validate([
            // DADOS PESSOAIS ALTERÁVEIS
            'nome_completo' => ['required', 'string', 'max:150'],
            'apelido' => ['nullable', 'string', 'max:50'],
            'raca_cor' => ['required', 'string', 'max:50'],
            'escolaridade' => ['required', 'string', 'max:50'],

            // CONTATO & CONTA
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($usuario->id),
            ],
            'celular_limpo' => ['required', 'string', 'min:10', 'max:11'],

            // ENDEREÇO RESIDENCIAL (OPCIONAL/COMPLETO)
            'cep_limpo' => ['nullable', 'string', 'max:8'],
            'logradouro' => ['nullable', 'string', 'max:150'],
            'numero' => ['nullable', 'string', 'max:20'],
            'complemento' => ['nullable', 'string', 'max:100'],
            'bairro' => ['nullable', 'string', 'max:100'],
            'municipio' => ['nullable', 'string', 'max:100'],
            'uf' => ['nullable', 'string', 'size:2'],
            'ponto_referencia' => ['nullable', 'string', 'max:150'],

            // SEGURANÇA / ALTERAÇÃO DE SENHA (OPCIONAL)
            'current_password' => ['nullable', 'required_with:password'],
            'password' => ['nullable', 'required_with:current_password', 'string', 'min:8', 'confirmed', 'different:current_password'],
        ], [
            'nome_completo.required' => 'O nome completo é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Este e-mail já está em uso por outro usuário.',
            'celular_limpo.required' => 'O número de celular é obrigatório.',
            'celular_limpo.min' => 'O celular deve ter no mínimo DDD + 8 dígitos.',
            'celular_limpo.max' => 'O celular deve ter no máximo DDD + 9 dígitos.',
            'current_password.required_with' => 'Informe sua senha atual para autorizar a definição de uma nova senha.',
            'password.required_with' => 'Informe a nova senha desejada.',
            'password.different' => 'A nova senha deve ser diferente da sua senha atual.',
            'password.min' => 'A nova senha deve ter no mínimo 8 caracteres.',
            'password.confirmed' => 'A confirmação da nova senha não confere.',
        ]);

        // Se solicitou troca de senha, valida a senha atual
        if (!empty($dadosValidados['password'])) {
            if (!Hash::check($request->input('current_password'), $usuario->password)) {
                return back()->withErrors(['current_password' => 'A senha atual informada está incorreta.'])->withInput();
            }
        }

        DB::transaction(function () use ($usuario, $cpfLimpo, $dadosValidados, $celularLimpo, $cepLimpo) {
            // 1. Atualiza os dados na tabela dim_pacientes
            if (!empty($cpfLimpo)) {
                $paciente = Paciente::where('cpf_paciente', $cpfLimpo)->first();

                if ($paciente) {
                    $paciente->update([
                        'nome_completo' => $dadosValidados['nome_completo'],
                        'apelido' => $dadosValidados['apelido'] ?? null,
                        'raca_cor' => $dadosValidados['raca_cor'],
                        'escolaridade' => $dadosValidados['escolaridade'],
                    ]);
                }

                // 2. Atualiza ou cria o Telefone do paciente
                TelefonePaciente::updateOrCreate(
                    [
                        'cpf_paciente' => $cpfLimpo,
                        'tipo' => 'celular',
                    ],
                    [
                        'numero' => $celularLimpo,
                    ]
                );

                // 3. Atualiza ou cria o Endereço do paciente
                if (!empty($dadosValidados['logradouro']) || !empty($cepLimpo) || !empty($dadosValidados['municipio'])) {
                    EnderecoPaciente::updateOrCreate(
                        ['cpf_paciente' => $cpfLimpo],
                        [
                            'cep' => $cepLimpo ?: null,
                            'logradouro' => $dadosValidados['logradouro'] ?? '',
                            'numero' => $dadosValidados['numero'] ?? '',
                            'complemento' => $dadosValidados['complemento'] ?? null,
                            'bairro' => $dadosValidados['bairro'] ?? '',
                            'municipio' => $dadosValidados['municipio'] ?? '',
                            'uf' => strtoupper($dadosValidados['uf'] ?? 'BA'),
                            'ponto_referencia' => $dadosValidados['ponto_referencia'] ?? null,
                        ]
                    );
                }
            }

            // 4. Atualiza os dados do Usuário de Acesso
            $updateUserData = [
                'name' => $dadosValidados['nome_completo'],
                'email' => $dadosValidados['email'],
            ];

            if (!empty($dadosValidados['password'])) {
                $updateUserData['password'] = Hash::make($dadosValidados['password']);
            }

            User::where('id', $usuario->id)->update($updateUserData);
        });

        return redirect()
            ->route('paciente.perfil')
            ->with('success', 'Seus dados foram atualizados com sucesso!');
    }
}
