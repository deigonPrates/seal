<?php

require_once 'login.class.php';
require_once 'validarCampos.php';

class Autenticacao {

    public function autenticarUsuario($dados) {
        $login = new Login();
        $validar = new ValidarCampos();

        $matricula = $dados['matricula'];
        $senha = $dados['senha'];
        $erro = [];

        $dados = [
            'matricula' => $matricula,
            'senha' => $senha
        ];

        $validacao = $validar->validarLogin($dados);

        if ($validacao->status) {

            $matricula = ($validacao->dados[0]["matricula"]);
            $senha = ($validacao->dados[1]["senha"]);

            $tabela = $login->BDRetornarTabela($matricula);

            $consulta = false;

            if ($tabela) {
                $consulta = $login->BDSeleciona("$tabela", '*', "where(matricula like '{$matricula}')");
            }
            if ($consulta != FALSE) {

                $bdMatricula = $matricula;
                $bdSenha = $consulta[0]['senha'];
                $bdTabela = $tabela;
                $ativo = (int) $consulta[0]['ativo'];

                if ($bdMatricula == false) {
                    $erro = array_merge($erro, ["Dados invalidos"]);
                } else {
                    if ($ativo == 0) {
                        if ($login->checarTentativasLogin($matricula)) {

                            if ($senha == $bdSenha) {
                                session_start();
                                $_SESSION['matricula'] = $dados['matricula'];
                                $nome = $login->BDSeleciona("$bdTabela", '*', "WHERE(matricula like '{$dados['matricula']}')");
                                $_SESSION['bemVindo'] = $nome[0]['username'];

                                $login->BDAtualiza("$bdTabela", "WHERE(matricula = {$matricula})", 'ativo', 1);
                                $login->excluirTentativasLogin($matricula);
                                $this->SweetAlertDown('Login realizado com sucesso! (:', 'redirecionando...', 'success');
                                header("Refresh: 3,  /inicio");
                            } else {
                                $login->registrarTentativaLogin($matricula);
                                $erro = array_merge($erro, ["Dados incorretos, por favor confira seus dados e tente novamente!"]);
                            }
                        } else {
                            $erro = array_merge($erro, ["Usuario bloqueado"]);
                        }
                    } else {
                        $erro = array_merge($erro, ["Está usuario já encontra-se logado no sistema"]);
                    }
                }
            } else {
                $erro = array_merge($erro, ["Dados incorretos, por favor confira seus dados e tente novamente!"]);
            }
            if (count($erro) > 0) {
                session_start();
                $_SESSION['erro'] = $erro;
                header("Location: ./login");
            }
        }
    }

    public function definirNiveisAcesso() {
        if (!isset($_SESSION)) {
            session_start();
        }
        $login = new Login();
        $conexao = $login->BDAbreConexao();

        $consulta = $login->BDRetornarPapelID($_SESSION['matricula']);
        $login->BDFecharConexao($conexao);

        switch ($consulta) {
            case 1:
                return './headerProfessor.php';
                break;
            case 2:
                return './headerAluno.php';
                break;
            case 3:
                return './headerMonitor.php';
                break;
        }
    }

    public function alert($tipo, $conteudo) {
        echo "<div class = 'alert alert-$tipo fade in'>";
        echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
        echo "<strong>Opss!</strong> " . $conteudo . "</div >";
    }

    public function SweetAlertDown($titulo, $conteudo, $tipo, $redirecionamento = false) {

        echo "<html>"
        . "<head>"
        . "<title></title>"
        . "<script src='/assets/alert/sweetalert2.min.js'></script>"
        . "<link rel='stylesheet' href='/assets/alert/sweetalert2.min.css'>"
        . "<script src='https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js'></script>"
        . "</head>"
        . "<body>";
        echo "<script>";

        if (($tipo == "down") && ($redirecionamento == false)) {
            echo "swal({
                title: '$titulo',
                text: '$conteudo',
                timer: 6000
            }).then(
                    function redireciona() {},
                    // handling the promise rejection
                            function (dismiss) {
                                if (dismiss === 'timer') {
                                    console.log('contando')
                                }
                            }
                    )";
        }
        if (($tipo == "down") && ($redirecionamento != false)) {
            echo "swal({
                title: '$titulo',
                text: '$conteudo',
                timer: 6000
            }).then(
                    function redireciona() {
                    window.location.href = '{$redirecionamento}';
                    },
                    // handling the promise rejection
                            function (dismiss) {
                                if (dismiss === 'timer') {
                                   window.setTimeout('location.href='/$redirecionamento',4000);
                                }
                            }
                    )";
        } elseif ($tipo == "success") {
            echo "swal(
                    '$titulo',
                    '$conteudo',
                    'success'
                  )";
        } elseif ($tipo == "error") {
            echo "swal(
                        '$titulo',
                        '$conteudo',
                        'error'
                      )";
        }
        echo "</script>";
        echo "</body>";
        echo "</html>";
    }

    public function ValidarAcesso($matricula, $acesso) {
        $login = new Login();

        $conexao = $login->BDAbreConexao();
        $papel = $login->BDRetornarPapelID($matricula);
        $login->BDFecharConexao($conexao);
        
        if ($papel != $acesso) {
            return false;
        } else {
            return true;
        }
    }

}
