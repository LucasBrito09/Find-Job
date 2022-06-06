<?php
class Sessao extends Conexao
{
    public $token;
    public $hash;
    public function __construct($token, $hash)
    {
        $this->token = $token;
        $this->hash = $hash;
    }
    public function validarSessao()
    {

        $banco = $this->iniciarConexao();

        $sqlSelect = "SELECT * FROM Usuario";
        $resultado = $banco->query($sqlSelect)->fetchAll(PDO::FETCH_ASSOC);

        foreach ($resultado as $value) {
            if(password_verify($value['id'], $this->token) AND password_verify($value['hash'], $this->hash)){
                $_SESSION['USER_ID'] = $value['id'];
                $_SESSION['USER_NOME'] = $value['nome'];
                $_SESSION['USER_EMAIL'] = $value['email'];
                return true;
                break;
            }
        }
        return false;
    }
}
