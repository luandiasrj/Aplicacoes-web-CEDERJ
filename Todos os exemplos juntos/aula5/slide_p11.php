<html>
<head>
<title> Fun&ccedil;&otilde;es, passagem de par&acirc;metros </title>
</head>
<body bgcolor="#ffffff">
<h1> Passagem de par&acirc;metros </h1>
<?php
   function calcula_soma($n1,$n2)
   {
      return $n1 + $n2;
   }
   $x1 = calcula_soma(20,30);          
   $x2 = calcula_soma(20*20,32+2);    
   $x3 = calcula_soma(); 
   echo $x1,"   ", $x2, "   ", $x3;
   echo "<br><br> Os avisos que aparecem neste exemplo n&atilde;o
   impedem que os comandos sejam executados. Portanto, os resultados
   s&atilde;o escritos na tela, mesmo com os avisos sendo emitidos.<br>"
?>
</body>
</html>
