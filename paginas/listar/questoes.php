<?php
session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: /login");
}
$title = "Cadastrar Atividade";
require_once './classes/conexao.class.php';

require_once './classes/autenticacao.class.php';

$autenticacao = new Autenticacao();
$header = $autenticacao->definirNiveisAcesso();
require_once "$header";

$conexao = new Conexao();
$con = $conexao->BDAbreConexao();

$bdAtividade = $conexao->BDSeleciona('exemplos', '*');
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
                            Editar
                        </li>
                        <li>
                            <a href="/editar/definirAtividade">Atividade</a>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <center><h4 class="page-title">Listando Questões</h4></center>
                <br>
                <form action="/editando/questao" class="form-horizontal" role="form" method="post">                                    

                    <div class="card-box">
                        <table id="demo-foo-filtering" class="table table-striped toggle-circle m-b-0" data-page-size="7">
                            <thead>
                                <tr>
                                    <th data-toggle="true">Pergunta</th>
                                    <th data-hide="phone, tablet">A</th>
                                    <th data-hide="phone, tablet">B</th>
                                    <th data-hide="phone, tablet">C</th>
                                    <th data-hide="phone, tablet">D</th>
                                    <th data-hide="phone, tablet">E</th>
                                    <th data-hide="phone, tablet">Alternativa</th>
                                    <th data-hide="phone, tablet">Solução</th>
                                    <th data-hide="phone, tablet">Ação</th>
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
                                if ($bdAtividade):
                                    foreach ($bdAtividade as $key => $valor):
                                        echo "<tr>";
                                        echo "<td>{$valor['pergunta']}</td>";
                                        echo "<td>{$valor['alternativa_a']}</td>";
                                        echo "<td>{$valor['alternativa_b']}</td>";
                                        echo "<td>{$valor['alternativa_c']}</td>";
                                        echo "<td>{$valor['alternativa_d']}</td>";
                                        echo "<td>{$valor['alternativa_e']}</td>";
                                        echo "<td>{$valor['alternativa']}</td>";
                                        echo "<td>{$valor['solucao']}</td>";
                                        $id = $valor['id'];
                                        echo "<td><button type='buttom' class='btn btn-warning  btn-xs' name='questao_id' value='{$id}'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></button> &nbsp";
                                        echo "<br><br><a href='/editar/removerQuestao'><span class='btn btn-danger  btn-xs glyphicon glyphicon-remove' aria-hidden='true'></span></a>";
                                        echo "</tr>";
                                    endforeach;
                                else:
                                    echo "<tr>";
                                    echo '<td> Nenhuma atividade encontrada</td>';
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
                    </div>
                </form>
            </div>   
        </div>
    </div>
</div>
<?php
require_once './footer.php';
?>