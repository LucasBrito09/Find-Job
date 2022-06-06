<?php
session_start();
require_once("../../BD/conexao.php");

class MudarSenha extends Conexao
{
    public $senha;
    public $senhaNew;
    public $id;

    public function __construct(array $dados, int $id)
    {
        $this->senha = $dados['senha'];
        $this->senhaNew = $dados['senhaNew'];
        $this->id = $id;
    }
    public function mudar()
    {
        $banco = $this->iniciarConexao();
        $senha = $this->validarDados($this->senha);
        $senhaNew = $this->validarDados($this->senhaNew);
        
        if($this->validationUserPassword($senha)){
            $senhaNew = password_hash($senhaNew, PASSWORD_DEFAULT);
            $sql = "UPDATE Usuario SET senha = '{$senhaNew}' WHERE id = '{$this->id}'";
            $banco->query($sql);
            return true;
        }

        return false;
    }
    public function validationUserPassword($senha){
        $banco = $this->iniciarConexao();
        $sql = "SELECT * FROM Usuario WHERE id = '{$this->id}'";
        $resultado = $banco->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($resultado as $value){
            if(password_verify($senha, $value['senha'])){
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

$base_url = isset($_POST['base_url']) ? $_POST['base_url'] : 'home.php';

if (empty($_POST['senha']) or empty($_POST['senhaNew'])) {
    $_SESSION['ERROR_REPORTING'] = true;
    header("Location: ../../{$base_url}?alerta=error");
    exit();
} else {
    $dadosUser = new MudarSenha($_POST, $_SESSION['USER_ID']);
    if ($dadosUser->mudar()) {
        $_SESSION['ERROR_REPORTING'] = false;
        header("Location: ../../{$base_url}?alerta=success");
    } else {
        $_SESSION['ERROR_REPORTING'] = true;
        header("Location: ../../{$base_url}?alerta=error");
    }
}
