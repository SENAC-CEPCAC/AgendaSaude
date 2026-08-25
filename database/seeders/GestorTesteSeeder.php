<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserColaborador;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GestorTesteSeeder extends Seeder
{
    /**
     * Cria um usuário Gestor Nível 4 para testes rápidos.
     * Execute no terminal com: php artisan db:seed --class=GestorTesteSeeder
     */
    public function run(): void
    {
        // 1. Cria ou atualiza na tabela 'users' (Login padrão por E-mail)
        User::updateOrCreate(
            ['email' => 'gestor@agendasaude.com'],
            [
                'name' => 'Gestor Geral (Nível 4)',
                'password' => Hash::make('12345678'),
                'nivel' => 4,
            ]
        );

        // 2. Se a tabela users_colaboradores existir, cria também para login por Matrícula
        try {
            UserColaborador::updateOrCreate(
                ['matricula' => 'ADM4001'],
                [
                    'nome' => 'Gestor Geral (Nível 4)',
                    'email' => 'gestor@agendasaude.com',
                    'password' => Hash::make('12345678'),
                    'nivel' => 4,
                    'cargo_funcao' => 'Gestor Geral',
                    'registro_profissional' => 'ADM-N4-001',
                ]
            );
        } catch (\Throwable $th) {
            // Ignora caso a tabela de colaboradores ainda não tenha sido migrada
        }

        $this->command->info('----------------------------------------------------');
        $this->command->info('✅ GESTOR NÍVEL 4 CRIADO COM SUCESSO PARA TESTES!');
        $this->command->info('----------------------------------------------------');
        $this->command->info('👉 Login padrão por E-mail (/login):');
        $this->command->info('   E-mail: gestor@agendasaude.com');
        $this->command->info('   Senha:  12345678');
        $this->command->info('----------------------------------------------------');
        $this->command->info('👉 Login colaborador por Matrícula (/loginadmin):');
        $this->command->info('   Matrícula: ADM4001');
        $this->command->info('   Senha:     12345678');
        $this->command->info('----------------------------------------------------');
    }
}
