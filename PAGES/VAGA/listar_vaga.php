<?php

class VagaListar extends Conexao
{
    public $acao;
    public function __construct($acao)
    {
        $this->acao = $acao;
    }
    public function listar()
    {
        $banco = $this->iniciarConexao();
        if ($this->acao == 'ultimas') {
            $query = "SELECT * FROM vaga ORDER BY id DESC LIMIT 8";
            $resultado = $banco->query($query)->fetchAll(PDO::FETCH_ASSOC);
            if (count($resultado) > 0) {
                return $resultado;
            }
        } else {
            $query = "SELECT * FROM vaga ORDER BY RAND() LIMIT 6";
            $resultado = $banco->query($query)->fetchAll(PDO::FETCH_ASSOC);
            if (count($resultado) > 0) {
                return $resultado;
            }
        }



        return false;
    }
    public function validarDados($dados)
    {
        return trim(addslashes(htmlspecialchars($dados)));
    }
}
