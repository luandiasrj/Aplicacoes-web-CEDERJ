<?php header("Content-Type: text/html; charset=ISO-8859-1",true) ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <link type="text/css" href="aula12.css" rel="stylesheet">
  <title>Loja X</title>
</head>
<body>
<h2>Cesta de Compras</h2>
<form method="post" action="cestadecompras.php" name="frmCesta">
<table cellpadding="5" cellspacing="5">
	<tbody>
	  <tr>
	    <th>Item</th>
	    <th>Preço</th>
	    <th>Quantidade</th>
	  </tr>
	  
<?php
$linhaTabela = <<<FIMLINHA
      <tr>
        <td>%s</td>
        <td align="right">%.2f</td>
        <td><input name="qtd[%d]" value="%d" size=2></td>
      </tr>
FIMLINHA;

$tabelaItens = 
    array(array ("Item A", 10.50),
          array ("Item B", 9.25),
          array ("Item C", 7.25),
          array ("Item D", 7.32));

if (IsSet($_POST['qtd'])) $qtd = $_POST['qtd']; else $qtd = array ();
$total = 0;
foreach ($tabelaItens as $indice => $item) {
	 list($nome, $preco) = $item;
	 if (IsSet($qtd[$indice])) $q = $qtd[$indice];
	 else $q = 0;
	 $total += $q * $preco;
	 echo sprintf ($linhaTabela,$nome,$preco,$indice,$q);
}
?>

	</tbody>
  </table>
<br>
Total: R$<?php echo sprintf ("%.2f",$total); ?><br>
<br>
<button value="atualizar" name="submit">Atualizar</button>
&nbsp; 
<button value="comprar" name="submit">Comprar</button>
</form>
</body>
</html>