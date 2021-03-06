<?php
session_start();

require_once("BD/conexao.php");
require_once('PAGES/AUTH/sessao.php');
require_once('PAGES/VAGA/listar_vaga.php');
require_once('PAGES/VAGA/pesquisa.php');

if (empty($_COOKIE['token']) or empty($_COOKIE['hash'])) {
    header("Location: index.php");
    exit();
} else {
    $sessao = new Sessao($_COOKIE['token'], $_COOKIE['hash']);
    if (!$sessao->validarSessao()) {
        header("Location: index.php");
    }
}

$vaga = new VagaListar('ultimas');
$ultimasVagasAdicionadas = $vaga->listar();
$vagaRandom = new VagaListar('random');
$randomVagasListar = $vagaRandom->listar();

$search = isset($_GET['search']) ? $_GET['search'] : false;
$searchConteudo = [];
if ($search) {
    $searchBuscar = new Pesquisa($search);
    $searchConteudo = $searchBuscar->mostrar();
}
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
                <a href="home.php" class="active">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>In??cio</h3>
                </a>
                <a href="history.php">
                    <span class="material-icons-sharp">article</span>
                    <h3>Hist??rico</h3>
                </a>
                <div class="aside-line"></div>
                <?php if ($_SESSION['USER_TIPO'] == 'candidato') { ?>
                    <div class="aside-select-a">
                        <span class="material-icons-sharp">work</span>
                        <h3>Curr??culo</h3>
                        <div class="aside-select">
                            <ul>
                                <li><a href="<?= $_SESSION['USER_CURRICULO'] == true?'update_curriculo.php':'create_curriculo.php' ?>"><?= $_SESSION['USER_CURRICULO'] == true?'Atualizar curr??culo':'Cadastrar curr??culo' ?></a></li>
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
                    <h3>Configura????es</h3>
                </div>
                <a href="/PAGES/AUTH/sair.php">
                    <span class="material-icons-sharp">logout</span>
                    <h3>Sair</h3>
                </a>
            </div>
        </aside>
        <main>
            <header>
                <form action="/home.php" method="get">
                    <input list="searchHistory" autocomplete="off" type="text" name="search" id="search" placeholder="Pesquisar vaga">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </form>
            </header>
            <section class="container-square">
                <?php if ($search) { ?>
                    <h2 class="container-titulo">Vagas relacionadas com a sua pesquisa</h2>
                    <div class="container-vagas">
                        <?php if (count($searchConteudo) > 0) { ?>
                            <?php foreach ($searchConteudo as $key => $valueSearch) {
                                $descricaoTotalCaractere = strlen($valueSearch['descricao']);
                                if ($descricaoTotalCaractere > 230) {
                                    $descricaoVagaSearch = '<p>' . substr($valueSearch['descricao'], 0, 230) . '... <span class="vaga-lermais" data-id="0">Ler mais</span></p>';
                                } else {
                                    $descricaoVagaSearch = '<p>' . $valueSearch['descricao'] . '</p>';
                                }
                                echo '<div class="vagas-conteudo">
                            <div class="vagas-conteudo-titulo">
                                <h2>' . $valueSearch['titulo'] . '</h2>
                                <h3>' . $valueSearch['forma_trabalho'] . '</h3>
                            </div>
                            <div class="vagas-conteudo-texto">
                                <p class="vaga-empresa">' . $valueSearch['empresa'] . '</p>
                                <p class="vaga-salario">' . number_format($valueSearch['salario'], 2, ",", ".")  . '</p>
                                <p class="vaga cidade">' . $valueSearch['cidade'] . '</p>
                                ' . $descricaoVagaSearch . '
                            </div>
                            <div class="vagas-conteudo-acoes">
                                <button class="vagas-acoes-btn-enviar"><a href="upload.php?id=' . $valueSearch['id'] . '">Enviar curr??culo</a></button>
                                <button class="vagas-acoes-btn-partilhar">
                                    <span class="material-icons-sharp">share</span>
                                    <span>Partilhar</span>
                                </button>
                            </div>
                        </div>
                   ';
                            }
                            ?>
                        <?php } else {
                            echo '<p class="container-vaga-paragrafo">N??o encontramos nenhuma vaga com as informa????es da sua pesquisa</p>';
                        } ?>
                    </div>

                <?php } ?>
                <h2 class="container-titulo">Sugest??es de vaga</h2>
                <div class="container-sugestao">
                    <?php
                    if ($randomVagasListar) {
                        foreach ($randomVagasListar as $vagaListarRandom) {
                            if (strlen($vagaListarRandom['titulo']) > 30) {
                                $tituloVaga = '<p>' . trim(substr($vagaListarRandom['titulo'], 0, 30)) . '...</p>';
                            } else {
                                $tituloVaga = '<p>' . $vagaListarRandom['titulo'] . '</p>';
                            }
                            echo ('<a href="vaga.php?id=' . $vagaListarRandom['id'] . '">
                        <div class="sugestao">
                            <div class="sugestao-titulo">
                                <h2>' . $tituloVaga . '</h2>
                            </div>
                            <div class="sugestao-descricao">
                                <p>' . $vagaListarRandom['forma_trabalho'] . '</p>
                                <p>R$ ' . number_format($vagaListarRandom['salario'], 2, ",", ".") . '</p>
                            </div>
                        </div>
                    </a>');
                        }
                    } else {
                        echo "<h2>Infelizmente ainda n??o temos nenhuma vaga cadastrada no nosso sistema</h2>";
                    }

                    ?>


                </div>
                <h2 class="container-titulo">??ltimas vagas adicionadas</h2>
                <div class="container-vagas">
                    <?php

                    if ($ultimasVagasAdicionadas) {
                        foreach ($ultimasVagasAdicionadas as $vagaListar) {
                            $descricaoTotalCaractere = strlen($vagaListar['descricao']);
                            if ($descricaoTotalCaractere > 230) {
                                $descricaoVaga = '<p>' . substr($vagaListar['descricao'], 0, 230) . '... <span class="vaga-lermais" data-id="0">Ler mais</span></p>';
                            } else {
                                $descricaoVaga = '<p>' . $vagaListar['descricao'] . '</p>';
                            }
                            echo ('<div class="vagas-conteudo">
                            <div class="vagas-conteudo-titulo">
                                <h2>' . $vagaListar['titulo'] . '</h2>
                                <h3>' . $vagaListar['forma_trabalho'] . '</h3>
                            </div>
                            <div class="vagas-conteudo-texto">
                                <p class="vaga-empresa">' . $vagaListar['empresa'] . '</p>
                                <p class="vaga-salario">R$ ' . number_format($vagaListar['salario'], 2, ",", ".") . '</p>
                                <p class="vaga cidade">' . $vagaListar['cidade'] . '-' . $vagaListar['estado'] . '</p>
                                ' . $descricaoVaga . '
                            </div>
                            <div class="vagas-conteudo-acoes">
                                <div>
                                    <button class="vagas-acoes-btn-enviar"><a href="upload.php?id=' . $vagaListar['id'] . '">Enviar curr??culo</a></button>
                                    <button class="vagas-acoes-btn-visualizarVaga"><a href="vaga.php?id=' . $vagaListar['id'] . '">Visualizar</a></button>
                                </div>
                                <button class="vagas-acoes-btn-partilhar">
                                    <span class="material-icons-sharp">share</span>
                                    <span class="partilharVagaEmprego" data-id="' . $vagaListar['id'] . '">Partilhar</span>
                                </button>
                            </div>
                        </div>');
                        }
                    } else {
                        echo "<h2>Infelizmente ainda n??o temos nenhuma vaga cadastrada no nosso sistema</h2>";
                    }
                    ?>
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
                        <p>Ol??, <b>Jo??o</b></p>
                        <small class="text-muted">Administrador</small>
                    </div>
                    <div class="profile-photo">
                        <img src="./assets/IMG/perfil.webp" alt="Foto do usu??rio" draggable="false" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="alerta-configuracao">
        <div class="configuracao">
            <h2 class="configuracao-titulo">Editar meus dados pessoais</h2>
            <div class="configuracao-diretorio">
                <button data-id="setting" class="config-setting configuracao-diretorio-btn configuracao-diretorio-btn-active">Configura????o</button>
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
                    <input type="hidden" name="base_url" value="home.php">
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
                    <input type="hidden" name="base_url" value="home.php">
                    <div class="configuracao-btn">
                        <button type="submit">Editar</button>
                        <button class="configuracao-btn-close" type="button">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <input type="text" name="linkvaga" id="linkvaga">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <?php if (isset($_SESSION['ERROR_REPORTING'])) { ?>
        <script>
            <?php
            if (!$_SESSION['ERROR_REPORTING']) { ?>
                swal("Muito bom!", "As informa????es foram modificadas com sucesso!");
            <?php } else { ?>
                swal("Sinto muito!", "N??o conseguimos modificar as informa????es!");
            <?php }
            unset($_SESSION['ERROR_REPORTING']);
            ?>
        </script>
    <?php } ?>
    <?php if (isset($_SESSION['CURRICULO_REPORTING'])) { ?>
        <script>
            <?php
            if (!$_SESSION['CURRICULO_REPORTING']) { ?>
                swal("Muito bom!", "Curr??culo enviado com sucesso!", "success");
            <?php } else { ?>
                swal("Sinto muito!", "N??o conseguimos enviar seu curr??culo!", "error");
            <?php }
            unset($_SESSION['CURRICULO_REPORTING']);
            ?>
        </script>
    <?php } ?>
    <script src="./assets/JS/home.js"></script>
</body>

</html>