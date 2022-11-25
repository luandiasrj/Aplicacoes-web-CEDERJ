<html>
<head>
<title> Exemplo de acesso a BDs </title>
</head>
<body><pre>
<?php
  echo "Este exemplo, assim como o do slide 4, assume que a tabela cliente já foi criada\n\n";
  // (1) abrir conexão com mysql no servidor remoto ao PHP
  $con = mysql_connect($_SERVER["REMOTE_ADDR"], "aluno", "aluno");
  // selecionar banco de dados
  mysql_select_db("prog2",$con);
  // (2) consulta ao bd prog2 sobre tabela cliente
  $res = mysql_query("SELECT * FROM cliente",$con);
  // (3) recupera linhas da tabela
 $row = mysql_fetch_array($res);
 echo $row["nome"];
  // (5) fechar conexão
  mysql_close($con);
?>
</pre></body>
</html>
