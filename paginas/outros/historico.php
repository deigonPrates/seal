<?php

$title = "Historico";
require_once './classes/autenticacao.class.php';
require_once './classes/conexao.class.php'; 

$autenticacao = new Autenticacao();
$header = $autenticacao->definirNiveisAcesso();
require_once "$header";

$conexao = new Conexao();

$con = $conexao->BDAbreConexao();

$id = $conexao->BDRetornaID($_SESSION['matricula']);
$nome = $conexao->BDSeleciona('alunos', 'nome', "WHERE id = {$id}");
$nome = $nome[0]['nome'];

$dados = $conexao->BDSQL("SELECT DISTINCT alunos.matricula,alunos.nome, turmas.nome,turmas.ano,turmas.semestre FROM alunos
                            join registros on registros.aluno_id = alunos.id 
                            JOIN turmas on registros.turma_id = turmas.id
                            WHERE(alunos.id = {$id})"
);

$conexao->BDFecharConexao($con);
