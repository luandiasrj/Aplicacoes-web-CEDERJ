<html>
<head>
<title> PHP: N&uacute;meros </title>
</head>
<body>
<?php 
  $preco = 25;
  $fpreco = sprintf("%01.2f",$preco);
  echo "$fpreco<BR>";

  echo "<P> A aula relacionada a este slide fala em printf, inv&eacute;s de
  sprintf, porque havia um erro no exemplo original. Se voc&ecirc; utilizar
  printf neste exemplo, o resultado ser&aacute; 25.005, porque al&eacute;m de
  formatar o n&uacute;mero 25, printf tamb&eacute;m retorna um valor
  inteiro (c&oacute;digo 
  de retorno). Desta forma, a vari&aacute;vel fpreco ter&aacute; o
  valor 25.00 concatenado com o valor 5, produzindo o alor
  25.005. Veja abaixo, o resultado utilizando apenas printf:<BR>";

  $fpreco = printf("%01.2f",$preco);
  echo "$fpreco<BR>";
?>
</body>
</html>
