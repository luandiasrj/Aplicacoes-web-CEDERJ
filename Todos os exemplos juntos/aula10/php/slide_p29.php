<html>
<head><title>Erros</title></head>
<body>
<?php
   function exibeErro() // Ignorado por conta de notação antiga
   {
      die("Erro " . mysql_errno() . ": " . mysql_error());
   }

   //if (! ($con = @mysql_connect($_SERVER["REMOTE_ADDR"],"aluno", "aluno")))
   $con = mysqli_connect($_SERVER["REMOTE_ADDR"], "aluno", "aluno", "prog2");
   if (mysqli_connect_errno()) {
      echo "Erro " . mysqli_connect_errno() . ": " . mysqli_connect_error();
      exit();
   }

   // die("Conexão falhou!");
   // if (! (mysql_select_db("xxx",$con)))
   //  exibeErro();

   mysqli_close($con);
   ?>
</body>
</html>

