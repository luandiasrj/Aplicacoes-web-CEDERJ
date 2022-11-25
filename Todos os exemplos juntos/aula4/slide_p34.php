<html>
<head>
<title> PHP: Arrays, list </title>
</head>
<body>
<p> Exemplo de utiliza&ccedil;&atilde;o de arrays, list <br>
<?php
   $tshirtinfo = array("Tam"=>"g","cor"=>"azul","preco"=>12.00); # Código original com erro de sintaxe
   asort($tshirtinfo);
   list($primvalor,$segvalor) = $tshirtinfo;
   echo $primvalor,"<br>";
   echo $segvalor,"<br>";

   echo 'Este exemplo n&atilde;o devolve valores para as
   vari&aacute;veis $primvalor e $segvalor porque a constru&ccedil;&atilde;o
   list somente funciona em arrays com &iacute;ndices
   num&eacute;ricos. Havia um erro no exemplo original de onde este
   programa foi retirado. Veja o resultado abaixo, com o mesmo exemplo
   com o array indexado com &iacute;dices num&eacute;ricos: <br><br>';

   $tshirtinfo = array("g","azul",12.00);
   sort($tshirtinfo);
   list($primvalor,$segvalor) = $tshirtinfo;
   echo $primvalor,"<br>";
   echo $segvalor,"<br>";

?>
</body>
</html>
