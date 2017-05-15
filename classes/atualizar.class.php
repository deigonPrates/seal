<?php

session_start();

if (!isset($_SESSION["matricula"])) {
    header("Location: /login");
    exit();
}

include_once './classes/conexao.class.php';
include_once './classes/validarCampos.php';

class Atualizar extends Conexao {

    public function atualizarPerfil($dados) {

        $validar = new ValidarCampos();
        $teste = $validar->validarEdicaoPerfil($dados, $_SESSION["matricula"]);
        $dados = $teste->dados;
        if ($teste) {
            $dados = array_filter($dados); //limpa o array de null e vazios
            //cria uma string so com as keys


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
            header("Location: /editar/perfil");
        } else {
            print_r($teste->erros);
        }
    }

    public function atualizarSenha($dados) {

        $validar = new ValidarCampos();

        $teste = $validar->validarEdicaoSenha($dados);
        $dados = $teste->dados;

        $tabela = $this->BDRetornarTabela($dados['matricula']);

        if (!empty($teste->erro)) {
            print_r($teste->erros);
        } else {
            $conn = $this->BDAbreConexao();
            $this->BDAtualiza("$tabela", "WHERE(matricula like '{$dados['matricula']}')", 'senha', "'{$dados['senha']}'");
            $this->BDFecharConexao($conn);

            header("Location: /editar/senha");
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

    public function atualizarAtividade($dados) {
        $_SESSION['atividade_id'] = $dados['atividade_id'];
        header("Location: /editar/atividade");
    }

    public function atualizarQuestao($dados) {
        $_SESSION['questao_id'] = $dados['questao_id'];

        header("Location: /editar/questao");
    }

    public function atualizandarquestoesAtividade($dados) {
        $id = $_SESSION['questao_id'];
        $solucao = $dados['solucao'];
        $alternativa = $dados['alternativa'];

        unset($dados['solucao']);
        unset($dados['alternativa']);

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
        header("Location: /editar/atividade");
    }

}
