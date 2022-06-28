<?php
class Curriculo extends Conexao
{
    public function listar()
    {
        $banco = $this->iniciarConexao();
        $id_user = $_SESSION['USER_ID'];
        $query = "SELECT c.id, c.idVaga, c.idEnviou, c.path, c.fileName, v.titulo  FROM curriculo c INNER JOIN vaga v ON c.idVaga = v.id WHERE v.idDono = '{$id_user}'";
        $resultado = $banco->query($query)->fetchAll(PDO::FETCH_ASSOC);
        if (count($resultado) > 0) {
            return $resultado;
        }
        return false;
    }
    public function listarPerson($listarPag = null, $pesquisa = null)
    {
        if ($listarPag == null) {
            $banco = $this->iniciarConexao();
            $query = "SELECT * FROM curriculo c INNER JOIN usuario u ON c.idEnviou = u.id WHERE c.path = '0'";
            if(!empty($pesquisa)){
                $query .= " AND c.cargo_experiencia LIKE '%{$pesquisa}%' OR c.cidade LIKE '%{$pesquisa}%' OR c.level_ingles LIKE '%{$pesquisa}%' OR c.level_espanhol LIKE '%{$pesquisa}%' OR c.formacao LIKE '%{$pesquisa}%' OR c.experiencia LIKE '%{$pesquisa}%' OR c.apresentacao LIKE '%{$pesquisa}%'";
            }
            $resultado = $banco->query($query)->fetchAll(PDO::FETCH_ASSOC);
            if (count($resultado) > 0) {
                return $resultado;
            }
            return [];
        } else {
            $banco = $this->iniciarConexao();
            $query = "SELECT * FROM curriculo c INNER JOIN usuario u ON c.idEnviou = u.id WHERE u.id = '$listarPag' AND c.path = '0'";
            $resultado = $banco->query($query)->fetchAll(PDO::FETCH_ASSOC);
            if (count($resultado) > 0) {
                return $resultado[0];
            }
            return [];
        }
    }
    public function getUserCurriculo($id)
    {
        $banco = $this->iniciarConexao();

        $query = "SELECT * FROM usuario WHERE id = {$id}";
        $resultado = $banco->query($query)->fetchAll(PDO::FETCH_ASSOC);
        if (count($resultado) > 0) {
            return $resultado[0];
        }
        return false;
    }

    public function FileSizeConvert($bytes)
    {
        $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );
        $result = '';
        foreach ($arBytes as $arItem) {
            if ($bytes >= $arItem["VALUE"]) {
                $result = $bytes / $arItem["VALUE"];
                $result = str_replace(".", ",", strval(round($result, 2))) . " " . $arItem["UNIT"];
                break;
            }
        }
        return $result;
    }
}
