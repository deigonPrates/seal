<?php

$title = "Historico";
require_once './classes/autenticacao.class.php';
require_once './classes/conexao.class.php';
require_once './assets/dompdf/autoload.inc.php';

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

$html = '<table border=1';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th>Matricula</th>';
$html .= '<th>Nome:</th>';
$html .= '<th>Turma</th>';
$html .= '<th>Ano</th>';
$html .= '<th>Semestre</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';

foreach ($dados as $key => $value) {
    $html .= '<tr><td>' . $dados[0]['matricula'] . "</td>";
    $html .= '<td>' . $dados[0]['nome'] . "</td>";
    $html .= '<td>' . $dados[0]['nome'] . "</td>";
    $html .= '<td>' . $dados[0]['ano'] . "</td>";
    $html .= '<td>' . $dados[0]['semestre'] . "</td></tr>";
}



$html .= '</tbody>';
$html .= '</table';

//referenciar o DomPDF com namespace
use Dompdf\Dompdf;

// include autoloader
require_once("./assets/dompdf/autoload.inc.php");

//Criando a Instancia
$dompdf = new Dompdf();

// Carrega seu HTML
$dompdf->loadHtml('
			<h1 style="text-align: center;">SEAL - Histórico</h1>
			' . $html . '
		');

//Renderizar o html
$dompdf->render();

//Exibibir a página
$dompdf->stream(
        "seal.pdf", array(
    "Attachment" => false //Para realizar o download somente alterar para true
        )
);
