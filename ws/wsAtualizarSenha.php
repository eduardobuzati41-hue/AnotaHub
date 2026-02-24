<?php
include "../includes/functions.php";

$conexao = conectar();
$usuarioToken = buscarTokenPorUsuario($conexao, $_COOKIE["token"]);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $response = null;

    if (!(isset($_POST["id"]) && isset($_POST["senha"]) && isset($_POST["senhanova"]))) {
        $response = [
            'success' => false,
            'Mensagem' => 'Parâmetros faltando'
        ];
    } else {
        $id = $_POST["id"];
        $senhaAtual = $_POST["senha"];
        $senhaNova = $_POST["senhanova"];

        $resultadoUsuario = editarSenhaUsuario($conexao, $id, $senhaAtual, $senhaNova);

        if ($resultadoUsuario) {
            $response = [
                'success' => true,
                'Mensagem' => 'Senha atualizada com sucesso'
            ];
        } else {
            $response = [
                'success' => false,
                'Mensagem' => 'Senha atual incorreta ou erro ao atualizar'
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
