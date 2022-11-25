<?php header("Content-Type: text/html; charset=ISO-8859-1"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" 
    "http://www.w3.org/TR/html4/loose.dtd" > 
<html> 
  <head><title>Authenticação</title></head> 
  <body> 
    <h2>Alô <?php echo $_SERVER['PHP_AUTH_USER']; ?></h2> 
    <p>Sua senha é <?php echo $_SERVER['PHP_AUTH_PW']; ?>! </p> 
    <p>Método de autenticação: <?php echo $_SERVER['AUTH_TYPE']; ?> </p>
  </body> 
</html>