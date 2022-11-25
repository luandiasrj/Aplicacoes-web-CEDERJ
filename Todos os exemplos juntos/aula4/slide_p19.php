<html>
<head>
<title> Tabuada da Multiplica&ccedil;&atilde;o </title>
</head>
<body bgcolor="#ffffff">
<h1> Tabuada de Multiplica&ccedil;&atilde;o </h1>
<?php
 // Passa por cada tabela
 for ($tabela=1;$tabela<13;$tabela++)
 {
   echo "<p><b> Tabuada de Multiplica&ccedil;&atilde;o de ".$tabela."</b>\n";
   // Produz 12 linhas para cada tabela
   for ($cont=1;$cont<13;$cont++)
   {
     $result = $tabela * $cont;

     // O contador é par?
     if ($cont % 2 == 0)
      // Sim, escrever a linha em negrito
      echo "<br><b>$cont x $tabela = "."$result</b>";
     else
      // Não, escrever a linha com fonte normal
      echo "<br>$cont x $tabela = "."$result";
   }
 }
?>
</body>
</html>
