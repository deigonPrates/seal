<?php
session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: /login");
}
$title = "Listar Questões";
require_once './classes/conexao.class.php';
require_once './classes/autenticacao.class.php';

$autenticacao = new Autenticacao();
$header = $autenticacao->definirNiveisAcesso();
require_once "$header";

$questoes_id = (int) $_SESSION['questao_id'];

$conexao = new Conexao();

$con = $conexao->BDAbreConexao();
$bdNivel = $conexao->BDSeleciona('niveis');
$bdQuestao = $conexao->BDSeleciona('questoes', '*', "where(id = {$questoes_id})");
$bdSolucao = $conexao->BDSeleciona('solucoes', '*', "where(questoes_id = {$questoes_id})");
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
                            <a href="/editar/questao">Questão</a>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <center><h4 class="page-title">Editar Questão</h4></center>
                <br>
                <br><form action="/atualizando/questoesAtividade" class="form-horizontal" role="form" method="post"> 
                    <div class="form-group">
                        <label class="col-md-3 control-label">Tipo de Questão:</label>
                        <div class="col-md-3">
                            <select class="form-control" id="tipoQuestao" name="categoria_id" onchange="optionCheck()">
                                <option selected="" disabled="">Selecione</option>
                                <?php
                                if ($bdQuestao[0]['categoria_id'] == 1) {
                                    echo "<option selected value = '1'>Objetiva</option>";
                                    echo "<option value = '2'>Subjetiva</option>";
                                } else {
                                    echo "<option value = '1'>Objetiva</option>";
                                    echo "<option selected value = '2'>Subjetiva</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <label class="col-md-1 control-label">Nivel:</label>
                        <div class="col-md-3">
                            <select class="form-control" name="nivel_id">
                                <option selected="" disabled="">Selecione</option>
                                <?php
                                foreach ($bdNivel as $key => $value) {
                                    if ($value['id'] == $bdQuestao[0]['nivel_id']) {
                                        echo "<option selected value='{$value['id']}'>" . $value['descricao'] . "</option>";
                                    } else {
                                        echo "<option value='{$value['id']}'>" . $value['descricao'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php
                    switch ($bdQuestao[0]['categoria_id']) {
                        case '1':
                            $style1 = "style='display:block;'";
                            $style2 = "style='display:none;'";
                            break;
                        case '2':
                            $style1 = "style='display:none;'";
                            $style2 = "style='display:block;'";
                            break;
                        default:
                            $style1 = "style='display:none;'";
                            $style2 = "style='display:none;'";
                    }
                    ?>
                    <div class="form-group" id="objetiva"<?php echo $style1; ?>>
                        <label class="col-md-2 control-label">Pergunta:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="pergunta" value="<?php echo $bdQuestao[0]['pergunta']; ?>">
                        </div>
                        <label class="col-md-2 control-label">A:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="alternativa_a" value="<?php echo $bdQuestao[0]['alternativa_a']; ?>">
                        </div>
                        <label class="col-md-2 control-label">B:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="alternativa_b" value="<?php echo $bdQuestao[0]['alternativa_b']; ?>">
                        </div>
                        <label class="col-md-2 control-label">C:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="alternativa_c" value="<?php echo $bdQuestao[0]['alternativa_c']; ?>">
                        </div>
                        <label class="col-md-2 control-label">D:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="alternativa_d" value="<?php echo $bdQuestao[0]['alternativa_d']; ?>">
                        </div>
                        <label class="col-md-2 control-label">E:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="alternativa_e" value="<?php echo $bdQuestao[0]['alternativa_e']; ?>">
                        </div>
                        <label class="col-md-2 control-label">Resposta:</label>
                        <div class="col-md-1">
                            <select class="form-control" id="alternativa" name="alternativa">
                                <option selected="" disabled=""></option>
                                <?php
                                switch ($bdSolucao[0]['alternativa']) {
                                    case 'a':
                                        echo "<option selected value = 'a'>A</option>";
                                        echo "<option value = 'b'>B</option>";
                                        echo "<option value = 'c'>C</option>";
                                        echo "<option value = 'd'>D</option>";
                                        echo "<option value = 'e'>E</option>";
                                        break;
                                    case 'b':
                                        echo "<option selected value = 'b'>b</option>";
                                        echo "<option value = 'b'>B</option>";
                                        echo "<option value = 'c'>C</option>";
                                        echo "<option value = 'd'>D</option>";
                                        echo "<option value = 'e'>E</option>";
                                        break;
                                    case 'c':
                                        echo "<option selected value = 'c'>C</option>";
                                        echo "<option value = 'b'>B</option>";
                                        echo "<option value = 'c'>C</option>";
                                        echo "<option value = 'd'>D</option>";
                                        echo "<option value = 'e'>E</option>";
                                        break;
                                    case 'd':
                                        echo "<option selected value = 'd'>D</option>";
                                        echo "<option value = 'b'>B</option>";
                                        echo "<option value = 'c'>C</option>";
                                        echo "<option value = 'd'>D</option>";
                                        echo "<option value = 'e'>E</option>";
                                        break;
                                    case 'e':
                                        echo "<option selected value = 'e'>E</option>";
                                        echo "<option value = 'b'>B</option>";
                                        echo "<option value = 'c'>C</option>";
                                        echo "<option value = 'd'>D</option>";
                                        echo "<option value = 'e'>E</option>";
                                        break;
                                    default :
                                        echo "<option value = 'a'>A</option>";
                                        echo "<option value = 'b'>B</option>";
                                        echo "<option value = 'c'>C</option>";
                                        echo "<option value = 'd'>D</option>";
                                        echo "<option value = 'e'>E</option>";
                                }
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="subjetiva" <?php echo $style2; ?>>
                        <label class="col-md-2 control-label">Pergunta:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="perguntaSubjetiva" value="<?php echo $bdQuestao[0]['pergunta']; ?>">
                        </div>
                        <label class="col-md-2 control-label">Solucao:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="solucao" value="<?php echo $bdSolucao[0]['solucao']; ?>">
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-9">
                                <button type="submit" class="btn btn-success waves-effect waves-light">Atualizar</button>
                                <button type="button" class="btn btn-danger waves-effect waves-light"><a href=" /editar/definirAtividade" style="color: white;"> Canselar</a></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>   
        </div>
    </div>
</div>
<script>
    function optionCheck() {
        var option = document.getElementById("tipoQuestao").value;
        if (option == "1") {
            document.getElementById("objetiva").style.display = "block";
            document.getElementById("subjetiva").style.display = "none";
        }
        if (option == "2") {
            document.getElementById("subjetiva").style.display = "block";
            document.getElementById("objetiva").style.display = "none";
        }
    }
</script>
<?php
require_once './footer.php';
?>
