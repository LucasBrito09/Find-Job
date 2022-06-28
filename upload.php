<?php
session_start();
require_once("BD/conexao.php");
require_once('PAGES/AUTH/sessao.php');
if (empty($_COOKIE['token']) or empty($_COOKIE['hash'])) {
    header("Location: index.php");
    exit();
} else {
    $sessao = new Sessao($_COOKIE['token'], $_COOKIE['hash']);
    if (!$sessao->validarSessao()) {
        header("Location: index.php");
    }
}
$idVaga = isset($_GET['id']) ? $_GET['id'] : '';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FindJob - Sua vaga garantida</title>
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/IMG/FAVICON/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/IMG/FAVICON/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/IMG/FAVICON/favicon-16x16.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="./assets/IMG/logo-favicon.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/assets/CSS/home.css" />
</head>

<body>
    <div class="container">

        <aside class="aside-menu">
            <div class="top">
                <div class="logo">
                    <img draggable="false" src="./assets/IMG/logo.png" />
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">menu</span>
                </div>
            </div>

            <div class="sidebar">
                <form action="#" method="get">
                    <input type="text" placeholder="Pesquisar" name="pesquisar" id="pesquisarVaga">
                    <button><span class="material-icons-sharp">search</span></button>
                </form>
                <a href="home.php">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Início</h3>
                </a>
                <a href="history.php">
                    <span class="material-icons-sharp">article</span>
                    <h3>Histórico</h3>
                </a>
                <div class="aside-line"></div>
                <?php if ($_SESSION['USER_TIPO'] == 'candidato') { ?>
                    <div class="aside-select-a">
                        <span class="material-icons-sharp">work</span>
                        <h3>Vaga</h3>
                        <div class="aside-select">
                            <ul>
                                <li><a href="<?= $_SESSION['USER_CURRICULO'] == true ? 'update_curriculo.php' : 'create_curriculo.php' ?>"><?= $_SESSION['USER_CURRICULO'] == true ? 'Atualizar currículo' : 'Cadastrar currículo' ?></a></li>
                            </ul>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="aside-select-a">
                        <span class="material-icons-sharp">work</span>
                        <h3>Empresa</h3>
                        <div class="aside-select">
                            <ul>
                                <li><a href="create_vaga.php">Cadastrar vaga</a></li>
                                <li><a href="recebidos.php">Curriculos recebidos</a></li>
                            </ul>
                        </div>
                    </div>

                    <a href="profissionais.php">
                        <span class="material-icons-sharp">assignment</span>
                        <h3>Encontrar profissionais</h3>
                    </a>
                <?php } ?>

                <div class="aside-line"></div>
                <div class="aside-select-a open-setting">
                    <span class="material-icons-sharp">settings</span>
                    <h3>Configurações</h3>
                </div>
                <a href="/PAGES/AUTH/sair.php">
                    <span class="material-icons-sharp">logout</span>
                    <h3>Sair</h3>
                </a>
            </div>
        </aside>
        <!------------------ END OF ASIDE ------------------>
        <main>
            <header>
                <form action="/home.php" method="get">
                    <input list="searchHistory" autocomplete="off" type="text" name="search" id="search" placeholder="Pesquisar vaga">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </form>
                <datalist id="searchHistory">
                    <option value="Diarista">
                    <option value="Desenvolvedor Web">
                    <option value="Mecânico">
                    <option value="Cozinheira">
                    <option value="Garçom">
                </datalist>
            </header>
            <section class="container-square">
                <h2 class="container-titulo">Faça upload do seu currículo</h2>
                <div class="container-upload">
                    <form action="PAGES/VAGA/enviar_curriculo.php" method="post" class="drag-area" enctype="multipart/form-data">
                        <label class="upload-arquivos" for="imagem_curriculo">
                            <div class="arquivos-container">
                                <span class="material-icons-sharp">cloud_upload</span>
                                <h2 class="drag-area-h2">Selecione o arquivo ou arraste e solte</h2>
                                <p>JPG, JPEG, WEBP ou PNG, tamanho máximo do arquivo é de 20MB</p>
                                <label class="drag-area-btn">Selecionar arquivo</label>
                            </div>
                            <input type="file" name="imagem_curriculo" id="imagem_curriculo" accept="image/png, image/jpeg, image/jpg, image/webp, image/pdf">
                            <input type="hidden" value="<?= $idVaga ?>" name="id_vaga">
                        </label>
                        <div class="upload-arquivos-add">
                            <h2>Arquivos adicionados</h2>
                            <div class="upload-arquivos-add-criados"></div>
                        </div>
                        <button class="enviar-curriculo-btn">ENVIAR</button>
                    </form>
                </div>
            </section>
        </main>
        <div class="right">
            <div class="top">
                <button id="menu-btn">
                    <span class="material-icons-sharp">menu</span>
                </button>
                <div class="menu-logo">
                    <img draggable="false" src="./assets/IMG/logo.png" />
                </div>
                <div class="profile">
                    <div class="info">
                        <p>Olá, <b>João</b></p>
                        <small class="text-muted">Administrador</small>
                    </div>
                    <div class="profile-photo">
                        <img src="./assets/IMG/perfil.webp" alt="Foto do usuário" draggable="false" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="alerta-configuracao">
        <div class="configuracao">
            <h2 class="configuracao-titulo">Editar meus dados pessoais</h2>
            <div class="configuracao-diretorio">
                <button data-id="setting" class="config-setting configuracao-diretorio-btn configuracao-diretorio-btn-active">Configuração</button>
                <button data-id="password" class="config-password configuracao-diretorio-btn">Mudar Senha</button>
            </div>
            <div class="configuracao-container">
                <form action="/PAGES/SETTINGS/modificar_informacoes.php" method="post" class="configuracao-form configuracao-setting configuracao-form-active">
                    <div class="configuracao-conteudo">
                        <fieldset>
                            <legend>Nome</legend>
                            <input type="text" name="nome" id="nome" value="<?= $_SESSION['USER_NOME'] ?>" placeholder="Digite seu nome">
                        </fieldset>
                        <fieldset>
                            <legend>E-mail</legend>
                            <input type="email" name="email" id="email" value="<?= $_SESSION['USER_EMAIL'] ?>" placeholder="Digite seu e-mail">
                        </fieldset>
                    </div>
                    <input type="hidden" name="base_url" value="upload.php">
                    <div class="configuracao-btn">
                        <button type="submit">Editar</button>
                        <button class="configuracao-btn-close" type="button">Cancelar</button>
                    </div>
                </form>
                <form action="/PAGES/SETTINGS/modificar_senha.php" method="post" class="configuracao-form configuracao-password">
                    <div class="configuracao-conteudo">
                        <fieldset>
                            <legend>Senha Atual</legend>
                            <input type="text" name="senha" id="senha" placeholder="Digite sua senha atual">
                        </fieldset>
                        <fieldset>
                            <legend>Nova Senha</legend>
                            <input type="text" name="senhaNew" id="senhaNew" placeholder="Digite sua nova senha">
                        </fieldset>
                    </div>
                    <input type="hidden" name="base_url" value="upload.php">
                    <div class="configuracao-btn">
                        <button type="submit">Editar</button>
                        <button class="configuracao-btn-close" type="button">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="./assets/JS/home.js"></script>
    <script src="./assets/JS/upload.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <?php if (isset($_SESSION['CURRICULO_REPORTING'])) { ?>
        <script>
            <?php
            if ($_SESSION['CURRICULO_REPORTING']) { ?>
                swal("Sinto muito!", "Você não pode enviar currículo para esta vaga. \n Motivo: Esta vaga pertence a você", "error");
            <?php } else { ?>
                swal("Muito bem!", "Currículo enviado com sucesso!");
            <?php }
            unset($_SESSION['CURRICULO_REPORTING']);
            ?>
        </script>
    <?php } ?>
    <?php if (isset($_SESSION['ERROR_REPORTING'])) { ?>
        <script>
            <?php
            if (!$_SESSION['ERROR_REPORTING']) { ?>
                swal("Muito bom!", "As informações foram modificadas com sucesso!", "success");
            <?php } else { ?>
                swal("Sinto muito!", "Não conseguimos modificar as informações!", "error");
            <?php }
            unset($_SESSION['ERROR_REPORTING']);
            ?>
        </script>
    <?php } ?>
</body>

</html>