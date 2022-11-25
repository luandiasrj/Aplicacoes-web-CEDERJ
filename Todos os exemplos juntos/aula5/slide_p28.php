<html>
<head>
<title> Exemplo de utiliza&ccedil;&atilde;o de classes e objetos
</title>
</head>
<body>
<h1> Exemplo de utiliza&ccedil;&atilde;o de classes e objetos </h1>
<?
  include "cont.inc";
  $Ocont = new contador;
  // comeca contador em 10
  $Ocont->IniciaContadorEm(10);
  // incrementa o contador
  $Ocont->incrementa();
  $Ocont->incrementa();
  $Ocont->incrementa();
  // Escreve valor atual do contador
  echo "Valor atual do contador: ";
  $Ocont->EscreveValor();                   // 13!
  $Ocont->reset();
  echo "<br>Valor atual do contador (depois de reset): ";
  $Ocont->EscreveValor();                   // 10!
?>
</body>
</html>
