<?php
class Conexao
{
    private $host = "localhost";
    private $nome_banco = 'findjob';
    private $usuario = "root";
    private $senha = "";

    public function iniciarConexao()
    {
        try {
            $conn = new PDO("mysql:host={$this->host};dbname={$this->nome_banco};charset=utf8", $this->usuario, $this->senha);
            return $conn;
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }
}
