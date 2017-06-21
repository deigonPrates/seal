<?php

session_start();

if (!isset($_SESSION["matricula"])) {
    header("Location: /login");
    exit();
}

include_once './classes/conexao.class.php';
include_once './classes/validarCampos.php';
include_once './classes/autenticacao.class.php';

class Atualizar extends Conexao {

    public function atualizarPerfil($dados) {

        $autenticacao = new Autenticacao();
        $validar = new ValidarCampos();
        $teste = $validar->validarEdicaoPerfil($dados, $_SESSION["matricula"]);
        $dados = $teste->dados;
        if ($teste) {
            $dados = array_filter($dados); //limpa o array de null e vazios

            $tabela = $this->BDRetornarTabela($_SESSION["matricula"]);
            unset($dados['senha-antiga']);
            unset($dados['senha-nova']);
            unset($dados['repeta-senha']);
            unset($dados['matricula']);

            $indices = implode(", ", array_keys($dados));
            //cria uma string so com os valores
            $valores = "'" . implode("', '", $dados) . "'";

            // transforma a string em array.
            $indices = explode(',', $indices);
            $valores = explode(',', $valores);

            for ($i = 0; $i < count($indices); $i++) {
                $this->BDAtualiza("$tabela", "WHERE(matricula like '{$_SESSION["matricula"]}')", $indices[$i], $valores[$i]);
            }

            if (!empty($teste->dados['senha-antiga'])) {

                if (!empty($teste->dados['senha-nova']) && !empty(!empty($teste->dados['repeta-senha']))) {
                    if ($teste->dados['senha-nova'] == $teste->dados['repeta-senha']) {
                        $senhaCriptografada = $autenticacao->hashHX($teste->dados['senha-nova']);
                        $pass = "'" . $senhaCriptografada['password'] . "'";
                        $saltCript = "'" . $senhaCriptografada['salt'] . "'";
                        $this->BDAtualiza($tabela, "where matricula = '{$_SESSION['matricula']}' ", 'senha', $pass);
                        $this->BDAtualiza($tabela, "where matricula = '{$_SESSION['matricula']}' ", 'salt', $saltCript);
                    } else {
                        $autenticacao->SweetAlertDown('Erro ):', 'Por favor tente novamente!', 'down');
                        header("Refresh: 1,  /editar/perfil");
                    }
                } else {
                    $autenticacao->SweetAlertDown('Erro ):', 'As senhas não conferem, tente novamente!', 'down');
                    header("Refresh: 1,  /editar/perfil");
                }
            }
            $autenticacao->SweetAlertDown('Cadastro atualizado (:', 'Seu cadastro foi atualizado com sucesso!', 'down');
            header("Refresh: 1,  /editar/perfil");
        } else {
            $autenticacao->SweetAlertDown('Opss ):', $teste->erros, 'error');
            header("Refresh: 3,  /editar/perfil");
        }
    }

    public function atualizarSenha($dados) {
        $validar = new ValidarCampos();
        $autenticacao = new Autenticacao();

        $teste = $validar->validarEdicaoSenha($dados);
        $dados = $teste->dados;
        
        $tabela = $this->BDRetornarTabela($dados['matricula']);

        if (!$tabela) {
            $autenticacao->SweetAlertDown('Opss ):', 'Matricula invalida', 'error');
            header("Refresh: 3, /editar/senha");
        }
        if (!empty($teste->erro)) {
            $autenticacao->SweetAlertDown('Opss ):', $teste->erros, 'error');
            header("Refresh: 3, /editar/senha");
        } else {
            $conn = $this->BDAbreConexao();
            $this->BDAtualiza("$tabela", "WHERE(matricula like '{$dados['matricula']}')", 'senha', "'{$dados['senha']}'");
            $this->BDAtualiza("$tabela", "WHERE(matricula like '{$dados['matricula']}')", 'salt', "'{$dados['salt']}'");
            $this->BDFecharConexao($conn);
            $autenticacao->SweetAlertDown('Cadastro atualizado (:', 'Cadastro foi atualizado com sucesso!', 'down');
            header("Refresh: 3,  /editar/senha");
        }
    }

    public function atualizaStatus($tabela, $dados, $retorno) {

        $id = implode(", ", array_keys($dados));
        $status = $this->BDSeleciona("$tabela", 'status', "WHERE(id = '{$id}')");

        if ($status[0]['status'] == 1) {
            $this->BDAtualiza("$tabela", "WHERE(id = {$id})", 'status', '0');
        } else {
            $this->BDAtualiza("$tabela", "WHERE(id = {$id})", 'status', " '1'");
        }

        if ($retorno == 'removerQuestoes') {
            header("Location: /editar/removerQuestao");
        } else {
            header("Location: /listar/" . $retorno);
        }
    }

    /**
     * Muda o ativo da tabela de 1 para 0 ou de 0 para 1
     */
    public function atualizaAtivo($tabela, $dados) {
        $matricula = $dados['matricula'];

        $id = $this->BDRetornaID($matricula);


        $tabela = $this->BDRetornarTabela($matricula);

        $this->BDAtualiza("alunos", "WHERE(id = $id)", 'ativo', '0') or die('error');

        header("Location: /listar/usuario");
    }

    public function atualizarAtividade($dados) {

        $_SESSION['atividade_id'] = $dados['atividade_id'];
        header("Location: /editar/atividade");
    }

    public function atualizarCabecalhoQuestao($dados) {

        $validar = new ValidarCampos();
        $atividade_id = $dados['atividade_id'];
        $teste = $validar->validarCabecalhoQuestao($dados);
        $dados = $teste->dados;

        if ($teste->status) {
            $indices = implode(", ", array_keys($dados));
            $valores = "'" . implode("', '", $dados) . "'";

            $indices = explode(',', $indices);
            $valores = explode(',', $valores);

            $aux = [];

            for ($i = 0; $i < count($valores); $i++) {
                $aux[] = $indices[$i] . '=' . $valores[$i];
            }

            $aux = implode(',', $aux);

            $this->BDExecutaQuery("UPDATE atividades SET {$aux} where id = {$atividade_id}");
            header("Location: /editar/atividade");
        } else {
            $autenticacao->SweetAlertDown('Opss ):', $teste->erros, 'error');
            header("Refresh: 3,  /editar/atividade");
        }
    }

    public function atualizarQuestao($dados) {
        $_SESSION['questao_id'] = $dados['questao_id'];

        header("Location: /editar/questao");
    }

    public function atualizandarquestoesAtividade($dados) {

        $id = $_SESSION['questao_id'];


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
            'questao_id' => $id,
            'solucao' => $solucao
        ];

        $objValidar = $validar->validarAdicaoQuestao($dados);

        if ($objValidar->status) {
            $dados = $objValidar->dados;
            unset($dados['alternativa']);
            unset($dados['solucao']);
            $indices = implode(", ", array_keys($dados));
            $valores = "'" . implode("', '", $dados) . "'";

            $indices = explode(',', $indices);
            $valores = explode(',', $valores);

            $aux = [];

            for ($i = 0; $i < count($valores); $i++) {
                $aux[] = $indices[$i] . '=' . $valores[$i];
            }

            $aux = implode(',', $aux);

            $this->BDExecutaQuery("UPDATE questoes SET {$aux} where id = {$id}");

            if ($dados['categoria_id'] == 2) {
                $this->BDAtualiza('solucoes', "where questoes_id = {$id}", 'solucao', "'{$solucao}'");
            } else {
                $this->BDAtualiza('solucoes', "where (questoes_id = {$id})", 'alternativa', "'{$alternativa}'");
            }
            $this->BDExecutaQuery("UPDATE questoes SET {$aux} where id = {$id}");
        } else {
            print_r($objValidar->erro);
        }
        $this->BDFecharConexao($conn);

        /*
          if ($dados['categoria_id'] == 1) {
          $alternativa = $dados['alternativa'];
          unset($dados['perguntaSubjetiva']);
          unset($dados['solucao']);
          unset($dados['alternativa']);
          } elseif ($dados['categoria_id'] == 2) {
          $solucao = $dados['solucao'];
          unset($dados['pergunta']);
          unset($dados['alternativa_a']);
          unset($dados['alternativa_b']);
          unset($dados['alternativa_c']);
          unset($dados['alternativa_d']);
          unset($dados['alternativa_e']);
          unset($dados['alternativa']);
          unset($dados['solucao']);
          unset($dados['perguntaSubjetiva']);
          }

          $indices = implode(", ", array_keys($dados));
          $valores = "'" . implode("', '", $dados) . "'";

          $indices = explode(',', $indices);
          $valores = explode(',', $valores);

          $aux = [];

          for ($i = 0; $i < count($valores); $i++) {
          $aux[] = $indices[$i] . '=' . $valores[$i];
          }

          $aux = implode(',', $aux);

          $this->BDExecutaQuery("UPDATE questoes SET {$aux} where id = {$id}");

          if ($dados['categoria_id'] == 2) {
          $this->BDAtualiza('solucoes', "where questoes_id = {$id}", 'solucao', "'{$solucao}'");
          } else {
          $this->BDAtualiza('solucoes', "where (questoes_id = {$id})", 'alternativa', "'{$alternativa}'");
          }

         */

        #$this->BDExecutaQuery("UPDATE questoes SET {$aux} where id = {$id}");
        header("Location: /editar/atividade");
    }

}
