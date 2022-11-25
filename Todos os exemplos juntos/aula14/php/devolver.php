<h2> Devolução de Livros</h2>
<?php
//
// Módulo encarregado da operação de devolução de livros.
//

require_once ('formemprestimo.php');

assegura_privilegio ('A');


// Apresentamos um formulário para escolha de livros emprestados e que podem 
// ser devolvidos. O administrador então seleciona aqueles que efetivamente
// está recebendo para devolução e confirma.
if (isset ($_POST["enviar_busca_emprestimo"])) {
    // Formulário de busca foi enviado. Realizo uma consulta de busca com
    // os critérios dados
    $emprestimos = busca_emprestimo ($_POST['nome'], $_POST['login'], 
		 		    $_POST['titulo'], $_POST['autor']);
    if (count ($emprestimos) == 0) {
	echo "<p> Não há livros emprestados dentro desses critérios</p>\n";
    } else {
	// Exibo formulário de confirmação de devolução
	form_confirma_devolucao ('index.php?acao=devolver',$emprestimos);
	// Guardo emprestimos em variável de sessão para evitar repetir consulta
	$_SESSION['emprestimos']=$emprestimos;
    }
}
elseif (isset($_POST["enviar_confirma_devolucao"])) {
    // Formulario de confirmacao foi enviado.
    // Obtenho os emprestimos a processar e Destruo a variável de sessão.
    $emprestimos = $_SESSION['emprestimos'];
    unset ($_SESSION['emprestimos']);
    // Contador de empréstimos devolvidos.
    $n_emprestimos = 0;
    // Total de multas
    $total_multa = 0;
    // Solicitacoes que agora podem ser atendidas devido às devoluções.
    $solicitacoes_pendentes = array();
    // Processo todos os emprestimos.
    foreach ($emprestimos as $indice=>$emprestimo) {
	// Processo apenas os emprestimos cujo "checkbox" de confirmação foi ligado.
	if ($_POST[$indice]) {
	    if (!$emprestimo->devolve()) {
		// Um erro inesperado?
		msg_erro ("Erro na realização da consulta");
		msg_erro (mysql_error());
	    } else {
		// Imprimo o empréstimo
		$n_emprestimos++;
		echo "<h3> Devolução $n_emprestimos </h3>\n";
		$emprestimo->exibe();
		// Vejo se há alguma solicitação para este livro que agora pode ser atendida.
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
	echo "<h3> As seguintes solicitações agora podem ser atendidas:</h3>\n";
	foreach ($solicitacoes_pendentes as $sol) {
	    $sol->exibe();
	}
    }
    // Imprimo total de multas se necessário.
    if ($total_multa > 0) {
	echo "<h3> Total de multas: R$".
	     number_format($total_multa, 2, ',', '.') ." </h3>\n";
    }
}
else {
    // Exibo formulário de busca de devolucoes.
    form_busca_emprestimo ('index.php?acao=devolver', $_POST);
}

?>
