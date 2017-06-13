<?php
session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: /login");
}
$title = "Campeonato " . date('Y');
require_once './classes/autenticacao.class.php';
require_once '/classes/conexao.class.php';

$autenticacao = new Autenticacao();
$header = $autenticacao->definirNiveisAcesso();
require_once "$header";

$conexao = new Conexao();
$con = $conexao->BDAbreConexao();
$dados = $conexao->BDSQL("SELECT alunos.username, alunos.matricula, sum(respostas.resultado) as pontos, turmas.nome as turmas, turmas.ano, turmas.semestre FROM alunos
                            join registros on alunos.id = registros.aluno_id
                            join turmas on registros.turma_id = turmas.id
                            JOIN atividades on turmas.id = atividades.turma_id
                            JOIN questoes on atividades.id = questoes.atividade_id
                            JOIN respostas on respostas.questao_id = questoes.id
                            WHERE(alunos.id = respostas.aluno_id)
                            GROUP by  alunos.username,  alunos.matricula, turmas.nome, turmas.ano, turmas.semestre
                            ");

$conexao->BDFecharConexao($con);
?>
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
                            outos
                        </li>
                        <li>
                            <a href="/outros/visualizarCampeonato">Campeonato</a>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">

                <center><h4 class="page-title">Classificação do campeonato</h4></center>
                <br>
                <br>
                <div class="col-sm-18">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class='danger'><strong>Classificação</strong></th>
                                <th class='danger'><strong>Nome</strong></th>
                                <th class='danger'><strong>Matricula</strong></th>
                                <th class='danger'><strong>Pontos</strong></th>
                            </tr>
                        </thead>
                        <tbody>  
                            <?php
                            $cont = 1;

                            foreach ($dados as $key => $value) {
                                if ($cont == 1) {
                                    echo "<tr class='success'>";
                                    echo "<td>$cont</td>";
                                    echo "<td>{$value['username']}</td>";
                                    echo "<td>{$value['matricula']}</td>";
                                    echo "<td>{$value['pontos']}</td>";
                                    echo "</tr>";
                                } else {
                                    echo "<tr>";
                                    echo "<td>$cont</td>";
                                    echo "<td>{$value['username']}</td>";
                                    echo "<td>{$value['matricula']}</td>";
                                    echo "<td>{$value['pontos']}</td>";
                                    echo "</tr>";
                                }
                                $cont++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php
    require_once './footer.php';
    ?>