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
$atividade_id = $_SESSION['atividade_id'];
$atividade = $conexao->BDSeleciona('atividades', '*', "where(id = $atividade_id and status = '1')");
$questoes = $conexao->BDSeleciona('questoes', '*', "where(atividade_id = $atividade_id and status = '1')");
$numero = $_SESSION['numero'];

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
                            <a href="/cadastrar/atividade">Atividade</a>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">

                <center><h4 class="page-title">Atividade sobre <?php echo $atividade[0]['conteudo']; ?></h4></center>
                <br>
                <br>

                <form action="/cadastrando/respostaAtividade" class="form-horizontal" role="form" method="post">                                    
                    <div class="form-group">
                        <?php
                        foreach ($questoes as $key => $value) :
                            if ($value['numero'] == $numero):
                                echo"<label class='col-md-2 control-label'>Pergunta:</label>";
                                echo "<div class='col-md-8'>";
                                echo "<input type='text' disabled='' class='form-control' placeholder='{$value['pergunta']}'>";
                                echo "</div>";
                                $aux = $value['id'];
                                if ($value['categoria_id'] == 2):
                                    ?>
                    </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Resposta:</label>
                                    <div class="col-md-8">
                                         <textarea id="code" name="resposta">
                                    </textarea>
                                    <p>Selecione um tema: <select onchange="selectTheme()" id=select>
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
                                <div class="form-group m-b-0">
                                    <div class="col-sm-offset-5 col-sm-9">
                                        <button type="submit" class="btn btn-success waves-effect waves-light" name="questao_id" value="<?php echo $aux; ?>">Cadastrar</button>
                                    </div>
                                </div>
                                <?php
                            else:
                                ?>
                                <div class="form-group col-md-10">
                                    <label class="col-md-2 control-label">A:</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" disabled="" value="<?php echo $value['alternativa_a'];?>">
                                    </div>
                                    <label class="col-md-2 control-label">B:</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" disabled=""  value="<?php echo $value['alternativa_b'];?>">
                                    </div>
                                    <label class="col-md-2 control-label">C:</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" disabled=""  value="<?php echo $value['alternativa_c'];?>">
                                    </div>
                                    <label class="col-md-2 control-label">D:</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" disabled=""  value="<?php echo $value['alternativa_d'];?>">
                                    </div>
                                    <label class="col-md-2 control-label">E:</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" disabled=""  value="<?php echo $value['alternativa_e'];?>">
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
                                <div class="form-group m-b-0">
                                    <div class="col-sm-offset-5 col-sm-9">
                                        <button type="submit" class="btn btn-success waves-effect waves-light" name="questao_id" value="<?php echo $aux; ?>">Cadastrar</button>
                                    </div>
                                </div>
                            <?php
                            endif;
                        endif;
                    endforeach;
                    ?>
                </form>
            </div>   
        </div>
    </div>
</div>


<?php
require_once './footer.php';
?>