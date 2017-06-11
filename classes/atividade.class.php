<?php

include_once './classes/conexao.class.php';

class Atividade extends Conexao {

    public function definirAtividade($dados) {
        session_start();
        if (isset($_SESSION['atividade_id'])) {
            unset($_SESSION['atividade_id']);
            $_SESSION['atividade_id'] = $dados['atividade_id'];
            $_SESSION['numero'] = 1;
        } else {
            $_SESSION['atividade_id'] = $dados['atividade_id'];
            $_SESSION['numero'] = 1;
        }
        $alunos_id = $this->BDRetornaID($_SESSION['matricula']);
        $avaliacoes_id = $_SESSION['atividade_id'];

        $dados = [
            'aluno_id' => $alunos_id,
            'avaliacao_id' => $avaliacoes_id
        ];
        $bdBusca = $this->BDSeleciona('alunos_atividades', '*', "WHERE(aluno_id = $alunos_id and avaliacao_id = $avaliacoes_id)");

        if (!$bdBusca) {
            $this->DBGravar('alunos_atividades', $dados);
        }
        header('Location: /fazer/atividade');
    }

    public function definirAvaliacao($dados) {
        session_start();
        if (isset($_SESSION['atividade_id'])) {
            unset($_SESSION['atividade_id']);
            $_SESSION['atividade_id'] = $dados['atividade_id'];
            $_SESSION['numero'] = 1;
        } else {
            $_SESSION['atividade_id'] = $dados['atividade_id'];
            $_SESSION['numero'] = 1;
        }
        $alunos_id = $this->BDRetornaID($_SESSION['matricula']);
        $avaliacoes_id = $_SESSION['atividade_id'];

        $dados = [
            'aluno_id' => $alunos_id,
            'avaliacao_id' => $avaliacoes_id
        ];
        $bdBusca = $this->BDSeleciona('alunos_atividades', '*', "WHERE(aluno_id = $alunos_id and avaliacao_id = $avaliacoes_id)");

        if (!$bdBusca) {
            $this->DBGravar('alunos_atividades', $dados);
        }
        header('Location: /fazer/avaliacao');
    }

    public function fazerAtividade($dados) {
        session_start();
        $bdCategoria = $this->BDSeleciona('questoes', 'categoria_id', "WHERE(id = {$dados['questao_id']})");

        if ($bdCategoria[0]['categoria_id'] == 1) {
            $questao_id = $dados['questao_id'];
            $resposta = $dados['alternativa'];

            $grava = [
                'questao_id' => $questao_id,
                'resposta' => $resposta
            ];
        } else {
            $questao_id = $dados['questao_id'];
            $resposta = $dados['resposta'];

            $grava = [
                'questao_id' => $questao_id,
                'resposta' => $resposta
            ];
        }
        $this->DBGravar('respostas', $grava);

        $limite = $this->BDSQL("SELECT numero FROM questoes ORDER by numero DESC LIMIT 1");
        $_SESSION['numero'] += 1;

        if ($_SESSION['numero'] > $limite[0]['numero']) {
            header('Location: /inicio');
        }
        header('Location: /fazer/atividade');
    }

    public function fazerAvaliacao($dados) {
        session_start();
        $bdCategoria = $this->BDSeleciona('questoes', 'categoria_id', "WHERE(id = {$dados['questao_id']})");

        if ($bdCategoria[0]['categoria_id'] == 1) {
            $questao_id = $dados['questao_id'];
            $resposta = $dados['alternativa'];

            $grava = [
                'questao_id' => $questao_id,
                'resposta' => $resposta
            ];
        } else {
            $questao_id = $dados['questao_id'];
            $resposta = $dados['resposta'];

            $grava = [
                'questao_id' => $questao_id,
                'resposta' => $resposta
            ];
        }

        $this->DBGravar('respostas', $grava);

        $limite = $this->BDSQL("SELECT numero FROM questoes ORDER by numero DESC LIMIT 1");
        $_SESSION['numero'] += 1;

        if ($_SESSION['numero'] > $limite[0]['numero']) {
            header('Location: /inicio');
        }
        header('Location: /fazer/atividade');
    }

    public function definirAtividadeCorrecao($dados) {
        
    }

    public function definirAvaliacaoCorrecao($dados) {

        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['atividade_id'] = $dados['id'];
        header('Location: /listar/definirCorrecao');
    }

    public function corrigirAvaliacao($dados) {
        if (!isset($_SESSION)) {
            session_start();
        }
        unset($_SESSION['atividade_id']);
        $_SESSION['alunos_atividades_id'] = $dados['alunos_atividades_id'];
        header('Location: /listar/corrigir');
    }

}
