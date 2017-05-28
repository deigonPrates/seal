<?php
session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: /login");
}
$title = "Editar Turma";
require_once './classes/autenticacao.class.php';

$autenticacao = new Autenticacao();
$header = $autenticacao->definirNiveisAcesso();
require_once "$header";
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
                            <a href="/editar/senha">Senha</a>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">

                <center><h4 class="page-title">Edite a senha do Usuário</h4></center>
                <br>
                <br>
                <form  method="post" class="form-horizontal m-t-20" action="/atualizando/senha">                                
                    <div class="form-group">
                        <label class="col-md-4 control-label">Matricula</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="matricula" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Nova Senha</label>
                        <div class="col-md-4">
                            <input type="password" class="form-control" name="senha" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Repita a Senha</label>
                        <div class="col-md-4">
                            <input type="password" class="form-control" name="repeta-senha" value="">
                        </div>

                    </div>
                    <div class="form-group m-b-0">
                        <div class="col-sm-offset-5 col-sm-2">
                            <button type="submit" class="btn btn-info waves-effect waves-light">Atualizar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php
    require_once './footer.php';
    ?>