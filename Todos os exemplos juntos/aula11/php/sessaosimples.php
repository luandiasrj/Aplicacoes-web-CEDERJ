<?php
session_start();
if (!IsSet($_SESSION["contador"])) 
   $_SESSION["contador"]=0;
$_SESSION["contador"]++;
?>
<html>
<head><title>Sessao Simples</title></head> 
<body>
<h1>Esta pagina foi acessada
<?php echo $_SESSION["contador"]; ?>
 vezes </h1>
</body>
</html>
