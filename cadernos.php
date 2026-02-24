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
        ?>

        <section class="scroll-reveal">
            <section class="jumbotron text-center">
                <div class="container">
                    <h1 class="jumbotron-heading">Cadernos</h1>
                    <p class="lead text-muted">Aqui você pode organizar e gerenciar seus cadernos.</p>
                </div>
                <br>
                <button type="button" class="btn btn-success" id="gerenciar">Gerenciar Cadernos</i></button>
            </section>

            <div class="card-deck">
                <div class="container d-flex flex-wrap justify-content-center">
                    <?php
                    foreach ($cadernos as $caderno) {
                        if($caderno['ocultar'] == 0){
                        $cor = ($caderno['cor']);
                        echo "<a href='caderno.php?id=" . $caderno['id'] . "' class='card-link'>";
                        echo "<div class='card notebook-card text-white my-3 mx-4' style='background-color: {$cor};'>";
                        if($caderno["favoritar"] == 1) {
                            echo "<h5 class='card-header'>" . ($caderno['nome']) . " <i class='bi bi-star-fill text-warning'></i></h5>";
                        } else{
                            echo "<h5 class='card-header'>" . ($caderno['nome']) . '</h5>';
                        }
                        echo "  <div class='card-body'>
                                        <h5 class='card-title'>Meu Caderno AnotaHub</h5>
                                    </div>
                                </div>
                            </a>";
                        } 
                    }
                    ?>

                    </a>
                    <a type="submit" class="card-link" id="btnEnviar"></i>
                        <div class="card notebook-card text-black bg-body-secondary my-3 mx-4">
                            <h5 class="card-header">Adicionar caderno</h5>
                            <div class="card-body">
                                <p class="card-add"><i class="bi bi-plus-lg"></i></p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </section>


        <div id="modalDetalhes" class="modal">
            <div class="modal-content modal-shadow">
                <span class="close" data-modal-id="modalDetalhes">&times;</span>
                <h2>Criar Caderno</h2>
                <p id="modalDescription"></p>

                <form id="formCadernos" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="usuario_id" value="<?= $usuarioToken['id_usuario'] ?>">
                    <div class="textfield">
                        <label for="nome">Título:</label>
                        <input type="text" id="nome" name="nome">
                        <div class="error" id="descError"></div>
                    </div>
                    <div class="color-picker-box">
                    <label for="cor">Cor do caderno</label>
                    <div class="color-btn-wrapper">
                        <input type="color" id="cor" name="cor" value="#7f37c9">
                    </div>
                    </div>
                    <br>
                    <button type="submit" class="bd" id="btnCadernos">Enviar</button>
                </form>
            </div>
        </div>


        <div id="modalDetalhes2" class="modal">
            <div class="modal-content modal-shadow">
                <span class="close2" data-modal-id="modalDetalhes2">&times;</span>
                <h2>Editar Caderno</h2>

                <form id="formEditarCaderno" method="post">
                    <input type="hidden" id="idMateria" name="id">
                    <div class="textfield">
                        <label for="nomeEditar">Título:</label>
                        <input type="text" id="nomeEditar" name="nome">
                        <div class="error" id="descError"></div>
                    </div>
                    <div class="color-picker-box">
                    <label for="corEditar">Cor do caderno</label>
                    <div class="color-btn-wrapper">
                        <input type="color" id="corEditar" name="corEditar" value="#7f37c9">
                    </div>
                    </div>
                    <br>
                    <button type="submit" class="bd" id="btnAtualizarCaderno">Enviar</button>
                </form>
            </div>
        </div>

        <div id="modalC" class="modalS">
            <div class="modalS-content">
                <h2>Caderno criado com sucesso!</h2>
                <div class="modalS-progress-bar"></div>
            </div>
        </div>

        <div id="modalH" class="modalS">
            <div class="modalS-content">
                <h2>Caderno atualizado com sucesso!</h2>
                <div class="modalS-progress-bar"></div>
            </div>
        </div>

        <div id="modalG" class="modal7">
            <div class="modal7-content">
                <span class="close3">&times;</span>
                <h2>Gerenciador de cadernos!</h2>
                <br>
                <div class="table-container">
                <table class="table-roxa" id="tabela-vencidas">
                    <thead>
                        <tr>
                            <th>Matéria</th>
                            <th class="tabelaG">Favoritar</th>
                            <th class="tabelaG">Ocultar</th>
                            <th class="tabelaG">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $cadernoss = false;

                        foreach ($cadernos as $caderno): 

                        $cadernoss = true;
                        ?>
                            <tr>
                                <td><?= ($caderno['nome']) ?></td>
                                <td>
                                    <input type="checkbox" class="btn-check" id="btn-fav-<?= $caderno['id'] ?>" autocomplete="off" <?= $caderno['favoritar'] ? "checked" : "" ?>>
                                    <label class="btn fav" for="btn-fav-<?= $caderno['id'] ?>">
                                        <i class="bi bi-star-fill estrela"></i>
                                    </label>
                                </td>
                                <td>
                                    <input type="checkbox" class="btn-check" id="btn-ocult-<?= $caderno['id'] ?>" autocomplete="off" <?= $caderno['ocultar'] ? "checked" : "" ?>>
                                    <label class="btn ocult" for="btn-ocult-<?= $caderno['id'] ?>">
                                        <i class="bi bi-eye-slash-fill olho"></i>
                                    </label>
                                </td>
                                <td>
                                    <button type="button" class="btn-roxo btnExcluir" data-id="<?= $caderno['id'] ?>"> <i
                                            class="bi bi-trash"></i> </button>
                                    <button type="button" class="btn-roxo btnAtualizar" data-id="<?= $caderno['id'] ?>"> <i
                                            class="bi bi-pencil-square"></i> </button>
                                </td>
                            </tr>
                        <?php 
                        endforeach; 

                         if (!$cadernoss) {
                                echo "<tr><td colspan='5'><p>Você não tem nenhum caderno</p></p></td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
                <div class="pagination-controls">
                                <button id="anterior">Anterior</button>
                                <button id="proximo">Próxima</button>
                            </div>
            </div>
            </div>
        </div>

        <div id="modalD" class="modalE">
            <div class="modalL-content">
                <h2>Tem certeza que deseja remover seu caderno?</h2>
                <button type="button" class="btn btn-danger b1" id="remover">Sim</i></button>
                <button type="button" class="btn btn-success b2" id="manter">Não</i></button>
            </div>
        </div>

        <div id="modalE" class="modalE">
            <div class="modalE-content">
                <h2>Caderno removido com sucesso!</h2>
                <div class="modalE-progress-bar"></div>
            </div>
        </div>

    </main>
</body>
<script src="./js/cadernos.js"></script>
<script src="./js/checarCaderno.js"></script>
<script src="./js/paginacao.js"></script>
<script src="./js/ocultar.js"></script>
<script src="./js/gerenciarCadernos.js"></script>
<script src="./js/scroll.js"></script>
<?php
include "includes/footer.php";
?>