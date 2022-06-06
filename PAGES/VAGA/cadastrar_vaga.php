<?php
session_start();
require_once("../../BD/conexao.php");

class VagaCadastrar extends Conexao
{
    public $dados;
    public function __construct($dados)
    {
        $this->dados = $dados;
    }
    public function cadastrar()
    {
        $banco = $this->iniciarConexao();

        if (
            $this->validarDadosVazios($this->dados['titulo']) or
            $this->validarDadosVazios($this->dados['empresa']) or
            $this->validarDadosVazios($this->dados['salario']) or
            $this->validarDadosVazios($this->dados['descricao']) or
            $this->validarDadosVazios($this->dados['pais']) or
            $this->validarDadosVazios($this->dados['estado']) or
            $this->validarDadosVazios($this->dados['cidade']) or
            $this->validarDadosVazios($this->dados['tipoContrato']) or
            $this->validarDadosVazios($this->dados['nivel']) or
            $this->validarDadosVazios($this->dados['formato'])
        ) {
            return false;
        }
        $query = "INSERT INTO vaga (idDono, titulo, empresa, salario, descricao, pais, estado, cidade, tipo_contrato, nivel, forma_trabalho)
        VALUES (:idDono, :titulo, :empresa, :salario, :descricao, :pais, :estado, :cidade, :tipo_contrato, :nivel, :forma_trabalho)";
        $stmt = $banco->prepare($query);
        $stmt->bindValue(':idDono', $_SESSION['USER_ID']);
        $stmt->bindValue(':titulo', $this->validarDados($this->dados['titulo']));
        $stmt->bindValue(':empresa', $this->validarDados($this->dados['empresa']));
        $stmt->bindValue(':salario', $this->validarDados($this->dados['salario']));
        $stmt->bindValue(':descricao', $this->validarDados($this->dados['descricao']));
        $stmt->bindValue(':pais', $this->validarDados($this->dados['pais']));
        $stmt->bindValue(':estado', $this->validarDados($this->dados['estado']));
        $stmt->bindValue(':cidade', $this->validarDados($this->dados['cidade']));
        $stmt->bindValue(':tipo_contrato', $this->validarDados($this->dados['tipoContrato']));
        $stmt->bindValue(':nivel', $this->validarDados($this->dados['nivel']));
        $stmt->bindValue(':forma_trabalho', $this->validarDados($this->dados['formato']));
        if ($stmt->execute()) :
            return true;
        endif;

        return false;
    }
    public function validarDados($dados)
    {
        return trim(addslashes(htmlspecialchars($dados)));
    }
    public function validarDadosVazios($dados)
    {
        if (empty($dados)) {
            return true;
        }
        return false;
    }
}
if (empty($_POST)) {
    $_SESSION['VAGA_REPORTING'] = true;
    header("Location: ../../create_vaga.php?alerta=erro");
    exit();
} else {
    $vaga = new VagaCadastrar($_POST);
    if ($vaga->cadastrar()) {
        $_SESSION['VAGA_REPORTING'] = false;
        header("Location: ../../create_vaga.php");
    } else {
        $_SESSION['VAGA_REPORTING'] = true;
        header("Location: ../../create_vaga.php?alerta=erro");
    }
}
