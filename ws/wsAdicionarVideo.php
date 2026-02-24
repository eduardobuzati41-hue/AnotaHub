<?php
include "../includes/functions.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $response = null;
    
    if (!(isset($_POST["usuario_id"]) && isset($_POST["materia"]) && isset($_POST["descricao"]) && isset($_POST["link"]))) {
        $response = [
            'success' => false,
            'Mensagem' => 'Os campos não podem estar vazios'
        ];   
    } else {
        $usuario_id = $_POST["usuario_id"];
        $caderno_id = $_POST["materia"];
        $descricao = $_POST["descricao"];
        $link = $_POST["link"];
    
        if (empty($descricao) || empty($link) || empty($usuario_id) || empty($caderno_id)) {
            $response = [
                'success' => false,
                'Mensagem' => 'Os campos não podem estar vazios'
            ];     
        } else {
            $con = conectar();
            $idVideo = adicionarVideo($con,$usuario_id,$caderno_id,$descricao,$link);

            if ($idVideo) {
                $response = [
                    'success' => true,
                    'Mensagem' => 'Video adicionado com sucesso!'
                ];
            } else {
                $response = [
                    'success' => false,
                    'Mensagem' => 'Erro ao adicionar o Video'
                ];
            }
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
