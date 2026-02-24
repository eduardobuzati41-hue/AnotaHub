<?php
include "../includes/functions.php";

$response = ['success' => false, 'mensagem' => 'Erro desconhecido'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST["email"]) || empty($_POST["password"])) {
        $response['mensagem'] = 'Usuário e Senha devem estar preenchidos';
    } else {
        $email = trim($_POST["email"]);
        $senha = $_POST["password"];

        $conexao = conectar();

        $usuario = validaLogin($conexao, $email, $senha);

        if ($usuario) {
            $token = gerarToken($conexao, $usuario);

            setcookie("token", $token, time() + (60 * 60 * 24), '/');

            if($usuario['id'] != 1){
                header("Location: ../home.php");
            } else{
                header("Location: ../sugestoes.php");
            }
            exit();
        } else {
            $erro = urlencode("Usuário ou senha inválidos");
            header("Location: ../login.php?erro=$erro");
            exit();
        }

        desconectar($conexao);
    }
} else {
    $response['mensagem'] = 'Método de requisição inválido';
}
?>
