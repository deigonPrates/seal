<?php

include_once './classes/conexao.class.php';
include_once './classes/autenticacao.class.php';

date_default_timezone_set("America/Sao_Paulo");
setlocale(LC_ALL, 'pt_BR');

class ValidarCampos {

    public function validarLogin($dados) {

        $objRetorno = new stdClass();
        $objRetorno->erro = [];
        $objRetorno->dados = [];
        $objRetorno->status = TRUE;

        $matricula = ($dados['matricula']) ? filter_var($dados['matricula'], FILTER_SANITIZE_STRING) : NULL;
        $senha = ($dados['senha']) ? filter_var($dados['senha'], FILTER_SANITIZE_STRING) : NULL;

        if (is_null($matricula)) {
            $objRetorno->erro[] = 'O campo matricula nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados[] = ['matricula' => $matricula];
        }
        if (is_null($senha)) {
            $objRetorno->erro[] = 'O campo senha nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados[] = ['senha' => $senha];
        }

        return $objRetorno;
    }

    public function ValidarCadastroUsuario($dados) {
        $auth = new Autenticacao();

        $conexao = new Conexao();
        $objRetorno = new stdClass();
        $objRetorno->erro = [];
        $objRetorno->dados = [];
        $objRetorno->status = TRUE;

        $nome = ($dados['nome']) ? filter_var($dados['nome'], FILTER_SANITIZE_STRING) : null;
        $matricula = ($dados['matricula']) ? filter_var($dados['matricula'], FILTER_SANITIZE_STRING) : NULL;
        $email = ($dados['email']) ? filter_var($dados['email'], FILTER_SANITIZE_EMAIL) : NULL;
        $username = ($dados['username']) ? filter_var($dados['username'], FILTER_SANITIZE_STRING) : NULL;
        $ano = ($dados['ano']) ? filter_var($dados['ano'], FILTER_SANITIZE_NUMBER_INT) : NULL;
        $semestre = ($dados['semestre']) ? filter_var($dados['semestre'], FILTER_SANITIZE_NUMBER_INT) : NULL;
        $senha = ($dados['senha']) ? filter_var($dados['senha'], FILTER_SANITIZE_STRING) : NULL;
        $repetaSenha = ($dados['repeta-senha']) ? filter_var($dados['repeta-senha'], FILTER_SANITIZE_STRING) : NULL;

        $pass = $auth->hashHX($senha); #criptografando a senha
        $senhaAux = $pass['password']; #passando a senha criptografada
        $salt = $pass['salt']; #definindo o salt
        $repetaSenhaCripto = $auth->hashHX($repetaSenha, $salt); #gerendo senha apartir do salt
        $repetaSenhaAux = $repetaSenhaCripto['password']; #passando a senha criptografada

        if (is_null($nome)) {
            $objRetorno->erro[] = 'O campo nome nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['nome' => $nome]);
        }
        if (is_null($matricula)) {
            $objRetorno->erro[] = 'O campo matricula nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['matricula' => $matricula]);
        }
        if (is_null($email)) {
            $objRetorno->erro[] = 'O campo email nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['email' => $email]);
        }
        if (is_null($username)) {
            $objRetorno->erro[] = 'O campo username nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['username' => $username]);
        }
        if (is_null($ano)) {
            $objRetorno->erro[] = 'O campo ano nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['ano' => $ano]);
        }
        if (is_null($semestre)) {
            $objRetorno->erro[] = 'O campo semestre nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['semestre' => $semestre]);
        }
        if (is_null($senha)) {
            $objRetorno->erro[] = 'O campo senha nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, [
                'senha' => $senhaAux,
                'salt' => $salt
            ]);
        }
        if (is_null($repetaSenha)) {
            $objRetorno->erro[] = 'O campo senha nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        }
        if ($senhaAux != $repetaSenhaAux) {
            $objRetorno->erro[] = 'As senhas informadas nao coincedem';
            $objRetorno->status = FALSE;
        }
        $bdEmail = $this->validarEntrada($email, "email");
        if ($bdEmail) {
            $objRetorno->erro[] = 'Ja existe um cadastro feito com esse email, por favor use outro!';
            $objRetorno->status = FALSE;
        }
        $bdMatricula = $this->validarEntrada($matricula, "matricula");
        if ($bdMatricula) {
            $objRetorno->erro[] = 'Ja existe um cadastro feito com essa matricula, por favor use outra!';
            $objRetorno->status = FALSE;
        }

        return $objRetorno;
    }

    public function ValidarCadastroMonitor($dados) {

        $auth = new Autenticacao();
        $conexao = new Conexao();
        $objRetorno = new stdClass();
        $objRetorno->erro = [];
        $objRetorno->dados = [];
        $objRetorno->status = TRUE;

        $nome = ($dados['nome']) ? filter_var($dados['nome'], FILTER_SANITIZE_STRING) : null;
        $matricula = ($dados['matricula']) ? filter_var($dados['matricula'], FILTER_SANITIZE_STRING) : NULL;
        $email = ($dados['email']) ? filter_var($dados['email'], FILTER_SANITIZE_EMAIL) : NULL;
        $username = ($dados['username']) ? filter_var($dados['username'], FILTER_SANITIZE_STRING) : NULL;
        $ano = ($dados['ano']) ? filter_var($dados['ano'], FILTER_SANITIZE_NUMBER_INT) : NULL;
        $semestre = ($dados['semestre']) ? filter_var($dados['semestre'], FILTER_SANITIZE_NUMBER_INT) : NULL;
        $senha = ($dados['senha']) ? filter_var($dados['senha'], FILTER_SANITIZE_STRING) : NULL;
        $repetaSenha = ($dados['repeta-senha']) ? filter_var($dados['repeta-senha'], FILTER_SANITIZE_STRING) : NULL;
        $turma = ($dados['turma_id']) ? filter_var($dados['turma_id'], FILTER_SANITIZE_STRING) : NULL;
        $turma = (int) $turma;
        $papel = 3;

        $pass = $auth->hashHX($senha); #criptografando a senha
        $senhaAux = $pass['password']; #passando a senha criptografada
        $salt = $pass['salt']; #definindo o salt
        $repetaSenhaCripto = $auth->hashHX($repetaSenha, $salt); #gerendo senha apartir do salt
        $repetaSenhaAux = $repetaSenhaCripto['password']; #passando a senha criptografada

        if (is_null($nome)) {
            $objRetorno->erro[] = 'O campo nome nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['nome' => $nome, 'papel_id' => $papel]);
        }
        if (is_null($matricula)) {
            $objRetorno->erro[] = 'O campo matricula nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['matricula' => $matricula, 'turma_id' => $turma]);
        }
        if (is_null($email)) {
            $objRetorno->erro[] = 'O campo email nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['email' => $email]);
        }
        if (is_null($username)) {
            $objRetorno->erro[] = 'O campo username nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['username' => $username]);
        }
        if (is_null($ano)) {
            $objRetorno->erro[] = 'O campo ano nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['ano' => $ano]);
        }
        if (is_null($semestre)) {
            $objRetorno->erro[] = 'O campo semestre nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['semestre' => $semestre]);
        }
        if (is_null($senha)) {
            $objRetorno->erro[] = 'O campo senha nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, [
                'senha' => $senhaAux,
                'salt' => $salt
            ]);
        }
        if (is_null($repetaSenha)) {
            $objRetorno->erro[] = 'O campo senha nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        }
        if ($senhaAux != $repetaSenhaAux) {
            $objRetorno->erro[] = 'As senhas informadas nao coincedem';
            $objRetorno->status = FALSE;
        }
        $bdEmail = $this->validarEntrada($email, "email");
        if ($bdEmail) {
            $objRetorno->erro[] = 'Ja existe um cadastro feito com esse email, por favor use outro!';
            $objRetorno->status = FALSE;
        }
        $bdMatricula = $this->validarEntrada($matricula, "matricula");
        if ($bdMatricula) {
            $objRetorno->erro[] = 'Ja existe um cadastro feito com essa matricula, por favor use outra!';
            $objRetorno->status = FALSE;
        }

        return $objRetorno;
    }

    public function validarCadastroAvaliacao($dados) {

        $objRetorno = new stdClass();
        $objRetorno->erro = [];
        $objRetorno->dados = [];
        $objRetorno->status = TRUE;

        $assunto = ($dados['assunto']) ? filter_var($dados['assunto'], FILTER_SANITIZE_STRING) : null;
        $turma = ($dados['turma']) ? filter_var($dados['turma'], FILTER_SANITIZE_STRING) : null;
        $data = $dados['data'];
        $valor = $dados['valor'];
        $dataAtual = date('Y-m-d');
        $dataTermino = $data;
        $dataModificacao = $dataAtual;

        if (is_null($assunto)) {
            $objRetorno->erro[] = 'O campo assunto nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['conteudo' => $assunto]);
        }
        if (is_null($turma)) {
            $objRetorno->erro[] = 'O campo turma nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['turma_id' => $turma]);
        }
        if (strtotime($data) < strtotime($dataAtual)) {
            $objRetorno->erro[] = 'A data informada e menor que a data atual. Por favor corrija';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, [
                'dataInicio' => $data,
                'dataTermino' => $data,
                'dataModificacao' => $dataModificacao
            ]);
        }
        if (is_null($valor)) {
            $objRetorno->erro[] = 'O campo valor nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['nota' => $valor]);
        }

        if ($objRetorno->status) {
            $objRetorno->dados = array_merge($objRetorno->dados, ['tipo_id' => 1]);
        }
        return $objRetorno;
    }

    public function validarCadastroAtividade($dados) {
        $objRetorno = new stdClass();
        $objRetorno->erro = [];
        $objRetorno->dados = [];
        $objRetorno->status = TRUE;
        $dataAtual = date('Y-m-d');
        $dataModificacao = $dataAtual;

        $assunto = $dados['assunto'];
        $turma = $dados['turma'];
        $dataInicio = $dados['dataInicio'];
        $dataTermino = $dados['dataTermino'];

        if (is_null($assunto)) {
            $objRetorno->erro[] = 'O campo assunto nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['conteudo' => $assunto]);
        }
        if (is_null($turma)) {
            $objRetorno->erro[] = 'O campo turma nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['turma_id' => $turma]);
        }
        if (is_null($dataInicio)) {
            $objRetorno->erro[] = 'O campo data de inicio nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['dataInicio' => $dataInicio]);
        }
        if (is_null($dataTermino)) {
            $objRetorno->erro[] = 'O campo data de termino nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, [
                'dataTermino' => $dataTermino,
                'dataModificacao' => $dataModificacao
            ]);
        }
        if (strtotime($dataInicio) > strtotime($dataTermino)) {
            $objRetorno->erro[] = 'A data de inicio tem que ser menor que a data de termino';
            $objRetorno->status = FALSE;
        }
        if (strtotime($dataInicio) < strtotime($dataAtual)) {
            $objRetorno->erro[] = 'A data de inicio esta menor que a data atual por favor corrija';
            $objRetorno->status = FALSE;
        }
        if (strtotime($dataTermino) < strtotime($dataAtual)) {
            $objRetorno->erro[] = 'A data de termino esta menor que a data atual por favor corrija';
            $objRetorno->status = FALSE;
        }
        return $objRetorno;
    }

    public function validarCadastroQuestao($dados) {
        $objRetorno = new stdClass();
        $objRetorno->erro = [];
        $objRetorno->dados = [];
        $objRetorno->status = TRUE;

        $categoria_id = ($dados['categoria_id']) ? filter_var($dados['categoria_id'], FILTER_SANITIZE_STRING) : null;
        $atividade_id = ($dados['atividade_id']) ? filter_var($dados['atividade_id'], FILTER_SANITIZE_STRING) : null;
        $pergunta = ($dados['pergunta']) ? filter_var($dados['pergunta'], FILTER_SANITIZE_STRING) : null;
        $alternativa_a = ($dados['alternativa_a']) ? filter_var($dados['alternativa_a'], FILTER_SANITIZE_STRING) : null;
        $alternativa_b = ($dados['alternativa_b']) ? filter_var($dados['alternativa_b'], FILTER_SANITIZE_STRING) : null;
        $alternativa_c = ($dados['alternativa_c']) ? filter_var($dados['alternativa_c'], FILTER_SANITIZE_STRING) : null;
        $alternativa_d = ($dados['alternativa_d']) ? filter_var($dados['alternativa_d'], FILTER_SANITIZE_STRING) : null;
        $alternativa_e = ($dados['alternativa_e']) ? filter_var($dados['alternativa_e'], FILTER_SANITIZE_STRING) : null;
        $alternativa = ($dados['alternativa']) ? filter_var($dados['alternativa'], FILTER_SANITIZE_STRING) : null;
        $solucao = ($dados['solucao']) ? filter_var($dados['solucao'], FILTER_SANITIZE_STRING) : null;
        $numero = $this->retornarNumeroQuestao($atividade_id);
        $nivel_id = ($dados['nivel_id']) ? filter_var($dados['nivel_id'], FILTER_SANITIZE_STRING) : null;
        $perguntaSubjetiva = ($dados['perguntaSubjetiva']) ? filter_var($dados['perguntaSubjetiva'], FILTER_SANITIZE_STRING) : null;
        $valor = $dados['valor'];
        $categoria_id = intval($categoria_id);

        if (!is_null($valor)) {
            $objRetorno->dados = array_merge($objRetorno->dados, ['valor' => $valor]);
        } else {
            $objRetorno->erro[] = 'O campo valor nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        }
        if ($categoria_id == 2) {
            $objRetorno->dados = array_merge($objRetorno->dados, ['atividade_id' => $atividade_id,
                'categoria_id' => $categoria_id,
                'valor' => $valor
            ]);
            if (!is_null($solucao)) {
                $objRetorno->dados = array_merge($objRetorno->dados, ['solucao' => $solucao]);
            } else {
                $objRetorno->erro[] = 'O campo solucao nao foi preenchido corretamente';
                $objRetorno->status = FALSE;
            }
            if (!is_null($perguntaSubjetiva)) {
                $objRetorno->dados = array_merge($objRetorno->dados, ['pergunta' => $perguntaSubjetiva]);
            } else {
                $objRetorno->erro[] = 'O campo Pergunta nao foi preenchido corretamente';
                $objRetorno->status = FALSE;
            }
            if ($numero != false) {
                $objRetorno->dados = array_merge($objRetorno->dados, ['numero' => $numero]);
            } else {
                $objRetorno->erro[] = 'O campo numero nao foi preenchido corretamente contate o administrado do sistema';
                $objRetorno->status = FALSE;
            }
        } elseif ($categoria_id == 1) {
            if (!is_null($categoria_id) && (($categoria_id > 0) && ($categoria_id < 3))) {
                $objRetorno->dados = array_merge($objRetorno->dados, [
                    'atividade_id' => intval($atividade_id),
                    'categoria_id' => $categoria_id
                ]);
            } else {
                $objRetorno->erro[] = 'O campo Tipo da questão nao foi preenchido corretamente';
                $objRetorno->status = FALSE;
            }
            if ($numero != false) {
                $objRetorno->dados = array_merge($objRetorno->dados, ['numero' => $numero]);
            } else {
                $objRetorno->erro[] = 'O campo numero nao foi preenchido corretamente contate o administrado do sistema';
                $objRetorno->status = FALSE;
            }
            if (!is_null($pergunta)) {
                $objRetorno->dados = array_merge($objRetorno->dados, ['pergunta' => $pergunta]);
            } else {
                $objRetorno->erro[] = 'O campo pergunta nao foi preenchido corretamente contate';
                $objRetorno->status = FALSE;
            }
            if (!is_null($alternativa_a) && !is_null($alternativa_b)) {
                $objRetorno->dados = array_merge($objRetorno->dados, [
                    'alternativa_a' => $alternativa_a,
                    'alternativa_b' => $alternativa_b,
                    'alternativa_c' => $alternativa_c,
                    'alternativa_d' => $alternativa_d,
                    'alternativa_e' => $alternativa_e
                ]);
            } else {
                $objRetorno->erro[] = 'Deve ter ao menos duas auternativas';
                $objRetorno->status = FALSE;
            }
            if (!is_null($alternativa)) {
                $objRetorno->dados = array_merge($objRetorno->dados, ['alternativa' => $alternativa]);
            } else {
                $objRetorno->erro[] = 'O campo resposta nao foi preenchido corretamente';
                $objRetorno->status = FALSE;
            }
        }
        if (!is_null($nivel_id)) {
            $objRetorno->dados = array_merge($objRetorno->dados, ['nivel_id' => intval($nivel_id)]);
        } else {
            $objRetorno->erro[] = 'O campo Nivel nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        }

        return $objRetorno;
    }

    public function validarAdicaoQuestao($dados) {
        $objRetorno = new stdClass();
        $objRetorno->erro = [];
        $objRetorno->dados = [];
        $objRetorno->status = TRUE;

        $categoria_id = ($dados['categoria_id']) ? filter_var($dados['categoria_id'], FILTER_SANITIZE_STRING) : null;
        $nivel_id = ($dados['nivel_id']) ? filter_var($dados['nivel_id'], FILTER_SANITIZE_STRING) : null;
        $pergunta = ($dados['pergunta']) ? filter_var($dados['pergunta'], FILTER_SANITIZE_STRING) : null;
        $alternativa_a = ($dados['alternativa_a']) ? filter_var($dados['alternativa_a'], FILTER_SANITIZE_STRING) : null;
        $alternativa_b = ($dados['alternativa_b']) ? filter_var($dados['alternativa_b'], FILTER_SANITIZE_STRING) : null;
        $alternativa_c = ($dados['alternativa_c']) ? filter_var($dados['alternativa_c'], FILTER_SANITIZE_STRING) : null;
        $alternativa_d = ($dados['alternativa_d']) ? filter_var($dados['alternativa_d'], FILTER_SANITIZE_STRING) : null;
        $alternativa_e = ($dados['alternativa_e']) ? filter_var($dados['alternativa_e'], FILTER_SANITIZE_STRING) : null;
        $perguntaSubjetiva = ($dados['perguntaSubjetiva']) ? filter_var($dados['perguntaSubjetiva'], FILTER_SANITIZE_STRING) : null;
        $solucao = ($dados['solucao']) ? filter_var($dados['solucao'], FILTER_SANITIZE_STRING) : null;
        $atividade_id = ($dados['atividade_id']) ? filter_var($dados['atividade_id'], FILTER_SANITIZE_STRING) : null;
        $numero = $this->retornarNumeroQuestao($atividade_id);
        $valor = ($dados['valor']) ? filter_var($dados['valor'], FILTER_SANITIZE_STRING) : null;

        if (!is_null($valor)) {
            $objRetorno->dados = array_merge($objRetorno->dados, ['valor' => $valor]);
        } else {
            $objRetorno->erro[] = 'O campo valor nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        }
        if ($categoria_id == 2) {

            $objRetorno->dados = array_merge($objRetorno->dados, ['atividade_id' => $atividade_id,
                'categoria_id' => $categoria_id
            ]);
            if (!is_null($perguntaSubjetiva)) {
                $objRetorno->dados = array_merge($objRetorno->dados, ['pergunta' => $perguntaSubjetiva]);
            } else {
                $objRetorno->erro[] = 'O campo pergunta nao foi preenchido corretamente';
                $objRetorno->status = FALSE;
            }
            if (!is_null($solucao)) {
                $objRetorno->dados = array_merge($objRetorno->dados, ['solucao' => $solucao]);
            } else {
                $objRetorno->erro[] = 'O campo solucao nao foi preenchido corretamente';
                $objRetorno->status = FALSE;
            }
            if ($numero != false) {
                $objRetorno->dados = array_merge($objRetorno->dados, ['numero' => $numero]);
            } else {
                $objRetorno->erro[] = 'O campo numero nao foi preenchido corretamente contate o administrado do sistema';
                $objRetorno->status = FALSE;
            }
        } elseif ($categoria_id == 1) {
            if (!is_null($categoria_id) && (($categoria_id > 0) && ($categoria_id < 3))) {
                $objRetorno->dados = array_merge($objRetorno->dados, ['atividade_id' => $atividade_id,
                    'categoria_id' => $categoria_id
                ]);
            } else {
                $objRetorno->erro[] = 'O campo Tipo da questão nao foi preenchido corretamente';
                $objRetorno->status = FALSE;
            }
            if ($numero != false) {
                $objRetorno->dados = array_merge($objRetorno->dados, ['numero' => $numero]);
            } else {
                $objRetorno->erro[] = 'O campo numero nao foi preenchido corretamente contate o administrado do sistema';
                $objRetorno->status = FALSE;
            }
            if (!is_null($pergunta)) {
                $objRetorno->dados = array_merge($objRetorno->dados, ['pergunta' => $pergunta]);
            } else {
                $objRetorno->erro[] = 'O campo pergunta nao foi preenchido corretamente contate';
                $objRetorno->status = FALSE;
            }
            if (!is_null($alternativa_a) && !is_null($alternativa_b)) {
                $objRetorno->dados = array_merge($objRetorno->dados, [
                    'alternativa_a' => $alternativa_a,
                    'alternativa_b' => $alternativa_b,
                    'alternativa_c' => $alternativa_c,
                    'alternativa_d' => $alternativa_d,
                    'alternativa_e' => $alternativa_e
                ]);
            } else {
                $objRetorno->erro[] = 'Deve ter ao menos duas alternativas';
                $objRetorno->status = FALSE;
            }
        }
        if (!is_null($nivel_id)) {
            $objRetorno->dados = array_merge($objRetorno->dados, ['nivel_id' => $nivel_id]);
        } else {
            $objRetorno->erro[] = 'O campo Nivel nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        }

        return $objRetorno;
    }

    public function retornarNumeroQuestao($atividade_id) {
        $login = new Login();
        $consulta = $login->BDSeleciona('questoes', 'numero', "WHERE(atividade_id = '{$atividade_id}') order by numero desc limit 1");

        if (!empty($consulta[0]['numero'])) {
            return ($consulta[0]['numero'] + 1);
        } else {
            return 1;
        }
    }

    public function validarCadastroTurma($dados) {
        $objRetorno = new stdClass();
        $objRetorno->erro = [];
        $objRetorno->dados = [];
        $objRetorno->status = TRUE;

        $nome = ($dados['nome']) ? filter_var($dados['nome'], FILTER_SANITIZE_STRING) : null;
        $professor = ($dados['professor']) ? filter_var($dados['professor'], FILTER_SANITIZE_STRING) : null;
        $codigo = ($dados['codigo']) ? filter_var($dados['codigo'], FILTER_SANITIZE_STRING) : null;
        $ano = ($dados['ano']) ? filter_var($dados['ano'], FILTER_SANITIZE_STRING) : NULL;
        $semestre = ($dados['semestre']) ? filter_var($dados['semestre'], FILTER_SANITIZE_STRING) : NULL;

        if (is_null($nome)) {
            $objRetorno->erro[] = 'O campo nome nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['nome' => $nome]);
        }
        if (is_null($professor)) {
            $objRetorno->erro[] = 'O campo professor nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['professor' => $professor]);
        }
        if (is_null($codigo)) {
            $objRetorno->erro[] = 'O campo codigo nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['codigo' => $codigo]);
        }
        if (is_null($ano)) {
            $objRetorno->erro[] = 'O campo nome ano foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['ano' => $ano]);
        }
        if (is_null($semestre)) {
            $objRetorno->erro[] = 'O campo semestre nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['semestre' => $semestre]);
        }

        return $objRetorno;
    }

    public function validarEdicaoPerfil($dados, $matricula) {

        $objRetorno = new stdClass();
        $objRetorno->erro = [];
        $objRetorno->dados = [];
        $objRetorno->status = TRUE;

        $nome = ($dados['nome']) ? filter_var($dados['nome'], FILTER_SANITIZE_STRING) : null;
        $email = ($dados['email']) ? filter_var($dados['email'], FILTER_SANITIZE_EMAIL) : NULL;
        $username = ($dados['username']) ? filter_var($dados['username'], FILTER_SANITIZE_STRING) : NULL;
        $senhaAntiga = ($dados['senha-antiga']) ? filter_var($dados['senha-antiga'], FILTER_SANITIZE_STRING) : false;
        $senha = ($dados['senha-nova']) ? filter_var($dados['senha-nova'], FILTER_SANITIZE_STRING) : false;
        $repetaSenha = ($dados['repeta-senha']) ? filter_var($dados['repeta-senha'], FILTER_SANITIZE_STRING) : false;

        if (is_null($nome)) {
            $objRetorno->erro[] = 'O campo nome nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = ['nome' => $nome];
        }
        if (is_null($email)) {
            $objRetorno->erro[] = 'O campo email nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($dados, ['email' => $email]);
        }
        if (is_null($username)) {
            $objRetorno->erro[] = 'O campo username nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dadosdados = array_merge($dados, ['username' => $username]);
        }if ($senhaAntiga) {
            $senha = md5($senha);
            $repetaSenha = md5($repetaSenha);

            if ($senha != $repetaSenha) {
                $objRetorno->erro[] = 'As senhas informadas nao coincedem';
                $objRetorno->status = FALSE;
            } else {
                $objRetorno->dados = array_merge($dados, ['senha' => $senha]);
            }
        }
        $bdEmail = $this->validarEntrada($email, 'email');
        if ($bdEmail) {
            $objRetorno->erro[] = 'Ja existe um cadastro feito com esse email, por favor use outro!';
            $objRetorno->status = FALSE;
        }


        return $objRetorno;
    }

    public function validarEdicaoSenha($dados) {

        $objRetorno = new stdClass();
        $objRetorno->erro = [];
        $objRetorno->dados = [];
        $objRetorno->status = TRUE;

        $matricula = ($dados['matricula']) ? filter_var($dados['matricula'], FILTER_SANITIZE_STRING) : NULL;
        $senha = ($dados['senha']) ? filter_var($dados['senha'], FILTER_SANITIZE_STRING) : false;
        $repetaSenha = ($dados['repeta-senha']) ? filter_var($dados['repeta-senha'], FILTER_SANITIZE_STRING) : false;
        $auth = new Autenticacao();

        if (is_null($matricula)) {
            $objRetorno->erro[] = 'O campo matricula nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } elseif (!$senha && !$repetaSenha) {
            $pass = $auth->hashHX($matricula);
            $senha = $pass['password'];
            $salt = $pass['salt'];
            $objRetorno->dados = array_merge($objRetorno->dados, [
                'matricula' => $matricula,
                'senha' => $senha,
                'salt' => $salt
            ]);
        } elseif (!is_null($senha) && (!is_null($repetaSenha))) {
            if ($senha != $repetaSenha) {
                $objRetorno->erro[] = 'As senhas informadas nao coincedem';
                $objRetorno->status = FALSE;
            } else {
                $pass = $auth->hashHX($senha);
                $senha = $pass['password'];
                $salt = $pass['salt'];
                $objRetorno->dados = array_merge($objRetorno->dados, [
                    'matricula' => $matricula,
                    'senha' => $senha,
                    'salt' => $salt
                ]);
            }
        }
        return $objRetorno;
    }

    public function validarCabecalhoQuestao($dados) {
        $objRetorno = new stdClass();
        $objRetorno->erro = [];
        $objRetorno->dados = [];
        $objRetorno->status = TRUE;
        $dataAtual = date('Y-m-d');
        $dataModificacao = $dataAtual;

        $assunto = ($dados['assunto']) ? filter_var($dados['assunto'], FILTER_SANITIZE_STRING) : NULL;
        $turma = ($dados['turma']) ? filter_var($dados['turma'], FILTER_SANITIZE_STRING) : false;
        $dataInicio = $dados['dataInicio'];
        $dataTermino = $dados['dataTermino'];

        if (is_null($assunto)) {
            $objRetorno->erro[] = 'O campo assunto nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['conteudo' => $assunto]);
        }
        if (is_null($turma)) {
            $objRetorno->erro[] = 'O campo turma nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['turma_id' => $turma]);
        }
        if (is_null($dataInicio)) {
            $objRetorno->erro[] = 'O campo data de inicio nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['dataInicio' => $dataInicio]);
        }
        if (is_null($dataTermino)) {
            $objRetorno->erro[] = 'O campo data de termino nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, [
                'dataTermino' => $dataTermino,
                'dataModificacao' => $dataModificacao
            ]);
        }
        if ($dataInicio > $dataTermino) {
            $objRetorno->erro[] = 'A data de inicio tem que ser menor ou igual a data de termino';
            $objRetorno->status = FALSE;
        }
        if ($dataInicio < $dataAtual) {
            $objRetorno->erro[] = 'A data de inicio esta menor que a data atual por favor corrija';
            $objRetorno->status = FALSE;
        }
        if ($dataTermino < $dataAtual) {
            $objRetorno->erro[] = 'A data de termino esta menor que a data atual por favor corrija';
            $objRetorno->status = FALSE;
        }
        return $objRetorno;
    }

    /**
     *  funcao feita para verificar se já existe um determinado dado numa determinada tabela
     * @param type $variavel 
     * @param type $descricao
     * @return boolean
     */
    public function validarEntrada($variavel, $descricao) {
        $conexao = new Conexao;
        $aluno = $conexao->BDSeleciona('alunos', "{$descricao}", "WHERE({$descricao} like '{$variavel}')");
        $professor = $conexao->BDSeleciona('professores', "{$descricao}", "WHERE({$descricao} like '{$variavel}')");
        $monitor = $conexao->BDSeleciona('monitores', "{$descricao}", "WHERE({$descricao} like '{$variavel}')");

        if (count($monitor) > 0) {
            return FALSE;
        } elseif (count($professor) > 0) {
            return false;
        } elseif (count($aluno) > 0) {
            return false;
        } else {
            return TRUE;
        }
    }

    public function validarMatriculaTurma($dados) {
        $objRetorno = new stdClass();
        $objRetorno->erro = [];
        $objRetorno->dados = [];
        $objRetorno->status = TRUE;
        $dataAtual = date('Y-m-d');
        $dataModificacao = $dataAtual;

        $codigo = ($dados['codigo']) ? filter_var($dados['codigo'], FILTER_SANITIZE_STRING) : NULL;

        if (is_null($codigo)) {
            $objRetorno->erro[] = 'O campo assunto nao foi preenchido corretamente';
            $objRetorno->status = FALSE;
        } else {
            $objRetorno->dados = array_merge($objRetorno->dados, ['codigo' => $codigo]);
        }

        return $objRetorno;
    }

}
