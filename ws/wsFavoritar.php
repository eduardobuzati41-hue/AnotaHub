<?php
include "../includes/functions.php";


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $response = null;

    if (!(isset($_POST["caderno_id"]) && isset($_POST["favoritar"]) && isset($_POST["usuario_id"]))) {
        $response = [
            'success' => false,
            'Mensagem' => 'Dados faltando'
        ];
    } else {
        $caderno_id = $_POST["caderno_id"];
        $usuario_id = $_POST["usuario_id"];
        $favoritar  = $_POST["favoritar"];

        $conexao = conectar();
        $resultado = atualizarFavorito($conexao, $caderno_id, $usuario_id, $favoritar);

        if ($resultado) {
            $response = [
                'success' => true,
                'Mensagem' => 'Status atualizado com sucesso'
            ];
        } else {
            $response = [
                'success' => false,
                'Mensagem' => 'Erro ao atualizar favorito'
            ];
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