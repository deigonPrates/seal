<?php

session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: /login");
}
include("./assets/mpdf/mpdf.php");
include_once("./classes/conexao.class.php");

$con = new Conexao();
$conexao = $con->BDAbreConexao();
$matricula = $_SESSION['matricula'];
$id = $con->BDRetornaID($matricula);
$tabela = $con->BDRetornarTabela($matricula);
$consulta = $con->BDSeleciona($tabela, '*', "WHERE(id = $id)");
$consulta_banco = $con->BDSQL("SELECT turmas.nome, turmas.ano, turmas.semestre from alunos
                                join registros on registros.aluno_id = alunos.id
                                JOIN turmas on registros.turma_id = turmas.id
                                WHERE(alunos.id = $id)");
$consultabd = $con->BDSQL("SELECT sum(questoes.valor) as nota, atividades.conteudo, atividades.dataInicio from alunos "
        . "join alunos_atividades on alunos.id = alunos_atividades.aluno_id "
        . "JOIN atividades on atividades.id = alunos_atividades.avaliacao_id "
        . "JOIN questoes on atividades.id = questoes.atividade_id "
        . "join respostas on questoes.id = respostas.questao_id "
        . "WHERE(respostas.resultado = 1 and alunos.id = $id) "
        . "GROUP by atividades.conteudo, atividades.dataInicio");
$con->BDFecharConexao($conexao);

$nome = $consulta[0]['nome'];
$ano = $consulta_banco[0]['ano'] . '.' . $consulta_banco[0]['semestre'];
$turma = $consulta_banco[0]['nome'];

$laco = null;
$cont = 1;
foreach ($consultabd as $key => $value) {
    $laco .= "<tr>";
    $laco .= "<td>{$cont}</td>";
    $laco .= "<td>{$value['conteudo']}</td>";
    $laco .= "<td>{$value['nota']}</td>";
    $laco .= "<td>{$value['dataInicio']}</td>";
    $laco .= "</tr>";
    $cont++;
}

$table = "
    <table id='playlistTable'>
  <thead>
    <tr>
      <th><strong>Nº</strong></th>
      <th><strong>Atividade</strong></th>
      <th><strong>Nota</strong></th>
      <th><strong>Data</strong></th>
    </tr>
  </thead>

  <tbody>
    $laco   
  </tbody>
</table>
    ";

$html = "
	 <fieldset>
	 	
  <caption><h1>Histórico</h1></caption>
	 	<p>Aluno: <strong> $nome </strong></p>
	 	<p>Matricula: <strong>$matricula</strong></p>
	 	<p>Ano: <strong>$ano<strong></p>
	 	<p>Turma: <strong>$turma<strong></p>
	 	<br>
		$table
		<br>
		<br>
		<br>
		<caption><p class='center sub-titulo'>          .........................................................................</p>
	 	<p class='center '><strong>Coordenador</strong></p></caption>
	 </fieldset>";

$mpdf = new mPDF();
$mpdf->SetDisplayMode('fullpage');
$css = file_get_contents("./assets/css/estilo.css");
$mpdf->WriteHTML($css, 1);
$mpdf->WriteHTML($html);
$mpdf->Output();

exit;
