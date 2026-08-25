<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserColaborador;
use App\Models\Paciente;

class UsuariosTesteSeeder extends Seeder
{
    /**
     * Popula os 4 perfis de acesso para testes imediatos dos fluxos:
     * - Nível 1: Paciente
     * - Nível 2: Operador / Recepção
     * - Nível 3: Médico / Triagem / Enfermagem
     * - Nível 4: Gestor / Administrador
     */
    public function run(): void
    {
        // =========================================================================
        // 1. PACIENTE (NÍVEL 1)
        // Login em: /login (E-mail: paciente@agendasaude.com | Senha: password)
        // =========================================================================
        $cpfPaciente = '12345678901';

        Paciente::updateOrCreate(
            ['cpf_paciente' => $cpfPaciente],
            [
                'cartao_sus' => '898000123456789',
                'nome_completo' => 'Maria Silva dos Santos (Paciente N1)',
                'nome_mae' => 'Ana Maria Silva',
                'apelido' => 'Mari',
                'data_nascimento' => '1990-05-15',
                'sexo' => 'F',
                'raca_cor' => 'Parda',
                'escolaridade' => 'Ensino Médio Completo',
                'termo_lgpd_aceito' => true,
                'data_cadastro' => now(),
            ]
        );

        DB::table('dim_telefones_paciente')->updateOrInsert(
            ['cpf_paciente' => $cpfPaciente, 'tipo' => 'celular'],
            ['numero' => '71988887777', 'created_at' => now(), 'updated_at' => now()]
        );

        User::updateOrCreate(
            ['email' => 'paciente@agendasaude.com'],
            [
                'name' => 'Maria Silva (Paciente N1)',
                'password' => Hash::make('password'),
                'cpf_paciente' => $cpfPaciente,
                'nivel' => 1,
            ]
        );

        // =========================================================================
        // 2. OPERADOR / RECEPÇÃO (NÍVEL 2)
        // Login em: /logincolaborador (E-mail: operador@agendasaude.com | Senha: password)
        // =========================================================================
        UserColaborador::updateOrCreate(
            ['email' => 'operador@agendasaude.com'],
            [
                'nome' => 'Carlos Operador (Nível 2)',
                'matricula' => 'OP2001',
                'cidade' => 'Salvador',
                'password' => Hash::make('password'),
                'permissao' => 2,
                'ativo' => true,
            ]
        );

        // =========================================================================
        // 3. MÉDICO / ENFERMAGEM / TRIAGEM (NÍVEL 3)
        // Login em: /logincolaborador (E-mail: medico@agendasaude.com | Senha: password)
        // =========================================================================
        UserColaborador::updateOrCreate(
            ['email' => 'medico@agendasaude.com'],
            [
                'nome' => 'Dra. Roberta Médica (Nível 3)',
                'matricula' => 'MED3001',
                'cidade' => 'Salvador',
                'password' => Hash::make('password'),
                'permissao' => 3,
                'ativo' => true,
            ]
        );

        // =========================================================================
        // 4. GESTOR / ADMINISTRADOR (NÍVEL 4)
        // Login em: /logincolaborador ou /login (E-mail: gestor@agendasaude.com | Senha: password)
        // =========================================================================
        UserColaborador::updateOrCreate(
            ['email' => 'gestor@agendasaude.com'],
            [
                'nome' => 'Fernando Gestor (Nível 4)',
                'matricula' => 'ADM4001',
                'cidade' => 'Salvador',
                'password' => Hash::make('password'),
                'permissao' => 4,
                'ativo' => true,
            ]
        );

        // Também cria o gestor na tabela users caso tente login pelo /login
        User::updateOrCreate(
            ['email' => 'gestor@agendasaude.com'],
            [
                'name' => 'Fernando Gestor (Nível 4)',
                'password' => Hash::make('password'),
                'cpf_paciente' => $cpfPaciente,
                'nivel' => 4,
            ]
        );
    }
}
