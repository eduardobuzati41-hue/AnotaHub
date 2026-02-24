<?php
    require_once "includes/functions.php";
    // if(!isset($_COOKIE["id"])){
    //     header("Location: login.php");
    //     exit();
    // }

    $conexao = conectar();

    $usuarioToken = false;
  
    if(isset($_COOKIE["token"])){
      $usuarioToken = buscarTokenPorUsuario($conexao, $_COOKIE["token"]);
    }


    if(!($usuarioToken && (date('Y-m-d H:i:s', strtotime('+0 seconds')) < $usuarioToken["data_expiracao"]))){
      setcookie("token", "", time()-(60*60*24), '/');
      header("Location: login.php");
    }
    
    

    