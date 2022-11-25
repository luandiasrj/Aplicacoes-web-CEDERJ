<h2>Consulta de Empréstimos e Solicitações</h2>
<?php
//
// Modulo para mostrar solicitacoes e emprestimos do usuario logado
//

assegura_privilegio ('M');

// Exibo empréstimos do usuario
$consulta = "select * from emprestimo where idusuario = ". $_SESSION['idusuario'];
$resultado = mysql_query ($consulta);
if (mysql_num_rows($resultado)>0) {
    echo "<h3> Empréstimos: </h3>\n";
    while ($array = mysql_fetch_array($resultado)) {
	$emprestimo = new emprestimo;
	$emprestimo->atribui_de_array ($array);
	$emprestimo->exibe();
	echo "<br>\n";
    }
}
// Exibo solicitações do usuário
$consulta = "select * from solicitacao where idusuario = ". $_SESSION['idusuario'];
$resultado = mysql_query ($consulta);
if (mysql_num_rows($resultado)>0) {
    echo "<h3> Solicitações: </h3>\n";
    while ($array = mysql_fetch_array($resultado)) {
	$solicitacao = new solicitacao;
	$solicitacao->atribui_de_array ($array);
	$solicitacao->exibe();
	echo "<br>\n";
    }
}
link_pagina_principal ();
?>
