<?php

require_once './classes/validarCampos.php';
require_once './classes/conexao.class.php';

class Cadastrar extends Conexao {

    public function cadastrarAluno($dados) {

        $validar = new ValidarCampos();
        $objValidar = $validar->ValidarCadastroUsuario($dados);

        if ($objValidar->status === TRUE) {
            $this->DBGravar('alunos', $objValidar->dados);

            session_start();
            $_SESSION['matricula'] = $_POST['matricula'];

            header("Location: /inicio");
        } else {
            print_r($objValidar->erro);
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

            header("Location: /inicio");
        } else {
            print_r($objValidar->erro);
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

        $lastID = $this->BDSeleciona('questoes', 'id', "order by id desc LIMIT 1");
        $solucao = $dados['solucao'];
        $alternativa = $dados['alternativa'];
        $id = $lastID[0]['id'];

        $grava = [
            'questoes_id' => $id,
            'solucao' => $solucao,
            'alternativa' => $alternativa
        ];

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
                'alternativa' => $alternativa,
                'solucao' => $solucao
            ];
        }
        $cadastroSolucao = [
            'alternativa' => $alternativa,
            'solucao' => $solucao
        ];

        $objValidar = $validar->validarAdicaoQuestao($dados);

        if ($objValidar->status) {
            $dados = $objValidar->dados;
            unset($dados['alternativa']);
            unset($dados['solucao']);

            $this->DBGravar('questoes', $dados);

            $this->cadastrarSolucao($cadastroSolucao);
            header("Location: /cadastrar/adicionarQuestao");
        } else {
            print_r($objValidar->erro);
        }
        $this->BDFecharConexao($conn);
    }

    public function matricularTurma($dados) {
        session_start();
        $ObjValidar = new ValidarCampos();
        $erro[] = NULL;

        $validar = $ObjValidar->validarMatriculaTurma($dados);
        if ($validar->status) {
            $condigo = $validar->dados['codigo'];
            $bdTurma = $this->BDSeleciona('turmas', '*', "WHERE(codigo like '{$condigo}' and status = 1)");

            if (!$bdTurma) {
                $erro = array_merge($erro, ['erro' => "O codigo informado para fazer a matricula é invalido por favor informe novamente!"]);
                print_r($erro);
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

                    if (!$bdregistro) {
                        $grava = $this->DBGravar('registros', $dados);
                    } else {
                        $erro = array_merge($erro, ['erro' => "Você já encontrase matriculado nesta turma!"]);
                    }
                    if ($grava) {
                        header('Location: /inicio');
                    } else {
                        $erro = array_merge($erro, ['erro' => "Houve um problema ao gravar no banco consulte o adiminstrador! <strong> ERROR: 777</strong>"]);
                    }
                }
                if (count($erro) > 0) {
                    unset($_SESSION['erros']);
                    $_SESSION['erros'] = $erro;
                    header('Location: /inicio');
                }
            }
        }
    }

}
