<h2>Remo��o de Livros</h2>
<?php
//
// M�dulo para buscar e remover livros.
//

// Apenas administradores podem acessar
assegura_privilegio ('A');

require_once ("formlivro.php");

// Vejo se o livro a remover foi definido.
if (isset ($_GET['id'])) {
    $idlivro = $_GET['id'];
    // Busco o livro a remover
    $livro_autores = new livro_autores;
    if (!$livro_autores->busca_idlivro ($idlivro)) {
	msg_erro ('Livro n�o existente');
    } else {
	$livro_autores->busca_idlivro ($idlivro);
	$livro_autores->exibe();
        // Livro est� na lista de algum usu�rio que o solicitou?
	$consulta = "select * from solicitacao where idlivro=".$idlivro;
	$resultado = mysql_query($consulta);
	// Algum resultado?
	if (mysql_num_rows($resultado) > 0) {
	   msg_erro ("Livro n�o pode ser removido, porque foi solicitado");
	} else {
	    // Livro est� na lista de emprestimos?
	    $consulta = "select * from emprestimo where idlivro=".$idlivro;
	    $resultado = mysql_query($consulta);
	    // Algum resultado?
	    if (mysql_num_rows($resultado) > 0) {
	       msg_erro ("Livro n�o pode ser removido, porque est� emprestado");
	    } else {
	        // Exibo o livro a ser removido
	        if (isset ($_GET['confirma'])) {
		    // Remo��o confirmada
		    $livro_autores->remove();
		    echo "<h3> Livro removido </h3>";
	        } else {
	             // Pe�o confirma��o
	             echo "<h3> Confirma remo��o? </h3>";
	             botao ("Sim", "index.php?acao=removerlivro&id=$idlivro&confirma=1");
		}
	    }
	}
    }
    link_pagina_principal ();
} 
// Caso contr�rio, vejo se o formul�rio foi postado.
elseif (isset ($_POST["enviar_busca_livro"])) {
    // Formul�rio de busca foi enviado. Realizo uma consulta de busca com
    // os crit�rios dados
    $resultado = busca_livro ($_POST['titulo'], $_POST['autor'], 
			      $_POST['genero'], $_POST['ano']);
    // Algum resultado?
    if (mysql_num_rows ($resultado) > 0) {
	// Sim, escrevo sob a forma de tabela
	echo "<table class='tabelabusca'>\n";
	linha_tabela (array('T�tulo', 'Autor', 'G�nero', 'Ano'), true);
	// Titulo de cada livro � formatado sob a forma de um link com este padr�o
	$link = "<a href='index.php?acao=removerlivro&id=%d'>%s</a>";
	while ($livro = mysql_fetch_array ($resultado)) {
	    $livro_autores = new livro_autores;
	    $livro_autores->busca_idlivro($livro['id']);
	    $linha = array ();
	    $livro_autores->atribui_a_array ($linha);
	    linha_tabela (array (sprintf($link, $linha['id'], $linha['titulo']),
				 $linha['autor'],
				 $linha['genero'],
				 $linha['ano']));
	}
	echo "</table>\n";
    } else {
        // N�o, exibo mensagem de aviso
	msg_erro ("Nenhum livro satisfaz os crit�rios dados.");
    }
} 
else {
    // Exibo um formul�rio com crit�rios de busca.
    form_busca_livro ("index.php?acao=removerlivro", $_POST);
}

?>