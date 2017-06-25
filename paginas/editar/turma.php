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
$turma_id = (int) $_SESSION['turma'];
$con = $conexao->BDAbreConexao();
$id = (int) $conexao->BDRetornaID($_SESSION['matricula']);
$dados = $conexao->BDSQL("SELECT turmas.id, turmas.codigo,turmas.nome,turmas.ano, turmas.semestre FROM turmas 
                        JOIN professores_turmas on turmas.id = professores_turmas.turma_id
                        join professores on professores.id = professores_turmas.professor_id
                        WHERE(professores.id = $id and turmas.id = $turma_id)");

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
                    <form action="/salvando/turma" class="form-horizontal" role="form" method="post">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Nome:</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="nome" value="<?php echo $dados[0]['nome']; ?>">
                            </div>
                            <label class="col-md-1 control-label">Codigo:</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="codigo" value="<?php echo $dados[0]['codigo']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Ano:</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="ano" value="<?php echo $dados[0]['ano']; ?>">
                            </div>
                            <label class="col-md-1 control-label">Semestre:</label>
                            <div class="col-md-2">
                                <input type="number" class="form-control" name="semestre" value="<?php echo $dados[0]['semestre']; ?>">
                            </div>
                        </div>
                        <div class="form-group m-b-0">
                            <div class="col-sm-offset-5 col-sm-9">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Atualizar</button>
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