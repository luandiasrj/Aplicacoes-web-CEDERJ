<html>
<head>
<title> Exemplo de acesso a BDs </title>
</head>
<body><pre>
<?php
  echo "Neste exemplo, quando você clicou no botão <abrir navegador>, uma tabela chamada cliente foi criada, com atributos: id, nome e endereco. Para repetir este exemplo, fora do contexto da aula, é necessário criar esta tabela manualmente no servidor mysql.\n\n";
  // (1) abrir conexão com mysql no servidor remoto ao PHP
  $con = mysql_connect($_SERVER["REMOTE_ADDR"], "aluno", "aluno");
  // selecionar banco de dados
  mysql_select_db("prog2",$con);
  // (2) consulta ao bd prog2 sobre tabela cliente
  $res = mysql_query("SELECT * FROM cliente",$con);
  // (3) recupera linhas da tabela
  while ($row = mysql_fetch_row($res))
  {
      // (4) imprime valores de atributos
      for ($i=0; $i < mysql_num_fields($res); $i++) 
          echo $row[$i]." ";
      echo "\n";
  }
  // (5) fechar conexão
  mysql_close($con);
?>
</pre></body>
</html>
