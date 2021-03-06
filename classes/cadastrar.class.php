<?php

require_once './classes/validarCampos.php';
require_once './classes/conexao.class.php';
require_once './classes/autenticacao.class.php';

class Cadastrar extends Conexao {

    public function cadastrarAluno($dados) {

        $validar = new ValidarCampos();
        $objValidar = $validar->ValidarCadastroUsuario($dados);
        $erro = [];
        if ($objValidar->status === TRUE) {
            $this->DBGravar('alunos', $objValidar->dados);

            session_start();
            $_SESSION['matricula'] = $_POST['matricula'];

            header("Location: /inicio");
        } else {

            var_dump($objValidar->erro);
            $erro = array_merge($erro, ["Ouvi um problema ao tentar cadastrar o usario por favor confira seus dados"]);
            session_start();
            $_SESSION['erro'] = $erro;
            #header("Location: /cadastro");
        }
    }

    public function cadastrarMonitor($dados) {

        $validar = new ValidarCampos();
        $objValidar = $validar->ValidarCadastroMonitor($dados);
        $erro = [];
        if ($objValidar->status === TRUE) {
            $this->DBGravar('monitores', $objValidar->dados);

            session_start();
            $_SESSION['sucesso'] = 'Monitor cadastrado com sucesso!';
            header("Location: /cadastrar/cadastroMonitor");
        } else {
            session_start();
            $_SESSION['erro'] = $objValidar->erro;
            header("Location: /cadastrar/cadastroMonitor");
        }
    }

    public function cadastrarAtividade($dados) {

        $validar = new ValidarCampos();
        $objValidar = $validar->validarCadastroAtividade($dados);

        if ($objValidar->status) {

            $this->DBGravar('atividades', $objValidar->dados);

            header("Location: /cadastrar/questao");
        } else {
            print_r($objValidar->erro);
        }
    }

    public function cadastrarAvaliacao($dados) {

        $validar = new ValidarCampos();
        $objValidar = $validar->validarCadastroAvaliacao($dados);

        if ($objValidar->status) {
            $this->DBGravar('atividades', $objValidar->dados);
            header("Location: /cadastrar/questao");
        } else {
            print_r($objValidar->erro);
        }
    }

    public function cadastrarTurma($dados) {
        $validar = new ValidarCampos();
        $objValidar = $validar->validarCadastroTurma($dados);

        if ($objValidar->status) {
            $this->DBGravar('turmas', $objValidar->dados);

            $autenticar = new Autenticacao();

            $autenticar->SweetAlertDown('Cadastro realizado', 'turma foi cadastrada com sucesso', 'success');
            header("Refresh: 3,  /cadastrar/turma");
        } else {
            $autenticar->SweetAlertDown('Opss ):', $objValidar->erro, 'error');
            header("Refresh: 3,  /cadastrar/turma");
        }
    }

    public function cadastrarQuestoes($dados) {
        $validar = new ValidarCampos();
        $conn = $this->BDAbreConexao();

        $lastAtividade = $this->BDSeleciona('atividades', 'id', "order by id desc LIMIT 1");
        $atividade = $lastAtividade[0]['id'];
        $dados = array_merge($dados, [
            'atividade_id' => $atividade
        ]);

        $objValidar = $validar->validarCadastroQuestao($dados);

        if ($objValidar->status) {
            $dados = $objValidar->dados;

            unset($dados['alternativa']);
            unset($dados['solucao']);
            unset($dados['perguntaSubjetiva']);

            $this->DBGravar('questoes', $dados);

            $this->cadastrarSolucao($objValidar->dados);
            header("Location: /cadastrar/questao");
        } else {
            print_r($objValidar->erro);
        }
        $this->BDFecharConexao($conn);
    }

    private function cadastrarSolucao($dados) {
        if(!isset($_SESSION)){
            session_start();
        }
        $aluno_id = $this->BDRetornaID($_SESSION['matricula']);
        $lastID = $this->BDSeleciona('questoes', 'id', "order by id desc LIMIT 1");
        $id = $lastID[0]['id'];
        if (isset($dados['solucao']) && ($dados['solucao'] == 1)) {

            $solucao = $dados['solucao'];
            $grava = [
                'questoes_id' => $id,
                'solucao' => $solucao,
                'aluno_id' =>$aluno_id
            ];
        } else {
            $alternativa = $dados['alternativa'];
            $grava = [
                'questoes_id' => $id,
                'alternativa' => $alternativa,
                'aluno_id' =>$aluno_id
            ];
        }

        $this->DBGravar('solucoes', $grava);
    }

    public function adicionarQuestoes($dados) {
        session_start();

        $validar = new ValidarCampos();
        $conn = $this->BDAbreConexao();

        $atividade = $_SESSION['atividade_id'];

        $dados = array_merge($dados, [
            'atividade_id' => $atividade
        ]);
        $solucao = $dados['solucao'];
        if ($dados['categoria_id'] == 1) {
            $alternativa = $dados['alternativa'];

            $cadastroSolucao = [
                'alternativa' => $alternativa
            ];
        } else {
            $cadastroSolucao = [
                'solucao' => $solucao
            ];
        }


        $objValidar = $validar->validarAdicaoQuestao($dados);

        if ($objValidar->status) {
            $dados = $objValidar->dados;
            unset($dados['alternativa']);
            unset($dados['solucao']);

            $this->DBGravar('questoes', $dados);

            $this->cadastrarSolucao($dados);
            header("Location: /cadastrar/adicionarQuestao");
        } else {
            print_r($objValidar->erro);
        }
        $this->BDFecharConexao($conn);
    }

    public function matricularTurma($dados) {
        session_start();
        $ObjValidar = new ValidarCampos();
        $autenticar = new Autenticacao();
        $erro[] = NULL;

        $validar = $ObjValidar->validarMatriculaTurma($dados);
        if ($validar->status) {
            $codigo = $validar->dados['codigo'];

            $bdTurma = $this->BDSeleciona('turmas', '*', "WHERE(codigo like '{$codigo}' and status = 1)");
            if (!$bdTurma) {
                $erro = array_merge($erro, ['erro' => "O codigo informado para fazer a matricula é invalido por favor informe outro!"]);
            } else {
                $matricula = $_SESSION['matricula'];
                $aluno_id = $this->BDRetornaID($matricula);
                $tabela = $this->BDRetornarTabela($matricula);
                $turma_id = $bdTurma[0]['id'];

                if ($tabela != 'alunos') {
                    $erro = array_merge($erro, ['erro' => "Houve um problema com o nivel de acesso por favor consulte o adiminstrador! <strong> ERROR: 4321</strong>"]);
                } else {
                    $dados = [
                        'turma_id' => $turma_id,
                        'aluno_id' => $aluno_id
                    ];
                    $bdregistro = $this->BDSeleciona('registros', '*', "WHERE(turma_id = $turma_id and aluno_id = $aluno_id)");

                    if (isset($bdregistro[0])) {

                        $erro = array_merge($erro, ['erro' => "Você já encontrase matriculado nesta turma!"]);
                    } else {
                        $grava = $this->DBGravar('registros', $dados);
                        session_start();
                        unset($_SESSION['erros']);
                        $_SESSION['sucesso'] = 'Matricula realizada!';
                        header('Location: /cadastrar/matriculaTurma');
                    }
                }
            }
            if (count($erro) > 0) {
                session_start();
                unset($_SESSION['erros']);
                $_SESSION['erros'] = $erro;
                header('Location: /cadastrar/matriculaTurma');
            }
        }
    }

    public function definirResolucaoAtividade($dados) {
        session_start();
        $_SESSION['atividade_id'] = $dados['id'];
        header('Location: /fazer/correcaoAtividade');
    }

}
