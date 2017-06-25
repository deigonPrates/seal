<?php

session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: /login");
}
include("./assets/mpdf/mpdf.php");
include_once("./classes/conexao.class.php");

$conexao = new Conexao();
$con = $conexao->BDAbreConexao();
$bdID = (int)$conexao->BDRetornaID($_SESSION['matricula']);

$alunos = $conexao->BDSeleciona('alunos', 'alunos.nome, alunos.email,alunos.matricula', "WHERE(id = 1)");
$turmas = $conexao->BDSeleciona('turmas', 'turmas.ano, turmas.semestre', "WHERE(id = 1)");
$consultabd = $conexao->BDSQL("SELECT sum(questoes.valor) as nota, atividades.conteudo, atividades.dataInicio from alunos "
        . "join alunos_atividades on alunos.id = alunos_atividades.aluno_id "
        . "JOIN atividades on atividades.id = alunos_atividades.avaliacao_id "
        . "JOIN questoes on atividades.id = questoes.atividade_id "
        . "join respostas on questoes.id = respostas.questao_id "
        . "WHERE(respostas.resultado = 1 and alunos.id = $bdID) "
        . "GROUP by atividades.conteudo, atividades.dataInicio");
$conexao->BDFecharConexao($con);

foreach ($alunos as $key => $value) {
    $lacoNome .= "<tr>";
    $lacoNome .= "<td>Nome: {$value['nome']}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $lacoNome .= "Matricula: {$value['matricula']}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $lacoNome .= "Email: {$value['email']}</td>";
    $lacoNome .= "</tr>";
}
foreach ($turmas as $key => $value) {
    $lacoTurma .= "<tr>";
    $lacoTurma .= "<td><strong>Graduação:&nbsp;&nbsp;&nbsp;</strong> Curso Superior de Tecnologia em Análise e Desenvolvimento de Sistemas <br>";
    $lacoTurma .= "<strong>Ano:&nbsp;&nbsp;&nbsp;</strong>{$value['ano']}".'.';
    $lacoTurma .= "{$value['semestre']}</td>";
    $lacoTurma .= "</tr>";
}
foreach ($consultabd as $key => $value) {
    $lacoDisciplina .= "<tr>";
    $lacoDisciplina .= "<td><center>{$value['conteudo']}</center></td>";
    $lacoDisciplina .= "<td><center>{$value['nota']}</center></td>";
    $lacoDisciplina .= "<td><center>{$value['dataInicio']}</center></td>";
    $lacoDisciplina .= "</tr>";
}
$pagina = "
<div class='row' >
    <div class='col-sm-12'>
        <div class='card-box'>
        <center><img src='./assets/images/headerHistorico.png'></center>
      <br>
     
";
$pagina.="
      <TABLE width='1000' > <!-- Tabela Herder  -->
          <TR> 
              <TD width='100' bgcolor='#A9A9A9'><center>IDENTIFICAÇÃO</center></TD>
          </TR> 
          $lacoNome
     </TABLE>
        <br>
      <TABLE width='1000'> <!-- Tabela Herder  -->
          <TR> 
             <TD width='100' bgcolor='#A9A9A9'><center>CURSO</center></TD>
          </TR> 
            $lacoTurma
      </TABLE>
         <br>
      <TABLE width='1000'> <!-- Tabela Herder  -->
          <TR> 
              <TD width='100' bgcolor='#A9A9A9' ><center>AVALIAÇÃO</center></TD> 
              <TD width='100' bgcolor='#A9A9A9'><center>NOTA</center></TD>
              <TD width='100' bgcolor='#A9A9A9'><center>DATA</center></TD>
          </TR> 
          $lacoDisciplina
           

      </TABLE>
        </div>
    </div>
</div>
   </div>
</div>
</div>
"; 
$arquivo = "histórico.pdf";

$mpdf = new mPDF();
$mpdf->WriteHTML($pagina);

$mpdf->Output($arquivo, 'I');

include_once 'footer.php';
?>
