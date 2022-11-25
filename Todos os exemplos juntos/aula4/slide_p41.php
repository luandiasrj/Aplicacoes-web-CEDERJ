<html>
<head>
<title> PHP: Arrays, foreach </title>
</head>
<body>
<p> Exemplo de utiliza&ccedil;&atilde;o de arrays, foreach <br>
<?php
   $capitais = array("PA"=>"Belem","AM"=>"Manaus","PI"=>"Teresina");
   ksort($capitais);
   foreach ($capitais as $estado => $cidade)
   {
      echo "$cidade, $estado<br>";
   }
?>
</body>
</html>
