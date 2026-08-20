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

ListaAgendamentoController
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








<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
