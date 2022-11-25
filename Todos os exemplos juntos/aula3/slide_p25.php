<html>
<head>
<title> PHP: Express&otilde;es Regulares </title>
</head>
<body>
<?php 
preg_match("/^[A-Z].*/", "O gato pulou do telhado", $matches);
echo $matches[0], "<br>";
preg_match("/^[A-Z].*/", "O", $matches);
echo $matches[0], "<br>";
preg_match("/^[A-Z].*/", "", $matches) ; # N\&atilde;o imprime nada
echo $matches[0], "<br>";
preg_match("/^[0-9]{5}(\-[0-9]{3})?$/","21920-030", $matches) ;
echo $matches[0], "<br>";
preg_match("/^[0-9]{5}(\-[0-9]{3})?$/","21920", $matches) ;
echo $matches[0], "<br>";
preg_match("/^[0-9]{5}(\-[0-9]{3})?$/","A2192", $matches) ; # Erro por conta do A no meio dos n\&uacute;meros
echo $matches[0], "<br>";
preg_match("/^[0-9]{5}(\-[0-9]{3})?$/","30000", $matches);
echo $matches[0], "<br>";

  echo('<br>A função <b>ereg</b> ficou obsoleta (deprecated) a partir do PHP 5.3.0 e removida no PHP 7.0.0 tendo sua substituição por <b>preg_match</b>.<br>Exibindo <b>preg_match</b> diretamente ele retorna 1 se a expressão regular for encontrada e 0 se não for encontrada.<br> Então para exibir o resultado da expressão regular é necessário chamar o conteúdo do array "$matches[0]".');
?>
</body>
</hmtl>

