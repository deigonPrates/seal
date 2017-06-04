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
$dados = $conexao->BDSeleciona('turmas', '*');

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
                                    <th data-hide="phone, tablet">Codigo</th>
                                    <th data-hide="phone, tablet">Semestre</th>
                                    <th data-hide="phone, tablet">Ano</th>
                                    <th data-hide="phone">Visualizar</th>
                                    <th data-hide="phone, tablet">Status</th>
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
                                    echo "<td>{$valor['codigo']}</td>";
                                    echo "<td>{$valor['ano']}</td>";
                                    echo "<td>{$valor['semestre']}</td>";
                                    $aux = $valor['id'];
                                    echo "<td><button class='btn btn-primary btn-xs'id='$aux' data-toggle='modal' data-target='#modal$aux' type='button'><span class='glyphicon  glyphicon-folder-open'></span></button></td>";
                                    if ($valor['status'] == 0):
                                        $aux = $valor['id'];
                                        echo "<td><span><button type='submit' class='btn btn-success btn-xs' name='$aux' >liberar</button></span></td>";
                                        echo "<td></td>";
                                    else:
                                        $aux = $valor['id'];
                                        echo "<td><span><button type='submit' class='btn btn-danger btn-xs' name='$aux'>bloquear</button></span></td>";
                                    endif;
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
<div id="<?php echo 'modal' . $aux; ?>" data-backdrop="static" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="full-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="full-width-modalLabel"><strong>Alunos matriculados</strong></h4>
            </div>
            <div class="modal-body">
                <table id="demo-foo-filtering" class="table table-striped toggle-circle m-b-0" data-page-size="7">
                    <thead>
                        <tr>
                            <th data-toggle="true">Nome</th>
                            <th data-toggle="true">Matricula</th>
                            <th data-hide="phone, tablet">Semestre</th>
                            <th data-hide="phone, tablet">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $con = $conexao->BDAbreConexao();
                        $dados = $conexao->BDSeleciona('alunos', '*');
                        $conexao->BDFecharConexao($con);
                        foreach ($dados as $key => $valor):
                            echo "<tr>";
                            echo "<td>{$valor['nome']}</td>";
                            echo "<td>{$valor['matricula']}</td>";
                            echo "<td>{$valor['semestre']}</td>";
                            $aux = $valor['id'];
                            if ($valor['status'] == 0):
                                $aux = $valor['id'];
                                echo "<td><span><button type='submit' class='btn btn-success btn-xs' name='$aux' >liberar</button></span></td>";
                            else:
                                $aux = $valor['id'];
                                echo "<td><span><button type='submit' class='btn btn-danger btn-xs' name='$aux'>Excluir</button></span></td>";
                            endif;
                            ?>
                        <?php
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fechar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php
require_once './footer.php';
?>
