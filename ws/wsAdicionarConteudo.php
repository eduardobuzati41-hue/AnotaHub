<?php
include "../includes/functions.php";

$conexao = conectar();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $response = null;

    if (!(isset($_POST["usuario_id"]) && isset($_POST["conteudo"]))) {
        $response = [
            'success' => false,
            'Mensagem' => 'Faltando'
        ];
    } else {
        $id = $_POST["id"];
        $conteudo = $_POST["conteudo"];

        $resultado = editarConteudo($conexao, $conteudo, $id);

        if ($resultado) {
            $response = [
                'success' => true,
                'Mensagem' => 'Conteudo atualizado com sucesso'
            ];
        } else {
            if (!$response) {
                $response = [
                    'success' => false,
                    'Mensagem' => 'Erro ao atualizar conteudo'
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
