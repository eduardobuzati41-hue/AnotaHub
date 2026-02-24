<?php
include "../includes/functions.php";

$conexao = conectar();
$usuarioToken = buscarTokenPorUsuario($conexao, $_COOKIE["token"]);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $response = null;

    if (!(isset($_POST["id"]) && isset($_POST["nome"]) && isset($_POST["email"]) && isset($_POST["tel"]) && isset($_POST["cpf"]) && isset($_POST["nascimento"]))) {
        $response = [
            'success' => false,
            'Mensagem' => 'Faltando'
        ];
    } else {
        $id = $_POST["id"];
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $tel = $_POST["tel"];
        $cpf = $_POST["cpf"];
        $nascimento = $_POST["nascimento"];

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $nomeArquivo = uniqid() . '.' . pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $caminhoImagem = "uploads/$nomeArquivo";
            $uploadfile = "../$caminhoImagem";

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadfile)) {
                $resultadoFoto = fotoUsuario($conexao, $caminhoImagem, $id);

                if (!$resultadoFoto) {
                    $response = [
                        'success' => false,
                        'Mensagem' => 'Erro ao salvar foto no banco'
                    ];
                }
            } else {
                $response = [
                    'success' => false,
                    'Mensagem' => 'Erro ao fazer upload da foto'
                ];
            }
        }

        $resultadoUsuario = editarUsuario($conexao, $nome, $email, $tel, $cpf, $nascimento, $id);

        if ($resultadoUsuario) {
            $usuarioToken["nome"] = $nome;
            $response = [
                'success' => true,
                'Mensagem' => 'Usuário atualizado com sucesso'
            ];
        } else {
            if (!$response) {
                $response = [
                    'success' => false,
                    'Mensagem' => 'Erro ao atualizar usuário'
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
