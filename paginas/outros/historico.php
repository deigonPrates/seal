<?php

session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: /login");
}
include("./assets/mpdf/mpdf.php");
include_once("./classes/conexao.class.php");

$conexao = new Conexao();
$con = $conexao->BDAbreConexao();

$alunos = $conexao->BDSeleciona('alunos', 'alunos.nome, alunos.email,alunos.matricula', "WHERE(id = 1)");
$turmas = $conexao->BDSeleciona('turmas', 'turmas.ano, turmas.semestre', "WHERE(id = 1)");
$consultabd = $conexao->BDSQL("SELECT sum(questoes.valor) as nota, atividades.conteudo, atividades.dataInicio from alunos "
        . "join alunos_atividades on alunos.id = alunos_atividades.aluno_id "
        . "JOIN atividades on atividades.id = alunos_atividades.avaliacao_id "
        . "JOIN questoes on atividades.id = questoes.atividade_id "
        . "join respostas on questoes.id = respostas.questao_id "
        . "WHERE(respostas.resultado = 1 and alunos.id = 1) "
        . "GROUP by atividades.conteudo, atividades.dataInicio");
$conexao->BDFecharConexao($con);

foreach ($alunos as $key => $value) {
    $lacoNome .= "<tr>";
    $lacoNome .= "<td>{$value['nome']}</td>";
    $lacoNome .= "<td>{$value['matricula']}</td>";
    $lacoNome .= "<td>{$value['email']}</td>";
    $lacoNome .= "</tr>";
}
foreach ($turmas as $key => $value) {
    $lacoTurma .= "<tr>";
    $lacoTurma .= "<td>{$value['ano']}</td>";
    $lacoTurma .= "<td>{$value['semestre']}</td>";
    $lacoTurma .= "</tr>";
}
foreach ($consultabd as $key => $value) {
    $lacoDisciplina .= "<tr>";
    $lacoDisciplina .= "<td>{$value['conteudo']}</td>";
    $lacoDisciplina .= "<td>{$value['nota']}</td>";
    $lacoDisciplina .= "<td>{$value['dataInicio']}</td>";
    $lacoDisciplina .= "</tr>";
}
$pagina = "
<div class='row' >
    <div class='col-sm-12'>
        <div class='card-box'>
            <center><h4 class='page-title' color=black>Historico Aluno</h4></center>
      <br>
      <br>
      <font  color=blue size=3>Dados Aluno </font>
      <br>
      <br>
     
";
$pagina.="
      <TABLE BORDER=1 width='1000' > <!-- Tabela Herder  -->
          <TR> 
              <TD width='100' bgcolor='#edf5ff' >Nome:</TD> 
              <TD width='100' bgcolor='#edf5ff' >Matricula </TD>
              <TD width='100' bgcolor='#edf5ff' > Email: </TD>
          </TR> 
          $lacoNome
     </TABLE>
        <br>
       <font  color=blue size=3>Dados do Curso </font>
      <br>
      <br>
     
      <TABLE BORDER=1 width='1000'> <!-- Tabela Herder  -->
          <TR> 
              <TD width='100' bgcolor='#edf5ff'>Ano </TD>
              <TD width='100' bgcolor='#edf5ff' >Semestre</TD> 
          </TR> 
            $lacoTurma
      </TABLE>
         <br>

         <font  color=blue size=3>Dados do Disciplinas </font>
      <br>
      <br>
      <TABLE BORDER=1 width='800'> <!-- Tabela Herder  -->
          <TR> 
              <TD width='100' bgcolor='#edf5ff' >Avaliação</TD> 
              <TD width='100' bgcolor='#edf5ff'>Nota </TD>
              <TD width='100' bgcolor='#edf5ff'>Data</TD>
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
$arquivo = "historico.pdf";

$mpdf = new mPDF();
$mpdf->WriteHTML($pagina);

$mpdf->Output($arquivo, 'I');
?>
