<?php
session_start();

echo "<pre>";
print_r($_POST);
echo "</pre>";


require_once("../../BD/conexao.php");

class UploadCurriculo extends Conexao
{
    private $name;
    private $full_path;
    private $type;
    private $tmp_name;
    private $error;
    private $size;
    private $id_vaga;
    private $id_user;


    public function __construct($files, $id_vaga, $id_user)
    {
        $this->name = $files['name'];
        $this->full_path = $files['full_path'];
        $this->type = $files['type'];
        $this->tmp_name = $files['tmp_name'];
        $this->error = $files['error'];
        $this->size = $files['size'];
        $this->id_vaga = $id_vaga;
        $this->id_user = $id_user;
    }

    public function upload()
    {
        if ($this->validationUserEqual()) {
            return false;
        }
        $banco = $this->iniciarConexao();
        $namefile = "FINDJOB-ID-" . strtoupper(uniqid()) . "." . pathinfo($this->name, PATHINFO_EXTENSION);
        $path = dirname(__DIR__, 2) . "/UPLOAD/curriculo/";
        $pathFile = $path . $namefile;
        if ($this->getType($this->type) and $this->getErro($this->error) and $this->getSize($this->size)) {
            if (move_uploaded_file($this->tmp_name,  $pathFile)) {
                $sqlInsert = "INSERT INTO curriculo (idVaga, idEnviou, path, fileName) VALUES ('{$this->id_vaga}','{$this->id_user}','{$namefile}','{$this->name}')";
                $resultado = $banco->query($sqlInsert);
                if ($resultado) {
                    return true;
                }
            }
        }
        return false;
    }
    public function getType($type)
    {
        if ($type == "image/jpeg" or $type == "image/jpg" or $type == "image/png" or $type == "image/webp") return true;

        return false;
    }
    public function validationUserEqual()
    {
        $banco = $this->iniciarConexao();
        $sql = "SELECT * FROM vaga WHERE idDono = '{$this->id_user}' AND id = '{$this->id_vaga}'";
        $resultado = $banco->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        if (count($resultado) > 0) {
            return true;
        }

        return false;
    }
    public function getErro($error)
    {
        if ($error == 0) return true;

        return false;
    }
    public function getSize($size)
    {
        if ($size <= 5000000) return true;

        return false;
    }
}

$upload = new UploadCurriculo($_FILES['imagem_curriculo'], $_POST['id_vaga'], $_SESSION['USER_ID']);
if ($upload->upload()) {
    $_SESSION['CURRICULO_REPORTING'] = false;
    header('Location: /home.php');
} else {
    $_SESSION['CURRICULO_REPORTING'] = true;
    header('Location: /upload.php?id=' . $_POST['id_vaga'] . '');
}
