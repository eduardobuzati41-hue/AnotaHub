<?php
if (!(isset($_COOKIE["token"]))) {
    header("Location: login.php");
    exit();
}

include "includes/header.php";
?>

<body>
    <main>

        <?php
        $con = conectar();
        if (isset($_GET['id'])) {
            $idCaderno = $_GET['id'];
            $cadernos1 = obterCadernoPorId($con, $idCaderno, $usuarioToken['id_usuario']);
            $cadernos = obterCadernoPorUsuario($con, $usuarioToken['id_usuario']);
            $agora = date('d/m/Y');
        }
        ?>


        <div class="caderno scroll-reveal">

            <div class="d-flex align-items-center justify-content-between">
                <?php
                foreach ($cadernos1 as $caderno1) {
                    echo "<h1 class='mb-0'>" . $caderno1['nome'] . "</h1>";
                }
                ?>

                <form class="d-flex" id="formBusca">
                    <input id="inputBusca" class="form-control me-2" type="search" placeholder="Buscar..." aria-label="Search">
                </form>

            </div>

            <hr>


            <br>
            <div id="toolbar-container">
                <span class="ql-formats">
                    <select class="ql-font"></select>
                    <select class="ql-size"></select>
                </span>
                <span class="ql-formats">
                    <button class="ql-bold"></button>
                    <button class="ql-italic"></button>
                    <button class="ql-underline"></button>
                    <button class="ql-strike"></button>
                </span>
                <span class="ql-formats">
                    <select class="ql-color"></select>
                    <select class="ql-background"></select>
                </span>
                <span class="ql-formats">
                    <button class="ql-script" value="sub"></button>
                    <button class="ql-script" value="super"></button>
                </span>
                <span class="ql-formats">
                    <button class="ql-header" value="1"></button>
                    <button class="ql-header" value="2"></button>
                    <button class="ql-blockquote"></button>
                    <button class="ql-code-block"></button>
                </span>
                <span class="ql-formats">
                    <button class="ql-list" value="ordered"></button>
                    <button class="ql-list" value="bullet"></button>
                    <button class="ql-indent" value="-1"></button>
                    <button class="ql-indent" value="+1"></button>
                </span>
                <span class="ql-formats">
                    <button class="ql-direction" value="rtl"></button>
                    <select class="ql-align"></select>
                </span>
                <span class="ql-formats">
                    <button class="ql-link"></button>
                    <button class="ql-image"></button>
                    <button class="ql-video"></button>
                    <button class="ql-formula"></button>
                </span>
                <span class="ql-formats">
                    <button class="ql-clean"></button>
                </span>
            </div>
            <form id="formCaderno">
                <input type="hidden" name="usuario_id" value="<?= $usuarioToken['id_usuario'] ?>">
                <?php foreach ($cadernos1 as $caderno1) { ?>
                    <input type="hidden" name="id" value="<?= $caderno1['id'] ?>">
                    <textarea name="conteudo" id="conteudo" style="display:none;"><?= $caderno1['conteudo'] ?></textarea>
                <?php } ?>

                <div id="editor"></div>

                <div class="actions">
                    <button type="submit" class="bb" id="btnEnviar">Salvar</button>

                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button"
                            aria-haspopup="true" aria-expanded="false">Cadernos</a>
                        <ul class="dropdown-menu">
                            <?php
                            foreach ($cadernos as $caderno) {
                                echo "<li><a class='dropdown-item' href='caderno.php?id=" . $caderno['id'] . "'>" . $caderno['nome'] . "</a></li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </form>


            <div id="modalSalvo" class="modalSalvo">
                <div class="modalSalvo-content">
                    <h2 class="salvo">Conteúdo salvo com sucesso!</h2>
                </div>
            </div>

    </main>
</body>

<script src="./js/caderno.js"></script>
<script src="./js/scroll.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php
include "includes/footer.php";
?>