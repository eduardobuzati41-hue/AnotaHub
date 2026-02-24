<?php
if (!(isset($_COOKIE["token"]))) {
    header("Location: login.php");
    exit();
}
include "includes/auth.php";
include "includes/header.php";
?>

<body>
    <main>
        <?php
        $con = conectar();
        $usuario = SelecionarUsuarioPorId($con, $usuarioToken['id_usuario']);
        $notas = obterNotasDoDia($con, $usuarioToken['id_usuario']);
        $cadernos = obterCadernoComMaisConteudo($con, $usuarioToken['id_usuario']);
        $ultimoCaderno = obterUltimoCadernoAcessado($con, $usuarioToken['id_usuario']);
        $vencidas = obterNotaPorUsuario($con, $usuarioToken['id_usuario']);
        date_default_timezone_set('America/Sao_Paulo');
        $agora = date('d/m/Y');
        $agora2 = date('d/m');
        $dataHoje = new DateTime();


        $daysOfWeek = [
            'Sunday' => 'Domingo',
            'Monday' => 'Segunda-feira',
            'Tuesday' => 'Terça-feira',
            'Wednesday' => 'Quarta-feira',
            'Thursday' => 'Quinta-feira',
            'Friday' => 'Sexta-feira',
            'Saturday' => 'Sábado'
        ];

        $dayInEnglish = date('l');

        $atividadesSemana = selectAtividadesSemana($con, $usuarioToken['id_usuario']);

        $labels = [];
        $valores = [];

        foreach ($atividadesSemana as $diaIngles => $qtd) {
            $labels[] = $daysOfWeek[$diaIngles];
            $valores[] = $qtd;
        }
        ?>
        <div class="card-home scroll-reveal">
            <div class="container-home2">
                <div class="card-home2 scroll-reveal">
                    <h1 class="h1home">Bem-vindo, <?= $usuario["nome"] ?>!</h1>

                    <h3 class="a scroll-reveal"><?= $daysOfWeek[$dayInEnglish]; ?> - <?= $agora2 ?></h3>

                    <div class="dashboard-row">

                        <div class="img-box">
                            <img class="d-block img-fluid" src="assets/img/inicioo.png" alt="Início">
                        </div>


                        <div class="graficos-box">
                            <div class="graficos-row">

                                <div class="container-home3">
                                    <div class="card-home3">
                                        <h2 class="b">Atividades de hoje!</h2>
                                        <br>
                                        <table class="table-roxa2"  id="tabela-hoje">
                                            <thead>
                                                <tr>
                                                    <th>Atividade</th>
                                                    <th class="tabelaG">Horário</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($notas) {
                                                    foreach ($notas as $nota): ?>
                                                        <tr>
                                                            <td class="td1"><?= ($nota['descricao']) ?></td>
                                                            <td class="td1">
                                                                <?= date('H:i', strtotime($nota['hora_publicada'])) ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach;
                                                } else { ?>
                                                    <tr>
                                                        <td class="td1">Você não tem nenhuma atividade hoje</td>
                                                        <td class="td1">00:00</td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php 
                                        if ($notas) { ?>
                                         <div class="pagination-controls2">
                                            <button id="anterior2">Anterior</button>
                                            <button id="proximo2">Próxima</button>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="container-home3">
                                    <div class="card-home3">
                                        <h2 class="b">Resumo da Semana</h2>
                                        <canvas id="myChart" height="400"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-home-container">
                        <a href="cadernos.php">
                            <button type="button" class="btn-home"><i class="bi bi-rocket-takeoff"></i> Visitar
                                Cadernos</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-container4">
            <div class="card-home4">
                <h4 class="h4v">Caderno mais utilizado <i class="bi bi-trophy-fill trofeu"></i></h4>
                <div class="card-deck d-flex align-items-center justify-content-between">

                    <div class="caderno-box">
                        <?php
                        $temCaderno = false;

                        foreach ($cadernos as $caderno) {
                            if (($caderno)) {
                                $temCaderno = true;
                                $cor = ($caderno['cor']);
                                echo "<a href='caderno.php?id=" . $caderno['id'] . "' class='card-link'>";
                                echo "<div class='card notebook-card text-white my-3 mx-4' style='background-color: {$cor};'>";
                                echo "<h5 class='card-header'>" . ($caderno['nome']) . '</h5>';
                                echo "<div class='card-body'>
                                        <h5 class='card-title'>Meu Caderno AnotaHub</h5>
                                    </div>
                                </div>
                            </a>";
                                break;
                            }
                        }
                        if (!$temCaderno) {
                            echo "<p class='j'>Nenhum caderno utilizado</p>";
                        }
                        ?>
                    </div>

                    <div class="personagem-box">
                        <img src="assets/img/anotinha.png" alt="Personagem Anotahub" height="170px">
                    </div>

                </div>
            </div>
            <div class="card-home5">
                <h4 class="h4v">Atividades expiradas <i class="bi bi-exclamation-triangle-fill alerta"></i></h4>
                <div class="card-deck d-flex align-items-center justify-content-between">

                    <div class='caderno-box'>
                        <?php
                        echo "<table class='table table-striped' id='tabela-vencidas'>";
                        echo "<thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Data</th>
                                        <th>Horário</th>
                                        <th>Agenda</th>
                                    </tr>
                                </thead>";
                        echo "<tbody>";

                        $atividadesVencidas = false;

                        foreach ($vencidas as $vencida) {
                            $dataHoraPublicada = new DateTime($vencida['data_publicada'] . ' ' . $vencida['hora_publicada']);
                            if (($vencida && $dataHoraPublicada < $dataHoje) && $vencida['concluido'] == 0) {
                                $atividadesVencidas = true;
                                echo "<tr>";
                                echo "<td><span style='color: red;'>{$vencida['descricao']}</span></td>";
                                echo "<td>" . $dataHoraPublicada->format('d/m/Y') . "</td>";
                                echo "<td>" . date('H:i', strtotime($vencida['hora_publicada'])) . "</td>";
                                echo "<td><a href='agenda.php' class='bq btn-lg'><i class='bi bi-person-walking'></i></a></td>";
                                echo "</tr>";
                            }
                        }
                       
                        if (!$atividadesVencidas) {
                            echo "<tr><td colspan='5'><p>Não existem atividades vencidas</p></td></tr>";
                        }

                        ?>
                        </table>
                        
                        <div class="pagination-controls">
                            <button id="anterior">Anterior</button>
                            <button id="proximo">Próxima</button>
                        </div>


                        <?php if (!$atividadesVencidas) {
                            echo '<div class="personagem-box">
                                <img src="assets/img/feliz.png" alt="Personagem Anotahub" height="170px">
                            </div>';
                        } else{
                            echo '<div class="personagem-box">
                                <img src="assets/img/triste.png" alt="Personagem Anotahub" height="170px">
                            </div>';
                        }?>
                    </div>
                </div>
            </div>
        </div>

    </main>


    <script src="./js/agenda.js"></script>
    <script src="./js/paginacao.js"></script>
    <script src="./js/checar.js"></script>
    <script src="./js/scroll.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const diasSemana = <?= json_encode($labels) ?>;
        const qtdAtividades = <?= json_encode($valores) ?>;
    </script>
    <script src="./js/estastisticas.js"></script>

    <?php
    include "includes/footer.php";
    ?>