<h2> Solicitação de Livro</h2>
<?php
// O livro cujo id é $_GET['id'] foi clicado numa busca e o usuário 
// deve ser inquirido se quer tomá-lo emprestado ou reservá-lo.

require_once('livro.php');
require_once('htmlutil.php');
require_once('solicitacao.php');

assegura_privilegio ('M');

// Obtém livro solicitado
$livro_autores = new livro_autores;
$idlivro = $_GET['id'];
if ($livro_autores->busca_idlivro($idlivro)) {
    $livro_autores->exibe();
    $disponiveis = $livro_autores->livro->exemplares_disponiveis();
    if (isset($_GET['confirma'])) {
	$solicitacao=new solicitacao;
	$solicitacao->idlivro = $idlivro;
	$solicitacao->idusuario = $_SESSION['idusuario'];
	// $solicitacao->hora = strftime('%Y-%m-%d %H:%M:%S');
	$solicitacao->hora = date('Y-m-d H:i:s');
	if (!$solicitacao->inclui()) {
	    // echo mysql_error();
		echo $solicitacao->error;
	    exit;
	}
	echo "<p> <b>Solicitação Confirmada</b> </p>\n";
	if ($disponiveis > 0) {
	    echo "<p>Dirija-se ao balcão para retirar o livro</p>\n";
	} else {
	    echo "<p>Enviaremos um e-mail para você quando um exemplar ".
		 "deste livro se tornar disponível</p>\n";
	}
    }
    else {
	if ($disponiveis > 0) {
	    echo "<p>Livro tem $disponiveis exemplares disponíveis. ".
		 "Deseja solicitar um exemplar?</p>";
	} else {
	    echo "<p>Livro não tem nenhum exemplar disponível. ".
		 "Deseja realizar uma reserva?</p>";
	}
	botao ("Sim", "index.php?acao=solicitar&confirma=1&id=$idlivro");
	// botao ("Não, Voltar", "javascript:history.back();");
	botao ("Não, Voltar", "index.php?acao=buscar");
	
	
    }
} 
else {
    msg_erro ("Livro não encontrado");
}
link_pagina_principal ();
?>
