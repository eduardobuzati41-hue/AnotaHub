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

    <?php if ($usuarioToken['id_usuario'] != 1) { ?>
        <h1 class="suges">Adicione uma dúvida ou sugestão!</h1>
        <p class="suges">Nossa equipe irá responder em até 48 horas!</p>
    <?php } else { ?>
        <h1 class="suges">Responder sugestões!</h1>
        <p class="suges">Responda os usuários de nossa aplicação!</p>
    <?php } ?>

    <div class="comentarios-container">

        <?php if ($usuarioToken['id_usuario'] != 1) { ?>
            <div class="comentario-card">
                <h2>Envie seu comentário</h2>
                <form id="registrationForm" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="usuario_id" value="<?= $usuarioToken['id_usuario'] ?>">
                    <input type="hidden" name="data_publicada" id="data_publicada">
                    <label for="nome">Seu nome:</label>
                    <input type="text" id="name" name="name" placeholder="Digite seu nome" value="<?= $usuario['nome'] ?>"
                        readonly>
                    <div class="error" id="nameError"></div>

                    <label for="comentario">Comentário:</label>
                    <textarea id="comentario" name="comentario" rows="4"
                        placeholder="Digite aqui sua dúvida ou sugestão..."></textarea>
                    <div class="error" id="comentarioError"></div>

                    <button type="submit" id="btnEnviar">Enviar</button>
                </form>
            </div>
        <?php } ?>

        <div <?php if ($usuarioToken['id_usuario'] != 1) { ?> class="comentarios-lista" <?php } else { ?>
                class="comentarios-lista2" <?php } ?> id="tabela-vencidas">
            <h2>Comentários recentes</h2>

            <?php if (!empty($comentarios)) { ?>
                <?php foreach ($comentarios as $comentario) {
                    $Tem = temRespostaAdmin($con, $comentario['id']);
                    ?>
                    <div class="comentario">
                        <div class="comentario-header">
                            <strong><?= $comentario['nome'] ?></strong>
                            <span class="comentario-data">
                                <?= date('d/m/Y H:i', strtotime($comentario['data_publicada'])) ?>
                                <?php if (($usuarioToken['id_usuario'] == $comentario['usuario_id']) || (($usuarioToken['id_usuario'] == 1))) { ?>
                                    <button type="button" class="btnExcluir3" data-id="<?= $comentario['id'] ?>"> <i
                                            class="bi bi-trash"></i> </button> 
                                <?php } ?>
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
                <?php } ?>
            <?php } else { ?>
                <p>Nenhum comentário encontrado.</p>
            <?php } ?>
            <div class="pagination-controls5">
                <button id="anterior">Anterior</button>
                <button id="proximo">Próxima</button>
            </div>
        </div>

        <div id="modalDetalhes2" class="modal">
            <div class="modal-content modal-shadow">
                <span class="close5" data-modal-id="modalDetalhes2">&times;</span>
                <h2>Responder comentário</h2>
                <form id="formResposta" method="post">
                    <input type="hidden" name="usuario_id" value="<?= $usuarioToken['id_usuario'] ?>">
                    <input type="hidden" name="data_publicada" id="data_publicada_resposta">
                    <input type="hidden" name="id_pai" id="id_pai">

                    <div class="textfield">
                        <label for="name_resposta">Nome:</label>
                        <input type="text" id="name_resposta" name="name" value="Anotinha" readonly>
                        <div class="error" id="nameError"></div>
                    </div>

                    <div class="textfield">
                        <label for="comentario_resposta">Resposta:</label>
                        <input type="text" id="comentario_resposta" name="comentario" placeholder="Digite sua resposta">
                        <div class="error" id="comentarioError"></div>
                    </div>

                    <br>
                    <button type="submit" class="bd" id="btnEnviarResposta">Enviar</button>
                </form>
            </div>
        </div>

        <div id="modalDetalhes" class="modalS">
            <div class="modalS-content">
                <h2>Comentário adicionado com sucesso!</h2>
                <div class="modalS-progress-bar"></div>
            </div>
        </div>

        <div id="modalD" class="modalE">
            <div class="modalL-content">
                <h2>Tem certeza que deseja remover este comentário?</h2>
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