<?php
if (!(isset($_COOKIE["token"]))) {
    header("Location: login.php");
    exit();
}
include "includes/auth.php";
include "includes/header.php";

$con = conectar();
$usuario = SelecionarUsuarioPorId($con, $usuarioToken['id_usuario']);
$comentarios = buscarComentario($con);
$comentariosAdm = buscarComentarioAdm($con);
?>

<body data-usuario="<?= $usuarioToken['id_usuario'] ?>">


    <h1 class="suges">Minhas sugestões!</h1>

    <div class="comentarios-container">

        <div <?php if ($usuarioToken['id_usuario'] != 1) { ?> class="comentarios-lista2" <?php }?>id="tabela-vencidas">
            <h2>Comentários recentes</h2>

            <?php if (!empty($comentarios)) { ?>
                <?php foreach ($comentarios as $comentario) {
                    if ($comentario['usuario_id'] == $usuarioToken['id_usuario']){
                    $Tem = temRespostaAdmin($con, $comentario['id']);
                    ?>
                    <div class="comentario">
                        <div class="comentario-header">
                            <strong><?= $comentario['nome'] ?></strong>
                            <span class="comentario-data">
                                <?= date('d/m/Y H:i', strtotime($comentario['data_publicada'])) ?>
                                <?php if ($usuarioToken['id_usuario'] == $comentario['usuario_id']) { ?>
                                    <button type="button" class="btnExcluir3" data-id="<?= $comentario['id'] ?>"> <i
                                            class="bi bi-trash"></i> </button> <?php } ?>
                            </span>
                        </div>
                        <p class="comentario-texto"><?= $comentario['comentario'] ?></p>

                        <?php if ($usuarioToken['id_usuario'] == 1 && !$Tem) { ?>
                            <button class="btnResponder" data-id="<?= $comentario['id'] ?>">Responder</button>
                        <?php } ?>

                        <?php foreach ($comentariosAdm as $comentarioA) { ?>
                            <?php if ($comentarioA['id_pai'] == $comentario['id']) { ?>
                                <div class="comentario1 resposta-admin">
                                    <div class="comentario1-header">
                                        <strong><?= $comentarioA['nome'] ?><img src="assets/img/duvi.png" alt="Personagem Anotahub"
                                                height="50px"></strong>
                                        <span class="comentario1-data">
                                            <?= date('d/m/Y H:i', strtotime($comentarioA['data_publicada'])) ?>
                                            <?php if ($usuarioToken['id_usuario'] == 1) { ?>
                                                <button type="button" class="btnExcluir" data-id="<?= $comentarioA['id'] ?>"> <i
                                                        class="bi bi-trash"></i></button> <?php } ?>
                                        </span>
                                    </div>
                                    <p class="comentario-texto"><?= $comentarioA['comentario'] ?></p>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php }} ?>
            <?php } else { ?>
                <p class="s">Nenhum comentário encontrado.</p>
            <?php } ?>
            <div class="pagination-controls5">
                <button id="anterior">Anterior</button>
                <button id="proximo">Próxima</button>
            </div>
        </div>


        <div id="modalD" class="modalE">
            <div class="modalL-content">
                <h2>Tem certeza que deseja remover seu comentário?</h2>
                <button type="button" class="btn btn-danger b1" id="remover">Sim</i></button>
                <button type="button" class="btn btn-success b2" id="manter">Não</i></button>
            </div>
        </div>

        <div id="modalE" class="modalE">
            <div class="modalE-content">
                <h2>Comentário removido com sucesso!</h2>
                <div class="modalE-progress-bar"></div>
            </div>
        </div>

    </div>

</body>
<script src="./js/sugestoes.js"></script>
<script src="./js/curtirComentario.js"></script>
<script src="./js/scroll.js"></script>
<script src="./js/paginacaoComentarios.js"></script>
<?php include "includes/footer.php"; ?>