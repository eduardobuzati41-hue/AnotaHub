<?php
include "../includes/functions.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $response = null;
    
    if (!(isset($_POST["usuario_id"]) && isset($_POST["nome"]) && isset($_POST["cor"]))) {
        $response = [
            'success' => false,
            'Mensagem' => 'Os campos não podem estar vazios'
        ];   
    } else {
        $usuario_id = $_POST["usuario_id"];
        $nome = $_POST["nome"];
        $cor = $_POST["cor"];
    
        if (empty($nome) || empty($usuario_id) || empty($cor)) {
            $response = [
                'success' => false,
                'Mensagem' => 'Os campos não podem estar vazios'
            ];     
        } else {
            $con = conectar();
            $idCaderno = adicionarCaderno($con,$usuario_id,$nome,$cor);

            if ($idCaderno) {
                $response = [
                    'success' => true,
                    'Mensagem' => 'Caderno adicionado com sucesso!'
                ];
            } else {
                $response = [
                    'success' => false,
                    'Mensagem' => 'Erro ao adicionar a nota'
                ];
            }
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
