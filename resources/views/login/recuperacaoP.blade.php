<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Recuperação de acesso</title>

    <link
        rel="stylesheet"
        href="/css/perfilPaciente.css">

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="bg-[#f8fafc]">


<div class="main flex justify-center items-center h-screen">


    <!-- ========================================= -->
    <!-- CARD -->
    <!-- ========================================= -->

    <div class="border border-slate-50 rounded-xl shadow-md bg-white w-80 p-8">


        <!-- ========================================= -->
        <!-- TÍTULO -->
        <!-- ========================================= -->

        <div class="text-center">

            <h2 class="text-3xl font-bold">
                Recuperação
            </h2>

            <p class="text-gray-500 text-sm mt-2">
                Recupere o acesso à sua conta
            </p>

        </div>


        <!-- ========================================= -->
        <!-- INDICADOR DAS ETAPAS -->
        <!-- ========================================= -->

        <div class="flex items-center justify-center mt-6 mb-7">


            <!-- ETAPA 1 -->

            <div class="text-center">

                <div
                    id="step1Indicator"
                    class="rounded-full bg-blue-900 text-white flex items-center justify-center mx-auto"
                    style="width: 35px; height: 35px;">

                    1

                </div>

                <small
                    id="step1Text"
                    class="text-xs font-semibold">

                    E-mail

                </small>

            </div>


            <!-- LINHA -->

            <div
                class="mx-3"
                style="width: 60px;">

                <hr>

            </div>


            <!-- ETAPA 2 -->

            <div class="text-center">

                <div
                    id="step2Indicator"
                    class="rounded-full bg-gray-400 text-white flex items-center justify-center mx-auto"
                    style="width: 35px; height: 35px;">

                    2

                </div>

                <small
                    id="step2Text"
                    class="text-xs text-gray-400">

                    Código

                </small>

            </div>

        </div>


        <!-- ========================================= -->
        <!-- ETAPA 1 -->
        <!-- ========================================= -->

        <div id="step1">


            <h4 class="text-sm font-semibold mb-2">

                Digite seu E-mail

            </h4>


            <input
                class="input w-full border border-gray-300 rounded-md px-3 py-2 text-sm"
                type="email"
                name="email"
                id="email"
                placeholder="Digite seu e-mail"
                autocomplete="email"
                required>


            <p class="text-xs text-gray-500 mt-2">

                Enviaremos um código de recuperação para este e-mail.

            </p>


            <button
                type="button"
                id="btnEnviarCodigo"
                class="butao w-full bg-blue-900 hover:bg-blue-800 text-white rounded-lg mt-5 py-2 font-semibold">

                Enviar código

            </button>


        </div>


        <!-- ========================================= -->
        <!-- ETAPA 2 -->
        <!-- ========================================= -->

        <div
            id="step2"
            class="hidden">


            <h4 class="text-sm font-semibold mb-2">

                Digite o código

            </h4>


            <p class="text-xs text-gray-500 mb-4">

                Enviamos um código para o seu e-mail.

            </p>


            <input
                class="input w-full border border-gray-300 rounded-md px-3 py-2 text-sm text-center tracking-widest"
                type="text"
                name="codigo"
                id="codigo"
                placeholder="000000"
                maxlength="6"
                inputmode="numeric"
                autocomplete="one-time-code"
                required>


            <!-- MENSAGEM DE ERRO -->

            <div
                id="erroCodigo"
                class="hidden text-red-500 text-xs mt-2">

                Código inválido. Tente novamente.

            </div>


            <button
                type="button"
                id="btnConfirmarCodigo"
                class="butao w-full bg-blue-900 hover:bg-blue-800 text-white rounded-lg mt-5 py-2 font-semibold">

                Confirmar código

            </button>


            <button
                type="button"
                id="btnVoltar"
                class="w-full text-gray-500 hover:text-gray-700 text-sm mt-3">

                ← Voltar

            </button>


            <button
                type="button"
                id="btnReenviar"
                class="w-full text-blue-900 hover:text-blue-700 text-sm mt-2">

                Reenviar código

            </button>


        </div>


    </div>

</div>



<!-- ========================================= -->
<!-- JAVASCRIPT -->
<!-- ========================================= -->

<script>


/*
|--------------------------------------------------------------------------
| ELEMENTOS
|--------------------------------------------------------------------------
*/

const step1 =
    document.getElementById('step1');

const step2 =
    document.getElementById('step2');

const btnEnviarCodigo =
    document.getElementById('btnEnviarCodigo');

const btnConfirmarCodigo =
    document.getElementById('btnConfirmarCodigo');

const btnVoltar =
    document.getElementById('btnVoltar');

const btnReenviar =
    document.getElementById('btnReenviar');

const email =
    document.getElementById('email');

const codigo =
    document.getElementById('codigo');

const erroCodigo =
    document.getElementById('erroCodigo');

const step1Indicator =
    document.getElementById('step1Indicator');

const step2Indicator =
    document.getElementById('step2Indicator');

const step1Text =
    document.getElementById('step1Text');

const step2Text =
    document.getElementById('step2Text');


/*
|--------------------------------------------------------------------------
| IR PARA ETAPA 2
|--------------------------------------------------------------------------
*/

btnEnviarCodigo.addEventListener('click', function () {


    /*
    | Verifica se o e-mail foi preenchido
    */

    if (!email.value || !email.checkValidity()) {

        email.classList.add('border-red-500');

        email.focus();

        return;

    }


    email.classList.remove('border-red-500');


    /*
    | Esconde etapa 1
    */

    step1.classList.add('hidden');


    /*
    | Mostra etapa 2
    */

    step2.classList.remove('hidden');


    /*
    | Atualiza indicador
    */

    step1Indicator.classList.remove('bg-blue-900');

    step1Indicator.classList.add('bg-green-600');


    step2Indicator.classList.remove('bg-gray-400');

    step2Indicator.classList.add('bg-blue-900');


    /*
    | Atualiza textos
    */

    step1Text.classList.remove('font-semibold');

    step1Text.classList.add('text-gray-400');

    step2Text.classList.remove('text-gray-400');

    step2Text.classList.add('font-semibold');


    /*
    | Foca no código
    */

    codigo.focus();

});


/*
|--------------------------------------------------------------------------
| VOLTAR PARA ETAPA 1
|--------------------------------------------------------------------------
*/

btnVoltar.addEventListener('click', function () {


    step2.classList.add('hidden');

    step1.classList.remove('hidden');


    /*
    | Indicadores
    */

    step1Indicator.classList.remove('bg-green-600');

    step1Indicator.classList.add('bg-blue-900');


    step2Indicator.classList.remove('bg-blue-900');

    step2Indicator.classList.add('bg-gray-400');


    /*
    | Textos
    */

    step1Text.classList.add('font-semibold');

    step1Text.classList.remove('text-gray-400');


    step2Text.classList.add('text-gray-400');

    step2Text.classList.remove('font-semibold');


    email.focus();

});


/*
|--------------------------------------------------------------------------
| PERMITIR APENAS NÚMEROS NO CÓDIGO
|--------------------------------------------------------------------------
*/

codigo.addEventListener('input', function () {

    this.value = this.value
        .replace(/\D/g, '')
        .substring(0, 6);

});


/*
|--------------------------------------------------------------------------
| CONFIRMAR CÓDIGO
|--------------------------------------------------------------------------
*/

btnConfirmarCodigo.addEventListener('click', function () {


    if (codigo.value.length !== 6) {

        erroCodigo.textContent =
            'Digite o código de 6 números.';

        erroCodigo.classList.remove('hidden');

        codigo.focus();

        return;

    }


    /*
    | Aqui posteriormente vamos fazer
    | a validação do código no Laravel.
    */

    erroCodigo.classList.add('hidden');


    console.log(
        'E-mail:',
        email.value
    );

    console.log(
        'Código:',
        codigo.value
    );


    /*
    | Depois daqui podemos levar
    | o usuário para a etapa de
    | criação da nova senha.
    */

});


/*
|--------------------------------------------------------------------------
| REENVIAR CÓDIGO
|--------------------------------------------------------------------------
*/

btnReenviar.addEventListener('click', function () {

    /*
    | Posteriormente vamos conectar
    | isso ao Controller Laravel.
    */

    alert(
        'Um novo código será enviado para o seu e-mail.'
    );

});


</script>


</body>

</html>