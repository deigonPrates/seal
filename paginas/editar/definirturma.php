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
$id = (int) $conexao->BDRetornaID($_SESSION['matricula']);
$dados = $conexao->BDSQL("SELECT turmas.id, turmas.codigo,turmas.nome,turmas.ano, turmas.semestre FROM turmas 
                        JOIN professores_turmas on turmas.id = professores_turmas.turma_id
                        join professores on professores.id = professores_turmas.professor_id
                        WHERE(professores.id = $id)");

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
                            editar
                        </li>
                        <li>
                            <a href="/editar/turma">Turma</a>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <center><h4 class="page-title">Editando Turma</h4></center>
                <br>
                <br>
                <div class="card-box">
                    <form action="/atualizando/turma" class="form-horizontal" role="form" method="post">
                        <table id="demo-foo-filtering" class="table table-striped toggle-circle m-b-0" data-page-size="7">
                            <thead>
                                <tr>
                                    <th data-toggle="true">Nome</th>
                                    <th data-hide="phone, tablet">Codigo</th>
                                    <th data-hide="phone, tablet">Semestre</th>
                                    <th data-hide="phone, tablet">Ano</th>
                                    <th data-hide="phone">Ação</th>
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
                                    echo "<td>{$valor['codigo']}</td>";
                                    echo "<td>{$valor['ano']}</td>";
                                    echo "<td>{$valor['semestre']}</td>";
                                    $aux = $valor['id'];
                                    echo "<td><button class='btn btn-danger btn-xs'value='$aux' name='id' type='submit'>Editar</button></td>";
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

<?php
require_once './footer.php';
?>
