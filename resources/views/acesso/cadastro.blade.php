<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Paciente - Agenda Saúde</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilo customizado -->
    <link rel="stylesheet" href="/css/perfilPaciente.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .step-circle {
            width: 40px;
            height: 40px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container py-5">

        <!-- CABEÇALHO -->
        <div class="text-center mb-4">
            <h2 class="fw-bold text-dark">Crie sua conta</h2>
            <p class="text-muted">Cadastre seus dados para agendar consultas e exames.</p>
        </div>

        <!-- CARD PRINCIPAL -->
        <div class="card shadow-sm border-0 mx-auto" style="max-width: 850px; border-radius: 12px;">
            <div class="card-body p-4 p-md-5">

                <!-- EXIBIÇÃO DE ERROS DO BACKEND -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <strong class="d-block mb-1">Por favor, corrija os erros abaixo:</strong>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- INDICADOR DE PROGRESSO -->
                <div class="d-flex align-items-center justify-content-center mb-5">
                    <!-- ETAPA 1 -->
                    <div class="text-center">
                        <div id="step1Indicator" class="step-circle bg-primary text-white mx-auto">
                            1
                        </div>
                        <small id="step1Text" class="d-block mt-2 fw-semibold text-primary">
                            Dados pessoais
                        </small>
                    </div>

                    <!-- LINHA DIVISÓRIA -->
                    <div class="mx-3 flex-grow-1" style="max-width: 120px;">
                        <hr class="my-0">
                    </div>

                    <!-- ETAPA 2 -->
                    <div class="text-center">
                        <div id="step2Indicator" class="step-circle bg-secondary text-white mx-auto">
                            2
                        </div>
                        <small id="step2Text" class="d-block mt-2 text-muted">
                            Dados de acesso
                        </small>
                    </div>
                </div>

                <!-- FORMULÁRIO -->
                <form id="formCadastroPaciente" action="{{ route('cadastro.store') }}" method="POST" novalidate>
                    @csrf

                    <!-- ========================================== -->
                    <!-- ETAPA 1: DADOS PESSOAIS                    -->
                    <!-- ========================================== -->
                    <div id="step1">
                        <h4 class="mb-4 text-secondary fw-semibold">Dados Pessoais</h4>

                        <div class="row g-3">
                            <!-- NOME COMPLETO -->
                            <div class="col-md-8">
                                <label for="nome_completo" class="form-label fw-semibold">Nome completo *</label>
                                <input type="text" class="form-control" id="nome_completo" name="nome_completo"
                                    placeholder="Digite seu nome completo" value="{{ old('nome_completo') }}" required>
                                <div class="invalid-feedback">Informe seu nome completo.</div>
                            </div>

                            <!-- APELIDO -->
                            <div class="col-md-4">
                                <label for="apelido" class="form-label fw-semibold">Apelido</label>
                                <input type="text" class="form-control" id="apelido" name="apelido"
                                    placeholder="Opcional" value="{{ old('apelido') }}">
                            </div>

                            <!-- NOME DA MÃE -->
                            <div class="col-12">
                                <label for="nome_mae" class="form-label fw-semibold">Nome da mãe *</label>
                                <input type="text" class="form-control" id="nome_mae" name="nome_mae"
                                    placeholder="Digite o nome completo da mãe" value="{{ old('nome_mae') }}" required>
                                <div class="invalid-feedback">Informe o nome da mãe.</div>
                            </div>

                            <!-- CPF -->
                            <div class="col-md-6">
                                <label for="cpf" class="form-label fw-semibold">CPF *</label>
                                <input type="text" class="form-control" id="cpf" name="cpf"
                                    placeholder="000.000.000-00" maxlength="14" value="{{ old('cpf') }}" required>
                                <div class="invalid-feedback">Informe um CPF válido (11 dígitos).</div>
                            </div>

                            <!-- CARTÃO SUS -->
                            <div class="col-md-6">
                                <label for="cartao_sus" class="form-label fw-semibold">Cartão SUS *</label>
                                <input type="text" class="form-control" id="cartao_sus" name="cartao_sus"
                                    placeholder="000000000000000" maxlength="15" value="{{ old('cartao_sus') }}" required>
                                <div class="invalid-feedback">Informe o número do Cartão SUS (15 dígitos).</div>
                            </div>

                            <!-- CELULAR -->
                            <div class="col-md-6">
                                <label for="celular" class="form-label fw-semibold">Número de celular (WhatsApp) *</label>
                                <input type="tel" class="form-control" id="celular" name="celular"
                                    placeholder="(00) 00000-0000" maxlength="15" value="{{ old('celular') }}" required>
                                <div class="invalid-feedback">Informe um número de celular válido com DDD.</div>
                            </div>

                            <!-- DATA DE NASCIMENTO -->
                            <div class="col-md-6">
                                <label for="data_nascimento" class="form-label fw-semibold">Data de nascimento *</label>
                                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento"
                                    value="{{ old('data_nascimento') }}" required>
                                <div class="invalid-feedback">Informe a data de nascimento.</div>
                            </div>

                            <!-- SEXO -->
                            <div class="col-md-4">
                                <label for="sexo" class="form-label fw-semibold">Sexo *</label>
                                <select class="form-select" id="sexo" name="sexo" required>
                                    <option value="">Selecione</option>
                                    <option value="masculino" {{ old('sexo') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="feminino" {{ old('sexo') == 'feminino' ? 'selected' : '' }}>Feminino</option>
                                    <option value="outro" {{ old('sexo') == 'outro' ? 'selected' : '' }}>Outro</option>
                                </select>
                                <div class="invalid-feedback">Selecione o sexo.</div>
                            </div>

                            <!-- RAÇA/COR -->
                            <div class="col-md-4">
                                <label for="raca_cor" class="form-label fw-semibold">Raça/Cor *</label>
                                <select class="form-select" id="raca_cor" name="raca_cor" required>
                                    <option value="">Selecione</option>
                                    <option value="branca" {{ old('raca_cor') == 'branca' ? 'selected' : '' }}>Branca</option>
                                    <option value="preta" {{ old('raca_cor') == 'preta' ? 'selected' : '' }}>Preta</option>
                                    <option value="parda" {{ old('raca_cor') == 'parda' ? 'selected' : '' }}>Parda</option>
                                    <option value="amarela" {{ old('raca_cor') == 'amarela' ? 'selected' : '' }}>Amarela</option>
                                    <option value="indigena" {{ old('raca_cor') == 'indigena' ? 'selected' : '' }}>Indígena</option>
                                    <option value="nao_informado" {{ old('raca_cor') == 'nao_informado' ? 'selected' : '' }}>Não informado</option>
                                </select>
                                <div class="invalid-feedback">Selecione a raça/cor.</div>
                            </div>

                            <!-- ESCOLARIDADE -->
                            <div class="col-md-4">
                                <label for="escolaridade" class="form-label fw-semibold">Escolaridade *</label>
                                <select class="form-select" id="escolaridade" name="escolaridade" required>
                                    <option value="">Selecione</option>
                                    <option value="nao_alfabetizado" {{ old('escolaridade') == 'nao_alfabetizado' ? 'selected' : '' }}>Não alfabetizado</option>
                                    <option value="fundamental_incompleto" {{ old('escolaridade') == 'fundamental_incompleto' ? 'selected' : '' }}>Fundamental incompleto</option>
                                    <option value="fundamental_completo" {{ old('escolaridade') == 'fundamental_completo' ? 'selected' : '' }}>Fundamental completo</option>
                                    <option value="medio_incompleto" {{ old('escolaridade') == 'medio_incompleto' ? 'selected' : '' }}>Médio incompleto</option>
                                    <option value="medio_completo" {{ old('escolaridade') == 'medio_completo' ? 'selected' : '' }}>Médio completo</option>
                                    <option value="superior_incompleto" {{ old('escolaridade') == 'superior_incompleto' ? 'selected' : '' }}>Superior incompleto</option>
                                    <option value="superior_completo" {{ old('escolaridade') == 'superior_completo' ? 'selected' : '' }}>Superior completo</option>
                                    <option value="pos_graduacao" {{ old('escolaridade') == 'pos_graduacao' ? 'selected' : '' }}>Pós-graduação</option>
                                </select>
                                <div class="invalid-feedback">Selecione a escolaridade.</div>
                            </div>
                        </div>

                        <!-- BOTÕES DA ETAPA 1 -->
                        <div class="d-flex justify-content-between  align-items-center mt-5 pt-3 border-top">
                            <a href="{{ route('acesso.index') }}" class="btn btn-outline-secondary px-4">
                                ← Voltar
                            </a>
                            <button type="button" id="btnProximo" class="btn btn-primary px-4 fw-semibold">
                                Próximo →
                            </button>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- ETAPA 2: DADOS DE ACESSO                   -->
                    <!-- ========================================== -->
                    <div id="step2" class="d-none">
                        <h4 class="mb-4 text-secondary fw-semibold">Dados de Acesso</h4>

                        <div class="row g-3">
                            <!-- E-MAIL -->
                            <div class="col-12">
                                <label for="email" class="form-label fw-semibold">E-mail *</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="exemplo@email.com" value="{{ old('email') }}" autocomplete="email" required>
                                <div class="form-text">Você utilizará este e-mail para acessar sua conta.</div>
                                <div class="invalid-feedback">Informe um e-mail válido.</div>
                            </div>

                            <!-- SENHA -->
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold">Senha *</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Mínimo 8 caracteres" minlength="8" required>
                                <div class="invalid-feedback">A senha deve ter pelo menos 8 caracteres.</div>
                            </div>

                            <!-- CONFIRMAR SENHA -->
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold">Confirmar senha *</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                                    placeholder="Digite novamente" minlength="8" required>
                                <div class="invalid-feedback">Confirme sua senha.</div>
                            </div>
                        </div>

                        <!-- ALERTA DE SENHA DIVERGENTE -->
                        <div id="erroSenha" class="alert alert-danger mt-4 d-none" role="alert">
                            As senhas informadas não coincidem.
                        </div>

                        <!-- BOTÕES DA ETAPA 2 -->
                        <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                            <button type="button" id="btnVoltarStep2" class="btn btn-outline-secondary px-4">
                                ← Voltar
                            </button>
                            <button type="submit" id="btnCadastrar" class="btn btn-success px-5 fw-bold">
                                Concluir Cadastro
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript do Formulário -->
    <script>
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const btnProximo = document.getElementById('btnProximo');
        const btnVoltarStep2 = document.getElementById('btnVoltarStep2');
        const form = document.getElementById('formCadastroPaciente');
        const step1Indicator = document.getElementById('step1Indicator');
        const step2Indicator = document.getElementById('step2Indicator');
        const step1Text = document.getElementById('step1Text');
        const step2Text = document.getElementById('step2Text');
        const erroSenha = document.getElementById('erroSenha');

        function mostrarEtapa2() {
            step1.classList.add('d-none');
            step2.classList.remove('d-none');

            step1Indicator.classList.remove('bg-primary');
            step1Indicator.classList.add('bg-success');
            step1Text.classList.remove('fw-semibold', 'text-primary');
            step1Text.classList.add('text-muted');

            step2Indicator.classList.remove('bg-secondary');
            step2Indicator.classList.add('bg-primary');
            step2Text.classList.remove('text-muted');
            step2Text.classList.add('fw-semibold', 'text-primary');
        }

        function mostrarEtapa1() {
            step2.classList.add('d-none');
            step1.classList.remove('d-none');

            step1Indicator.classList.remove('bg-success');
            step1Indicator.classList.add('bg-primary');
            step1Text.classList.remove('text-muted');
            step1Text.classList.add('fw-semibold', 'text-primary');

            step2Indicator.classList.remove('bg-primary');
            step2Indicator.classList.add('bg-secondary');
            step2Text.classList.remove('fw-semibold', 'text-primary');
            step2Text.classList.add('text-muted');
        }

        // Validação da Etapa 1 ao clicar em "Próximo"
        btnProximo.addEventListener('click', function() {
            const camposEtapa1 = step1.querySelectorAll('input[required], select[required]');
            let valido = true;

            camposEtapa1.forEach(function(campo) {
                // Validações customizadas
                if (campo.id === 'cpf') {
                    const cpfLimpo = campo.value.replace(/\D/g, '');
                    if (cpfLimpo.length !== 11) {
                        campo.classList.add('is-invalid');
                        valido = false;
                        return;
                    }
                }

                if (campo.id === 'cartao_sus') {
                    const susLimpo = campo.value.replace(/\D/g, '');
                    if (susLimpo.length !== 15) {
                        campo.classList.add('is-invalid');
                        valido = false;
                        return;
                    }
                }

                if (campo.id === 'celular') {
                    const telLimpo = campo.value.replace(/\D/g, '');
                    if (telLimpo.length < 10 || telLimpo.length > 11) {
                        campo.classList.add('is-invalid');
                        valido = false;
                        return;
                    }
                }

                if (!campo.value.trim() || !campo.checkValidity()) {
                    campo.classList.add('is-invalid');
                    valido = false;
                } else {
                    campo.classList.remove('is-invalid');
                }
            });

            if (valido) {
                mostrarEtapa2();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });

        // Voltar para Etapa 1
        btnVoltarStep2.addEventListener('click', function() {
            mostrarEtapa1();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Validação no envio final do formulário
        form.addEventListener('submit', function(event) {
            const email = document.getElementById('email');
            const senha = document.getElementById('password');
            const confirmar = document.getElementById('password_confirmation');
            let valido = true;

            if (!email.value.trim() || !email.checkValidity()) {
                email.classList.add('is-invalid');
                valido = false;
            } else {
                email.classList.remove('is-invalid');
            }

            if (!senha.value || senha.value.length < 8) {
                senha.classList.add('is-invalid');
                valido = false;
            } else {
                senha.classList.remove('is-invalid');
            }

            if (!confirmar.value || confirmar.value.length < 8) {
                confirmar.classList.add('is-invalid');
                valido = false;
            } else {
                confirmar.classList.remove('is-invalid');
            }

            if (senha.value && confirmar.value && senha.value !== confirmar.value) {
                erroSenha.classList.remove('d-none');
                confirmar.classList.add('is-invalid');
                valido = false;
            } else {
                erroSenha.classList.add('d-none');
            }

            if (!valido) {
                event.preventDefault();
                event.stopPropagation();
            }
        });

        // Máscara de CPF
        document.getElementById('cpf').addEventListener('input', function(e) {
            let v = e.target.value.replace(/\D/g, '').substring(0, 11);
            if (v.length > 9) v = v.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
            else if (v.length > 6) v = v.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
            else if (v.length > 3) v = v.replace(/(\d{3})(\d{1,3})/, '$1.$2');
            e.target.value = v;
        });

        // Máscara de Cartão SUS (somente números, 15 dígitos)
        document.getElementById('cartao_sus').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '').substring(0, 15);
        });

        // Máscara de Celular
        document.getElementById('celular').addEventListener('input', function(e) {
            let v = e.target.value.replace(/\D/g, '').substring(0, 11);
            if (v.length > 10) {
                v = v.replace(/^(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            } else if (v.length > 5) {
                v = v.replace(/^(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
            } else if (v.length > 2) {
                v = v.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
            }
            e.target.value = v;
        });

        // Remover classes de erro ao digitar
        form.querySelectorAll('input, select').forEach(function(campo) {
            campo.addEventListener('input', function() {
                if (campo.value.trim()) campo.classList.remove('is-invalid');
            });
            campo.addEventListener('change', function() {
                if (campo.value.trim()) campo.classList.remove('is-invalid');
            });
        });

        // Se houver erros em campos do Step 2 retornados do backend, abre direto no Step 2
        @if ($errors->has('email') || $errors->has('password') || $errors->has('password_confirmation'))
            document.addEventListener('DOMContentLoaded', function() {
                mostrarEtapa2();
            });
        @endif
    </script>
</body>

</html>