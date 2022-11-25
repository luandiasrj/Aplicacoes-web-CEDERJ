<h2> Entrega de Livros</h2>
<?php
//
// Este módulo é encarregado da operação de entrega de livros,
// isto é, efetivação dos empréstimos solicitados pelos usuários
//

require_once ('formsolicitacao.php');

assegura_privilegio ('A');

// Apresentamos um formulário para escolha de livros solicitados e que podem 
// ser entregues. O administrador então seleciona aqueles que deseja entregar
// e confirma a entrega.
if (isset ($_POST["enviar_busca_solicitacao"])) {
    // Formulário de busca foi enviado. Realizo uma consulta de busca com
    // os critérios dados
    $solicitacoes = busca_solicitacao ($_POST['nome'], $_POST['login'], 
		 		    $_POST['titulo'], $_POST['autor']);
    if (count ($solicitacoes) == 0) {
	echo "<p> Não há livros solicitados dentro desses critérios.</p>\n";
    } else {
	// Exibo formulário de confirmação de entrega
	form_confirma_entrega ('index.php?acao=entregar',$solicitacoes);
	// Guardo solicitações em variável de sessão para evitar repetir consulta
	$_SESSION['solicitacoes']=$solicitacoes;
    }
}
elseif (isset($_POST["enviar_confirma_entrega"])) {
    // Formulario de confirmacao foi enviado.
    // Obtenho as solicitações a processar e Destruo a variável de sessão.
    $solicitacoes = $_SESSION['solicitacoes'];
    unset ($_SESSION['solicitacoes']);
    // Contador de empréstimos feitos
    $n_emprestimos = 0;
    // Processo todas as solicitações em ordem crescente de hora
    foreach ($solicitacoes as $indice=>$solicitacao) {
	// Processo apenas as solicitações cujo "checkbox" de confirmação estava ligado
	// if ($_POST[$indice]) {
	if (isset($_POST[$indice])) {
	    if (!$solicitacao->entrega()) {
		// Um erro inesperado?
		msg_erro ("Erro na realização da consulta.");
		// msg_erro (mysql_error());
		msg_erro(mysqli_error($conexao));
	    } else {
		// Imprimo o empréstimo
		$n_emprestimos++;
		echo "<h3> Empréstimo $n_emprestimos </h3>\n";
		$emprestimo = new emprestimo;
		$emprestimo->busca ("idlivro=$solicitacao->idlivro ".
				    "and idusuario=$solicitacao->idusuario");
		$emprestimo->exibe();
	    }
	}
    }
}
else {
    // Exibo formulário de busca de solicitações
    form_busca_solicitacao ('index.php?acao=entregar', $_POST);
}

?>