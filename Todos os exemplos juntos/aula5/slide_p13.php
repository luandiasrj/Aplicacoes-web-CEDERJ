<html>
<head>
<title> Fun&ccedil;&otilde;es, passagem de par&acirc;metros </title>
</head>
<body bgcolor="#ffffff">
<h1> Passagem de par&acirc;metros </h1>
<?php
   $numeros = array(10,20,30,40,50);
   soma($numeros);
   function soma($array)
   {
      echo sizeof($array),"<br>";
      $soma = 0; # Corrigido para não aparecer os notices de variável não inicializada
      for ($i=0; $i<sizeof($array); $i++)
      {
         $soma += $array[$i];
         echo "Soma parcial=$soma<br>";
      }
      echo $soma;
   }
?>
</body>
</html>
