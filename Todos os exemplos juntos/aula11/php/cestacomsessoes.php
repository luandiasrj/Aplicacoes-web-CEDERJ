<?php 
header("Content-Type: text/html; charset=ISO-8859-1");
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <link type="text/css" href="aula12.css" rel="stylesheet">
  <title>Loja X</title>
</head>
<body>
<h2>Cesta de Compras</h2>
<form method="post" action="cestacomsessoes.php" name="frmCesta">
<table cellpadding="5" cellspacing="5">
      <tr>
         <th width=20px> Item </th>
	<th width=250px>Descrição</th>
	<th width=80px>Preço</th>
	<th width=50px>Quantidade</th>
      </tr>	  
<?php

$linhaTabela = <<<FIMLINHA
      <tr>
	<td>%d</td>
        <td>%s</td>
        <td align="right">%.2f</td>
        <td><input name="qtd[%d]" value="%d" size=2></td>
      </tr>
FIMLINHA;

define ("LinhasPorPag", 5); 

function formata_linhas_tabela ($consulta, $pagina,&$qtd) {
    $numLinha = $pagina * LinhasPorPag;
    // mysql_data_seek($consulta, $numLinha);
    mysqli_data_seek($consulta, $numLinha);
    global $linhaTabela;
    for ($n = 0; $n < LinhasPorPag && 
         // ($linha = mysql_fetch_array($consulta)); $n++) {
            ($linha = mysqli_fetch_array($consulta)); $n++) {
	$descricao = $linha["descricao"];
	$preco = $linha["preco"];
	$id = $linha["id"];
	$q = IsSet($qtd[$id]) ? $qtd[$id] : 0;
	echo sprintf ($linhaTabela, $id, $descricao, $preco, $id, $q);
    }
}

function formata_botoes ($numPg, $pag) {
    echo "<br> Página ".($pag+1)." de ".$numPg."&nbsp".
    //
       '<button value="atualizar" name="submit">Atualizar'.
       '</button> &nbsp'.
       '<button value="comprar" name="submit">Comprar'.
       '</button> &nbsp';
    if ($pag > 0) 
	echo '<button value="prev" name="submit">'.
	     'Pg. Anterior</button> &nbsp'; 
    if ($pag < $numPg-1) 
       echo '<button value="prox" name="submit">Próxima Pg.</button>';
    echo "<br>\n";
}

function formata_total ($consulta, $qtd) {
    // mysql_data_seek($consulta, 0);
    mysqli_data_seek($consulta, 0);
    $total = 0;
    // while (($linha = mysql_fetch_array($consulta))) {
    while (($linha = mysqli_fetch_array($consulta))) {
	$id = $linha["id"];
	$total += $linha["preco"] * $qtd[$id];
    }
    echo "<br> Total : R\$" . sprintf ("%.2f",$total) . "<br>\n";
}
    
function pega_pagina ($numPaginas) {
    $pagina = IsSet($_SESSION["pagina"])?$_SESSION["pagina"]:0;
    if (IsSet($_POST["submit"])) {
	if ($_POST["submit"] == 'prox') 
	    $pagina = min($pagina+1,$numPaginas-1);
	if ($_POST["submit"] == 'prev') 
	    $pagina = max($pagina-1,0);
    }
    $_SESSION["pagina"] = $pagina;
    return $pagina;
}

function pega_quantidades () {
    $qtd = IsSet($_SESSION["qtd"]) ? $_SESSION["qtd"] : array();
    if (IsSet($_POST["qtd"])) {
	foreach ($_POST["qtd"] as $id => $q) {
	    $qtd [$id]=$q;
	}
    }
    $_SESSION["qtd"] = $qtd;
    return $qtd;
}


$servidor = $_SERVER["REMOTE_ADDR"];
// $conexao = mysql_connect($servidor,"aluno","aluno"); 
$conexao = mysqli_connect($servidor,"aluno","aluno", "prog2");
// mysql_select_db("prog2", $conexao);
// $consulta = mysql_query ("select * from produto", $conexao);
$consulta = mysqli_query ($conexao, "select * from produto");

// $numPaginas = ceil(mysql_num_rows ($consulta)/LinhasPorPag);
$numPaginas = ceil(mysqli_num_rows ($consulta)/LinhasPorPag);
$qtd = pega_quantidades ();
$pagina = pega_pagina ($numPaginas);

formata_linhas_tabela ($consulta, $pagina, $qtd);
echo "</table>";
formata_botoes ($numPaginas, $pagina);
formata_total ($consulta, $qtd);
// mysql_close($conexao);
mysqli_close($conexao);
?>
</form>
</body>
</html>