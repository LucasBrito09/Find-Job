<?php
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
    <title>Cadastro - FindJob</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="./assets/IMG/logo-favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="./assets/CSS/acesso.css">
</head>

<body>
    <main>
        <button id="btn-voltar"><a href="index.php"><i class="fa-solid fa-arrow-left"></i><span>Voltar para tela
                    inicial</span></a></button>
        <div class="container">
            <p>Estamos felizes que você resolveu entrar no time</p>
            <h2>Criar uma conta</h2>
            <form action="PAGES/AUTH/cadastro.php" method="post">
                <?php if (@$_GET['alerta'] == "erro") : ?>
                    <fieldset class="erro">
                        <p>Não conseguimos te cadastrar em nosso sistema. Por favor, tente novamente</p>
                    </fieldset>
                <?php endif; ?>
                <fieldset>
                    <legend>Nome</legend>
                    <input type="text" name="nome" id="nome" placeholder="Informe seu nome">
                </fieldset>
                <fieldset>
                    <legend>E-mail</legend>
                    <input type="text" name="email" id="email" placeholder="Informe seu e-mail">
                </fieldset>
                <fieldset>
                    <legend>Digite uma senha</legend>
                    <input type="password" name="senha" id="senha" placeholder="Informe uma senha">
                </fieldset>
                <fieldset>
                    <legend>Confirme sua senha</legend>
                    <input type="password" name="senha-confirm" id="senha-confirm" placeholder="Confirme sua senha">
                </fieldset>
                <fieldset>
                    <button>Cadastre-se</button>
                </fieldset>
                <fieldset>
                    <p>Já tem um conta? <a href="login.php">Faça o login</a></p>
                </fieldset>
            </form>
        </div>
    </main>
</body>

</html>