<?php
include "../includes/functions.php";

$conexao = conectar();

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $response = null;

    if (!(isset($_GET["id"]) && isset($_COOKIE["token"]))) {
        $response = [
            'success' => false,
            'Mensagem' => 'Dados faltando'
        ];
    } else {
        $cadernoId = $_GET["id"];
        $usuario_id = $usuarioToken['id_usuario'];

        $resultado = buscarVideo($conexao, $usuario_id, $cadernoId);

        if ($resultado) {
            $response = [
                'success' => true,
                'Mensagem' => 'Vídeos buscados com sucesso',
                'videos' => $resultado
            ];
        } else {
            $response = [
                'success' => false,
                'Mensagem' => 'Nenhum vídeo encontrado'
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
