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
                                $_SESSION['matricula'] = $_POST['matricula'];

                                $login->BDAtualiza("$bdTabela", "WHERE(matricula = {$matricula})", 'ativo', 1);
                                $login->excluirTentativasLogin($matricula);

                                header("Location: ./inicio");
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
        session_start();
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

}
