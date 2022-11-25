<html>
<head><title>Erros</title></head>
<body>
<?php
 function exibeErro()
 {
   die("Erro ".mysql_errno().": ".mysql_error());
 }

 if (! ($con = @mysql_connect($_SERVER["REMOTE_ADDR"],"aluno", "aluno")))
    die("Conexão falhou!");
 if (! (mysql_select_db("xxx",$con)))
    exibeErro();
?>
</body>
</html>

