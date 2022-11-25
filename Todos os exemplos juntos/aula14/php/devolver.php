<h2> Devolu��o de Livros</h2>
<?php
//
// M�dulo encarregado da opera��o de devolu��o de livros.
//

require_once ('formemprestimo.php');

assegura_privilegio ('A');


// Apresentamos um formul�rio para escolha de livros emprestados e que podem 
// ser devolvidos. O administrador ent�o seleciona aqueles que efetivamente
// est� recebendo para devolu��o e confirma.
if (isset ($_POST["enviar_busca_emprestimo"])) {
    // Formul�rio de busca foi enviado. Realizo uma consulta de busca com
    // os crit�rios dados
    $emprestimos = busca_emprestimo ($_POST['nome'], $_POST['login'], 
		 		    $_POST['titulo'], $_POST['autor']);
    if (count ($emprestimos) == 0) {
	echo "<p> N�o h� livros emprestados dentro desses crit�rios</p>\n";
    } else {
	// Exibo formul�rio de confirma��o de devolu��o
	form_confirma_devolucao ('index.php?acao=devolver',$emprestimos);
	// Guardo emprestimos em vari�vel de sess�o para evitar repetir consulta
	$_SESSION['emprestimos']=$emprestimos;
    }
}
elseif (isset($_POST["enviar_confirma_devolucao"])) {
    // Formulario de confirmacao foi enviado.
    // Obtenho os emprestimos a processar e Destruo a vari�vel de sess�o.
    $emprestimos = $_SESSION['emprestimos'];
    unset ($_SESSION['emprestimos']);
    // Contador de empr�stimos devolvidos.
    $n_emprestimos = 0;
    // Total de multas
    $total_multa = 0;
    // Solicitacoes que agora podem ser atendidas devido �s devolu��es.
    $solicitacoes_pendentes = array();
    // Processo todos os emprestimos.
    foreach ($emprestimos as $indice=>$emprestimo) {
	// Processo apenas os emprestimos cujo "checkbox" de confirma��o foi ligado.
	if ($_POST[$indice]) {
	    if (!$emprestimo->devolve()) {
		// Um erro inesperado?
		msg_erro ("Erro na realiza��o da consulta");
		msg_erro (mysql_error());
	    } else {
		// Imprimo o empr�stimo
		$n_emprestimos++;
		echo "<h3> Devolu��o $n_emprestimos </h3>\n";
		$emprestimo->exibe();
		// Vejo se h� alguma solicita��o para este livro que agora pode ser atendida.
		$solicitacao = new solicitacao;
		if ($solicitacao->busca ("idlivro = $emprestimo->idlivro", "hora")) {
		    if ($solicitacao->lugar_fila() == 0) {
			$solicitacoes_pendentes [] = $solicitacao;
		    }
		}
		// Acumulo a multa
		$total_multa+=$emprestimo->multa();
	    }
	}
    }
    // Imprimo as solicitacoes pendentes
    if (count($solicitacoes_pendentes) > 0) {
	echo "<h3> As seguintes solicita��es agora podem ser atendidas:</h3>\n";
	foreach ($solicitacoes_pendentes as $sol) {
	    $sol->exibe();
	}
    }
    // Imprimo total de multas se necess�rio.
    if ($total_multa > 0) {
	echo "<h3> Total de multas: R$".
	     number_format($total_multa, 2, ',', '.') ." </h3>\n";
    }
}
else {
    // Exibo formul�rio de busca de devolucoes.
    form_busca_emprestimo ('index.php?acao=devolver', $_POST);
}

?>
