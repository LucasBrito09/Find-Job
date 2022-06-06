<?php

class VagaListarEditar extends Conexao
{
    public function listar($idVaga, $idDono)
    {
        $banco = $this->iniciarConexao();
        $query = "SELECT * FROM vaga WHERE id = '$idVaga' AND idDono = '$idDono'";
        $resultado = $banco->query($query)->fetchAll(PDO::FETCH_ASSOC);
        if (count($resultado) > 0) {
            return $resultado;
        }
        return false;
    }
}
