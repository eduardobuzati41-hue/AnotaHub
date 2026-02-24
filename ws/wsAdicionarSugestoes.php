<?php
include "../includes/functions.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $response = null;

    if (!(isset($_POST["usuario_id"]) && isset($_POST["name"]) && isset($_POST["comentario"]) && isset($_POST["data_publicada"]))) {
        $response = [
            'success' => false,
            'Mensagem' => 'Os campos não podem estar vazios'
        ];   
    } else {
        $usuario_id = $_POST["usuario_id"];
        $nome = $_POST["name"];
        $comentario = $_POST["comentario"];
        $data = $_POST["data_publicada"];
        $id_pai = $_POST["id_pai"] ?? null;

        if (empty($nome) || empty($comentario) || empty($usuario_id) || empty($data)) {
            $response = [
                'success' => false,
                'Mensagem' => 'Os campos não podem estar vazios'
            ];     
        } else {
            $con = conectar();

            $id_pai = isset($_POST['id_pai']) && $_POST['id_pai'] !== '' ? $_POST['id_pai'] : NULL;
            
            $idComentario = adicionarComentario($con, $usuario_id, $nome, $comentario, $data, $id_pai);

            if ($idComentario) {
                $response = [
                    'success' => true,
                    'Mensagem' => 'Comentario adicionado com sucesso!'
                ];
            } else {
                $response = [
                    'success' => false,
                    'Mensagem' => 'Erro ao adicionar o comentario'
                ];
            }
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
