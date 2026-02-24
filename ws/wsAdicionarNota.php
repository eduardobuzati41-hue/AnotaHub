<?php
include "../includes/functions.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $response = null;
    
    if (!(isset($_POST["usuario_id"]) && isset($_POST["descricao"]) && isset($_POST["data_publicada"]) && isset($_POST["hora_publicada"]))) {
        $response = [
            'success' => false,
            'Mensagem' => 'Os campos não podem estar vazios'
        ];   
    } else {
        $usuario_id = $_POST["usuario_id"];
        $descricao = $_POST["descricao"];
        $data_publicada = $_POST["data_publicada"];
        $hora_publicada = $_POST["hora_publicada"];
    
        if (empty($descricao) || empty($data_publicada) || empty($hora_publicada) || empty($usuario_id)) {
            $response = [
                'success' => false,
                'Mensagem' => 'Os campos não podem estar vazios'
            ];     
        } else {
            $con = conectar();
            $idNota = adicionarNota($con,$usuario_id,$descricao,$data_publicada,$hora_publicada);

            if ($idNota) {
                $response = [
                    'success' => true,
                    'Mensagem' => 'Nota adicionada com sucesso!'
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
