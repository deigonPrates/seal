<?php
session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: /login");
}
$title = "Matricular em Turma";
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
                            Cadastrar
                        </li>
                        <li>
                            <a href="/cadastrar/turma">Turma</a>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">

                <center><h4 class="page-title">Faça sua matricula</h4></center>
                <br>
                <br>
                <?php
                if (isset($_SESSION['sucesso'])) {
                    $autenciar = new Autenticacao();
                    $autenciar->SweetAlertDown('(:', 'Matricula realizada!!', 'success');

                    unset($_SESSION['sucesso']);
                }
                
                if (isset($_SESSION['erros'])) {
                    $autenciar = new Autenticacao();
                    $autenciar->SweetAlertDown('Opss! /:', $_SESSION['erros']['erro'], 'error');

                    unset($_SESSION['erros']);
                }
                
                ?>
                <form action="/matriculando/turma" class="form-horizontal" role="form" method="post">                                    
                    <div class="form-group">
                        <label class="col-md-4 control-label">Codigo:</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="codigo" value="">
                        </div>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Matricular</button>
                    </div>
                </form>
            </div>   
        </div>
    </div>
</div>


<?php
require_once './footer.php';
?>