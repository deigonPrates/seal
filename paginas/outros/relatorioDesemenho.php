<?php

session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: /login");
}
$title = "Disponibilidade do aluno";
require_once './classes/conexao.class.php';
require_once './classes/autenticacao.class.php';

$autenticacao = new Autenticacao();
$header = $autenticacao->definirNiveisAcesso();
require_once "$header";
$conexao = new Conexao();
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Status', 'Quantidade'],
            ['Media Entre 5 e 7', 8],
            ['Media < 5', 3],
            ['Media Entre 7 e 9', 5],
            ['Media = 10', 1]
        ]);

        var options = {
            title: 'Atividade'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    google.charts.load("current", {packages: ["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Status', 'Total'],
            ['Aprovados', 11],
            ['Em finais', 2],
            ['Reprovados', 2]
        ]);

        var options = {
            title: 'Turma',
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
    }
</script>
<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li>
                            <a href="/inicio">Inicio</a>
                        </li>
                        <li class="active">
                            listar
                        </li>
                        <li>
                            <a href="/listar/usuario">Alunos</a>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <center><h4 class="page-title">Relatório de Desempenho</h4></center>
                <br>
                <br>
                <div class="card-box">
                    <div id="piechart"></div>
                    <div id="piechart_3d"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

require_once './footer.php';
?>
