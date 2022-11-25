<html>
<head>
<title> Exemplo de utiliza&ccedil;&atilde;o de array Multidimensional </title>
<body>
<?php
  $prod['roupa']['tshirt'] = 20.00;
  $prod['roupa']['calcas'] = 32.00;
  $prod['cama']['colcha'] = 45.00;
  $prod['cama']['lencol'] = 22.00;
  $prod['movel']['mesa'] = 120.00;
  $prod['movel']['sofa'] = 640.00;

  echo "<table border=1>";
  foreach ( $prod as $categoria )
  {
     foreach ( $categoria as $pr => $preco )
     {
         $f_preco = sprintf("%01.2f",$preco);
         echo "<tr><td>$pr:</td>
                   <td>R\$$f_preco</td></tr>";
     }
  }
  echo "</table>";
?>
</body>
</html>