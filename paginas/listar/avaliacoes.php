<?php
session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: /login");
}
$title = "Listar Atividades";
require_once './classes/conexao.class.php';
require_once './classes/autenticacao.class.php';

$autenticacao = new Autenticacao();
$header = $autenticacao->definirNiveisAcesso();
require_once "$header";

$conexao = new Conexao();

$con = $conexao->BDAbreConexao();
$bdID = $conexao->BDRetornaID($_SESSION['matricula']);
$dados = $conexao->BDSQL("SELECT atividades.id, atividades.conteudo, atividades.dataInicio from alunos "
        . "join alunos_atividades on alunos.id = alunos_atividades.aluno_id "
        . "join atividades on alunos_atividades.avaliacao_id = atividades.id "
        . "WHERE(alunos.id = $bdID and atividades.tipo_id = 1)");

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
                            <a href="/listar/avaliacoes">Avaliações</a>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <center><h4 class="page-title">Listando Avaliações</h4></center>
                <br>
                <br>
                <div class="card-box">
                    <form action="/listando/questoesAtividade" class="form-horizontal" role="form" method="post">
                        <table id="demo-foo-filtering" class="table table-striped toggle-circle m-b-0" data-page-size="7">
                            <thead>
                                <tr>
                                    <th data-toggle="true">Conteudo</th>
                                    <th data-hide="phone">Valor</th>
                                    <th data-toggle="true">Data</th>
                                    <th data-hide="phone, tablet">Nota</th>
                                    <th data-toggle="true">Ação</th>
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
                                if ($dados):
                                    foreach ($dados as $key => $valor):
                                        echo "<tr>";
                                        echo "<td>{$valor['conteudo']}</td>";
                                        echo "<td>5</td>";
                                        echo "<td>{$valor['dataInicio']}</td>";
                                        echo "<td>4</td>";
                                        $aux = $valor['id'];
                                        echo "<td><button class='btn btn-primary btn-xs'name='atividade_id' value='$aux' type='submit'><span></span>Exibir</button></td>";
                                        echo "</tr>";
                                    endforeach;
                                else:
                                    echo "<tr>";
                                    echo '<td> Nenhuma Avaliação encontrada</td>';
                                    echo "</tr>";
                                endif;
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
