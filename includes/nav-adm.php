<?php
if (!(isset($_COOKIE["token"]))) {
  header("Location: login.php");
  exit();
  include "includes/auth.php";
}
?>

<?php
if (isset($usuarioToken['id_usuario'])) {
  $con = conectar();
}
?>

<nav class="navbar navbar-expand-lg shadow p-3 mb-5 bg-white rounded">
  <div class="container-fluid">
    <img class="anota" src="./assets/img/AnotaHub.png">

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
  
     <div class="d-flex ms-auto">
      <li class="nav dropdown">
        <a class="nav-link dropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <i class="bi bi-gear"></i></i></a>
        <ul class="dropdown-menu dropdown-menu-end">
          <a class="dropdown-item" href="perfil.php"><i class="bi bi-person"></i> Perfil</a>
          <a class="dropdown-item" href="sugestoes.php"><i class="bi bi-lightbulb"></i> Sugestões</a>
          <a class="dropdown-item" href="proc/procLogout.php"><i class="bi bi-box-arrow-left"></i> Sair</a>
        </ul>
      </li>
    </div>

      

    </div>
  </div>
</nav>