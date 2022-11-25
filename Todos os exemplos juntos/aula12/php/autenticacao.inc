<?php
function autentica ($nome, $senha, $conexao) {
  if (isset($nome) && isset($senha)) { 
    // Computar o sal para o crypt 
    $sal = substr($nome, 0, 2); 
    // Criar senha encriptada
    $senha_enc = crypt($senha, $sal);
    // Realizar consulta
    $consulta = "select * from usuarios where nome = '$nome' and senha = '$senha_enc'";
    $result = mysql_query ($consulta, $conexao);
    // Retornar true somente se encontrado 1 nome
    return (mysql_num_rows ($result) == 1);
  }
  return false;
} 

$servidor = $_SERVER["REMOTE_ADDR"];
$conexao = mysql_connect($servidor,"aluno","aluno"); 
mysql_select_db("prog2", $conexao);
?>