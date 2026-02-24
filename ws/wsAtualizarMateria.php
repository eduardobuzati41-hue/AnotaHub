<?php
include "../includes/functions.php";

$conexao = conectar();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $response = null;

    if (!(isset($_POST["id"]) && isset($_POST["nome"]) && isset($_POST["cor"]))) {
        $response = [
            'success' => false,
            'Mensagem' => 'Faltando'
        ];
    } else {
        $id = $_POST["id"];
        $nome = $_POST["nome"];
        $cor = $_POST["cor"];

        $resultadoMateria = editarMateria($conexao, $nome, $id, $cor);

        if ($resultadoMateria) {
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
