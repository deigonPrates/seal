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
$atividade_id = (int)$_SESSION['atividade_id'];
$atividade = $conexao->BDSeleciona('atividades', '*', "where(id = $atividade_id and status = '1')");
$questoes = $conexao->BDSeleciona('questoes', '*', "where(atividade_id = $atividade_id and status = '1')");
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
                            Corrigir
                        </li>
                        <li>
                            <a href="/listar/atividade">Atividade</a>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">

                <center><h4 class="page-title">Atividade sobre <?php echo $atividade[0]['conteudo']; ?></h4></center>
                <br>
                <br>

                <form action="#" class="form-horizontal" role="form" method="post">                                    
                    
                </form>
            </div>   
        </div>
    </div>
</div>


<?php
require_once './footer.php';
?>