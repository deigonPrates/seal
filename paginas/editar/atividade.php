<?php
$title = "Cadastrar Atividade";
require_once './classes/conexao.class.php';

require_once './classes/autenticacao.class.php';

$autenticacao = new Autenticacao();
$header = $autenticacao->definirNiveisAcesso();
require_once "$header";

$conexao = new Conexao();
$con = $conexao->BDAbreConexao();

$bdAtividade = $conexao->BDSeleciona('atividades', '*', "WHERE (id = '{$_SESSION['atividade_id']}')");
$bdTurmas = $conexao->BDSeleciona('turmas', '*', "where(status = '1')");
$bdQuestao = $conexao->BDSQL("SELECT questoes.id as 'questao_id', questoes.pergunta, questoes.alternativa_a, 
                                questoes.alternativa_b, questoes.alternativa_c, questoes.alternativa_d, 
                                questoes.alternativa_e, solucoes.id as 'solucao_id', solucoes.solucao, 
                                solucoes.alternativa FROM atividades
                                join questoes on atividades.id = questoes.atividade_id
                                join solucoes on questoes.id = solucoes.questoes_id
                                WHERE(atividades.id = 24 and questoes.status = 1)");

$conexao->BDFecharConexao($con);
echo "<pre>";
var_dump($bdQuestao);
echo "</pre>";

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
                <center><h4 class="page-title">Editar atividade</h4></center>
                <br>
                <br>
                <form action="/editando/questao" class="form-horizontal" role="form" method="post">                                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Assunto:</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="assunto" value="<?php echo $bdAtividade[0]['conteudo']; ?>">
                        </div>
                        <label class="col-md-1 control-label">Turma:</label>
                        <div class="col-md-3">
                            <select class="form-control" name="turma">
                                <option selected="" disabled="">Selecione</option>
                                <?php
                                foreach ($bdTurmas as $key => $value) {
                                    if ($value['id'] == $bdAtividade[0][turma_id]) {
                                        echo "<option selected value='{$value['id']}'>" . $value['nome'] . "</option>";
                                    }
                                    echo "<option value='{$value['id']}'>" . $value['nome'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Data inicio:</label>
                        <div class="col-md-5">
                            <input type="date" class="form-control" name="dataInicio" value="<?php echo $bdAtividade[0]['dataInicio']; ?>" placeholder="">
                        </div>
                        <label class="col-md-1 control-label">Termino:</label>
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="dataTermino" value="<?php echo $bdAtividade[0]['dataTermino']; ?>" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nova questões:</label>
                        <div class="col-md-4">
                            <button type="buttom" class="btn btn-primary waves-effect waves-light"><a href="/cadastrar/adicionarQuestao" style="color: white;">Adicionar</a></button>
                        </div>
                    </div>
                    <br>
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
                                if ($bdQuestao):
                                    foreach ($bdQuestao as $key => $valor):
                                        echo "<tr>";
                                        echo "<td>{$valor['pergunta']}</td>";
                                        echo "<td>{$valor['alternativa_a']}</td>";
                                        echo "<td>{$valor['alternativa_b']}</td>";
                                        echo "<td>{$valor['alternativa_c']}</td>";
                                        echo "<td>{$valor['alternativa_d']}</td>";
                                        echo "<td>{$valor['alternativa_e']}</td>";
                                        echo "<td>{$valor['alternativa']}</td>";
                                        echo "<td>{$valor['solucao']}</td>";
                                        $id = $valor['questao_id'];
                                        echo "<td><button type='buttom' class='btn btn-warning  btn-xs' name='questao_id' value='{$id}'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></button> &nbsp";
                                        echo "&nbsp<button type='buttom' class='btn btn-danger  btn-xs'><a href='/editar/removerQuestao' style='color: white;'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a></button></td>";
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
                    <div class="form-group m-b-0">
                        <div class="col-sm-offset-5 col-sm-9">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Atualizar</button>
                        </div>
                    </div>
                </form>
            </div>   
        </div>
    </div>
</div>


<?php
require_once './footer.php';
?>