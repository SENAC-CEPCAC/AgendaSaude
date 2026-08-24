<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class RelatoriosTestDataSeeder extends Seeder
{
    /**
     * Seed para teste local de todos os Relatórios, Fila Inteligente e Protocolos SISMAMA/SISCOLO.
     * 
     * Estrutura rigorosamente alinhada com as tabelas das Migrations:
     * - dim_perfis_acesso (id_perfil)
     * - dim_profissionais (id_profissional, id_perfil, nome, registro_profissional, cargo_funcao, email_corporativo)
     * - dim_turno (id_turno, turno)
     * - dim_vagas (id_vagas, tipo_exame)
     * - dim_cnes_unidades (id_cnes_unidade, codigo_cnes, nome_unidade)
     * - dim_pacientes (cpf_paciente PK CHAR(11), cartao_sus, nome_completo, data_nascimento, sexo)
     * - dim_enderecos_pacientes (id_endereco, cpf_paciente FK)
     * - dim_telefones_paciente (id_telefone, cpf_paciente FK, numero, tipo)
     * - fato_cronogramas (id_agenda PK, id_cnes_unidade, Vagas_id_vagas, Turno_id_turno, data_atendimento, municipio_atendimento)
     * - fato_prontuario (id_prontuario PK, cpf_paciente, id_agenda, status_comparecimento, limite_confirmacao_24h, cliente_confirmou, numero_sequencial, status_agendamento, status_documentos)
     * - fato_anamnese (id_fato_anamnese PK, id_prontuario, id_profissional, tipo_anamnese, data_realizacao)
     * - anamnese_sismama (id_sismama, id_fato_anamnese, nodulo_mama_direita, nodulo_mama_esquerda, risco_elevado_cancer, ...)
     * - anamnese_siscolo (id_siscolo, id_fato_anamnese, motivo_exame, fez_preventivo_anterior, usa_pilula, ...)
     * 
     * Como rodar:
     * php artisan db:seed --class=RelatoriosTestDataSeeder
     */
    public function run(): void
    {
        $hoje = Carbon::now();

        Schema::disableForeignKeyConstraints();

        DB::table('anamnese_siscolo')->truncate();
        DB::table('anamnese_sismama')->truncate();
        DB::table('fato_anamnese')->truncate();
        DB::table('fato_feedback')->truncate();
        DB::table('fato_log_prontuario')->truncate();
        DB::table('fato_prontuario')->truncate();
        DB::table('fato_cronogramas')->truncate();
        DB::table('dim_telefones_paciente')->truncate();
        DB::table('dim_enderecos_pacientes')->truncate();
        DB::table('dim_pacientes')->truncate();
        DB::table('dim_cnes_unidades')->truncate();
        DB::table('dim_vagas')->truncate();
        DB::table('dim_turno')->truncate();
        DB::table('dim_profissionais')->truncate();
        DB::table('dim_perfis_acesso')->truncate();

        Schema::enableForeignKeyConstraints();

        $this->command->info('1. Inserindo Perfis de Acesso...');
        $perfilMedico = DB::table('dim_perfis_acesso')->insertGetId([
            'nome_perfil' => 'Médico Mastologista / Ginecologista',
            'pode_ver_anamnese' => true,
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);

        $perfilOperador = DB::table('dim_perfis_acesso')->insertGetId([
            'nome_perfil' => 'Operador de Regulação N1',
            'pode_ver_anamnese' => false,
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);

        $this->command->info('2. Inserindo Profissionais...');
        $profCamila = DB::table('dim_profissionais')->insertGetId([
            'id_perfil' => $perfilMedico,
            'nome' => 'Dra. Camila Ribeiro de Souza',
            'registro_profissional' => 'CRM/SP 189.442',
            'cargo_funcao' => 'Médica Mastologista',
            'email_corporativo' => 'camila.ribeiro@sus.saude.gov.br',
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);

        $profRoberto = DB::table('dim_profissionais')->insertGetId([
            'id_perfil' => $perfilMedico,
            'nome' => 'Dr. Roberto Vasconcelos Lima',
            'registro_profissional' => 'CRM/SP 142.339',
            'cargo_funcao' => 'Médico Clínico Geral',
            'email_corporativo' => 'roberto.vasconcelos@sus.saude.gov.br',
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);

        $this->command->info('3. Inserindo Turnos, Vagas e Unidades CNES...');
        $turnoManha = DB::table('dim_turno')->insertGetId(['turno' => 'Manhã', 'created_at' => $hoje, 'updated_at' => $hoje]);
        $turnoTarde = DB::table('dim_turno')->insertGetId(['turno' => 'Tarde', 'created_at' => $hoje, 'updated_at' => $hoje]);

        $vagaMamografia = DB::table('dim_vagas')->insertGetId(['tipo_exame' => 'Mamografia Bilateral', 'created_at' => $hoje, 'updated_at' => $hoje]);
        $vagaPreventivo = DB::table('dim_vagas')->insertGetId(['tipo_exame' => 'Preventivo Citopatológico', 'created_at' => $hoje, 'updated_at' => $hoje]);
        $vagaClinica = DB::table('dim_vagas')->insertGetId(['tipo_exame' => 'Consulta Clínica Geral', 'created_at' => $hoje, 'updated_at' => $hoje]);

        $unidadeNise = DB::table('dim_cnes_unidades')->insertGetId([
            'codigo_cnes' => '2078912',
            'nome_unidade' => 'Centro de Saúde da Mulher Dra. Nise da Silveira',
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);

        $unidadeVilaMariana = DB::table('dim_cnes_unidades')->insertGetId([
            'codigo_cnes' => '2078920',
            'nome_unidade' => 'UBS Vila Mariana - Central',
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);

        $this->command->info('4. Inserindo Cronogramas (Agendas)...');
        $agenda1 = DB::table('fato_cronogramas')->insertGetId([
            'id_cnes_unidade' => $unidadeNise,
            'Vagas_id_vagas' => $vagaMamografia,
            'Turno_id_turno' => $turnoManha,
            'data_atendimento' => $hoje->copy()->subDays(2)->format('Y-m-d'),
            'municipio_atendimento' => 'São Paulo',
            'qnt_oferecidas_vagas' => 20,
            'prenchida_vagas' => 20,
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);

        $agenda2 = DB::table('fato_cronogramas')->insertGetId([
            'id_cnes_unidade' => $unidadeVilaMariana,
            'Vagas_id_vagas' => $vagaClinica,
            'Turno_id_turno' => $turnoTarde,
            'data_atendimento' => $hoje->copy()->subDays(1)->format('Y-m-d'),
            'municipio_atendimento' => 'São Paulo',
            'qnt_oferecidas_vagas' => 15,
            'prenchida_vagas' => 15,
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);

        $agenda3_futura = DB::table('fato_cronogramas')->insertGetId([
            'id_cnes_unidade' => $unidadeNise,
            'Vagas_id_vagas' => $vagaMamografia,
            'Turno_id_turno' => $turnoManha,
            'data_atendimento' => $hoje->copy()->addDay()->format('Y-m-d'),
            'municipio_atendimento' => 'São Paulo',
            'qnt_oferecidas_vagas' => 20,
            'prenchida_vagas' => 18,
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);

        $this->command->info('5. Inserindo Pacientes (Chave Primária cpf_paciente)...');
        // Paciente 1 - Carlos (Atendido + Anamnese SISMAMA)
        DB::table('dim_pacientes')->insert([
            'cpf_paciente' => '45678901233',
            'cartao_sus' => '898004567890123',
            'nome_completo' => 'Carlos Eduardo Fagundes',
            'data_nascimento' => '1978-02-14',
            'sexo' => 'M',
            'raca_cor' => 'Branca',
            'escolaridade' => 'Ensino Superior',
            'termo_lgpd_aceito' => true,
            'data_cadastro' => $hoje->copy()->subDays(10),
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);
        DB::table('dim_telefones_paciente')->insert([
            'cpf_paciente' => '45678901233',
            'numero' => '(11) 95432-1098',
            'tipo' => 'celular',
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);

        // Paciente 2 - Luciana (Atendida + Anamnese SISCOLO)
        DB::table('dim_pacientes')->insert([
            'cpf_paciente' => '56789012344',
            'cartao_sus' => '898005678901234',
            'nome_completo' => 'Luciana Ferreira Costa',
            'data_nascimento' => '1989-09-08',
            'sexo' => 'F',
            'raca_cor' => 'Parda',
            'escolaridade' => 'Ensino Médio',
            'termo_lgpd_aceito' => true,
            'data_cadastro' => $hoje->copy()->subDays(8),
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);
        DB::table('dim_telefones_paciente')->insert([
            'cpf_paciente' => '56789012344',
            'numero' => '(11) 94321-0987',
            'tipo' => 'celular',
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);

        // Paciente 3 - Maria (Desistência / Cancelado Prazo 24h)
        DB::table('dim_pacientes')->insert([
            'cpf_paciente' => '12345678900',
            'cartao_sus' => '898001234567890',
            'nome_completo' => 'Maria Silva Santos',
            'data_nascimento' => '1984-05-12',
            'sexo' => 'F',
            'raca_cor' => 'Parda',
            'termo_lgpd_aceito' => true,
            'data_cadastro' => $hoje->copy()->subDays(6),
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);
        DB::table('dim_telefones_paciente')->insert([
            'cpf_paciente' => '12345678900',
            'numero' => '(11) 98765-4321',
            'tipo' => 'celular',
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);

        // Paciente 4 - João (Fila de Espera #51 - Primeiro a ser convocado)
        DB::table('dim_pacientes')->insert([
            'cpf_paciente' => '23456789011',
            'cartao_sus' => '898002345678901',
            'nome_completo' => 'João Pereira Lima',
            'data_nascimento' => '1990-08-23',
            'sexo' => 'M',
            'termo_lgpd_aceito' => true,
            'data_cadastro' => $hoje->copy()->subDays(5),
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);
        DB::table('dim_telefones_paciente')->insert([
            'cpf_paciente' => '23456789011',
            'numero' => '(11) 97654-3210',
            'tipo' => 'celular',
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);

        // Paciente 5 - Ana Beatriz (Fila de Espera #52)
        DB::table('dim_pacientes')->insert([
            'cpf_paciente' => '34567890122',
            'cartao_sus' => '898003456789012',
            'nome_completo' => 'Ana Beatriz Oliveira',
            'data_nascimento' => '1995-11-30',
            'sexo' => 'F',
            'termo_lgpd_aceito' => true,
            'data_cadastro' => $hoje->copy()->subDays(4),
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);
        DB::table('dim_telefones_paciente')->insert([
            'cpf_paciente' => '34567890122',
            'numero' => '(11) 96543-2109',
            'tipo' => 'celular',
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);

        $this->command->info('6. Inserindo Prontuários (fato_prontuario)...');
        // Prontuário 1: #53 Atendido (Carlos)
        $prontuario1 = DB::table('fato_prontuario')->insertGetId([
            'numero_sequencial' => 53,
            'cpf_paciente' => '45678901233',
            'id_agenda' => $agenda1,
            'status_comparecimento' => 'presente',
            'status_agendamento' => 'confirmado',
            'status_documentos' => 'aprovado',
            'status_documento' => 'aprovado',
            'cliente_confirmou' => true,
            'limite_confirmacao_24h' => $hoje->copy()->subDays(2),
            'created_at' => $hoje->copy()->subDays(5),
            'updated_at' => $hoje->copy()->subDays(2),
        ]);

        // Prontuário 2: #48 Atendido (Luciana)
        $prontuario2 = DB::table('fato_prontuario')->insertGetId([
            'numero_sequencial' => 48,
            'cpf_paciente' => '56789012344',
            'id_agenda' => $agenda1,
            'status_comparecimento' => 'presente',
            'status_agendamento' => 'confirmado',
            'status_documentos' => 'validar_no_ato',
            'status_documento' => 'pendente',
            'cliente_confirmou' => true,
            'limite_confirmacao_24h' => $hoje->copy()->subDays(3),
            'created_at' => $hoje->copy()->subDays(6),
            'updated_at' => $hoje->copy()->subDays(3),
        ]);

        // Prontuário 3: #50 Desistência / Expirado 24h (Maria)
        DB::table('fato_prontuario')->insert([
            'numero_sequencial' => 50,
            'cpf_paciente' => '12345678900',
            'id_agenda' => $agenda3_futura,
            'status_comparecimento' => 'cancelado',
            'status_agendamento' => 'cancelado_prazo_24h',
            'status_documentos' => 'aprovado',
            'status_documento' => 'aprovado',
            'cliente_confirmou' => false,
            'limite_confirmacao_24h' => $hoje->copy()->subHours(2), // Expirou
            'motivo_rejeicao_documento' => 'Prazo de confirmação de 24h encerrado sem resposta.',
            'created_at' => $hoje->copy()->subDays(4),
            'updated_at' => $hoje->copy()->subHours(2),
        ]);

        // Prontuário 4: #51 Fila de Espera (João - Titular aguardando confirmação pós liberação de vaga)
        DB::table('fato_prontuario')->insert([
            'numero_sequencial' => 51,
            'cpf_paciente' => '23456789011',
            'id_agenda' => $agenda3_futura,
            'status_comparecimento' => 'espera',
            'status_agendamento' => 'aguardando_confirmacao',
            'status_documentos' => 'aprovado',
            'status_documento' => 'aprovado',
            'cliente_confirmou' => null,
            'limite_confirmacao_24h' => $hoje->copy()->addHours(22),
            'created_at' => $hoje->copy()->subDays(3),
            'updated_at' => $hoje,
        ]);

        // Prontuário 5: #52 Fila de Espera (Ana Beatriz)
        DB::table('fato_prontuario')->insert([
            'numero_sequencial' => 52,
            'cpf_paciente' => '34567890122',
            'id_agenda' => $agenda3_futura,
            'status_comparecimento' => 'espera',
            'status_agendamento' => 'em_espera',
            'status_documentos' => 'pendente',
            'status_documento' => 'pendente',
            'cliente_confirmou' => null,
            'limite_confirmacao_24h' => null,
            'created_at' => $hoje->copy()->subDays(2),
            'updated_at' => $hoje,
        ]);

        $this->command->info('7. Inserindo Questionários Clínicos (fato_anamnese, anamnese_sismama, anamnese_siscolo)...');
        // Anamnese 1: SISMAMA (Mamografia de Carlos)
        $fatoAnamnese1 = DB::table('fato_anamnese')->insertGetId([
            'id_prontuario' => $prontuario1,
            'id_profissional' => $profCamila,
            'tipo_anamnese' => 'sismama',
            'data_realizacao' => $hoje->copy()->subDays(2)->format('Y-m-d'),
            'created_at' => $hoje->copy()->subDays(2),
            'updated_at' => $hoje->copy()->subDays(2),
        ]);

        DB::table('anamnese_sismama')->insert([
            'id_fato_anamnese' => $fatoAnamnese1,
            'nodulo_mama_direita' => true,
            'nodulo_mama_esquerda' => false,
            'risco_elevado_cancer' => true,
            'mamas_examinadas_anteriormente' => true,
            'fez_mamografia_anterior' => true,
            'ano_ultima_mamografia' => 2024,
            'fez_radioterapia_mama' => false,
            'fez_cirurgia_mama' => false,
            'tipo_mamografia' => 'Diagnóstica',
            'achado_descarga_papilar_dir' => 'Ausente',
            'achado_descarga_papilar_esq' => 'Ausente',
            'achado_nodulo_localizacao_dir' => 'Quadrante Superior Externo',
            'achado_nodulo_localizacao_esq' => 'Sem alterações',
            'achado_linfonodo_palpavel_dir' => 'Axilar móvel (<1cm)',
            'achado_linfonodo_palpavel_esq' => 'Não palpável',
            'created_at' => $hoje->copy()->subDays(2),
            'updated_at' => $hoje->copy()->subDays(2),
        ]);

        // Anamnese 2: SISCOLO (Preventivo de Luciana)
        $fatoAnamnese2 = DB::table('fato_anamnese')->insertGetId([
            'id_prontuario' => $prontuario2,
            'id_profissional' => $profCamila,
            'tipo_anamnese' => 'siscolo',
            'data_realizacao' => $hoje->copy()->subDays(3)->format('Y-m-d'),
            'created_at' => $hoje->copy()->subDays(3),
            'updated_at' => $hoje->copy()->subDays(3),
        ]);

        DB::table('anamnese_siscolo')->insert([
            'id_fato_anamnese' => $fatoAnamnese2,
            'motivo_exame' => 'Rastreamento Citopatológico Preventivo de Rotina',
            'fez_preventivo_anterior' => true,
            'ano_ultimo_preventivo' => 2024,
            'usa_diu' => false,
            'esta_gravida' => false,
            'usa_pilula' => true,
            'usa_hormonio_menopausa' => false,
            'ja_fez_radioterapia' => false,
            'data_ultima_menstruacao' => $hoje->copy()->subDays(20)->format('Y-m-d'),
            'sangramento_apos_relacao' => false,
            'sangramento_apos_menopausa' => false,
            'inspecao_colo' => 'Colo eutrófico, orifício externo puntiforme, sem sangramentos',
            'sinais_dst' => false,
            'created_at' => $hoje->copy()->subDays(3),
            'updated_at' => $hoje->copy()->subDays(3),
        ]);

        $this->command->info('================================================================');
        $this->command->info('✓ SEED CONCLUÍDO COM SUCESSO SEGUINDO 100% DAS SUAS MIGRATIONS!');
        $this->command->info('• Pacientes cadastrados com PK cpf_paciente (CHAR 11)');
        $this->command->info('• Fato Cronogramas vinculado com dim_vagas, dim_turno e dim_cnes_unidades');
        $this->command->info('• Fato Prontuário com controle de status, documentos e 24 horas');
        $this->command->info('• Protocolos Clínicos SISMAMA e SISCOLO preenchidos com sucesso!');
        $this->command->info('================================================================');
    }
}