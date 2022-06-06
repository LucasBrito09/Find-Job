<?php

class Pesquisa extends Conexao
{
    public $conteudo;
    public function __construct($conteudo)
    {
        $this->conteudo = $this->validarDados($conteudo);
    }
    public function mostrar()
    {
        $banco = $this->iniciarConexao();

        $query = "SELECT * FROM vaga WHERE titulo LIKE '%{$this->conteudo}%' OR descricao LIKE '%{$this->conteudo}%' ORDER BY id DESC LIMIT 10";
        $stmt = $banco->prepare($query);
        if ($stmt->execute()) :
            $conteudo = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $conteudo;
        endif;

        return false;
    }
    public function validarDados($dados)
    {
        return trim(addslashes(htmlspecialchars($dados)));
    }
}
