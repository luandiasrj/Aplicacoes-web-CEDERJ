<html>
<head>
<title> Heran&ccedil;a </title>
</head>
<body bgcolor="#ffffff">
<h1> Heran&ccedil;a </h1>
<?
  include "cont.inc";
  class ContGarrafas extends Contador
  {
      // Adiciona 12 garrafas ao contador
      function AdicionaCaixa()
      {
          $this->cont += 12;
      }
      function NumerodeCaixas()
      {
          return ceil($this->cont/12);
      }
      function ContGarrafas($inicio)        // construtor
      {
          $this->cont = $inicio;
      }
  }
  $temp = new ContGarrafas(12);             // $cont = 12
  $temp->AdicionaCaixa();                   // $cont = 24
  $var = $temp->NumerodeCaixas();           // $var = 2
  echo '(numero de caixas) Valor de $var = ',"$var <br>";
?>
</body>
</html>
