<?php
session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: /login");
}
$title = "Inicio";
require_once './classes/autenticacao.class.php';
$autenticacao = new Autenticacao();
$header = $autenticacao->definirNiveisAcesso();
require_once "$header";

if (isset($_SESSION['bemVindo'])) {

    $autenticacao->SweetAlertDown("Bem Vindo {$_SESSION['bemVindo']}",'', 'down');
    unset($_SESSION['bemVindo']);
}
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            oi eu sou o goku!!
        </div>
    </div>
</div>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
    (function () {
        var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/58f74c61f7bbaa72709c710f/default';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
</script>
<!--End of Tawk.to Script-->
<?php
require_once './footer.php';
?>
