<?php

session_start();
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
$con->BDFecharConexao($conexao);
$nome = $consulta[0]['nome'];
$ano = $consulta_banco[0]['ano'] . '.' . $consulta_banco[0]['semestre'];
$turma = $consulta_banco[0]['nome'];

$table = "
    <table id='playlistTable'>
  <caption>Top 15 Playlist</caption>
  <thead>
    <tr>
      <th></th>
      <th>Track Name</th>
      <th>Artist</th>
      <th>Album</th>
    </tr>
  </thead>

  <tbody>
    <tr>
      <td>1</td>
      <td>Hide You</td>
      <td>Kosheen</td>
      <td>Resist</td>
    </tr>

    <tr>
      <td>2</td>
      <td>.38.45</td>
      <td>Thievery Corporation</td>
      <td>Sounds From the Thievery Hi-Fi</td>
    </tr>

    <tr>
      <td>3</td>
      <td>Fix You</td>
      <td>Coldplay</td>
      <td>X&amp;Y</td>
    </tr>

    <tr>
      <td>4</td>
      <td>Maps</td>
      <td>Yeah Yeah Yeahs</td>
      <td>Fever To Tell</td>
    </tr>

    <tr>
      <td>5</td>
      <td>Ask me how I am</td>
      <td>Snow Patrol</td>
      <td>Final Straw</td>
    </tr>

    <tr>
      <td>6</td>
      <td>PMT</td>
      <td>Deeper Water</td>
      <td>Global Underground Moscow</td>
    </tr>

    <tr>
      <td>7</td>
      <td>Four Kicks</td>
      <td>Kings of Leon</td>
      <td>Aha Shake Heartbreak</td>
    </tr>

    <tr>
      <td>8</td>
      <td>Gravity</td>
      <td>Embrace</td>
      <td>Out of Nothing</td>
    </tr>

    <tr>
      <td>9</td>
      <td>Lyla</td>
      <td>Oasis</td>
      <td>Don't Believe the Truth</td>
    </tr>

    <tr>
      <td>10</td>
      <td>All For You, Sophia</td>
      <td>Franz Ferdinand</td>
      <td>Take me Out</td>
    </tr>

    <tr>
      <td>11</td>
      <td>Look What You've Done</td>
      <td>Jet</td>
      <td>Get Born</td>
    </tr>

    <tr>
      <td>12</td>
      <td>Chicken Payback</td>
      <td>The Bees</td>
      <td>Free the Bees</td>
    </tr>

    <tr>
      <td>13</td>
      <td>Walkabout</td>
      <td>Blue States</td>
      <td>Bar Lounge Classics</td>
    </tr>

    <tr>
      <td>14</td>
      <td>Oh My God</td>
      <td>Kaiser Chiefs</td>
      <td>Employment</td>
    </tr>

    <tr>
      <td>15</td>
      <td>Rock Scene</td>
      <td>Athlete</td>
      <td>Tourist</td>
    </tr>
  </tbody>
</table>
    ";

$html = "
	 <fieldset>
	 	<h1>Histórico</h1>
	 	<p>Aluno: <strong> $nome </strong></p>
	 	<p>Matricula: <strong>$matricula</strong></p>
	 	<p>Ano: <strong>$ano<strong></p>
	 	<br>
		<br>
		$table;
		<br>
		<p class='center sub-titulo'>          .........................................................................</p>
	 	<p class='center '><strong>Coordenador</strong> CPF/CNPJ: <strong>222.222.222-02</strong></p>
	 </fieldset>";

$mpdf = new mPDF();
$mpdf->SetDisplayMode('fullpage');
$css = file_get_contents("./assets/css/estilo.css");
$mpdf->WriteHTML($css, 1);
$mpdf->WriteHTML($html);
$mpdf->Output();

exit;
