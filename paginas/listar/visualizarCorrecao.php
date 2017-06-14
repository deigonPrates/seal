<?php
session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: /login");
}
$title = "Listar Avaliaçoes";
require_once './classes/conexao.class.php';
require_once './classes/autenticacao.class.php';

$autenticacao = new Autenticacao();
$header = $autenticacao->definirNiveisAcesso();
require_once "$header";
$conexao = new Conexao();

$con = $conexao->BDAbreConexao();
$id = $conexao->BDRetornaID($_SESSION['matricula']);
$dados= $conexao->BDSQL("SELECT  distinct alunos.id, questoes.numero,questoes.pergunta, solucoes.id as id_solucao, 
                            solucoes.solucao, solucoes.alternativa, respostas.id as resposta_id, 
                            respostas.questao_id, respostas.resposta, respostas.comentario FROM alunos 
                            join alunos_atividades on alunos.id = alunos_atividades.aluno_id
                            join atividades on alunos_atividades.avaliacao_id = atividades.id
                            join questoes on questoes.atividade_id = atividades.id
                            JOIN respostas on respostas.questao_id = questoes.id
                            join solucoes on solucoes.questoes_id = questoes.id
                            WHERE(alunos.id = $id and atividades.id = {$_SESSION['atividade_id']} and respostas.aluno_id = $id) 
                            ORDER by questoes.numero asc");
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
                            <a href="/listar/avaliacao">Avaliações</a>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <center><h4 class="page-title">Correção da Avaliação</h4></center>
                <br>
                <br>
                <div class="card-box">
                    <form action="/salvar/correcao" class="form-horizontal" role="form" method="post">
                        <table id="demo-foo-filtering" class="table table-striped toggle-circle m-b-0" data-page-size="7">
                            <thead>
                                <tr>
                                    <th data-toggle="true">Numero</th>
                                    <th data-toggle="true">Pergunta</th>
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
                                if ($dados) {
                                    foreach ($dados as $key => $valor):
                                        echo "<tr>";
                                        echo "<td>{$valor['numero']}</td>";
                                        echo "<td>{$valor['pergunta']}</td>";
                                        $aux = $valor['resposta_id'];
                                        echo "<td><button class='btn btn-primary btn-xs'id='$aux' data-toggle='modal' data-target='#modal$aux' type='button'>Exibir</button></td>";
                                        echo "</tr>";
                                        ?>
                                    <div id="<?php echo 'modal' . $aux; ?>" data-backdrop="static" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="full-width-modalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-full">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title" id="full-width-modalLabel"><strong>Correção de Avaliação</strong></h4>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="col-md-12">
                                                        <div class="col-md-5">
                                                            <label class="">Codigo da solução</label>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <label class="">Codigo do aluno</label>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="">Comentario</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="col-md-5">
                                                            <textarea id="code1" name="solucao">
                                                                <?php echo $valor['solucao']; ?>
                                                            </textarea>
                                                            <select style="display:none" onchange="selectTheme()" id=selecte>
                                                                <option>default</option>
                                                                <option>3024-day</option>
                                                                <option>3024-night</option>
                                                                <option>abcdef</option>
                                                                <option>ambiance</option>
                                                                <option>base16-dark</option>
                                                                <option>base16-light</option>
                                                                <option>bespin</option>
                                                                <option>blackboard</option>
                                                                <option>cobalt</option>
                                                                <option>colorforth</option>
                                                                <option>dracula</option>
                                                                <option>duotone-dark</option>
                                                                <option>duotone-light</option>
                                                                <option selected>eclipse</option>
                                                                <option>elegant</option>
                                                                <option>erlang-dark</option>
                                                                <option>hopscotch</option>
                                                                <option>icecoder</option>
                                                                <option>isotope</option>
                                                                <option>lesser-dark</option>
                                                                <option>liquibyte</option>
                                                                <option>material</option>
                                                                <option>mbo</option>
                                                                <option>mdn-like</option>
                                                                <option>midnight</option>
                                                                <option>monokai</option>
                                                                <option>neat</option>
                                                                <option>neo</option>
                                                                <option>night</option>
                                                                <option>panda-syntax</option>
                                                                <option>paraiso-dark</option>
                                                                <option>paraiso-light</option>
                                                                <option>pastel-on-dark</option>
                                                                <option>railscasts</option>
                                                                <option>rubyblue</option>
                                                                <option>seti</option>
                                                                <option>solarized dark</option>
                                                                <option>solarized light</option>
                                                                <option>the-matrix</option>
                                                                <option>tomorrow-night-bright</option>
                                                                <option>tomorrow-night-eighties</option>
                                                                <option>ttcn</option>
                                                                <option>twilight</option>
                                                                <option>vibrant-ink</option>
                                                                <option>xq-dark</option>
                                                                <option>xq-light</option>
                                                                <option>yeti</option>
                                                                <option>zenburn</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <textarea id="code2" name="resposta">
                                                                <?php print_r($valor['resposta']); ?>
                                                            </textarea>
                                                            <select  style="display:none" onchange="selectTheme()" id=selects>
                                                                <option>default</option>
                                                                <option>3024-day</option>
                                                                <option>3024-night</option>
                                                                <option>abcdef</option>
                                                                <option>ambiance</option>
                                                                <option>base16-dark</option>
                                                                <option>base16-light</option>
                                                                <option>bespin</option>
                                                                <option>blackboard</option>
                                                                <option>cobalt</option>
                                                                <option>colorforth</option>
                                                                <option>dracula</option>
                                                                <option>duotone-dark</option>
                                                                <option>duotone-light</option>
                                                                <option>eclipse</option>
                                                                <option selected="">elegant</option>
                                                                <option>erlang-dark</option>
                                                                <option>hopscotch</option>
                                                                <option>icecoder</option>
                                                                <option>isotope</option>
                                                                <option>lesser-dark</option>
                                                                <option>liquibyte</option>
                                                                <option>material</option>
                                                                <option>mbo</option>
                                                                <option>mdn-like</option>
                                                                <option>midnight</option>
                                                                <option>monokai</option>
                                                                <option>neat</option>
                                                                <option>neo</option>
                                                                <option>night</option>
                                                                <option>panda-syntax</option>
                                                                <option>paraiso-dark</option>
                                                                <option>paraiso-light</option>
                                                                <option>pastel-on-dark</option>
                                                                <option>railscasts</option>
                                                                <option>rubyblue</option>
                                                                <option>seti</option>
                                                                <option>solarized dark</option>
                                                                <option>solarized light</option>
                                                                <option>the-matrix</option>
                                                                <option>tomorrow-night-bright</option>
                                                                <option>tomorrow-night-eighties</option>
                                                                <option>ttcn</option>
                                                                <option>twilight</option>
                                                                <option>vibrant-ink</option>
                                                                <option>xq-dark</option>
                                                                <option>xq-light</option>
                                                                <option>yeti</option>
                                                                <option>zenburn</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <textarea disabled="" id="code3" class="form-control" name="comentario" rows="5" style="margin: 0px; width: 227px; height: 224px;">
                                                                <?php echo $valor['comentario'];?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="form-group text-center m-t-40">
                                                        <div class="col-xs-12" style="padding-top: 2%;">
                                                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Fechar</button>
                                                        </div> 
                                                    </div> 
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                    <?php
                                endforeach;
                            }else {
                                echo "<tr>";
                                echo "<td>Nenuma questão cadastrada!</td>";
                                echo "</tr>";
                            }
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
