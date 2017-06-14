<?php

include_once'./classes/login.class.php';
include_once'./classes/autenticacao.class.php';
include_once'./classes/cadastrar.class.php';

define("PASTA", "./paginas/");

$REQUEST_URI = filter_input(INPUT_SERVER, 'REQUEST_URI');
$INITE = strpos($REQUEST_URI, '?');

if ($INITE):
    $REQUEST_URI = substr($REQUEST_URI, 0, $INITE);
endif;

$REQUEST_URI_PASTA = substr($REQUEST_URI, 1);
$URL = explode('/', $REQUEST_URI_PASTA);
$URL[0] = ($URL[0] != '' ? $URL[0] : 'login');

if ((isset($URL[0])) && ($URL[0] == 'sair')):
    $login = new Login();
    $login->sair();
endif;
if ((isset($URL[0])) && (isset($URL[1])) && ($URL[0] . '/' . $URL[1] == 'atualizando/perfil')):
    include_once'./classes/atualizar.class.php';
    $atualizar = new Atualizar();
    $atualizar->atualizarPerfil($_POST);
endif;
if ((isset($URL[0])) && (isset($URL[1])) && ($URL[0] . '/' . $URL[1] == 'resolucao/atividade')):
    include_once'./classes/cadastrar.class.php';
    $cadastrar = new Cadastrar();
    $cadastrar->definirResolucaoAtividade($_GET);
endif;
if ((isset($URL[0])) && (isset($URL[1])) && ($URL[0] . '/' . $URL[1] == 'atualizando/senha')):
    include_once'./classes/atualizar.class.php';
    $atualizar = new Atualizar();
    $atualizar->atualizarSenha($_POST);
endif;
if ((isset($URL[0])) && (isset($URL[1])) && ($URL[0] . '/' . $URL[1] == 'corigir/avaliacao')):
    include_once'./classes/atividade.class.php';
    $atividade = new Atividade();
    $atividade->definirAvaliacaoCorrecao($_GET);
endif;
if ((isset($URL[0])) && (isset($URL[1])) && ($URL[0] . '/' . $URL[1] == 'salvar/correcao')):
    include_once'./classes/atividade.class.php';
    $atividade = new Atividade();
    $atividade->salvarCorrecao($_POST);
endif;
if (((isset($URL[0])) && isset($URL[1])&& isset($URL[2])) && ($URL[0] . '/' . $URL[1] .'/'.$URL[2]== 'corrigir/atividade/avaliativa')):
    include_once'./classes/atividade.class.php';
    $atividade = new Atividade();
    $atividade->corrigirAvaliacao($_POST);
endif;
if ((isset($URL[0])) && (isset($URL[1])) && ($URL[0] . '/' . $URL[1] == 'definindo/atividade')):
    include_once './classes/atividade.class.php';
    $atividade = new Atividade();
    $atividade->definirAtividade($_POST);
endif;
if ((isset($URL[0])) && (isset($URL[1])) && ($URL[0] . '/' . $URL[1] == 'definindo/avaliacao')):
    include_once './classes/atividade.class.php';
    $atividade = new Atividade();
    $atividade->definirAvaliacao($_POST);
endif;
if ((isset($URL[0])) && (isset($URL[1])) && ($URL[0] . '/' . $URL[1] == 'cadastrando/respostaAtividade')):
    include_once './classes/atividade.class.php';
    $atividade = new Atividade();
    $atividade->fazerAtividade($_POST);
endif;
if ((isset($URL[0])) && (isset($URL[1])) && ($URL[0] . '/' . $URL[1] == 'listando/questoesAtividade')):
   include_once'./classes/atividade.class.php';
    $atividade = new Atividade();
    $atividade->definirVisualizacaoAtividade($_POST);
endif;
if ((isset($URL[0])) && (isset($URL[1])) && ($URL[0] . '/' . $URL[1] == 'atualizando/questoesAtividade')):
   include_once'./classes/atualizar.class.php';
    $atualizar = new Atualizar();
    $atualizar->atualizandarquestoesAtividade($_POST);
endif;
if ((isset($URL[0])) && (isset($URL[1])) && ($URL[0] . '/' . $URL[1] == 'atualizando/cabecalhoQuestao')):
   include_once'./classes/atualizar.class.php';
    $atualizar = new Atualizar();
    $atualizar->atualizarCabecalhoQuestao($_POST);
endif;
if ((isset($URL[0])) && (isset($URL[1])) && (isset($URL[2])) && ($URL[0] . '/' . $URL[1] == 'atualizar/status')):
    include_once'./classes/atualizar.class.php';
    $atualizar = new Atualizar();
    $atualizar->atualizaStatus($URL[3], $_POST, $URL[2]);
endif;
if ((isset($URL[0])) && (isset($URL[1])) && (isset($URL[2])) && ($URL[0] . '/' . $URL[1] == 'atualizar/ativo')):
    include_once'./classes/atualizar.class.php';
    $atualizar = new Atualizar();
    $atualizar->atualizaAtivo($URL[2], $_POST);
endif;#/atualizar/ativo/usuario/alunos
if ((isset($URL[0])) && (isset($URL[1])) && ($URL[0] . '/' . $URL[1] == 'editando/atividade')):
    include_once'./classes/atualizar.class.php';
    $atualizar = new Atualizar();
    $atualizar->atualizarAtividade($_POST);
endif;
if ((isset($URL[0])) && (isset($URL[1])) && ($URL[0] . '/' . $URL[1] == 'editando/questao')):
    include_once'./classes/atualizar.class.php';
    $atualizar = new Atualizar();
    $atualizar->atualizarQuestao($_POST);
endif;
if ((isset($URL[0])) && (isset($URL[1])) && ($URL[0] . '/' . $URL[1] == 'adicionando/questao')):
    include_once'./classes/cadastrar.class.php';
    $cadastrar = new Cadastrar();
    $cadastrar->adicionarQuestoes($_POST);
endif;
if ((isset($URL[0])) && (isset($URL[1])) && ($URL[0] . '/' . $URL[1] == 'cadastrando/atividade')):
    include_once'./classes/cadastrar.class.php';
    $cadastrar = new Cadastrar();
    $cadastrar->cadastrarAtividade($_POST);
endif;
if ((isset($URL[0])) && (isset($URL[1])) && ($URL[0] . '/' . $URL[1] == 'cadastrando/questoesAtividade')):
    include_once'./classes/cadastrar.class.php';
    $cadastrar = new Cadastrar();
    $cadastrar->cadastrarQuestoes($_POST);
endif;
if ((isset($URL[0])) && (isset($URL[1])) && ($URL[0] . '/' . $URL[1] == 'cadastrando/avaliacao')):
    include_once'./classes/cadastrar.class.php';
    $cadastrar = new Cadastrar();
    $cadastrar->cadastrarAvaliacao($_POST);
endif;
if ((isset($URL[0])) && (isset($URL[1])) && ($URL[0] . '/' . $URL[1] == 'cadastrando/turma')):
    include_once'./classes/cadastrar.class.php';
    $cadastrar = new Cadastrar();
    $cadastrar->cadastrarTurma($_POST);
endif;
if ((isset($URL[0])) && (isset($URL[1])) && ($URL[0] . '/' . $URL[1] == 'matriculando/turma')):
    include_once'./classes/cadastrar.class.php';
    $cadastrar = new Cadastrar();
    $cadastrar->matricularTurma($_POST);
endif;
if ((isset($URL[0])) && ($URL[0] == 'autenticacao')):
    $autenticacao = new Autenticacao();
    $autenticacao->autenticarUsuario($_POST);
endif;
if (file_exists(PASTA . $URL[0] . '.php')):
    require(PASTA . $URL[0] . '.php');
elseif ((isset($URL[0]) && isset($URL[1])) && (($URL[0] . '/' . $URL[1]) == 'cadastrando/aluno')):
    $cadastrar = new Cadastrar();
    $cadastrar->cadastrarAluno($_POST);
elseif ((isset($URL[0]) && isset($URL[1])) && (($URL[0] . '/' . $URL[1]) == 'cadastrando/monitor')):
    $cadastrar = new Cadastrar();
    $cadastrar->cadastrarMonitor($_POST);
elseif (is_dir(PASTA . $URL[0])):
    if (isset($URL[1]) && file_exists(PASTA . $URL[0] . '/' . $URL[1] . '.php')):
        require(PASTA . $URL[0] . '/' . $URL[1] . '.php');
    else:
        require(PASTA . '404.html');
    endif;
else:
    require(PASTA . '404.html');
    endif;