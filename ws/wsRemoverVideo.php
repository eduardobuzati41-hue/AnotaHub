<?php
include "../includes/functions.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $response = null;

    if (isset($_POST["id"])) {
        $id = $_POST["id"];
        $con = conectar();
        if (excluirVideo($con, $id)) {
            $response = [
                'success' => true,  
                'Mensagem' => 'Excluído com sucesso'
            ];

        } else {
            
            $response = [
                'sucess' => false,
                'Mensagem' => 'Erro ao excluir'
            ];
        }
        
        desconectar($con);
    } else {
        $response = [
            'sucess' => false,
            'Mensagem' => 'Erro no id'
        ];
    }
} else {
    $response = [
        'sucess' => false,
        'Mensagem' => 'Erro'
    ];
}


header('Content-Type: application/json');
echo json_encode($response);