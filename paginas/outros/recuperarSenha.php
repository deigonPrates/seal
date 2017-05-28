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
                            outos
                        </li>
                        <li>
                            <a href="/outros/recuperarSenha"> Recuperar Senha</a>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">

                <center><h4 class="page-title">Recuperando a senha</h4></center>
                <br>
                <br>
                <form  method="post" class="form-horizontal m-t-20" action="/atualizando/senha">                                
                    <div class="form-group">
                        <label class="col-md-4 control-label">Matricula</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="matricula" value="">
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <div class="col-sm-offset-5 col-sm-2">
                            <button type="submit" class="btn btn-warning waves-effect waves-light">Recuperar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php
    require_once './footer.php';
    ?>