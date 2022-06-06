<?php
session_start();
require_once("../../BD/conexao.php");

class Delete extends Conexao
{
    public $idvaga;
    public function __construct($idvaga)
    {
        $this->idvaga = $idvaga;
    }
    public function delete()
    {
        $banco = $this->iniciarConexao();
        $query = "DELETE FROM vaga WHERE id = :idVaga AND idDono = :idDono";        
        $stmt = $banco->prepare($query);
        $stmt->bindValue(':idVaga', intval($this->validarDados($this->idvaga)));
        $stmt->bindValue(':idDono', $_SESSION['USER_ID']);
        if ($stmt->execute()) :
            return true;
        endif;

        return false;
    }
    public function validarDados($dados)
    {
        return trim(addslashes(htmlspecialchars($dados)));
    }
}
if (empty($_GET)) {
    $_SESSION['VAGA_DELETE_REPORTING'] = true;
    header("Location: ../../history.php?alerta=erro");
    exit();
} else {
    $vaga = new Delete($_GET['id']);
    if ($vaga->delete()) {
        $_SESSION['VAGA_DELETE_REPORTING'] = false;
        header("Location: ../../history.php");
    } else {
        $_SESSION['VAGA_DELETE_REPORTING'] = true;
        header("Location: ../../history.php?alerta=erro");
    }
}
