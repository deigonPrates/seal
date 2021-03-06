<?php
session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: /login");
    exit();
}
$title = "Listar Usuarios";
require_once './classes/conexao.class.php';
require_once './classes/autenticacao.class.php';

$autenticacao = new Autenticacao();
$header = $autenticacao->definirNiveisAcesso();
require_once "$header";

if (!$autenticacao->ValidarAcesso($_SESSION['matricula'], 1)) {
    echo "<script>location.href='/inicio';</script>";
    exit();
}


$conexao = new Conexao();
$con = $conexao->BDAbreConexao();

$tabela = $conexao->BDRetornarTabela($_SESSION['matricula']);
$consulta = $conexao->BDSeleciona("$tabela", '*', "WHERE(matricula like '{$_SESSION['matricula']}')");
$nome = $consulta[0]['nome'];
$email = $consulta[0]['email'];
$username = $consulta[0]['username'];

if ($tabela != 'professores') {
    $semestre = $consulta[0]['semestre'];
    $ano = $consulta[0]['ano'];
}
$conexao->BDFecharConexao($con);
?>
<div class="row" id="resultado">
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
                            Visualizar
                        </li>
                        <li>
                            <a href="/outros/historico_admin">Histórico</a>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <center><h4 class="page-title">Histórico</h4></center>
                <br>
                <br>
                <div class="card-box">
                        <table id="demo-foo-filtering" class="table table-striped toggle-circle m-b-0" data-page-size="7">
                            <thead>
                                <tr>
                                    <th data-toggle="true">Nome</th>
                                    <th data-toggle="true">Matricula</th>
                                    <th data-toggle="true">Detalhes</th>
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
                                                <option value="liberar">liberar</option>
                                                <option value="bloquear">bloquear</option>
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
                                $con = $conexao->BDAbreConexao();
                                $dados = $conexao->BDSeleciona('alunos', '*');
                                $conexao->BDFecharConexao($con);
                                foreach ($dados as $key => $valor):
                                    echo "<tr>";
                                    echo "<td>{$valor['nome']}</td>";
                                    echo "<td>{$valor['matricula']}</td>";
                                    $aux = $valor['id'];
                                    echo "<td><button class='btn btn-xs'id='$aux' data-toggle='modal' data-target='#modal$aux' type='button'><span class='glyphicon glyphicon-eye-open'></span></button></td>";
                                    echo "<td><a href='/outros/historico?id=$aux'target='_blank'><button class='btn btn-primary btn-xs' type='button'>Gerar Historico</button></a></td>";
                                    ?>   
                                <div id="<?php echo 'modal' . $aux; ?>" data-backdrop="static" class="modal fade" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content  col-sm-12">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <?php
                                                $con = $conexao->BDAbreConexao();
                                                $papel = $conexao->BDSeleciona('papeis', 'descricao', "WHERE(id = {$valor['papel_id']})");
                                                $conexao->BDFecharConexao($con);
                                                ?>
                                                <h4 class="modal-title"><strong>Detalhes do <?php echo $papel[0]['descricao'] ?></strong></h4>
                                            </div>   
                                            <div class="col-sm-12"style="width:70%">
                                                <img src="../../assets/images/user.jpg" alt="5%" class="img-circle img-responsive">
                                            </div>
                                            <div class="form-group  col-sm-12">
                                                <label disabled="" class="col-md-2 control-label">Nome:</label>
                                                <div class="col-md-5">
                                                    <input disabled="" type="text" class="form-control" value="<?php echo $valor['nome']; ?>">
                                                </div>
                                                <label disabled="" class="col-md-2 control-label">Username:</label>
                                                <div class="col-md-3">
                                                    <input disabled="" type="text" class="form-control" value="<?php echo $valor['username']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <label class="col-md-2 control-label" for="email">Email:</label>
                                                <div class="col-md-5">
                                                    <input disabled="" type="email" id="example-email" class="form-control" value="<?php echo $valor['email']; ?>">
                                                </div>
                                                <label class="col-md-2 control-label">Matricula:</label>
                                                <div class="col-md-3">
                                                    <input disabled="" type="text" class="form-control" name="matricula" value="<?php echo $valor['matricula']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group  col-sm-12">
                                                <label class="col-md-2 control-label">Ano:</label>
                                                <div class="col-md-2">
                                                    <input disabled="" type="text" class="form-control" name="ano" value="<?php echo $valor['ano']; ?>">
                                                </div>
                                                <label class="col-md-2 control-label">Semestre:</label>
                                                <div class="col-md-2">
                                                    <input  disabled=""  type="text" class="form-control" name="semestre" value="<?php echo $valor['semestre']; ?>">
                                                </div>
                                            </div>
                                            <div class="modal-footer  col-sm-12">
                                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Fechar</button>
                                                <button type="button" class="btn btn-success waves-effect waves-light">Salvar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.modal -->
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
            </div>
        </div>
    </div>
</div>
<?php
require_once './footer.php';
?>
