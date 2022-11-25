<?php 
// Obtem o valor do cookie chamado 'acessos'
if (IsSet($_COOKIE['acessos']))
    $acessos = $_COOKIE['acessos']+1;
else $acessos = 0;

// Enviar um novo valor para o cookie valido por 10 minutos
setcookie("acessos", $acessos, time()+600, "/"); 
?>
<html> 
  <head><title>Cookies</title></head> 
  <body> 
  <h1> Esta página foi acessada <?php echo $acessos; ?> vezes </h1>
  </body>
</html>
