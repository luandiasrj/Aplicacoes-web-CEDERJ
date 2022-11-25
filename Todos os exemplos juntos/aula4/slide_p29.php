<html>
<head>
<title> PHP: Arrays, &iacute;ndice alfanum&eacute;rico </title>
</head>
<body>
<p> Exemplo de utiliza&ccedil;&atilde;o de arrays <br>
<?php
    $moeda = array("BR"=>"Real","EUA"=>"Dolar");

    echo "Valor de $moeda<br>";
    echo "<pre>";
    print_r($moeda); 
    echo "</pre>";

    $moeda['EUA'] = "";

    echo "Valor de $moeda depois de atribuir string nula a chave EUA<br>";
    echo "<pre>";
    print_r($moeda); 
    echo "</pre>";

    unset($moeda['EUA']);   

    echo "Valor de $moeda depois de fazer unset da chave EUA<br>";
    echo "<pre>";
    print_r($moeda); 
    echo "</pre>";

?>
</body>
</html>
