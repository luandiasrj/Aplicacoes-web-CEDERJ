<html>
<head>
<title> Fun&ccedil;&otilde;es, passagem de par&acirc;metros por
refer&ecirc;cia </title>
</head>
<body bgcolor="#ffffff">
<h1> Passagem de par&acirc;metros por refer&ecirc;cia </h1>
<?php
   function dobro(&$var)
   {
      $var = $var * 2;
   }

   $var1 = 5;
   echo 'Valor de $var1 antes da chamada da funcao dobro = ',"$var1<br>";
   dobro($var1);
   echo 'Valor de $var1 depois da chamada da funcao dobro = ',"$var1<br>";
?>
</body>
</html>
