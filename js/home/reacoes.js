//pega o botão
const BTN_CADASTRARSE = document.querySelector(".hero_conteudo_btn_cadastrese");

//adiciona evento ao botão
BTN_CADASTRARSE.addEventListener("click", function() {
    // remove classes tailwind
    BTN_CADASTRARSE.classList.remove("bg-transparent", "hover:bg-azul/15");
    // adciona classes tailwind
    BTN_CADASTRARSE.classList.add("bg-amarelo", "hover:bg-amarelo");

    const TELA_CADASTRO = BTN_CADASTRARSE.getAttribute("data-url");

    setTimeout(function() {
            window.location.href = TELA_CADASTRO;
        }, 50
    );
    
});

const BTN_ENTRAR_HEADER = document.querySelector(".header_btn_entrar");;

BTN_ENTRAR_HEADER.addEventListener("click", function() {

    BTN_ENTRAR_HEADER.classList.remove("bg-branco", "hover:bg-azul", "hover:text-branco");

    BTN_ENTRAR_HEADER.classList.add("bg-amarelo", "hover:bg-amarelo");

    const TELA_LOGIN = BTN_ENTRAR_HEADER.getAttribute("login-url");

    setTimeout(function() {
            window.location.href = TELA_LOGIN;
        }, 50
    );
});

const BTN_ENTRAR_HERO = document.querySelector(".hero_conteudo_btn_entrar");

BTN_ENTRAR_HERO.addEventListener("click", function() {

    BTN_ENTRAR_HERO.classList.remove("bg-branco", "hover:bg-azul");

    BTN_ENTRAR_HERO.classList.add("bg-amarelo", "hover:bg-amarelo");

    const TELA_LOGIN = BTN_ENTRAR_HERO.getAttribute("login-url");

    setTimeout(function() {
            window.location.href = TELA_LOGIN;
        }, 50
    );
});