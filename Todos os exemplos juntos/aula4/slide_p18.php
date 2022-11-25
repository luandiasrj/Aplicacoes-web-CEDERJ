<html>
<head>
<title> PHP: Loops </title>
</head>
<body>
<p> Exemplo de utiliza&ccedil;&atilde;o do while/continue <br>
<?php
    $cont = 0;
    while ($cont < 5)
    {
	$cont++;
	if ($cont == 3)
        {
           echo "continue<br>";
           continue;
        }
        echo "Fim do while: cont=$cont<br>";
    }
    echo "Depois do loop<br>";
?>
</body>
</html>
