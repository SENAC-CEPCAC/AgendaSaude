<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DadosFakeSeeder extends Seeder
{
    /**
     * Popula a base de dados com um cenário realista:
     * - 6 Profissionais (1 Gestor, 2 Médicos, 2 Enfermeiros, 1 Atendente/Operador)
     * - 2 Unidades Móveis (CNES)
     * - 4 Cronogramas de Atendimento (Siscolo e Sismama)
     * - 10 Pacientes com endereços e telefones
     * - 10 Prontuários (4 Siscolo, 4 Sismama, 2 Fila de espera)
     * - 4 Anamneses Clínicas completas (2 Siscolo e 2 Sismama)
     * - Feedbacks de satisfação
     */
    public function run(): void
    {
        // 1. GARANTIR PERFIS, TURNOS E TIPOS DE VAGAS
        $this->seedTabelasBase();

        // 2. UNIDADES MÓVEIS (CNES)
        $this->seedUnidadesMoveis();

        // 3. PROFISSIONAIS (6: 1 Gestor, 2 Médicos, 2 Enfermeiros, 1 Operador)
        $this->seedProfissionais();

        // 4. CRONOGRAMAS DE ATENDIMENTO
        $this->seedCronogramas();

        // 5. PACIENTES (10 Pacientes)
        $this->seedPacientes();

        // 6. PRONTUÁRIOS, AGENDAMENTOS E ANAMNESES (4 Siscolo, 4 Sismama, 2 Espera)
        $this->seedProntuariosEAnamneses();
    }

    private function seedTabelasBase(): void
    {
        // Perfis de Acesso
        $perfis = [
            ['id_perfil' => 1, 'nome_perfil' => 'Administrador', 'pode_ver_anamnese' => true],
            ['id_perfil' => 2, 'nome_perfil' => 'Médico', 'pode_ver_anamnese' => true],
            ['id_perfil' => 3, 'nome_perfil' => 'Enfermeiro', 'pode_ver_anamnese' => true],
            ['id_perfil' => 4, 'nome_perfil' => 'Atendente', 'pode_ver_anamnese' => false],
        ];
        foreach ($perfis as $perfil) {
            DB::table('dim_perfis_acesso')->updateOrInsert(
                ['id_perfil' => $perfil['id_perfil']],
                ['nome_perfil' => $perfil['nome_perfil'], 'pode_ver_anamnese' => $perfil['pode_ver_anamnese'], 'created_at' => now(), 'updated_at' => now()]
            );
        }

        // Turnos
        $turnos = [
            ['id_turno' => 1, 'turno' => 'Manhã'],
            ['id_turno' => 2, 'turno' => 'Tarde'],
            ['id_turno' => 3, 'turno' => 'Integral'],
        ];
        foreach ($turnos as $turno) {
            DB::table('dim_turno')->updateOrInsert(
                ['id_turno' => $turno['id_turno']],
                ['turno' => $turno['turno'], 'created_at' => now(), 'updated_at' => now()]
            );
        }

        // Tipos de Exames / Vagas
        $vagas = [
            ['id_vagas' => 1, 'tipo_exame' => 'Preventivo (Siscolo)'],
            ['id_vagas' => 2, 'tipo_exame' => 'Mamografia (Sismama)'],
        ];
        foreach ($vagas as $vaga) {
            DB::table('dim_vagas')->updateOrInsert(
                ['id_vagas' => $vaga['id_vagas']],
                ['tipo_exame' => $vaga['tipo_exame'], 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }

    private function seedUnidadesMoveis(): void
    {
        $unidades = [
            [
                'id_cnes_unidade' => 1,
                'codigo_cnes' => '2658914',
                'nome_unidade' => 'Unidade Móvel de Saúde da Mulher 01 - Centro / Itinerante'
            ],
            [
                'id_cnes_unidade' => 2,
                'codigo_cnes' => '3049182',
                'nome_unidade' => 'Unidade Móvel de Prevenção e Diagnóstico 02 - Zona Leste'
            ]
        ];

        foreach ($unidades as $unidade) {
            DB::table('dim_cnes_unidades')->updateOrInsert(
                ['id_cnes_unidade' => $unidade['id_cnes_unidade']],
                [
                    'codigo_cnes' => $unidade['codigo_cnes'],
                    'nome_unidade' => $unidade['nome_unidade'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }

    private function seedProfissionais(): void
    {
        $profissionais = [
            // 1 Gestor / Administrador
            [
                'id_profissional' => 1,
                'id_perfil' => 1,
                'nome' => 'Dr. Carlos Eduardo Menezes',
                'registro_profissional' => 'CRM-SP 145892',
                'cargo_funcao' => 'Coordenador Geral de Saúde Móvel',
                'email_corporativo' => 'carlos.menezes@agendasaude.sp.gov.br'
            ],
            // 2 Médicos
            [
                'id_profissional' => 2,
                'id_perfil' => 2,
                'nome' => 'Dra. Mariana Albuquerque Lima',
                'registro_profissional' => 'CRM-SP 189420',
                'cargo_funcao' => 'Médica Ginecologista e Obstetra',
                'email_corporativo' => 'mariana.lima@agendasaude.sp.gov.br'
            ],
            [
                'id_profissional' => 3,
                'id_perfil' => 2,
                'nome' => 'Dr. Rodrigo Silveira Ramos',
                'registro_profissional' => 'CRM-SP 201345',
                'cargo_funcao' => 'Médico Mastologista / Radiologista',
                'email_corporativo' => 'rodrigo.ramos@agendasaude.sp.gov.br'
            ],
            // 2 Enfermeiros
            [
                'id_profissional' => 4,
                'id_perfil' => 3,
                'nome' => 'Enf. Juliana Castro Barbosa',
                'registro_profissional' => 'COREN-SP 512340-ENF',
                'cargo_funcao' => 'Enfermeira de Saúde Coletiva e Coleta',
                'email_corporativo' => 'juliana.barbosa@agendasaude.sp.gov.br'
            ],
            [
                'id_profissional' => 5,
                'id_perfil' => 3,
                'nome' => 'Enf. Lucas Ferreira Martins',
                'registro_profissional' => 'COREN-SP 498712-ENF',
                'cargo_funcao' => 'Enfermeiro Triagista e Acolhimento',
                'email_corporativo' => 'lucas.martins@agendasaude.sp.gov.br'
            ],
            // 1 Operador / Atendente
            [
                'id_profissional' => 6,
                'id_perfil' => 4,
                'nome' => 'Patrícia Souza Nogueira',
                'registro_profissional' => 'MAT-202409',
                'cargo_funcao' => 'Operadora de Recepção e Agendamento',
                'email_corporativo' => 'patricia.nogueira@agendasaude.sp.gov.br'
            ]
        ];

        foreach ($profissionais as $prof) {
            DB::table('dim_profissionais')->updateOrInsert(
                ['id_profissional' => $prof['id_profissional']],
                [
                    'id_perfil' => $prof['id_perfil'],
                    'nome' => $prof['nome'],
                    'registro_profissional' => $prof['registro_profissional'],
                    'cargo_funcao' => $prof['cargo_funcao'],
                    'email_corporativo' => $prof['email_corporativo'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }

    private function seedCronogramas(): void
    {
        $cronogramas = [
            // Cronograma 1: Unidade 1, Siscolo, Manhã
            [
                'id_agenda' => 1,
                'id_cnes_unidade' => 1,
                'Vagas_id_vagas' => 1, // Siscolo
                'Turno_id_turno' => 1, // Manhã
                'data_atendimento' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'municipio_atendimento' => 'São Paulo - Praça da Sé',
                'qnt_oferecidas_vagas' => 20,
                'prenchida_vagas' => 12
            ],
            // Cronograma 2: Unidade 1, Sismama, Tarde
            [
                'id_agenda' => 2,
                'id_cnes_unidade' => 1,
                'Vagas_id_vagas' => 2, // Sismama
                'Turno_id_turno' => 2, // Tarde
                'data_atendimento' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'municipio_atendimento' => 'São Paulo - Praça da Sé',
                'qnt_oferecidas_vagas' => 15,
                'prenchida_vagas' => 10
            ],
            // Cronograma 3: Unidade 2, Siscolo, Manhã
            [
                'id_agenda' => 3,
                'id_cnes_unidade' => 2,
                'Vagas_id_vagas' => 1, // Siscolo
                'Turno_id_turno' => 1, // Manhã
                'data_atendimento' => Carbon::now()->addDays(4)->format('Y-m-d'),
                'municipio_atendimento' => 'São Paulo - Itaquera',
                'qnt_oferecidas_vagas' => 20,
                'prenchida_vagas' => 8
            ],
            // Cronograma 4: Unidade 2, Sismama, Tarde
            [
                'id_agenda' => 4,
                'id_cnes_unidade' => 2,
                'Vagas_id_vagas' => 2, // Sismama
                'Turno_id_turno' => 2, // Tarde
                'data_atendimento' => Carbon::now()->addDays(4)->format('Y-m-d'),
                'municipio_atendimento' => 'São Paulo - Itaquera',
                'qnt_oferecidas_vagas' => 15,
                'prenchida_vagas' => 9
            ]
        ];

        foreach ($cronogramas as $crono) {
            DB::table('fato_cronogramas')->updateOrInsert(
                ['id_agenda' => $crono['id_agenda']],
                [
                    'id_cnes_unidade' => $crono['id_cnes_unidade'],
                    'Vagas_id_vagas' => $crono['Vagas_id_vagas'],
                    'Turno_id_turno' => $crono['Turno_id_turno'],
                    'data_atendimento' => $crono['data_atendimento'],
                    'municipio_atendimento' => $crono['municipio_atendimento'],
                    'qnt_oferecidas_vagas' => $crono['qnt_oferecidas_vagas'],
                    'prenchida_vagas' => $crono['prenchida_vagas'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }

    private function seedPacientes(): void
    {
        $pacientes = [
            // 4 Pacientes para SISCOLO
            [
                'id_paciente' => 1,
                'cartao_sus' => '700123456789012',
                'cpf' => '12345678901',
                'nome_completo' => 'Ana Paula Ribeiro',
                'nome_mae' => 'Maria das Graças Ribeiro',
                'apelido' => 'Paulinha',
                'data_nascimento' => '1992-05-14',
                'sexo' => 'F',
                'raca_cor' => 'Parda',
                'escolaridade' => 'Ensino Superior Completo',
                'endereco' => [
                    'logradouro' => 'Rua da Consolação',
                    'numero' => '1200',
                    'complemento' => 'Apto 34',
                    'bairro' => 'Centro',
                    'municipio' => 'São Paulo',
                    'uf' => 'SP',
                    'cep' => '01302-001',
                    'ponto_referencia' => 'Próximo ao Metrô Higienópolis-Mackenzie'
                ],
                'telefone' => ['numero' => '(11) 98123-4567', 'tipo' => 'celular']
            ],
            [
                'id_paciente' => 2,
                'cartao_sus' => '700234567890123',
                'cpf' => '23456789012',
                'nome_completo' => 'Beatriz Helena Souza',
                'nome_mae' => 'Lúcia Helena Souza',
                'apelido' => 'Bia',
                'data_nascimento' => '1985-09-22',
                'sexo' => 'F',
                'raca_cor' => 'Branca',
                'escolaridade' => 'Ensino Médio Completo',
                'endereco' => [
                    'logradouro' => 'Avenida Paulista',
                    'numero' => '800',
                    'complemento' => 'Bloco B, Ap 42',
                    'bairro' => 'Bela Vista',
                    'municipio' => 'São Paulo',
                    'uf' => 'SP',
                    'cep' => '01310-100',
                    'ponto_referencia' => 'Em frente ao Shopping Cidade São Paulo'
                ],
                'telefone' => ['numero' => '(11) 97234-5678', 'tipo' => 'celular']
            ],
            [
                'id_paciente' => 3,
                'cartao_sus' => '700345678901234',
                'cpf' => '34567890123',
                'nome_completo' => 'Camila Duarte Albuquerque',
                'nome_mae' => 'Sônia Maria Duarte',
                'apelido' => 'Cami',
                'data_nascimento' => '1998-11-03',
                'sexo' => 'F',
                'raca_cor' => 'Preta',
                'escolaridade' => 'Ensino Superior Incompleto',
                'endereco' => [
                    'logradouro' => 'Rua Vergueiro',
                    'numero' => '350',
                    'complemento' => 'Casa 2',
                    'bairro' => 'Liberdade',
                    'municipio' => 'São Paulo',
                    'uf' => 'SP',
                    'cep' => '01504-000',
                    'ponto_referencia' => 'Ao lado do Centro Cultural São Paulo'
                ],
                'telefone' => ['numero' => '(11) 99345-6789', 'tipo' => 'celular']
            ],
            [
                'id_paciente' => 4,
                'cartao_sus' => '700456789012345',
                'cpf' => '45678901234',
                'nome_completo' => 'Débora Cristina Moreira',
                'nome_mae' => 'Antônia Rosa Moreira',
                'apelido' => null,
                'data_nascimento' => '1979-02-18',
                'sexo' => 'F',
                'raca_cor' => 'Parda',
                'escolaridade' => 'Ensino Fundamental Completo',
                'endereco' => [
                    'logradouro' => 'Rua Augusta',
                    'numero' => '550',
                    'complemento' => 'Apto 101',
                    'bairro' => 'Consolação',
                    'municipio' => 'São Paulo',
                    'uf' => 'SP',
                    'cep' => '01304-000',
                    'ponto_referencia' => 'Esquina com a Rua Caio Prado'
                ],
                'telefone' => ['numero' => '(11) 96456-7890', 'tipo' => 'celular']
            ],

            // 4 Pacientes para SISMAMA (Mamografia)
            [
                'id_paciente' => 5,
                'cartao_sus' => '700567890123456',
                'cpf' => '56789012345',
                'nome_completo' => 'Elena Vasconcelos Pires',
                'nome_mae' => 'Clarice Vasconcelos',
                'apelido' => 'Dona Elena',
                'data_nascimento' => '1968-07-30',
                'sexo' => 'F',
                'raca_cor' => 'Branca',
                'escolaridade' => 'Ensino Superior Completo',
                'endereco' => [
                    'logradouro' => 'Avenida Brigadeiro Luís Antônio',
                    'numero' => '2100',
                    'complemento' => 'Apto 81',
                    'bairro' => 'Jardim Paulista',
                    'municipio' => 'São Paulo',
                    'uf' => 'SP',
                    'cep' => '01402-002',
                    'ponto_referencia' => 'Próximo ao Parque Ibirapuera'
                ],
                'telefone' => ['numero' => '(11) 98567-8901', 'tipo' => 'celular']
            ],
            [
                'id_paciente' => 6,
                'cartao_sus' => '700678901234567',
                'cpf' => '67890123456',
                'nome_completo' => 'Fátima Aparecida Guimarães',
                'nome_mae' => 'Neuza Guimarães',
                'apelido' => 'Dona Fátima',
                'data_nascimento' => '1972-12-08',
                'sexo' => 'F',
                'raca_cor' => 'Parda',
                'escolaridade' => 'Ensino Médio Completo',
                'endereco' => [
                    'logradouro' => 'Rua Teodoro Sampaio',
                    'numero' => '1850',
                    'complemento' => null,
                    'bairro' => 'Pinheiros',
                    'municipio' => 'São Paulo',
                    'uf' => 'SP',
                    'cep' => '05406-150',
                    'ponto_referencia' => 'Perto da Praça Benedito Calixto'
                ],
                'telefone' => ['numero' => '(11) 97678-9012', 'tipo' => 'celular']
            ],
            [
                'id_paciente' => 7,
                'cartao_sus' => '700789012345678',
                'cpf' => '78901234567',
                'nome_completo' => 'Gisele Monteiro Prado',
                'nome_mae' => 'Joana Monteiro Prado',
                'apelido' => 'Gi',
                'data_nascimento' => '1965-04-19',
                'sexo' => 'F',
                'raca_cor' => 'Preta',
                'escolaridade' => 'Ensino Médio Incompleto',
                'endereco' => [
                    'logradouro' => 'Rua Domingos de Morais',
                    'numero' => '920',
                    'complemento' => 'Casa dos fundos',
                    'bairro' => 'Vila Mariana',
                    'municipio' => 'São Paulo',
                    'uf' => 'SP',
                    'cep' => '04010-100',
                    'ponto_referencia' => 'Próximo à Estação Ana Rosa'
                ],
                'telefone' => ['numero' => '(11) 99789-0123', 'tipo' => 'celular']
            ],
            [
                'id_paciente' => 8,
                'cartao_sus' => '700890123456789',
                'cpf' => '89012345678',
                'nome_completo' => 'Helena Barros Fagundes',
                'nome_mae' => 'Rosa Maria Barros',
                'apelido' => null,
                'data_nascimento' => '1975-10-05',
                'sexo' => 'F',
                'raca_cor' => 'Branca',
                'escolaridade' => 'Ensino Superior Completo',
                'endereco' => [
                    'logradouro' => 'Avenida Rebouças',
                    'numero' => '1100',
                    'complemento' => 'Apto 15',
                    'bairro' => 'Cerqueira César',
                    'municipio' => 'São Paulo',
                    'uf' => 'SP',
                    'cep' => '05402-000',
                    'ponto_referencia' => 'Esquina com Rua Oscar Freire'
                ],
                'telefone' => ['numero' => '(11) 98890-1234', 'tipo' => 'celular']
            ],

            // 2 Pacientes adicionais (Fluxo de Fila de Espera / Triagem)
            [
                'id_paciente' => 9,
                'cartao_sus' => '700901234567890',
                'cpf' => '90123456789',
                'nome_completo' => 'Isabela Fontes Meireles',
                'nome_mae' => 'Teresa Fontes',
                'apelido' => 'Isa',
                'data_nascimento' => '1995-03-12',
                'sexo' => 'F',
                'raca_cor' => 'Branca',
                'escolaridade' => 'Ensino Superior Completo',
                'endereco' => [
                    'logradouro' => 'Rua Clélia',
                    'numero' => '400',
                    'complemento' => 'Apto 72',
                    'bairro' => 'Lapa',
                    'municipio' => 'São Paulo',
                    'uf' => 'SP',
                    'cep' => '05042-000',
                    'ponto_referencia' => 'Próximo ao Sesc Pompeia'
                ],
                'telefone' => ['numero' => '(11) 96901-2345', 'tipo' => 'celular']
            ],
            [
                'id_paciente' => 10,
                'cartao_sus' => '700012345678901',
                'cpf' => '01234567890',
                'nome_completo' => 'Juliana Macedo Rezende',
                'nome_mae' => 'Carmem Rezende',
                'apelido' => 'Ju Rezende',
                'data_nascimento' => '1970-08-25',
                'sexo' => 'F',
                'raca_cor' => 'Parda',
                'escolaridade' => 'Ensino Médio Completo',
                'endereco' => [
                    'logradouro' => 'Rua Voluntários da Pátria',
                    'numero' => '1300',
                    'complemento' => 'Casa 1',
                    'bairro' => 'Santana',
                    'municipio' => 'São Paulo',
                    'uf' => 'SP',
                    'cep' => '02010-200',
                    'ponto_referencia' => 'Perto do Metrô Santana'
                ],
                'telefone' => ['numero' => '(11) 97012-3456', 'tipo' => 'celular']
            ]
        ];

        foreach ($pacientes as $p) {
            DB::table('dim_pacientes')->updateOrInsert(
                ['id_paciente' => $p['id_paciente']],
                [
                    'cartao_sus' => $p['cartao_sus'],
                    'cpf' => $p['cpf'],
                    'nome_completo' => $p['nome_completo'],
                    'nome_mae' => $p['nome_mae'],
                    'apelido' => $p['apelido'],
                    'data_nascimento' => $p['data_nascimento'],
                    'sexo' => $p['sexo'],
                    'raca_cor' => $p['raca_cor'],
                    'escolaridade' => $p['escolaridade'],
                    'termo_lgpd_aceito' => true,
                    'data_cadastro' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );

            // Endereço
            DB::table('dim_enderecos_pacientes')->updateOrInsert(
                ['id_paciente' => $p['id_paciente']],
                [
                    'logradouro' => $p['endereco']['logradouro'],
                    'numero' => $p['endereco']['numero'],
                    'complemento' => $p['endereco']['complemento'],
                    'bairro' => $p['endereco']['bairro'],
                    'municipio' => $p['endereco']['municipio'],
                    'uf' => $p['endereco']['uf'],
                    'cep' => $p['endereco']['cep'],
                    'ponto_referencia' => $p['endereco']['ponto_referencia'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );

            // Telefone
            DB::table('dim_telefones_paciente')->updateOrInsert(
                ['id_paciente' => $p['id_paciente']],
                [
                    'numero' => $p['telefone']['numero'],
                    'tipo' => $p['telefone']['tipo'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }

    private function seedProntuariosEAnamneses(): void
    {
        // 10 Prontuários com variedade de status para demonstração da Triagem N1
        $prontuarios = [
            // SISCOLO (Pacientes 1, 2, 3, 4)
            ['id_prontuario' => 1, 'id_paciente' => 1, 'id_agenda' => 1, 'status' => 'presente', 'status_doc' => 'aprovado', 'motivo' => null],
            ['id_prontuario' => 2, 'id_paciente' => 2, 'id_agenda' => 1, 'status' => 'confirmado', 'status_doc' => 'aprovado', 'motivo' => null],
            ['id_prontuario' => 3, 'id_paciente' => 3, 'id_agenda' => 3, 'status' => 'agendado', 'status_doc' => 'pendente', 'motivo' => null],
            ['id_prontuario' => 4, 'id_paciente' => 4, 'id_agenda' => 3, 'status' => 'presente', 'status_doc' => 'aprovado', 'motivo' => null],

            // SISMAMA (Pacientes 5, 6, 7, 8)
            ['id_prontuario' => 5, 'id_paciente' => 5, 'id_agenda' => 2, 'status' => 'presente', 'status_doc' => 'aprovado', 'motivo' => null],
            ['id_prontuario' => 6, 'id_paciente' => 6, 'id_agenda' => 2, 'status' => 'confirmado', 'status_doc' => 'aprovado', 'motivo' => null],
            ['id_prontuario' => 7, 'id_paciente' => 7, 'id_agenda' => 4, 'status' => 'agendado', 'status_doc' => 'rejeitado', 'motivo' => 'Documento ilegível. Favor enviar foto nítida do RG aberto.'],
            ['id_prontuario' => 8, 'id_paciente' => 8, 'id_agenda' => 4, 'status' => 'presente', 'status_doc' => 'aprovado', 'motivo' => null],

            // Fila de Espera (Pacientes 9, 10)
            ['id_prontuario' => 9, 'id_paciente' => 9, 'id_agenda' => 1, 'status' => 'espera', 'status_doc' => 'pendente', 'motivo' => null],
            ['id_prontuario' => 10, 'id_paciente' => 10, 'id_agenda' => 2, 'status' => 'espera', 'status_doc' => 'pendente', 'motivo' => null],
        ];

        foreach ($prontuarios as $pront) {
            DB::table('fato_prontuario')->updateOrInsert(
                ['id_prontuario' => $pront['id_prontuario']],
                [
                    'id_paciente' => $pront['id_paciente'],
                    'id_agenda' => $pront['id_agenda'],
                    'status_comparecimento' => $pront['status'],
                    'status_documento' => $pront['status_doc'],
                    'motivo_rejeicao_documento' => $pront['motivo'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }


        // ANAMNESES PARA PACIENTES PRESENTES:

        // 1. Anamnese SISCOLO (Paciente 1 - Ana Paula, Atendida pela Dra. Mariana)
        DB::table('fato_anamnese')->updateOrInsert(
            ['id_fato_anamnese' => 1],
            [
                'id_prontuario' => 1,
                'id_profissional' => 2, // Dra. Mariana
                'tipo_anamnese' => 'siscolo',
                'data_realizacao' => Carbon::now()->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        DB::table('anamnese_siscolo')->updateOrInsert(
            ['id_siscolo' => 1],
            [
                'id_fato_anamnese' => 1,
                'motivo_exame' => 'Rastreamento de rotina preventiva',
                'fez_preventivo_anterior' => true,
                'ano_ultimo_preventivo' => 2024,
                'usa_diu' => false,
                'esta_gravida' => false,
                'usa_pilula' => true,
                'usa_hormonio_menopausa' => false,
                'ja_fez_radioterapia' => false,
                'data_ultima_menstruacao' => Carbon::now()->subDays(14)->format('Y-m-d'),
                'sangramento_apos_relacao' => false,
                'sangramento_apos_menopausa' => false,
                'inspecao_colo' => 'Colo normal / Sem lesões visíveis',
                'sinais_dst' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        // Feedback Paciente 1
        DB::table('fato_feedback')->updateOrInsert(
            ['id_feedback' => 1],
            [
                'fato_prontuario_id_prontuario' => 1,
                'avaliacao' => 5,
                'tempo_espera' => 'Excelente (< 10 min)',
                'atendimento_equipe' => 'Muito atenciosos e cuidadosos',
                'clareza_informacoes' => 'Ótima explicação do procedimento',
                'facilidade_agendamento' => 'Muito fácil pelo sistema',
                'comentario' => 'Atendimento acolhedor e humanizado na unidade móvel. Estão de parabéns!',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        // 2. Anamnese SISCOLO (Paciente 4 - Débora, Atendida pela Enf. Juliana)
        DB::table('fato_anamnese')->updateOrInsert(
            ['id_fato_anamnese' => 2],
            [
                'id_prontuario' => 4,
                'id_profissional' => 4, // Enf. Juliana
                'tipo_anamnese' => 'siscolo',
                'data_realizacao' => Carbon::now()->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        DB::table('anamnese_siscolo')->updateOrInsert(
            ['id_siscolo' => 2],
            [
                'id_fato_anamnese' => 2,
                'motivo_exame' => 'Controle periódico anual',
                'fez_preventivo_anterior' => true,
                'ano_ultimo_preventivo' => 2023,
                'usa_diu' => false,
                'esta_gravida' => false,
                'usa_pilula' => false,
                'usa_hormonio_menopausa' => false,
                'ja_fez_radioterapia' => false,
                'data_ultima_menstruacao' => Carbon::now()->subDays(20)->format('Y-m-d'),
                'sangramento_apos_relacao' => false,
                'sangramento_apos_menopausa' => false,
                'inspecao_colo' => 'Colo eutrófico sem queixas',
                'sinais_dst' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        // 3. Anamnese SISMAMA (Paciente 5 - Elena, Atendida pelo Dr. Rodrigo)
        DB::table('fato_anamnese')->updateOrInsert(
            ['id_fato_anamnese' => 3],
            [
                'id_prontuario' => 5,
                'id_profissional' => 3, // Dr. Rodrigo
                'tipo_anamnese' => 'sismama',
                'data_realizacao' => Carbon::now()->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        DB::table('anamnese_sismama')->updateOrInsert(
            ['id_sismama' => 1],
            [
                'id_fato_anamnese' => 3,
                'nodulo_mama_direita' => false,
                'nodulo_mama_esquerda' => false,
                'risco_elevado_cancer' => false,
                'mamas_examinadas_anteriormente' => true,
                'fez_mamografia_anterior' => true,
                'ano_ultima_mamografia' => 2024,
                'fez_radioterapia_mama' => false,
                'fez_cirurgia_mama' => false,
                'tipo_mamografia' => 'Rastreamento (50-69 anos)',
                'achado_descarga_papilar_dir' => 'Ausente',
                'achado_descarga_papilar_esq' => 'Ausente',
                'achado_nodulo_localizacao_dir' => 'Sem alterações',
                'achado_nodulo_localizacao_esq' => 'Sem alterações',
                'achado_linfonodo_palpavel_dir' => 'Não palpáveis',
                'achado_linfonodo_palpavel_esq' => 'Não palpáveis',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        // Feedback Paciente 5
        DB::table('fato_feedback')->updateOrInsert(
            ['id_feedback' => 2],
            [
                'fato_prontuario_id_prontuario' => 5,
                'avaliacao' => 5,
                'tempo_espera' => 'Pontual',
                'atendimento_equipe' => 'Excelente atendimento do Dr. Rodrigo',
                'clareza_informacoes' => 'Muito claro sobre prazos',
                'facilidade_agendamento' => 'Muito prático',
                'comentario' => 'Muito bom ter essa unidade móvel perto do nosso bairro. Economizou muito tempo.',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        // 4. Anamnese SISMAMA (Paciente 8 - Helena, Atendida pelo Dr. Rodrigo)
        DB::table('fato_anamnese')->updateOrInsert(
            ['id_fato_anamnese' => 4],
            [
                'id_prontuario' => 8,
                'id_profissional' => 3, // Dr. Rodrigo
                'tipo_anamnese' => 'sismama',
                'data_realizacao' => Carbon::now()->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        DB::table('anamnese_sismama')->updateOrInsert(
            ['id_sismama' => 2],
            [
                'id_fato_anamnese' => 4,
                'nodulo_mama_direita' => false,
                'nodulo_mama_esquerda' => false,
                'risco_elevado_cancer' => true, // Histórico de mãe/irmã
                'mamas_examinadas_anteriormente' => true,
                'fez_mamografia_anterior' => true,
                'ano_ultima_mamografia' => 2023,
                'fez_radioterapia_mama' => false,
                'fez_cirurgia_mama' => false,
                'tipo_mamografia' => 'Rastreamento de alto risco',
                'achado_descarga_papilar_dir' => 'Ausente',
                'achado_descarga_papilar_esq' => 'Ausente',
                'achado_nodulo_localizacao_dir' => 'Sem alterações',
                'achado_nodulo_localizacao_esq' => 'Sem alterações',
                'achado_linfonodo_palpavel_dir' => 'Linfonodos normais',
                'achado_linfonodo_palpavel_esq' => 'Linfonodos normais',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

    }
}
