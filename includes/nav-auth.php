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
  $notas = obterNotasDoDia($con, $usuarioToken['id_usuario']);
}
$agora = date('H:i:s');
?>

<nav class="navbar navbar-expand-lg shadow p-3 mb-5 bg-white rounded">
  <div class="container-fluid">
    <img class="" src="./assets/img/AnotaHub.png" width="6%">

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mx">
         <li class="nav-item">
          <a class="nav-link nav1" aria-current="page" href="index.php">AnotaHub</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link" aria-current="page" href="home.php">
            <i class="bi bi-house-door"></i> Minha Área</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cadernos.php">
            <i class="bi bi-journals"></i> Cadernos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="agenda.php">
            <i class="bi bi-calendar-week"></i> Agenda</a>
        </li>
        <li class="nav-item me-5">
          <a class="nav-link" href="videos.php">
            <i class="bi bi-camera-reels"></i> Vídeos</a>
        </li>
      </ul>

     <div class="d-flex ms-auto">
      <li class="nav dropdown">
        <a class="nav-link dropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php if (!empty($notas)) { ?>
            <i class="bi bi-bell sino"></i>
          <?php } else { ?>
            <i class="bi bi-bell-slash"></i>
          <?php } ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item">
              <h6>Lembretes de hoje</h6>
            </a></li>
          <?php
          if (!empty($notas)) {
            foreach ($notas as $nota) {
              $hora = new DateTime($nota['hora_publicada']);
              echo '<li><a class="dropdown-item">' . ($nota['descricao']) . " " . $hora->format('H:i') . ' <i class="bi bi-stopwatch"></i></a></li>';
            }
          } else {
            echo '<li><a class="dropdown-item disabled">Nenhum lembrete</a></li>';
          }
          ?>
        </ul>
      </li>
      <li class="nav dropdown">
        <a class="nav-link dropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <i class="bi bi-list"></i></a>
        <ul class="dropdown-menu dropdown-menu-end">
          <a class="dropdown-item" href="perfil.php"><i class="bi bi-person"></i> Perfil</a>
          <a class="dropdown-item" href="sugestoes.php"><i class="bi bi-lightbulb"></i> Sugestões</a>
          <a class="dropdown-item" href="minhasSugestoes.php"><i class="bi bi-person-vcard"></i> Minhas sugestões</a>
          <a class="dropdown-item" href="proc/procLogout.php"><i class="bi bi-box-arrow-left"></i> Sair</a>
        </ul>
      </li>
    </div>

      

    </div>
  </div>
</nav>