<?php
require_once("../../BD/conexao.php");

class Cadastro extends Conexao
{
    public $nome;
    public $email;
    public $senha;
    public $senhaConfirmar;
    public function __construct(array $dados)
    {
        $this->nome = $dados['nome'];
        $this->email = $dados['email'];
        $this->senha = $dados['senha'];
        $this->senhaConfirmar = $dados['senha-confirm'];
    }
    public function validarCadastro()
    {
        $banco = $this->iniciarConexao();
        $this->nome = $this->validarDados($this->nome);
        $this->email = $this->validarDados($this->email);
        $this->senha = $this->validarDados($this->senha);
        $this->senhaConfirmar = $this->validarDados($this->senhaConfirmar);

        $sqlSelect = "SELECT * FROM Usuario WHERE email = '$this->email'";

        $resultado = $banco->query($sqlSelect)->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($resultado)) {
            return false;
        }
        if ($this->senha == $this->senhaConfirmar) {
            $senha = password_hash($this->senha, PASSWORD_DEFAULT);
            $sqlInsert = "INSERT INTO Usuario (nome, email, senha) VALUES ('$this->nome', '$this->email', '$senha')";
            $resultado = $banco->query($sqlInsert);
            if ($resultado) {
                return true;
            }
        }
        return false;
    }
    public function validarDados($dados)
    {
        return trim(addslashes(htmlspecialchars($dados)));
    }
}


if (empty($_POST['nome']) or empty($_POST['email']) or empty($_POST['senha']) or empty($_POST['senha-confirm'])) {
    header("Location: ../../cadastro.php?alerta=erro");
    exit();
} else {
    $cadastro = new Cadastro(array("nome" => $_POST['nome'], "email" =>  $_POST['email'], "senha" =>  $_POST['senha'], "senha-confirm" =>  $_POST['senha-confirm']));
    if ($cadastro->validarCadastro()) {
        header("Location: ../../login.php?alerta=sucesso");
    } else {
        header("Location: ../../cadastro.php?alerta=erro");
    }
}
