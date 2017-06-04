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

$dataAtual = date('Y-m-d');
$dados = $conexao->BDSeleciona('atividades', '*', "where(tipo_id= 2 and status = '1' and '{$dataAtual}' BETWEEN dataInicio and dataTermino);
");
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
                            fazer
                        </li>
                        <li>
                            <a href="/fazer/definirAtividade">Atividade</a>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">

                <center><h4 class="page-title">Definindo Atividade</h4></center>
                <br>
                <br>

                <form action="/definindo/atividade" class="form-horizontal" role="form" method="post">                                    
                    <div class="form-group">
                        <label class="col-md-4 control-label">Atividade:</label>
                        <div class="col-md-3">
                            <select class="form-control" name="atividade_id">
                                <option selected="" disabled="">Selecione</option>
                                <?php
                                foreach ($dados as $key => $value) {
                                    echo "<option value='{$value['id']}'>" . 'Assunto: '.$value['conteudo'].' Data inicial: '.$value['dataInicio'].' Data Final: '.$value['dataInicio']. "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Iniciar</button>
                    </div>
                </form>
            </div>   
        </div>
    </div>
</div>


<?php
require_once './footer.php';
?>