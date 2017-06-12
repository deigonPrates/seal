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

$dados = $conexao->BDSeleciona('niveis', '*');

$conexao->BDFecharConexao($con);
?>
<div class="container">             
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <!-- Page-Title -->
                <div class="row"  style="height:2000px">
                    <center><h4 class="page-title">Cadastrando as questões da atividade</h4></center>
                    <br>
                    <form action="/cadastrando/questoesAtividade" class="form-horizontal" role="form" method="post"> 
                        <div class="form-group">
                            <label class="col-md-2 control-label">Tipo de Questão:</label>
                            <div class="col-md-2">
                                <select class="form-control" id="tipoQuestao" name="categoria_id" onchange="optionCheck()">
                                    <option selected="" disabled="">Selecione</option>
                                    <option value='1'>Objetiva</option>
                                    <option value='2'>Subjetiva</option>
                                </select>
                            </div>
                            <label class="col-md-1 control-label">Nivel:</label>
                            <div class="col-md-2">
                                <select class="form-control" name="nivel_id">
                                    <option selected="" disabled="">Selecione</option>
                                    <?php
                                    foreach ($dados as $key => $value) {
                                        echo "<option value='{$value['id']}'>" . $value['descricao'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <label class="col-md-1 control-label">Valor:</label>
                            <div class="col-md-2">
                                <input type="number" class="form-control" name="valor" value="">
                            </div>
                        </div>
                        <div class="form-group" id="objetiva" style="display:none;">
                            <label class="col-md-2 control-label">Pergunta:</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="pergunta" value="">
                            </div>
                            <label class="col-md-2 control-label">A:</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="alternativa_a" value="">
                            </div>
                            <label class="col-md-2 control-label">B:</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="alternativa_b" value="">
                            </div>
                            <label class="col-md-2 control-label">C:</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="alternativa_c" value="">
                            </div>
                            <label class="col-md-2 control-label">D:</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="alternativa_d" value="">
                            </div>
                            <label class="col-md-2 control-label">E:</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="alternativa_e" value="">
                            </div>
                            <label class="col-md-2 control-label">Resposta:</label>
                            <div class="col-md-1">
                                <select class="form-control" id="alternativa" name="alternativa">
                                    <option selected="" disabled=""></option>
                                    <option value='a'>A</option>
                                    <option value='b'>B</option>
                                    <option value='c'>C</option>
                                    <option value='d'>D</option>
                                    <option value='e'>E</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="subjetiva" style="display:none;">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Pergunta</label>
                                <div class="col-md-8">
                                    <textarea id="code2" name="perguntaSubjetiva" rows="5" style="width: 87%;">

                                    </textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Solução:</label>
                                <div class="col-md-7">
                                    <textarea id="code" name="solucao">
                                    </textarea>
                                    <p>Selecione um tema: <select onchange="selectTheme()" id=select1>
                                            <option>default</option>
                                            <option>3024-day</option>
                                            <option>3024-night</option>
                                            <option>abcdef</option>
                                            <option>ambiance</option>
                                            <option>base16-dark</option>
                                            <option>base16-light</option>
                                            <option>bespin</option>
                                            <option>blackboard</option>
                                            <option>cobalt</option>
                                            <option>colorforth</option>
                                            <option>dracula</option>
                                            <option>duotone-dark</option>
                                            <option>duotone-light</option>
                                            <option>eclipse</option>
                                            <option>elegant</option>
                                            <option>erlang-dark</option>
                                            <option>hopscotch</option>
                                            <option>icecoder</option>
                                            <option>isotope</option>
                                            <option>lesser-dark</option>
                                            <option>liquibyte</option>
                                            <option>material</option>
                                            <option>mbo</option>
                                            <option>mdn-like</option>
                                            <option>midnight</option>
                                            <option>monokai</option>
                                            <option selected>neat</option>
                                            <option>neo</option>
                                            <option>night</option>
                                            <option>panda-syntax</option>
                                            <option>paraiso-dark</option>
                                            <option>paraiso-light</option>
                                            <option>pastel-on-dark</option>
                                            <option>railscasts</option>
                                            <option>rubyblue</option>
                                            <option>seti</option>
                                            <option>solarized dark</option>
                                            <option>solarized light</option>
                                            <option>the-matrix</option>
                                            <option>tomorrow-night-bright</option>
                                            <option>tomorrow-night-eighties</option>
                                            <option>ttcn</option>
                                            <option>twilight</option>
                                            <option>vibrant-ink</option>
                                            <option>xq-dark</option>
                                            <option>xq-light</option>
                                            <option>yeti</option>
                                            <option>zenburn</option>
                                        </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-b-0">
                            <div class="form-group">
                                <div class="col-sm-offset-5 col-sm-9">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Cadastrar</button>
                                    <button type="button" class="btn btn-danger waves-effect waves-light"><a href=" /inicio" style="color: white;"> Cancelar</a></button>
                                </div>
                            </div>
                        </div>
                    </form>
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