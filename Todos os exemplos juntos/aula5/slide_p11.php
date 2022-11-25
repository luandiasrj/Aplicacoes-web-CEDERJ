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
   // $x3 = calcula_soma(); // Irá gerar um notice de erro de falta de parâmetros
   //echo $x1,"   ", $x2, "   ", $x3; // Notice: Undefined variable: x3
   echo $x1,"   ", $x2;
   echo "<br><br> Os avisos que aparecem neste exemplo impedem que os comandos sejam executados. Portanto, os resultados
   s&atilde;o escritos na tela.<br>"
?>
</body>
</html>
