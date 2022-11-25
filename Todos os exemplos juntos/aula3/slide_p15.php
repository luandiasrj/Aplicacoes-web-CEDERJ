<html>
<head>
<title> PHP: Datas e Hor&aacute;rios </title>
</head>
<body>
<?php 
  $hoje = strtotime("today");
  $data = strtotime("last monday"); 
  $intervalo = (($hoje - $data)/60)/60;
  echo $intervalo;
?>
</body>
</hmtl>

