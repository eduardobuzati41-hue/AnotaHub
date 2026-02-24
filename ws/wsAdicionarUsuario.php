<?php
include "../includes/functions.php";

if ($_SERVER['REQUEST_METHOD'] == "POST"):

    $response = null;

    if (
        !(isset($_POST["nome"]) && isset($_POST["email"]) && isset($_POST["tel"]) &&
        isset($_POST["cpf"]) && isset($_POST["nascimento"]) && isset($_POST["senha"]))
    ):
        $response = [
            'sucess' => false,
            'Mensagem' => 'Os campos não podem estar vazios'
        ];
    else:
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $tel = $_POST["tel"];
        $cpf = $_POST["cpf"];
        $nascimento = $_POST["nascimento"];
        $senha = $_POST["senha"];

        if (
            empty($nome) || empty($email) || empty($tel) ||
            empty($cpf) || empty($nascimento) || empty($senha)
        ):
            $response = [
                'sucess' => false,
                'Mensagem' => 'Os campos não podem estar vazios'
            ];
        else:
            $con = conectar();

            if (verificarEmailExistente($con, $email)) {
                $response = [
                    'sucess' => false,
                    'Mensagem' => 'Já existe uma conta cadastrada com este e-mail'
                ];
            } else {
                $nomeImg = $_FILES['foto']['name'];
                $nomeNovo = $_FILES['foto']['tmp_name'];
                $explode = explode('.', $nomeImg);
                $extensao = end($explode);

                $idUsuario = adicionarUsuario($con, $nome, $email, $tel, $cpf, $nascimento, $senha);
                setcookie("idUsuario", $idUsuario);

                $nomeArquivo = $idUsuario . "." . $extensao;
                $caminhoImagem = "uploads/$nomeArquivo";
                $uploadfile = "../$caminhoImagem";

                move_uploaded_file($nomeNovo, $uploadfile);
                fotoUsuario($con, $caminhoImagem, $idUsuario);

                if ($idUsuario) {
                    $response = [
                        'sucess' => true,
                        'Mensagem' => 'Usuário adicionado com sucesso!'
                    ];
                } else {
                    $response = [
                        'sucess' => false,
                        'Mensagem' => 'Erro ao adicionar o usuário'
                    ];
                }
            }
        endif;
    endif;

    header('Content-Type: application/json');
    echo json_encode($response);
endif;
