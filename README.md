# Agenda Saúde

O Agenda Saúde é um sistema web desenvolvido como Projeto Integrador (Senac), voltado para a gestão de agendamentos, triagem clínica e atendimento em Unidades Móveis de Saúde, com foco preventivo em saúde da mulher (programas SISCOLO e SISMAMA do SUS/Ministério da Saúde).

## 1. Objetivo Principal

Automatizar e centralizar o fluxo de atendimento em saúde móvel: desde o agendamento prévio pelo paciente/atendente, controle de vagas por município/turno, até o preenchimento de prontuários, anamnese médica e avaliação de satisfação.

## 2. Principais Módulos e Funcionalidades

Fluxo de Agendamento do Paciente (3 Etapas):



Etapa 1
: Identificação e cadastro prévio dos dados do paciente.


Etapa 2
: Seleção de unidade móvel, município, data, turno e vaga disponível.


Etapa 3
: Confirmação/revisão dos dados e suporte à fila de espera inteligente.
Prontuário & Anamnese Clínica Especializada:

Protocolo SISCOLO (

AnamneseColoController
): Coleta de dados para rastreamento de câncer do colo de útero (preventivo, histórico de DIU, gestação, sangramentos, inspeção clínica).
Protocolo SISMAMA (

AnamneseMamaController
): Coleta de dados para rastreamento de câncer de mama (nódulos, histórico prévio de mamografia, histórico familiar, fatores de risco).
Gestão de Comparecimento e Fila (

ListaProntuarioController
):

Controle de status do paciente: agendado, confirmado (via WhatsApp/contato), espera, presente (recepção na unidade móvel), faltou e cancelado.
Painel Administrativo & Indicadores (

DashboardController
):

Visualização de vagas ofertadas vs. preenchidas por município e unidade.
Monitoramento de taxas de presença e absenteísmo.
Pesquisa de Satisfação & Feedback (

feedbackController
):

Coleta de avaliação do atendimento pós-consulta (fato_feedback).
Autenticação e Permissões:

Telas de autenticação, recuperação de senha e controle de perfis de colaboradores/profissionais de saúde.

## 3. Arquitetura de Banco de Dados (Modelagem Dimensional)

O banco foi modelado no padrão Star Schema (DW) com separação clara entre dimensões e tabelas fato:

Dimensões (dim_*):


dim_pacientes
, 

dim_enderecos_pacientes
, 

dim_telefones_paciente


dim_profissionais
, 

dim_perfis_acesso


dim_cnes_unidades
, 

dim_turno
, 

dim_vagas
Fatos e Protocolos (fato_* / anamnese_*):


fato_cronogramas
 (oferta de vagas e itinerário das unidades móveis)


fato_prontuario
 (vínculo paciente + cronograma + status)


fato_anamnese
, 

anamnese_siscolo
 e 

anamnese_sismama


fato_feedback
 e 

fato_log_prontuario

## 4. Tecnologias Utilizadas

Backend: PHP 8.2+, Laravel 12 (com arquitetura MVC e Eloquent ORM).
Frontend: Blade Templates, HTML5, CSS3, JavaScript e Vite como bundler.
Banco de Dados: Compatível com MySQL / PostgreSQL / SQLite via migrations do Laravel.

## 5. Estado Atual do Projeto

As estruturas de banco (migrations) e grande parte das interfaces visuais (views Blade) já foram desenhadas.
Algumas rotas e fluxos de agendamento ainda utilizam views estáticas/prototipadas, enquanto módulos como Anamnese (SISCOLO/SISMAMA) já contam com persistência e controllers mais estruturados.
