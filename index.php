<?php
session_start();
require_once("BD/conexao.php");
require_once('PAGES/AUTH/sessao.php');
if (!empty($_COOKIE['token']) or !empty($_COOKIE['hash'])) {
    $sessao = new Sessao($_COOKIE['token'], $_COOKIE['hash']);
    if ($sessao->validarSessao()) {
        header("Location: home.php");
    }
} 
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Job - Encontre sua vaga de emprego</title>
    <link rel="shortcut icon" href="./assets/IMG/logo-favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/CSS/style.css">
</head>
<body>
    <section id="banner">
        <header>
            <div class="header-container">
                <div class="header-logo">
                    <img draggable="false" src="./assets/IMG/logo.png" alt="logo find job">
                </div>
                <div class="header-btn">
                    <a href="login.php"><button class="header-btn-entrar">Entrar</button></a>
                    <a href="cadastro.php"><button class="header-btn-cadastrar">Cadastrar</button></a>
                </div>
            </div>
        </header>
        <div class="banner-conteudo">
            <div class="banner-conteudo-imagem">
                <img draggable="false" src="./assets/IMG/bg-index-2.png" alt="foto para banner">
            </div>
            <div class="banner-conteudo-texto">
                <h2>As melhores vagas
                    de emprego para você</h2>
                <p>O Find Job é eficiente para profissionais e para empresas, tanto para divulgação de vagas, quanto
                    para contratação.</p>
                <a href="cadastro.php"><button>Cadastre-se</button></a>
            </div>
        </div>
    </section>
    <section id="sobrenos">
        <div class="sobrenos-container">
            <div class="sobrenos-texto">
                <h2>Etapas para conquistar sua vaga</h2>
                <p>O Find Job é um site no qual pessoas desempregadas ou donos de empresas/estabelecimentos, 
                    irão se cadastrar para acompanhar e fazer publicações. Os donos dos estabelecimentos irão 
                    divulgar em qual área estão precisando de pessoas e os interessados irão entrar em contato 
                    pelo chat do site. Já os que estão à procura de emprego poderão postar seu currículo no 
                    site, para que, assim, donos de empresas/estabelecimentos interessados possam entrar em 
                    contato pelo chat do site ou pelo contato fornecido no currículo.</p>
            </div>
            <div class="sobrenos-imagem">
                <img src="./assets/IMG/about-img.png" alt="sobre nos find job">
            </div>
        </div>
    </section>
    <section id="mensagem">
        <div class="mensagem-container">
            <div class="mensagem-texto">
                <h2>Tem uma vaga esperando por você</h2>
            </div>
        </div>
    </section>
</body>

</html>