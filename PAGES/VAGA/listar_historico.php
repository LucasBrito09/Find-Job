<?php
class Historico extends Conexao
{
    public function listar($acao, $id)
    {
        $banco = $this->iniciarConexao();
        if ($acao == 'vaga') {
            $query = "SELECT * FROM vaga WHERE idDono = '$id' ORDER BY id DESC";
            $resultado = $banco->query($query)->fetchAll(PDO::FETCH_ASSOC);
            if (count($resultado) > 0) {
                return $resultado;
            }
            return [];
        } else {
            $query = "SELECT c.id, c.idVaga, c.idEnviou, c.path, c.fileName, v.titulo, v.descricao, v.empresa, v.estado, v.cidade, v.forma_trabalho FROM curriculo c INNER JOIN vaga v ON c.idVaga = v.id WHERE c.idEnviou = '{$id}' ORDER BY id DESC";
            $resultado = $banco->query($query)->fetchAll(PDO::FETCH_ASSOC);
            if (count($resultado) > 0) {
                return $resultado;
            }
            return [];
        }



        return false;
    }
}
