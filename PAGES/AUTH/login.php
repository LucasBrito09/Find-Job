<?php
require_once("../../BD/conexao.php");

class Login extends Conexao
{
    public $email;
    public $senha;
    public function __construct($email, $senha)
    {
        $this->email = $email;
        $this->senha = $senha;
    }
    public function validarLogin()
    {
        $banco = $this->iniciarConexao();
        $email = $this->validarDados($this->email);
        $senha = $this->validarDados($this->senha);
        $hash = rand(1, 1000);

        $sqlSelect = "SELECT * FROM Usuario";
        $resultado = $banco->query($sqlSelect)->fetchAll(PDO::FETCH_ASSOC);

        foreach ($resultado as $value) {
            if ($email == $value['email'] and password_verify($senha, $value['senha'])) {
                $sql = "UPDATE Usuario SET hash = '{$hash}' WHERE email = '{$email}'";
                if ($banco->query($sql)) {
                    $id_token = password_hash($value['id'], PASSWORD_DEFAULT);
                    $hash_token = password_hash($hash, PASSWORD_DEFAULT);

                    setcookie("token", "$id_token", time() + 3600 * 60 * 60 * 60, "/");
                    setcookie("hash", "$hash_token", time() + 3600 * 60 * 60 * 60, "/");
                    return true;
                }
                break;
            }
        }
        return false;
    }
    public function validarDados($dados)
    {
        return trim(addslashes(htmlspecialchars($dados)));
    }
}


if (empty($_POST['email']) or empty($_POST['senha'])) {
    header("Location: ../../login.php?alerta=erro");
    exit();
} else {
    $login = new Login($_POST['email'], $_POST['senha']);
    if ($login->validarLogin()) {
        header("Location: ../../home.php");
    } else {
        header("Location: ../../login.php?alerta=erro");
    }
}
