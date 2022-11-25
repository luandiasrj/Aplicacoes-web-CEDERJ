<html>
<head>
<title> PHP: Arrays, extract </title>
</head>
<body>
<p> Exemplo de utiliza&ccedil;&atilde;o de arrays, extract <br>
<?php
   $Tam = "m";
   $tshirtinfo = array("Tam"=>"g","cor"=>"azul","preco"=>12.00);
   asort($tshirtinfo);
   extract($tshirtinfo,EXTR_PREFIX_SAME,"xxx");
   echo $Tam," ",$cor," ",$preco," ",$xxx_Tam;
?>
</body>
</html>
