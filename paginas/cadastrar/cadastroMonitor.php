<?php
session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: /login");
}
$title = "Cadastrar Avaliação";
require_once './classes/conexao.class.php';
require_once './classes/autenticacao.class.php';

$autenticacao = new Autenticacao();
$header = $autenticacao->definirNiveisAcesso();
require_once "$header";

$conexao = new Conexao();
$con = $conexao->BDAbreConexao();

$turmas = $conexao->BDSeleciona('turmas', '*', "where(status = '1')");

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
                            Cadastrar
                        </li>
                        <li>
                            <a href="/cadastrar/cadastroMonitor">Monitor</a>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <center><h4 class="page-title">Cadastrando monitor</h4></center>
                <br>
                <br>
                <?php
                if (isset($_SESSION['sucesso'])) {
                    $autenticacao->SweetAlertDown('', $_SESSION['sucesso'], 'down');
                    unset($_SESSION['sucesso']);
                }
                if (isset($_SESSION['erro'])) {
                    $autenticacao->SweetAlertDown('', $_SESSION['erro'], 'down');
                     unset($_SESSION['erro']);
                }
                ?>
                <form  method="post" class="form-horizontal m-t-20" action="/cadastrando/monitor">
                    <div class="form-group ">
                        <div class="col-xs-8">
                            <input class="form-control" type="text" required="" name="nome" placeholder="Nome">
                        </div>
                        <div class="col-xs-4">
                            <input class="form-control" type="text" required="" name="matricula" placeholder="Matricula">
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-8">
                            <input class="form-control" type="email" required="" name="email" placeholder="Email">
                        </div>
                        <div class="col-xs-4">
                            <input class="form-control" type="text" required="" name="username" placeholder="Nome de Usuário">
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-4">
                            <input class="form-control" type="text" required="" name="ano" placeholder="Ano">
                        </div>
                        <div class="col-xs-4">
                            <input class="form-control" type="text" required="" name="semestre" placeholder="semestre">
                        </div>
                        <div class="col-md-4">
                            <select class="form-control" name="turma_id">
                                <option selected="" disabled="">Selecione uma turma</option>
                                <?php
                                foreach ($turmas as $key => $value) {
                                    echo "<option value='{$value['id']}'>" . $value['nome'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-6">
                            <input class="form-control" type="password" required="" name="senha" placeholder="Senha">
                        </div>
                        <div class="col-xs-6">
                            <input class="form-control" type="password" required="" name="repeta-senha" placeholder="Repita a senha">
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <div class="col-sm-offset-5 col-sm-9">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Cadastrar</button>
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