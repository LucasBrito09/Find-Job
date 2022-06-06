<?php
session_start();
require_once("../../BD/conexao.php");

class MudarInformacoes extends Conexao
{
    public $nome;
    public $email;
    public $id;

    public function __construct(array $dados, int $id)
    {
        $this->nome = $dados['nome'];
        $this->email = $dados['email'];
        $this->id = $id;
    }
    public function mudar()
    {
        $banco = $this->iniciarConexao();
        $nome = $this->validarDados($this->nome);
        $email = $this->validarDados($this->email);

        $sql = "UPDATE Usuario SET nome = '{$nome}', email = '{$email}' WHERE id = '{$this->id}'";
        $resultado = $banco->query($sql);
        return $resultado;
    }
    public function validarDados($dados)
    {
        return trim(addslashes(htmlspecialchars($dados)));
    }
}

$base_url = isset($_POST['base_url']) ? $_POST['base_url'] : 'home.php';

if (empty($_POST['nome']) or empty($_POST['email'])) {
    $_SESSION['ERROR_REPORTING'] = true;
    header("Location: ../../{$base_url}?alerta=erro");
    exit();
} else {
    $dadosUser = new MudarInformacoes($_POST, $_SESSION['USER_ID']);
    if ($dadosUser->mudar()) {
        $_SESSION['ERROR_REPORTING'] = false;
        header("Location: ../../{$base_url}");
    } else {
        $_SESSION['ERROR_REPORTING'] = true;
        header("Location: ../../{$base_url}?alerta=erro");
    }
}
