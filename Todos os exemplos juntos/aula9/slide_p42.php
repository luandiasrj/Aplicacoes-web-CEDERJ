<html>
<head><title>Combined scripts</title></head>
<body>
<?php
   $script = "slide_p42.php";
   if (empty($_GET["assunto"]))
   {
?>
   <form action="<?=$script;?>" method="GET"> 
   <br> Entre com um assunto: 
   <input type="text" name="assunto" value="Todos"> 
   (Digite Todos para ver todos os assuntos)
   </br> <input type="submit" value="Mostrar livros">
   </form><br>
<?php
   } // fim do if empty($assunto)
   else echo $_GET["assunto"];
?>
</body>
</html>

