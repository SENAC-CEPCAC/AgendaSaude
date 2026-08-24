<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class AgendamentosTesteSeeder extends Seeder
{
    private function insertSeguro(string $tabela, array $dadosCustomizados): mixed
    {
        $hoje = Carbon::now();
        $colunas = Schema::getColumnListing($tabela);
        $dadosFinais = [];

        foreach ($colunas as $campo) {
            if ($campo === 'id' && !array_key_exists('id', $dadosCustomizados)) {
                continue;
            }

            if (array_key_exists($campo, $dadosCustomizados)) {
                $dadosFinais[$campo] = $dadosCustomizados[$campo];
                continue;
            }
        }

        foreach ($dadosCustomizados as $campo => $valor) {
            if (in_array($campo, $colunas)) {
                $dadosFinais[$campo] = $valor;
            }
        }

        return DB::table($tabela)->insertGetId($dadosFinais);
    }

    public function run(): void
    {
        $hoje = Carbon::now();

        Schema::disableForeignKeyConstraints();
        DB::table('fato_prontuario')->truncate();
        DB::table('fato_cronogramas')->truncate();
        DB::table('dim_vagas')->truncate();
        DB::table('dim_pacientes')->truncate();
        DB::table('dim_profissionais')->truncate();
        
        if (Schema::hasTable('dim_cnes_unidades')) {
            DB::table('dim_cnes_unidades')->truncate();
        }
        if (Schema::hasTable('dim_turnos')) {
            DB::table('dim_turnos')->truncate();
        }
        if (Schema::hasTable('dim_turno')) {
            DB::table('dim_turno')->truncate();
        }
        if (Schema::hasTable('dim_perfis_acesso')) {
            DB::table('dim_perfis_acesso')->truncate();
        }
        if (Schema::hasTable('dim_perfis')) {
            DB::table('dim_perfis')->truncate();
        }
        Schema::enableForeignKeyConstraints();

        // 0. DIM_PERFIS_ACESSO
        $this->command->info('0. Inserindo Perfis de Acesso e Unidades...');
        $perfilId = 1;
        
        if (Schema::hasTable('dim_perfis_acesso')) {
            $campoPerfil = in_array('nome_perfil', Schema::getColumnListing('dim_perfis_acesso')) 
                ? 'nome_perfil' 
                : (in_array('perfil', Schema::getColumnListing('dim_perfis_acesso')) ? 'perfil' : 'nome');

            $perfilId = $this->insertSeguro('dim_perfis_acesso', [
                $campoPerfil => 'Gestor / Operador',
                'descricao' => 'Acesso completo à gestão de agendamentos',
                'nivel_acesso' => 3,
                'created_at' => $hoje,
                'updated_at' => $hoje,
            ]);
        }

        // 0.1 DIM_CNES_UNIDADES
        $unidadeId = 1;
        if (Schema::hasTable('dim_cnes_unidades')) {
            $unidadeId = $this->insertSeguro('dim_cnes_unidades', [
                'cnes' => '2001458',
                'nome_fantasia' => 'Centro de Saúde da Mulher Dra. Nise da Silveira',
                'razao_social' => 'Secretaria Municipal de Saúde',
                'municipio' => 'São Paulo',
                'uf' => 'SP',
                'created_at' => $hoje,
                'updated_at' => $hoje,
            ]);
        }

        // 0.2 DIM_TURNOS
        $turnoId = 1;
        $tabelaTurno = Schema::hasTable('dim_turnos') ? 'dim_turnos' : (Schema::hasTable('dim_turno') ? 'dim_turno' : null);
        if ($tabelaTurno) {
            $turnoId = $this->insertSeguro($tabelaTurno, [
                'nome_turno' => 'Manhã',
                'descricao' => '07:00 às 13:00',
                'created_at' => $hoje,
                'updated_at' => $hoje,
            ]);
        }

        $this->command->info('1. Inserindo Profissionais...');

        $campoNomeProf = in_array('nome_profissional', Schema::getColumnListing('dim_profissionais')) 
            ? 'nome_profissional' 
            : (in_array('nome_completo', Schema::getColumnListing('dim_profissionais')) ? 'nome_completo' : 'nome');

        $operadorId = $this->insertSeguro('dim_profissionais', [
            'id_perfil' => $perfilId,
            $campoNomeProf => 'Dr. Marcos Gabriel (Gestor Geral)',
            'cargo_funcao' => 'Gestor Geral / Operador',
            'cpf' => '11122233344',
            'cns' => '700000000000001',
            'registro_profissional' => 'CRM/SP 123456',
            'email_corporativo' => 'marcos.gestor@agendasaude.gov.br',
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);

        $medico1Id = $this->insertSeguro('dim_profissionais', [
            'id_perfil' => $perfilId,
            $campoNomeProf => 'Dra. Camila Ribeiro (Ginecologia)',
            'cargo_funcao' => 'Médica Ginecologista',
            'cpf' => '22233344455',
            'cns' => '700000000000002',
            'registro_profissional' => 'CRM/SP 654321',
            'email_corporativo' => 'camila.ribeiro@agendasaude.gov.br',
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);

        $medico2Id = $this->insertSeguro('dim_profissionais', [
            'id_perfil' => $perfilId,
            $campoNomeProf => 'Dr. Roberto Vasconcelos (Clínica Geral)',
            'cargo_funcao' => 'Médico Clínico Geral',
            'cpf' => '33344455566',
            'cns' => '700000000000003',
            'registro_profissional' => 'CRM/SP 987654',
            'email_corporativo' => 'roberto.vasconcelos@agendasaude.gov.br',
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);

        $this->command->info('2. Inserindo Pacientes...');

        $campoNomePac = in_array('nome_completo', Schema::getColumnListing('dim_pacientes')) ? 'nome_completo' : 'nome';

        $pacientes = [
            [
                $campoNomePac => 'Maria Silva Santos',
                'cpf_paciente' => '12345678900',
                'cartao_sus' => '898001234567890',
                'telefone' => '11987654321',
                'sexo' => 'F',
                'data_nascimento' => '1984-05-12',
                'created_at' => $hoje,
                'updated_at' => $hoje,
            ],
            [
                $campoNomePac => 'João Pereira Lima (Próximo da Fila #51)',
                'cpf_paciente' => '23456789011',
                'cartao_sus' => '898002345678901',
                'telefone' => '11976543210',
                'sexo' => 'M',
                'data_nascimento' => '1990-08-23',
                'created_at' => $hoje->copy()->subDays(3),
                'updated_at' => $hoje,
            ],
            [
                $campoNomePac => 'Ana Beatriz Oliveira (Fila #52)',
                'cpf_paciente' => '34567890122',
                'cartao_sus' => '898003456789012',
                'telefone' => '11965432109',
                'sexo' => 'F',
                'data_nascimento' => '1995-11-30',
                'created_at' => $hoje->copy()->subDays(2),
                'updated_at' => $hoje,
            ],
            [
                $campoNomePac => 'Carlos Eduardo Fagundes',
                'cpf_paciente' => '45678901233',
                'cartao_sus' => '898004567890123',
                'telefone' => '11954321098',
                'sexo' => 'M',
                'data_nascimento' => '1978-02-14',
                'created_at' => $hoje,
                'updated_at' => $hoje,
            ],
            [
                $campoNomePac => 'Luciana Ferreira Costa',
                'cpf_paciente' => '56789012344',
                'cartao_sus' => '898005678901234',
                'telefone' => '11943210987',
                'sexo' => 'F',
                'data_nascimento' => '1989-09-08',
                'created_at' => $hoje,
                'updated_at' => $hoje,
            ],
        ];

        foreach ($pacientes as $p) {
            $this->insertSeguro('dim_pacientes', $p);
        }

        $this->command->info('3. Inserindo Vagas e Horários...');

        $campoNomeVaga = in_array('nome_vaga', Schema::getColumnListing('dim_vagas')) 
            ? 'nome_vaga' 
            : (in_array('descricao', Schema::getColumnListing('dim_vagas')) ? 'descricao' : 'nome');

        $vaga1Id = $this->insertSeguro('dim_vagas', [
            $campoNomeVaga => 'Mamografia Bilateral',
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);

        $vaga2Id = $this->insertSeguro('dim_vagas', [
            $campoNomeVaga => 'Preventivo Citopatológico',
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);

        $vaga3Id = $this->insertSeguro('dim_vagas', [
            $campoNomeVaga => 'Consulta Clínica Geral',
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);

        // Cronogramas
        $agenda1Id = $this->insertSeguro('fato_cronogramas', [
            'id_cnes_unidade' => $unidadeId,
            'Vagas_id_vagas' => $vaga1Id,
            'Turno_id_turno' => $turnoId,
            'id_turno' => $turnoId,
            'Profissionais_id_profissional' => $medico1Id,
            'data_atendimento' => $hoje->copy()->addHours(20)->format('Y-m-d H:i:s'),
            'municipio_atendimento' => 'São Paulo',
            'qnt_oferecidas_vagas' => 10,
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);

        $agenda2Id = $this->insertSeguro('fato_cronogramas', [
            'id_cnes_unidade' => $unidadeId,
            'Vagas_id_vagas' => $vaga2Id,
            'Turno_id_turno' => $turnoId,
            'id_turno' => $turnoId,
            'Profissionais_id_profissional' => $medico1Id,
            'data_atendimento' => $hoje->copy()->addDays(3)->setTime(10, 0, 0)->format('Y-m-d H:i:s'),
            'municipio_atendimento' => 'São Paulo',
            'qnt_oferecidas_vagas' => 10,
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);

        $agenda3Id = $this->insertSeguro('fato_cronogramas', [
            'id_cnes_unidade' => $unidadeId,
            'Vagas_id_vagas' => $vaga3Id,
            'Turno_id_turno' => $turnoId,
            'id_turno' => $turnoId,
            'Profissionais_id_profissional' => $medico2Id,
            'data_atendimento' => $hoje->copy()->addDays(5)->setTime(14, 30, 0)->format('Y-m-d H:i:s'),
            'municipio_atendimento' => 'São Paulo',
            'qnt_oferecidas_vagas' => 10,
            'created_at' => $hoje,
            'updated_at' => $hoje,
        ]);

        $this->command->info('4. Inserindo Agendamentos com Cenários de Teste...');

        $agendaFila = $agenda1Id;

        // CENÁRIO 1: Agendamento #50 (Prazo de 24h expirado)
        $this->insertSeguro('fato_prontuario', [
            'numero_sequencial' => 50,
            'cpf_paciente' => '12345678900',
            'id_agenda' => $agenda1Id,
            'id_profissional' => $medico1Id,
            'id_vagas' => $vaga1Id,
            'status_comparecimento' => 'agendado',
            'status_agendamento' => 'aguardando_confirmacao',
            'status_documentos' => 'aprovado',
            'operador_validou_id' => $operadorId,
            'data_validacao_operador' => $hoje->copy()->subHours(5),
            'limite_confirmacao_24h' => $hoje->copy()->subMinutes(15),
            'cliente_confirmou' => null,
            'promovido_da_fila' => 0,
            'created_at' => $hoje->copy()->subDays(4),
            'updated_at' => $hoje,
        ]);

        // CENÁRIO 2: Paciente #51 na FILA DE ESPERA (O próximo da fila)
        $this->insertSeguro('fato_prontuario', [
            'numero_sequencial' => 51,
            'cpf_paciente' => '23456789011',
            'id_agenda' => $agendaFila,
            'status_comparecimento' => 'agendado',
            'status_agendamento' => 'em_espera',
            'status_documentos' => 'aprovado',
            'operador_validou_id' => $operadorId,
            'data_validacao_operador' => $hoje->copy()->subHours(2),
            'limite_confirmacao_24h' => null,
            'cliente_confirmou' => null,
            'promovido_da_fila' => 0,
            'created_at' => $hoje->copy()->subDays(3),
            'updated_at' => $hoje,
        ]);

        // CENÁRIO 3: Paciente #52 na FILA DE ESPERA (Doc Pendente)
        $this->insertSeguro('fato_prontuario', [
            'numero_sequencial' => 52,
            'cpf_paciente' => '34567890122',
            'id_agenda' => $agendaFila,
            'status_comparecimento' => 'agendado',
            'status_agendamento' => 'em_espera',
            'status_documentos' => 'pendente',
            'operador_validou_id' => null,
            'data_validacao_operador' => null,
            'limite_confirmacao_24h' => null,
            'cliente_confirmou' => null,
            'promovido_da_fila' => 0,
            'created_at' => $hoje->copy()->subDays(2),
            'updated_at' => $hoje,
        ]);

        // CENÁRIO 4: Agendamento #53 (Confirmado pelo Paciente)
        $this->insertSeguro('fato_prontuario', [
            'numero_sequencial' => 53,
            'cpf_paciente' => '45678901233',
            'id_agenda' => $agenda2Id,
            'id_profissional' => $medico1Id,
            'id_vagas' => $vaga2Id,
            'status_comparecimento' => 'agendado',
            'status_agendamento' => 'confirmado',
            'status_documentos' => 'aprovado',
            'operador_validou_id' => $operadorId,
            'data_validacao_operador' => $hoje->copy()->subDays(1),
            'limite_confirmacao_24h' => $hoje->copy()->addDays(2),
            'cliente_confirmou' => 1,
            'data_confirmacao_cliente' => $hoje->copy()->subHours(12),
            'promovido_da_fila' => 0,
            'created_at' => $hoje->copy()->subDays(5),
            'updated_at' => $hoje,
        ]);

        // CENÁRIO 5: Agendamento #54 (Validar no Ato)
        $this->insertSeguro('fato_prontuario', [
            'numero_sequencial' => 54,
            'cpf_paciente' => '56789012344',
            'id_agenda' => $agenda3Id,
            'id_profissional' => $medico2Id,
            'id_vagas' => $vaga3Id,
            'status_comparecimento' => 'agendado',
            'status_agendamento' => 'aguardando_confirmacao',
            'status_documentos' => 'validar_no_ato',
            'operador_validou_id' => $operadorId,
            'data_validacao_operador' => $hoje->copy()->subHours(1),
            'observacao_operador' => 'Paciente apresentará pedido no dia do exame.',
            'limite_confirmacao_24h' => $hoje->copy()->addDays(4),
            'cliente_confirmou' => null,
            'promovido_da_fila' => 0,
            'created_at' => $hoje->copy()->subDays(1),
            'updated_at' => $hoje,
        ]);

        $this->command->info('=====================================================');
        $this->command->info('✓ SEED CONCLUÍDO COM SUCESSO TOTAL!');
        $this->command->info('=====================================================');
    }
}