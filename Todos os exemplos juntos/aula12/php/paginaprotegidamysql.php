<?php
header("Content-Type: text/html; charset=ISO-8859-1"); 
include "autenticacao.inc";

// Autenticacao
if (!autentica ($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'], $conexao)) {
  // Credenciais n�o encontradas. Enviar cabe�alho pedindo autenticacao
  header("WWW-Authenticate: Basic realm=\"Pagina Protegida\""); 
  header("HTTP/1.0 401 Unauthorized");
  // Mensagem a ser exibida se usuario cancelar o di�logo
  echo "<H1> Pagina Protegida.</h1>";
  // Abortar processamento
  exit;
} 
// P�gina propriamente dita segue
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" 
    "http://www.w3.org/TR/html4/loose.dtd" > 
<html> 
  <head><title>Authentica��o Correta!</title></head> 
  <body> 
    <h2>Al� <?php echo $_SERVER['PHP_AUTH_USER']; ?></h2> 
    <p>Sua senha � <?php echo $_SERVER['PHP_AUTH_PW']; ?>! </p> 
  </body> 
</html>
