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
    private $cargo_experiencia;
    private $cidade;
    private $ingles;
    private $espanhol;
    private $formacao;
    private $telefone;
    private $genero;
    private $salario;
    private $experiencia;
    private $apresentacao;


    public function __construct($files, $id_vaga, $id_user, $dados)
    {

        $this->id_vaga = $id_vaga;
        $this->id_user = $id_user;

        if ($files['size'] > 0) {
            $this->name = $files['name'];
            $this->full_path = $files['full_path'];
            $this->type = $files['type'];
            $this->tmp_name = $files['tmp_name'];
            $this->error = $files['error'];
            $this->size = $files['size'];
        } else {
            $this->cargo_experiencia = $dados['cargo_experiencia'];
            $this->cidade = $dados['cidade'];
            $this->ingles = $dados['ingles'];
            $this->espanhol = $dados['espanhol'];
            $this->formacao = $dados['formacao'];
            $this->telefone = $dados['telefone'];
            $this->genero = $dados['genero'];
            $this->salario = $dados['salario'];
            $this->experiencia = $dados['experiencia'];
            $this->apresentacao = $dados['apresentacao'];
        }
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
        if ($this->size > 0) {
            if ($this->getType($this->type) and $this->getErro($this->error) and $this->getSize($this->size)) {
                if (move_uploaded_file($this->tmp_name,  $pathFile)) {
                    $sqlInsert = "INSERT INTO curriculo 
                    (idVaga, idEnviou, path, fileName, cargo_experiencia, cidade, level_ingles, level_espanhol, formacao, telefone, genero, salario, experiencia, apresentacao) 
                    VALUES 
                    ('{$this->id_vaga}','{$this->id_user}','{$namefile}','{$this->name}', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0')";
                    $resultado = $banco->query($sqlInsert);
                    if ($resultado) {
                        return true;
                    }
                }
            }
        } else {
            $sqlInsert = "INSERT INTO curriculo 
                    (idVaga, idEnviou, path, fileName, cargo_experiencia, cidade, level_ingles, level_espanhol, formacao, telefone, genero, salario, experiencia, apresentacao) 
                    VALUES 
                    ('0','{$this->id_user}', '0', '0','{$this->cargo_experiencia}','{$this->cidade}','{$this->ingles}','{$this->espanhol}','{$this->formacao}','{$this->telefone}','{$this->genero}','{$this->salario}','{$this->experiencia}','{$this->apresentacao}')";
            $resultado = $banco->query($sqlInsert);
            if ($resultado) {
                return true;
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

$upload = new UploadCurriculo($_FILES['imagem_curriculo'], $_POST['id_vaga'], $_SESSION['USER_ID'], $_POST);
if ($upload->upload()) {
    $_SESSION['CURRICULO_REPORTING'] = false;
    header('Location: /home.php');
} else {
    $_SESSION['CURRICULO_REPORTING'] = true;
    if($_FILES['imagem_curriculo']['size'] > 0){
        header('Location: /upload.php?id=' . $_POST['id_vaga'] . '');
    }else{
        header('Location: /create_curriculo.php?');
    }
}
