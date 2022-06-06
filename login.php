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
    <title>Login - FindJob</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./assets/CSS/acesso.css">
</head>
<body>
    <main>
        <button id="btn-voltar"><a href="index.php"><i class="fa-solid fa-arrow-left"></i><span>Voltar para tela inicial</span></a></button>
        <div class="container">
            <p>Bem-vindo de volta!</p>
            <h2>Entrar em sua conta</h2>
            <form action="PAGES/AUTH/login.php" method="post">
                <?php if (@$_GET['alerta'] == "sucesso") : ?>
                    <fieldset class="sucesso">
                        <p>Conta criada com sucesso, faça seu login</p>
                    </fieldset>
                <?php endif; ?>
                <?php if (@$_GET['alerta'] == "erro") : ?>
                    <fieldset class="erro">
                        <p>Não encontramos nenhuma conta com essas informações</p>
                    </fieldset>
                <?php endif; ?>
                <fieldset>
                    <legend>E-mail</legend>
                    <input type="text" name="email" id="email" placeholder="Digite seu e-mail">
                </fieldset>
                <fieldset>
                    <legend>Senha</legend>
                    <input type="password" name="senha" id="senha" placeholder="Digite sua senha">
                </fieldset>
                <fieldset class="d-flex"></fieldset>
                <fieldset>
                    <button>Entrar</button>
                </fieldset>
                <fieldset>
                    <p>Não tem um conta? <a href="cadastro.php">Cadastre agora mesmo</a></p>
                </fieldset>
            </form>
        </div>
    </main>
</body>

</html>