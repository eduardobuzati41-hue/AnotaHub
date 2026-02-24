<?php
include "../includes/functions.php";

$conexao = conectar();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $response = null;

    if (!(isset($_POST["id"]) && isset($_POST["concluido"]) && isset($_POST["usuario_id"]))) {
        $response = [
            'success' => false,
            'Mensagem' => 'Dados faltando'
        ];
    } else {
        $id = $_POST["id"];
        $usuario_id = $_POST["usuario_id"];
        $concluido = $_POST["concluido"];

        $resultado = atualizarConcluido($conexao, $id, $usuario_id, $concluido);

        if ($resultado) {
            $response = [
                'success' => true,
                'Mensagem' => 'Status atualizado com sucesso'
            ];
        } else {
            $response = [
                'success' => false,
                'Mensagem' => 'Erro ao atualizar status'
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
?>
