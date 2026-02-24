<?php
if (!(isset($_COOKIE["token"]))) {
    header("Location: login.php");
    exit();
}
include "includes/header.php";
?>

<body data-usuario="<?= $usuarioToken['id_usuario'] ?>">
    <main>
        <?php
        $con = conectar();
        $cadernos = obterCadernoPorUsuario($con, $usuarioToken['id_usuario']);

        if (isset($_GET['caderno']) && !empty($_GET['caderno'])) {
            $cadernoId = intval($_GET['caderno']);
            $videos = buscarVideo($con, $usuarioToken['id_usuario'], $cadernoId);
        } else {
            $videos = buscarVideo($con, $usuarioToken['id_usuario']);
        }
        ?>

        <section class="scroll-reveal">
            <section class="jumbotron text-center">
                <div class="container">
                    <h1 class="jumbotron-heading">Vídeos</h1>
                    <p class="lead text-muted">Aqui você pode armazenar vídeos importantes para o seu estudo.</p>
                </div>
                <br>
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-success" id="btnEnviar">
                        <i class="bi bi-plus-circle me-1"></i> Adicionar vídeos
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Ordenar
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php if ($cadernos) { ?>
                                <?php foreach ($cadernos as $caderno): ?>
                                    <li>
                                        <a class="dropdown-item" href="videos.php?caderno=<?= $caderno['id'] ?>">
                                            <?= $caderno['nome'] ?>
                                        </a>
                                    </li>
                                <?php endforeach;
                            } else {
                                echo "Não há cadernos!";
                            } ?>
                        </ul>
                    </div>
                </div>

                </div>
            </section>

            <div class="card-deck">
                <div class="container d-flex flex-wrap justify-content-center">
                    <?php
                    foreach ($videos as $video) {
                        $descricao = $video['descricao'];
                        $link = $video['link'];

                        if (strpos($link, 'youtube.com/watch?v=') !== false) {
                            $videoId = explode('v=', $link)[1];
                            $videoId = explode('&', $videoId)[0];
                            $embedLink = "https://www.youtube.com/embed/{$videoId}";
                        } else {
                            $embedLink = $link;
                        }

                        echo "<div class='card notebook-card2 text-white my-3 mx-4' style='background-color: white; max-width: 26rem; flex: 0 0 28rem;'>";
                        echo "
                    <div class='d-flex vide'>
                    <h5 class='card-header2'>{$descricao}</h5> 
                    <button class='btnExcluir2' data-id='" . $video['id'] . "'><i class='bi bi-trash3-fill'></i></button> 
                    </div>";
                        echo "<div class='card-body'>";
                        echo "<div class='video-container'>";
                        echo "<iframe src='{$embedLink}' frameborder='0' allowfullscreen></iframe>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </section>


        <div id="modalDetalhes" class="modal">
            <div class="modal-content modal-shadow">
                <span class="close" data-modal-id="modalDetalhes">&times;</span>
                <h2>Adicionar Vídeo</h2>
                <p id="modalDescription"></p>
                <form id="formVideos" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="usuario_id" value="<?= $usuarioToken['id_usuario'] ?>">
                    <div class="textfield">
                        <label for="descricao">Descrição:</label>
                        <input type="text" id="descricao" name="descricao">
                        <div class="error" id="descError"></div>
                    </div>

                    <div class="textfield">
                        <label for="link">Link</label></label>
                        <input type="text" id="link" name="link">
                        <div class="error" id="linkError"></div>
                    </div>

                    <div class="textfield">
                        <label for="materia">Matéria:</label>
                        <select id="materia" name="materia" class="form-control">
                            <?php foreach ($cadernos as $caderno): ?>
                                <option value="<?= $caderno['id'] ?>"><?= $caderno['nome'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="error" id="materiaError"></div>
                    </div>
                    <br>
                    <button type="submit" class="bd" id="btnVideos">Enviar</button>
                </form>
            </div>
        </div>

        <div id="modalR" class="modalS">
            <div class="modalS-content">
                <h2>Vídeo cadastrado com sucesso!</h2>
                <div class="modalS-progress-bar"></div>
            </div>
        </div>

        <div id="modalD" class="modalE">
            <div class="modalL-content">
                <h2>Tem certeza que deseja remover este vídeo?</h2>
                <button type="button" class="btn btn-danger b1" id="remover">Sim</i></button>
                <button type="button" class="btn btn-success b2" id="manter">Não</i></button>
            </div>
        </div>

        <div id="modalE" class="modalE">
            <div class="modalE-content">
                <h2>Vídeo removido com sucesso!</h2>
                <div class="modalE-progress-bar"></div>
            </div>
        </div>

    </main>
</body>
<script src="./js/scroll.js"></script>
<script src="./js/buscarvideo.js"></script>
<script src="./js/videos.js"></script>
<?php
include "includes/footer.php";
?>