<?php 

setcookie("token",$_COOKIE["token"], time() - (60*60*24*10), "/");

header("Location: ../login.php");
exit();