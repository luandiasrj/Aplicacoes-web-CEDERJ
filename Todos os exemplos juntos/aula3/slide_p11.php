<html>
<head>
<title> PHP: Datas e Hor&aacute;rios </title>
</head>
<body>
<?php 
  $data = strtotime("last saturday");
  echo "Ultimo sabado: ", date("d/m/y",$data), "<br>";
  $data = strtotime("8pm + 3 days");
  echo "8pm + 3 dias: ", date("d/m/y",$data), "<br>";
  $data = strtotime("next year gmt");
  echo "Proximo ano gmt: ", date("d/m/y",$data), "<br>";
  $data = strtotime("this 4am");
  echo "Hoje 4am: ", date("d/m/y",$data), "<br>";
  $data = strtotime("2 weeks ago");
  echo "2 semanas atras: ", date("d/m/y",$data), "<br>";
?>
</body>
</html>
