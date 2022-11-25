<html>
<head>
<title> PHP: Arrays, sort </title>
</head>
<body>
<p> Exemplo de utiliza&ccedil;&atilde;o de arrays, sort <br>
<?php
    $animal[] = "tigre";
    $animal[] = "girafa";
    $animal[] = "elefante";

    echo "Valor de $animal antes do sort<br>";
    echo "<pre>";
    print_r($animal); 
    echo "</pre>";

    sort($animal);

    echo "Valor de $animal depois do sort<br>";
    echo "<pre>";
    print_r($animal); 
    echo "</pre>";

?>
</body>
</html>
