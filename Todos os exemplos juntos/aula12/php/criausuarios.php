<?php
header("Content-Type: text/html; charset=ISO-8859-1");

function insere_usuario ($nome, $senha, $conexao) {
   // Computar o sal para o crypt 
   $sal = substr($nome, 0, 2); 
   // Criar senha encriptada
   $senha_enc = crypt($senha, $sal);
   // Realizar inserção
   mysql_query ("insert into usuarios values 
     (\"$nome\", \"$senha_enc\")", $conexao) or
   exit ("ERRO inserindo $nome");
}

$servidor = $_SERVER["REMOTE_ADDR"];
$conexao = mysql_connect($servidor,"aluno","aluno"); 
mysql_select_db("prog2", $conexao);
$consulta = mysql_query ("DROP TABLE IF EXISTS usuarios") or die ("Erro dropping");
$consulta = mysql_query (
   "CREATE TABLE usuarios ( 
       nome varchar(10) not null, 
       senha varchar(15) not null,
       PRIMARY KEY (nome))"
) or die ("Erro criando");
insere_usuario ("aluno", "aluno", $conexao);
insere_usuario ("fulano", "xpto", $conexao);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" 
    "http://www.w3.org/TR/html4/loose.dtd" > 
<html> 
  <head><title>Criação da tabelas 'usuarios'</title></head> 
  <body> 
      <h2> Tabela 'usuarios' criada </h2>
  </body> 
</html>