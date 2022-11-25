<h2> Solicita��o de Livro</h2>
<?php
// O livro cujo id � $_GET['id'] foi clicado numa busca e o usu�rio 
// deve ser inquirido se quer tom�-lo emprestado ou reserv�-lo.

require_once('livro.php');
require_once('htmlutil.php');
require_once('solicitacao.php');

assegura_privilegio ('M');

// Obt�m livro solicitado
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
	echo "<p> <b>Solicita��o Confirmada</b> </p>\n";
	if ($disponiveis > 0) {
	    echo "<p>Dirija-se ao balc�o para retirar o livro</p>\n";
	} else {
	    echo "<p>Enviaremos um e-mail para voc� quando um exemplar ".
		 "deste livro se tornar dispon�vel</p>\n";
	}
    }
    else {
	if ($disponiveis > 0) {
	    echo "<p>Livro tem $disponiveis exemplares dispon�veis. ".
		 "Deseja solicitar um exemplar?</p>";
	} else {
	    echo "<p>Livro n�o tem nenhum exemplar dispon�vel. ".
		 "Deseja realizar uma reserva?</p>";
	}
	botao ("Sim", "index.php?acao=solicitar&confirma=1&id=$idlivro");
	// botao ("N�o, Voltar", "javascript:history.back();");
	botao ("N�o, Voltar", "index.php?acao=buscar");
	
	
    }
} 
else {
    msg_erro ("Livro n�o encontrado");
}
link_pagina_principal ();
?>
