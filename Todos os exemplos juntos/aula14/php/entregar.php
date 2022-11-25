<h2> Entrega de Livros</h2>
<?php
//
// Este m�dulo � encarregado da opera��o de entrega de livros,
// isto �, efetiva��o dos empr�stimos solicitados pelos usu�rios
//

require_once ('formsolicitacao.php');

assegura_privilegio ('A');

// Apresentamos um formul�rio para escolha de livros solicitados e que podem 
// ser entregues. O administrador ent�o seleciona aqueles que deseja entregar
// e confirma a entrega.
if (isset ($_POST["enviar_busca_solicitacao"])) {
    // Formul�rio de busca foi enviado. Realizo uma consulta de busca com
    // os crit�rios dados
    $solicitacoes = busca_solicitacao ($_POST['nome'], $_POST['login'], 
		 		    $_POST['titulo'], $_POST['autor']);
    if (count ($solicitacoes) == 0) {
	echo "<p> N�o h� livros solicitados dentro desses crit�rios.</p>\n";
    } else {
	// Exibo formul�rio de confirma��o de entrega
	form_confirma_entrega ('index.php?acao=entregar',$solicitacoes);
	// Guardo solicita��es em vari�vel de sess�o para evitar repetir consulta
	$_SESSION['solicitacoes']=$solicitacoes;
    }
}
elseif (isset($_POST["enviar_confirma_entrega"])) {
    // Formulario de confirmacao foi enviado.
    // Obtenho as solicita��es a processar e Destruo a vari�vel de sess�o.
    $solicitacoes = $_SESSION['solicitacoes'];
    unset ($_SESSION['solicitacoes']);
    // Contador de empr�stimos feitos
    $n_emprestimos = 0;
    // Processo todas as solicita��es em ordem crescente de hora
    foreach ($solicitacoes as $indice=>$solicitacao) {
	// Processo apenas as solicita��es cujo "checkbox" de confirma��o estava ligado
	// if ($_POST[$indice]) {
	if (isset($_POST[$indice])) {
	    if (!$solicitacao->entrega()) {
		// Um erro inesperado?
		msg_erro ("Erro na realiza��o da consulta.");
		// msg_erro (mysql_error());
		msg_erro(mysqli_error($conexao));
	    } else {
		// Imprimo o empr�stimo
		$n_emprestimos++;
		echo "<h3> Empr�stimo $n_emprestimos </h3>\n";
		$emprestimo = new emprestimo;
		$emprestimo->busca ("idlivro=$solicitacao->idlivro ".
				    "and idusuario=$solicitacao->idusuario");
		$emprestimo->exibe();
	    }
	}
    }
}
else {
    // Exibo formul�rio de busca de solicita��es
    form_busca_solicitacao ('index.php?acao=entregar', $_POST);
}

?>