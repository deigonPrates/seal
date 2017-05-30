<?php
session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: /login");
}
$title = "Listar Turma";
require_once './classes/conexao.class.php';
require_once './classes/autenticacao.class.php';

$autenticacao = new Autenticacao();
$header = $autenticacao->definirNiveisAcesso();
require_once "$header";
$conexao = new Conexao();

$con = $conexao->BDAbreConexao();
$bdID = $conexao->BDRetornaID($_SESSION['matricula']);
$dados = $conexao->BDSQL("select turmas.nome, turmas.id, turmas.semestre, turmas.ano, professores.nome as professor from alunos 
                         join registros on registros.aluno_id = alunos.id 
                         join turmas on turmas.id = registros.turma_id 
                         join professores_turmas on professores_turmas.turma_id = turmas.id 
                         join professores on professores.id = professores_turmas.professor_id 
                         WHERE(alunos.id = $bdID)
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
                            listar
                        </li>
                        <li>
                            <a href="/listar/turma">Turma</a>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <center><h4 class="page-title">Listando Turma</h4></center>
                <br>
                <br>
                <div class="card-box">
                    <form action="/atualizar/status/turma/turmas" class="form-horizontal" role="form" method="post">
                        <table id="demo-foo-filtering" class="table table-striped toggle-circle m-b-0" data-page-size="7">
                            <thead>
                                <tr>
                                    <th data-toggle="true">Nome</th>
                                    <th data-toggle="true">Professor</th>
                                    <th data-hide="phone, tablet">Ano</th>
                                    <th data-hide="phone, tablet">Semestre</th>
                                </tr>
                            </thead>
                            <div class="form-inline m-b-20">
                                <div class="row">
                                    <div class="col-sm-6 text-xs-center">
                                        <div class="form-group">
                                            <label class="control-label m-r-5">Status</label>
                                            <select id="demo-foo-filter-status" class="form-control input-sm">
                                                <option selected="" disabled=""value="">Selecione</option>
                                                <option value="">Todos</option>
                                                <option value="disponivel">disponivel</option>
                                                <option value="bloqueado">bloqueado</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 text-xs-center text-right">
                                        <div class="form-group">
                                            <input id="demo-foo-search" type="text" placeholder="Pesquisar" class="form-control input-sm" autocomplete="on">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <tbody>
                                <?php
                                foreach ($dados as $key => $valor):
                                    echo "<tr>";
                                    echo "<td>{$valor['nome']}</td>";
                                    echo "<td>{$valor['professor']}</td>";
                                    echo "<td>{$valor['ano']}</td>";
                                    echo "<td>{$valor['semestre']}</td>";
                                    echo "</tr>";
                                endforeach;
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <div class="text-right">
                                            <ul class="pagination pagination-split m-t-30 m-b-0"></ul>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<?php
require_once './footer.php';
?>
