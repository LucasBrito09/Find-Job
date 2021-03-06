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
                        <h3>Vaga</h3>
                        <div class="aside-select">
                            <ul>
                                <li><a href="<?= $_SESSION['USER_CURRICULO'] == true ? 'update_curriculo.php' : 'create_curriculo.php' ?>"><?= $_SESSION['USER_CURRICULO'] == true ? 'Atualizar curr??culo' : 'Cadastrar curr??culo' ?></a></li>
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
            <section class="container-square">
                <div class="container-vagaCrud">
                    <form action="PAGES/VAGA/cadastrar_vaga.php" method="post">
                        <div class="form-container">
                            <div class="container-vagaCrud-left">
                                <fieldset>
                                    <legend>Pa??s</legend>
                                    <input type="text" placeholder="Digite o nome do seu Pa??s" name="pais" id="pais">
                                    <span class="material-icons-sharp">room</span>
                                </fieldset>
                                <fieldset>
                                    <legend>Estado</legend>
                                    <input type="text" placeholder="Digite o nome do seu Estado" name="estado" id="estado">
                                    <span class="material-icons-sharp">room</span>
                                </fieldset>
                                <fieldset>
                                    <legend>Cidade</legend>
                                    <input type="text" placeholder="Digite o nome da sua Cidade" name="cidade" id="cidade">
                                    <span class="material-icons-sharp">room</span>
                                </fieldset>
                                <div class="fieldset-checkboxRadio">
                                    <legend>Tipo de contrato</legend>
                                    <div class="fieldset-checkboxRadio-div"><label for="freelance"><input type="checkbox" value="Freelance" name="tipoContrato" id="freelance"><span>Freelance</span></label></div>
                                    <div class="fieldset-checkboxRadio-div"><label for="full-time"><input type="checkbox" value="Full-time" name="tipoContrato" id="full-time"><span>Full-time</span></label></div>
                                    <div class="fieldset-checkboxRadio-div"><label for="internship"><input type="checkbox" value="Internship" name="tipoContrato" id="internship"><span>Internship</span></label></div>
                                    <div class="fieldset-checkboxRadio-div"><label for="part-time"><input type="checkbox" value="Part-time" name="tipoContrato" id="part-time"><span>Part-time</span></label></div>
                                </div>
                                <div class="fieldset-checkboxRadio">
                                    <legend>Level</legend>
                                    <div class="fieldset-checkboxRadio-div"><label for="junior"><input type="checkbox" name="nivel" value="junior" id="junior"><span>Junior</span></label></div>
                                    <div class="fieldset-checkboxRadio-div"><label for="pleno"><input type="checkbox" name="nivel" value="pleno" id="pleno"><span>Pleno</span></label></div>
                                    <div class="fieldset-checkboxRadio-div"><label for="senior"><input type="checkbox" name="nivel" value="Senior" id="senior"><span>Senior</span></label></div>
                                </div>
                                <div class="fieldset-checkboxRadio">
                                    <legend>Tipo</legend>
                                    <div class="fieldset-checkboxRadio-div"><label for="presencial"><input type="radio" name="formato" value="Presencial" id="presencial"><span>Presencial</span></label></div>
                                    <div class="fieldset-checkboxRadio-div"><label for="remoto"><input type="radio" name="formato" value="Remoto" id="remoto"><span>Remoto</span></label></div>
                                </div>
                            </div>
                            <div class="container-vagaCrud-right">
                                <fieldset>
                                    <legend>Titulo</legend>
                                    <input type="text" placeholder="Digite um Titulo para vaga" name="titulo" id="titulo">
                                </fieldset>
                                <fieldset>
                                    <legend>Nome da empresa</legend>
                                    <input type="text" placeholder="Digite o nome da sua empresa" name="empresa" id="empresa">
                                </fieldset>
                                <fieldset>
                                    <legend>Sal??rio</legend>
                                    <input type="number" placeholder="Digite qual valor voc?? deseja pagar" name="salario" id="salario">
                                </fieldset>
                                <fieldset>
                                    <legend>Descri????o da vaga</legend>
                                    <textarea placeholder="Adicione uma descri????o da vaga" name="descricao" id="descricao"></textarea>
                                </fieldset>
                            </div>
                        </div>
                        <button type="submit">POSTAR</button>
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
                    <input type="hidden" name="base_url" value="create_vaga.php">
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
                    <input type="hidden" name="base_url" value="create_vaga.php">
                    <div class="configuracao-btn">
                        <button type="submit">Editar</button>
                        <button class="configuracao-btn-close" type="button">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <?php if (isset($_SESSION['ERROR_REPORTING'])) { ?>
        <script>
            <?php
            if (!$_SESSION['ERROR_REPORTING']) { ?>
                swal("Muito bom!", "As informa????es foram modificadas com sucesso!", "success");
            <?php } else { ?>
                swal("Sinto muito!", "N??o conseguimos modificar as informa????es!", "error");
            <?php }
            unset($_SESSION['ERROR_REPORTING']);
            ?>
        </script>
    <?php } ?>
    <?php if (isset($_SESSION['VAGA_REPORTING'])) { ?>
        <script>
            <?php
            if (!$_SESSION['VAGA_REPORTING']) { ?>
                swal("Muito bom!", "Vaga cadastrada com sucesso!");
            <?php } else { ?>
                swal("Sinto muito!", "N??o conseguimos cadastrar esta vaga. Por favor, tente novamente!");
            <?php }
            unset($_SESSION['VAGA_REPORTING']);
            ?>
        </script>
    <?php } ?>
    <script src="./assets/JS/home.js"></script>
</body>

</html>