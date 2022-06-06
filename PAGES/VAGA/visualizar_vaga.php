<?php

class Visualizar extends Conexao
{
    public function listar($idVaga)
    {
        $banco = $this->iniciarConexao();
        $query = "SELECT * FROM vaga WHERE id = '$idVaga'";
        $resultado = $banco->query($query)->fetchAll(PDO::FETCH_ASSOC);
        if (count($resultado) > 0) {
            return $resultado;
        }
        return false;
    }
}
