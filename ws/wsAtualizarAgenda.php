<?php
include "../includes/functions.php";

$conexao = conectar();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $response = null;

    if (!(isset($_POST["id"]) && isset($_POST["descricao"]) && isset($_POST["data_publicada"]) && isset($_POST["hora_publicada"]))) {
        $response = [
            'success' => false,
            'Mensagem' => 'Faltando'
        ];
    } else {
        $id = $_POST["id"];
        $descricao = $_POST["descricao"];
        $data = $_POST["data_publicada"];
        $hora = $_POST["hora_publicada"];

        $resultadoAgenda = editarAgenda($conexao, $hora, $data, $descricao, $id);

        if ($resultadoAgenda) {
            $response = [
                'success' => true,
                'Mensagem' => 'Matéria atualizada com sucesso'
            ];
        } else {
            if (!$response) {
                $response = [
                    'success' => false,
                    'Mensagem' => 'Erro ao atualizar Matéria'
                ];
            }
        }
    }

    desconectar($conexao);

} else {
    $response = [
        'success' => false,
        'Mensagem' => 'Método de requisição inválido'
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
