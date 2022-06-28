<?php
session_start();

echo "<pre>";
print_r($_POST);
echo "</pre>";


require_once("../../BD/conexao.php");

class UploadCurriculo extends Conexao
{

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


    public function __construct($id_user, $dados)
    {

        $this->id_user = $id_user;

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

    public function upload()
    {
        $banco = $this->iniciarConexao();

        $sqlInsert = "UPDATE curriculo SET 
        cargo_experiencia = '{$this->cargo_experiencia}',
        cidade = '{$this->cidade}',
        level_ingles = '{$this->ingles}', 
        level_espanhol = '{$this->espanhol}', 
        formacao = '{$this->formacao}', 
        telefone = '{$this->telefone}', 
        genero = '{$this->genero}', 
        salario = '{$this->salario}', 
        experiencia = '{$this->experiencia}', 
        apresentacao = '{$this->apresentacao}' WHERE idEnviou = '{$this->id_user}' AND path = '0'";
        $resultado = $banco->query($sqlInsert);
        if ($resultado) {
            return true;
        }

        return false;
    }
}

$upload = new UploadCurriculo($_SESSION['USER_ID'], $_POST);
if ($upload->upload()) {
    $_SESSION['CURRICULO_REPORTING'] = false;
    header('Location: /update_curriculo.php');
} else {
    $_SESSION['CURRICULO_REPORTING'] = true;
    header('Location: /update_curriculo.php?');
}
