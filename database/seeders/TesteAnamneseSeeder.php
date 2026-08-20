<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TesteAnamneseSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // 1. Perfil de acesso
            $perfil = DB::table('dim_perfis_acesso')->where('nome_perfil', 'Enfermeiro(a)')->first();
            $idPerfil = $perfil->id_perfil ?? DB::table('dim_perfis_acesso')->insertGetId([
                'nome_perfil' => 'Enfermeiro(a)',
                'pode_ver_anamnese' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 2. Profissional
            $profissional = DB::table('dim_profissionais')->where('email_corporativo', 'maria.souza@saude.gov.br')->first();
            $idProfissional = $profissional->id_profissional ?? DB::table('dim_profissionais')->insertGetId([
                'id_perfil' => $idPerfil,
                'nome' => 'Maria Aparecida Souza',
                'registro_profissional' => 'COREN-12345',
                'cargo_funcao' => 'Enfermeira',
                'email_corporativo' => 'maria.souza@saude.gov.br',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 3. Paciente
            $paciente = DB::table('dim_pacientes')->where('cpf', '12345678900')->first();
            $idPaciente = $paciente->id_paciente ?? DB::table('dim_pacientes')->insertGetId([
                'cartao_sus' => '898001160540121',
                'cpf' => '12345678900',
                'nome_completo' => 'Joana da Silva',
                'nome_mae' => 'Antonia da Silva',
                'apelido' => 'Joaninha',
                'data_nascimento' => '1985-04-12',
                'sexo' => 'F',
                'raca_cor' => 'Parda',
                'escolaridade' => 'Ensino Médio Completo',
                'termo_lgpd_aceito' => true,
                'data_cadastro' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 4. Unidade CNES
            $unidade = DB::table('dim_cnes_unidades')->where('codigo_cnes', '1234567')->first();
            $idUnidade = $unidade->id_cnes_unidade ?? DB::table('dim_cnes_unidades')->insertGetId([
                'codigo_cnes' => '1234567',
                'nome_unidade' => 'Unidade Móvel Centro',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 5. Vaga
            $vaga = DB::table('dim_vagas')->where('tipo_exame', 'Preventivo')->first();
            $idVaga = $vaga->id_vagas ?? DB::table('dim_vagas')->insertGetId([
                'tipo_exame' => 'Preventivo',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 6. Turno
            $turno = DB::table('dim_turno')->where('turno', 'Manhã')->first();
            $idTurno = $turno->id_turno ?? DB::table('dim_turno')->insertGetId([
                'turno' => 'Manhã',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 7. Cronograma (agenda) - sempre cria um novo, já que não tem chave natural única
            $idAgenda = DB::table('fato_cronogramas')->insertGetId([
                'id_cnes_unidade' => $idUnidade,
                'Vagas_id_vagas' => $idVaga,
                'Turno_id_turno' => $idTurno,
                'data_atendimento' => now()->addDays(3)->format('Y-m-d'),
                'municipio_atendimento' => 'Cruz das Almas',
                'qnt_oferecidas_vagas' => 20,
                'prenchida_vagas' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 8. Prontuário - sempre cria um novo
            $idProntuario = DB::table('fato_prontuario')->insertGetId([
                'id_paciente' => $idPaciente,
                'id_agenda' => $idAgenda,
                'status_comparecimento' => 'presente',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->command->info("✅ Prontuário de teste criado! id_prontuario = {$idProntuario}");
            $this->command->info("✅ Profissional de teste: id_profissional = {$idProfissional}");
            $this->command->info("Acesse: http://127.0.0.1:8000/anamnese-colo/create/{$idProntuario}");
        });
    }
}