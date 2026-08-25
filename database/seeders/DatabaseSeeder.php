<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed principal da aplicação.
     * Execute no terminal com: php artisan db:seed
     */
    public function run(): void
    {
        // =========================================================================
        // 1. DADOS ESTRUTURAIS OBRIGATÓRIOS (Produção e Desenvolvimento)
        // ATENÇÃO: Estes seeders são obrigatórios para o sistema funcionar!
        // =========================================================================
        $this->call([
            DimPerfisAcessoSeeder::class, // [OBRIGATÓRIO] Perfis de acesso: Admin, Médico, Enfermeiro, Atendente
            DimTurnoSeeder::class,        // [OBRIGATÓRIO] Turnos de atendimento: Manhã, Tarde, Integral
            DimVagasSeeder::class,        // [OBRIGATÓRIO] Tipos de exames/vagas: Siscolo (Preventivo), Sismama (Mamografia)
        ]);

        // =========================================================================
        // 2. DADOS FAKE / SIMULAÇÃO (Apenas Ambiente Local / Desenvolvimento)
        // NOTA PARA A EQUIPE: Os seeders abaixo servem para testes e demonstração do PI.
        // Eles são executados automaticamente no ambiente local (APP_ENV=local no .env).
        // Em ambiente de produção real, este bloco é ignorado automaticamente.
        // =========================================================================
        if (app()->environment('local', 'testing')) {
            
            // Usuário padrão de autenticação para testes
            if (!User::where('email', 'test@example.com')->exists()) {
                User::factory()->create([
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                ]); // [FAKE] Usuário de teste para login inicial
            }

            User::where('email', 'admin@agendasaude.com')->delete();

            User::updateOrCreate(
                ['email' => 'adm@sesc.ba'],
                [
                    'name' => 'Administrador',
                    'password' => Hash::make('Sesc@123'),
                    'nivel' => 4,
                ]
            );

            // Dados fake do cenário de atendimento do Projeto Integrador
            $this->call([
                DadosFakeSeeder::class, // [FAKE] 6 Profissionais, 2 Unidades Móveis, 4 Cronogramas, 10 Pacientes (4 Siscolo, 4 Sismama, 2 Espera) e Anamneses
            ]);
        }
    }
}
