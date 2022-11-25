<h2>Edi��o de Livros</h2>
<?php
//
// M�dulo para buscar e editar livros.
//

// Apenas administradores podem acessar
assegura_privilegio ('A');

require_once ("formlivro.php");

if (isset ($_POST["enviar_busca_livro"])) {
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
	$link = "<a href='index.php?acao=cadastrarlivro&id=%d'>%s</a>";
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
	echo "<p>Nenhum livro satisfaz os crit�rios dados </p>";
    }
} 
else {
    // Exibo um formul�rio com crit�rios de busca.
    form_busca_livro ("index.php?acao=editarlivro", $_POST);
}

?>