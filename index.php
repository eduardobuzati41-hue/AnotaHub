<?php
include "includes/header.php";
?>

<body>
  <div id="myCarousel" class="carousel slide scroll-reveal" data-ride="carousel">
    <div class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img class="d-block w-100 img-fluid" src="assets/img/Home.png" alt="First slide">
        <div class="container">
          <?php
          if (!(isset($_COOKIE["token"]))) {
            ?>
            <div class="carousel-caption">
              <a href="adicionarUsuario.php" class="custom-button">Cadastre-se</a>
            </div>
            <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>

  <div class="container marketing scroll-reveal">
    <div class="row">
      <div class="col-lg-4">
        <img class="rounded-circle" src="assets/img/nota.png" alt="Generic placeholder image" width="140" height="140">
        <h2>Realize suas <br>anotações</h2>
        <p>Realize suas anotações de maneira rápida e organizada. Registre ideias, compromissos e informações
          importantes com facilidade e acesse tudo quando precisar, tudo em um único lugar.</p>
      </div>
      <div class="col-lg-4">
        <img class="rounded-circle" src="assets/img/relogio.png" alt="Generic placeholder image" width="140"
          height="140">
        <h2>Nunca perca <br>um prazo</h2>
        <p>Nunca perca um prazo novamente. Com nosso sistema de gestão, você recebe alertas e lembretes para manter seus
          compromissos sempre em dia, garantindo eficiência e pontualidade em todas as tarefas.</p>
      </div>
      <div class="col-lg-4">
        <img class="rounded-circle" src="assets/img/cale.png" alt="Generic placeholder image" width="140" height="140">
        <h2>Organize seus compromissos</h2>
        <p>Organize seus compromissos de forma prática e eficiente. Tenha controle total da sua agenda, otimize seu
          tempo e nunca perca um compromisso importante com nosso sistema de gerenciamento intuitivo.</p>
      </div>
    </div>


    <hr class="featurette-divider">

    <div class="row featurette scroll-reveal">
      <div class="col-md-7">
        <h2 class="featurette-heading  scroll-reveal">Aplicação que facilita seus estudos.</h2>
        <p class="lead  scroll-reveal">O AnotaHub é a aplicação que facilita seus estudos. Com recursos para organizar
          seu tempo, revisar conteúdos e fazer exercícios, ele torna o aprendizado mais eficiente. Acompanhe seu
          progresso de forma prática e dinâmica, ajudando você a alcançar seus objetivos acadêmicos com facilidade.
          Estude de maneira inteligente e obtenha resultados rápidos e eficazes!</p>
      </div>
      <div class="col-md-5">
        <img class="featurette-image img-fluid mx-auto" src="assets/img/anota2.jpeg" alt="Generic placeholder image">
      </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette scroll-reveal">
      <div class="col-md-7 order-md-2">
        <h2 class="featurette-heading">Fique por dentro de seus compromissos.</h2>
        <p class="lead">Fique por dentro de todos os seus compromissos de maneira prática e organizada, garantindo que
          você esteja sempre preparado para cumprir prazos e responsabilidades. Com uma gestão eficiente da sua agenda,
          você tem total controle sobre suas atividades, evitando imprevistos e alcançando seus objetivos com mais
          facilidade.</p>
      </div>
      <div class="col-md-5 order-md-1">
        <img class="featurette-image img-fluid mx-auto" src="assets/img/anota3.jpeg" alt="Generic placeholder image">
      </div>
    </div>

    <hr class="featurette-divider">

    <?php
    if (!(isset($_COOKIE["token"]))) {
      ?>
      <div class="container text-center scroll-reveal mb-5">
        <h2>Pronto para começar?</h2>
        <p>Organize suas anotações e compromissos agora mesmo.</p>
        <a href="adicionarUsuario.php" class="btn b btn-lg">Cadastre-se gratuitamente</a>
      </div>
    <?php } ?>

  </div>
</body>
<script src="./js/scroll.js"></script>

<?php
include "includes/footer.php";
?>