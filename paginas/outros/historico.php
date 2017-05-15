<?php
$title = "Historico";
require_once './classes/autenticacao.class.php';

$autenticacao = new Autenticacao();
$header = $autenticacao->definirNiveisAcesso();
require_once "$header";
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            o historico vem aqui
        </div>
    </div>
</div>


<?php
require_once './footer.php';
?>
