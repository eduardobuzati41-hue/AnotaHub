<?php
if (!(isset($_COOKIE["token"]))) {
    header("Location: login.php");
    exit();
}
include "includes/auth.php";
include "includes/header.php";
?>

<body data-usuario="<?= $usuarioToken['id_usuario'] ?>">
    <main>
        <?php
        $con = conectar();
        $notas = obterNotaPorUsuario($con, $usuarioToken['id_usuario']);
        $agora = date('Y-m-d');
        date_default_timezone_set('America/Sao_Paulo');
        $dataHoje = new DateTime();


        $filtroData = isset($_GET['filtro_data']) ? $_GET['filtro_data'] : null;

        if ($filtroData) {
            $notas = array_filter($notas, function ($nota) use ($filtroData) {
                return $nota['data_publicada'] === $filtroData;
            });
        }
        ?>

        <div class="container-agenda">
            <div class="card-agenda scroll-reveal">
                <div class="header">Agenda</div>

                <div class="d-flex mb-3 justify-content-between align-items-center">
                    <button type="submit" class="btn-agenda" id="btnEnviar">Adicionar <i
                            class="bi bi-plus-lg"></i></button>
                    <form method="GET" class="form-inline mb-3 ms-auto">
                        <div class="estilo-filtro">
                            <div class="d-flex">
                                <input type="date" id="filtro_data" name="filtro_data" value="<?= ($filtroData) ?>">
                                <button type="submit" class="ms-2"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="content">
                    <table class="table table-striped" id="tabela-hoje">
                        <thead>
                            <th>Concluir</th>
                            <th>Título</th>
                            <th>Data</th>
                            <th>Horário</th>
                            <th>Ações</th>
                        </thead>
                        <tbody id="listarCategorias">
                            <?php

                            $atividadesSemana = false;

                            foreach ($notas as $nota) {
                                $dataHoraPublicada = new DateTime($nota['data_publicada'] . ' ' . $nota['hora_publicada']);

                                if ($nota['concluido'] != 1) {

                                    $atividadesSemana = true;

                                    echo "<tr>";
                                    echo "<td>
                                    <div class='form-check s'>
                                        <input class='form-check-input chkConcluido' type='checkbox' data-id='{$nota['id']}' " . ($nota['concluido'] ? "checked" : "") . ">
                                        <label class='form-check-label' for='defaultCheck{$nota['id']}'></label>
                                    </div>
                                </td>";
                                    echo "<td>";
                                    if ($dataHoraPublicada < $dataHoje) {
                                        echo "<span style='color: red;'>" . $nota['descricao'] . "</span>";
                                    } else {
                                        echo $nota['descricao'];
                                    }
                                    echo "</td>";
                                    echo "<td>" . $dataHoraPublicada->format('d/m/Y') . "</td>";
                                    echo "<td>" . $dataHoraPublicada->format('H:i') . "</td>";
                                    echo "<td>
                                        <button class='btnExcluir' data-id='" . $nota['id'] . "'><i class='bi bi-trash3-fill'></i></button>
                                        <button class='btnAtualizar' data-id='" . $nota['id'] . "'><i class='bi bi-pencil-fill'></i></button>
                                    </td>";
                                    echo "</tr>";
                                }
                            }

                            if (!$atividadesSemana) {
                                echo "<tr><td colspan='5'><p>Não existem atividades</p></td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="pagination-controls3">
                        <button id="anterior2">Anterior</button>
                        <button id="proximo2">Próxima</button>
                    </div>

                </div>

                <div class="footer">Fim da agenda</div>

                <div class="p-2">
                    <p class="text-dark">
                        <i class="bi bi-square-fill text-danger"></i> Atividades expiradas
                    </p>
                </div>
            </div>

            <div class="cards-laterais">

                <div class="card-lateral">
                    <h4>Resumo</h4>
                    <p>Total de atividades: <?= count($notas) ?></p>
                    <p>Atividades expiradas: <?= count(array_filter($notas, function ($n) use ($dataHoje) {
                        $dataHoraStr = $n['data_publicada'] . ' ' . $n['hora_publicada'];
                        $dataHora = DateTime::createFromFormat('Y-m-d H:i:s', $dataHoraStr);
                        if (!$dataHora) {
                            $dataHora = DateTime::createFromFormat('Y-m-d H:i', $dataHoraStr);
                        }
                        return $dataHora && $dataHora < $dataHoje;
                    })) ?></p>
                    <p>Atividades concluídas: <?= count(array_filter($notas, fn($n) => $n['concluido'] == 1)) ?></p>
                    <?php
                    $proxima = null;
                    foreach ($notas as $n) {
                        $data = new DateTime($n['data_publicada']);
                        $hora = new DateTime($n['hora_publicada']);
                        if ($n['data_publicada'] >= $agora && !$n['concluido']) {
                            $proxima = $n['descricao'] . " " . $data->format('d/m/Y') . " " . $hora->format('H:i');
                            break;
                        }
                    }
                    ?>
                    <p>Próxima atividade: <?= $proxima ?? "Nenhuma" ?></p>
                </div>

                <div class="card-lateral">
                    <h4 class="h4v">Atividades concluidas <i class="bi bi-check-circle-fill feito"></i></h4>
                    <div class="card-deck d-flex align-items-center justify-content-between">

                        <div class='caderno-box'>
                            <table class="table table-striped" id="tabela-vencidas">
                                <thead>
                                    <th>Concluir</th>
                                    <th>Título</th>
                                    <th>Data</th>
                                    <th>Ações</th>
                                </thead>
                                <tbody>
                                    <?php $atividadesConcluidas = false;

                                    foreach ($notas as $nota) {

                                        $dataHoraPublicada = new DateTime($nota['data_publicada'] . ' ' . $nota['hora_publicada']);
                                        if ($nota['concluido'] == 1) {
                                            $atividadesConcluidas = true;
                                            echo "<tr>";
                                            echo "<td>
                                                <div class='form-check s'>
                                                    <input class='form-check-input chkConcluido' type='checkbox' data-id='{$nota['id']}' " . ($nota['concluido'] ? "checked" : "") . ">
                                                    <label class='form-check-label' for='defaultCheck{$nota['id']}'></label>
                                                </div>
                                            </td>";
                                            echo "<td>";
                                            if (($dataHoraPublicada < $dataHoje)) {
                                                echo "<span style='color: red;'>" . $nota['descricao'] . "</span>";
                                            } else {
                                                echo $nota['descricao'];
                                            }
                                            echo "</td>";
                                            echo "<td>" . $dataHoraPublicada->format('d/m/Y') . "</td>";
                                            echo "<td>
                                        <button class='btnExcluir' data-id='" . $nota['id'] . "'><i class='bi bi-trash3-fill'></i></button>
                                        <button class='btnAtualizar' data-id='" . $nota['id'] . "'><i class='bi bi-pencil-fill'></i></button>
                                    </td>";
                                            echo "</tr>";
                                        }
                                    }

                                    if (!$atividadesConcluidas) {
                                        echo "<tr><td colspan='5'><p>Você não concluiu nenhuma atividade</p></p></td></tr>";
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
            </div>

            <div id="modalDetalhes" class="modal">
                <div class="modal-content modal-shadow">
                    <span class="close" data-modal-id="modalDetalhes">&times;</span>
                    <h2>Criar atividade</h2>
                    <p id="modalDescription"></p>

                    <form id="formNotas" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="usuario_id" value="<?= $usuarioToken['id_usuario'] ?>">
                        <div class="textfield">
                            <label for="descricao">Título:</label>
                            <input type="text" id="descricao" name="descricao">
                            <div class="error" id="descError"></div>
                        </div>

                        <div class="textfield">
                            <label for="data_publicada">Data:</label>
                            <input type="date" id="data_publicada" name="data_publicada" required
                                min="<?= date('Y-m-d') ?>">
                            <div class="error" id="dataError"></div>
                        </div>

                        <div class="textfieldTime">
                            <label for="hora_publicada">Horário:</label>
                            <input type="time" id="hora_publicada" name="hora_publicada">
                            <div class="error" id="timeError"></div>
                        </div>
                        <br>
                        <button type="submit" class="bd" id="btnNotas">Enviar</button>
                    </form>
                </div>
            </div>

            <div id="modalAtualizar" class="modal">
                <div class="modal-content modal-shadow">
                    <span class="close2" data-modal-id="modalAtualizar">&times;</span>
                    <h2>Editar</h2>

                    <form id="formAtualizar" method="post">
                        <input type="hidden" id="notaId" name="id">

                        <div class="textfield">
                            <label for="descricaoAtualizar">Título:</label>
                            <input type="text" id="descricaoAtualizar" name="descricao" value="">
                            <div class="error" id="descErrorAtualizar"></div>
                        </div>

                        <div class="textfield">
                            <label for="dataAtualizar">Data:</label>
                            <input type="date" id="dataAtualizar" name="data_publicada" value="" required
                                min="<?= date('Y-m-d') ?>">
                            <div class="error" id="dataErrorAtualizar"></div>
                        </div>

                        <div class="textfieldTime">
                            <label for="horaAtualizar">Horário:</label>
                            <input type="time" id="horaAtualizar" name="hora_publicada" value="">
                            <div class="error" id="timeErrorAtualizar"></div>
                        </div>

                        <br>
                        <button type="submit" class="bd">Enviar</button>
                    </form>
                </div>
            </div>

            <div id="modalR" class="modalS">
                <div class="modalS-content">
                    <h2>Atividade cadastrada com sucesso!</h2>
                    <div class="modalS-progress-bar"></div>
                </div>
            </div>

            <div id="modalC" class="modalS">
                <div class="modalS-content">
                    <h2>Atividade atualizado com sucesso!</h2>
                    <div class="modalS-progress-bar"></div>
                </div>
            </div>

            <div id="modalD" class="modalE">
                <div class="modalL-content">
                    <h2>Tem certeza que deseja remover sua Atividade?</h2>
                    <button type="button" class="btn btn-danger b1" id="remover">Sim</i></button>
                    <button type="button" class="btn btn-success b2" id="manter">Não</i></button>
                </div>
            </div>

            <div id="modalE" class="modalE">
                <div class="modalE-content">
                    <h2>Atividade removida com sucesso!</h2>
                    <div class="modalE-progress-bar"></div>
                </div>
            </div>

    </main>
</body>


<script src="./js/agenda.js"></script>
<script src="./js/checar.js"></script>
<script src="./js/paginacao.js"></script>
<script src="./js/scroll.js"></script>

<?php
include "includes/footer.php";
?>