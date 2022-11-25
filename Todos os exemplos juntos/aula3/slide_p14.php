<html>
<head>
<title> PHP: Datas e Hor&aacute;rios </title>
</head>
<body>
<?php 
  $hoje = strtotime("today");
  $data = strtotime("last monday"); 
  $intervalo = $hoje - $data;
  echo $intervalo;
?>
</body>
</hmtl>

