<?php
//
// Define funções e classes para representar livros e autores
//

use autor as GlobalAutor;

require_once ("tabelabd.php");

// Classe que representa uma linha da tabela livro
class livro extends tabela_bd_com_id
{
    // Variáveis
    var $id; 		// Id do livro no bd
    var $titulo = ''; 	// Título do livro
    var $exemplares = 0;// Número de exemplares do livro
    var $genero = '';	// Gênero do livro
    var $ano = 0;	// Ano de publicação
    
    // Retorna o número de exemplares solicitados deste livro
    function exemplares_solicitados () {
	$consulta = "select count(*) from solicitacao where idlivro = $this->id";
	// $resultado = mysql_query ($consulta);
	global $conexao;
	$resultado = mysqli_query ($conexao, $consulta);
	// $linha = mysql_fetch_row($resultado);
	$linha = mysqli_fetch_row($resultado);
	return $linha[0];
    }

    // Retorna o número de exemplares emprestados deste livro
    function exemplares_emprestados () {
	$consulta = "select count(*) from emprestimo where idlivro = $this->id";
	// $resultado = mysql_query ($consulta);
	global $conexao;
	$resultado = mysqli_query ($conexao, $consulta);
	// $linha = mysql_fetch_row($resultado);
	$linha = mysqli_fetch_row($resultado);
	return $linha[0];
    }
    
    // Retorna um booleano que diz se algum exemplar deste livro está disponível
    function exemplares_disponiveis () {
	return $this->exemplares
	       - $this->exemplares_solicitados()
	       - $this->exemplares_emprestados();
    }
}

// Classe que representa um autor de livro
class autor extends tabela_bd_com_id
{
    // Variáveis
    var $id; 		// Id do autor no bd
    var $nome = ''; 	// Nome do autor
}

// Classe que representa um relacionamento do tipo autor escreveu livro
class escreveu extends tabela_bd
{
    // Variáveis
    var $idlivro; 	// Id de um livro no bd
    var $idautor; 	// Id de um autor no bd
}

// Classe que representa um livro e seu(s) autor(es)
class livro_autores 
{
    // Variáveis
    var $livro;		// Objeto da classe livro
    var $autores;	// Array de objetos da classe autor
    
    // Construtor
    function livro_autores () {
	$this->livro = new livro;
	$this->autores = array();
    }
    
    // Preenche livro e autores com o livro dado por $idlivro
    function busca_idlivro ($idlivro) {

		
	$this->livro = new livro;
	$this->livro->busca ("id = $idlivro");
	if (!$this->livro->busca ("id = $idlivro")) return false;
	$consulta = "select idautor, nome ".
		    "from autor, escreveu ".
		    "where idlivro=$idlivro and autor.id=idautor";
	// $resultado = mysql_query ($consulta);
	global $conexao;
	$resultado = mysqli_query ($conexao, $consulta);
	$this->autores = array();
	// while ($array = mysql_fetch_array ($resultado)) {
	while ($array = mysqli_fetch_array ($resultado)) {

	    $autor = new autor;
	    // $autor->id = $array['idlivro'];
		$autor->id = $array['idautor']; // retorna a chave certa do array
	    $autor->nome = $array['nome'];
	    $this->autores [] = $autor;
	}
	return true;
    } 
    
    // Retorna um array com os nomes dos autores deste livro
    function autores () {
	$array_autor = array();
	// se autores for um array, então percorre o array
	if (is_array ($this->autores)) {
	foreach ($this->autores as $autor) {
	    $array_autor[] = $autor->nome;
	}
}
	return $array_autor;
    }
    
    // Atualiza o registro nas tabelas livro escreveu e autores
    function atualiza () {
	assert ($this->livro->id > 0);
	// Atualizo registro na tabela livro
	$this->livro->atualiza ("id = ".$this->livro->id);
	// Removo registros em escreveu que referem-se a este livro
	// $resultado = mysql_query ("delete from escreveu where idlivro = ".$this->livro->id);
	global $conexao;
	$resultado = mysqli_query ($conexao, "delete from escreveu where idlivro = ".$this->livro->id);
	assert ($resultado !== false);
	// Processo todos os autores
	foreach ($this->autores as $autor) {
	    // Vejo se autor já está no banco
	    // $resultado = $autor->busca("nome=".addslashes($this->nome));
		$resultado = $autor->busca("nome='".$autor->nome."'");
	    // if (@mysql_num_rows ($resultado) == 0) {
		if ($resultado == false) {
		// Não, incluo novo registro
		unset ($autor->id);
		$autor->inclui();
	    }
	    // Incluo um registro em escreveu 
	    $escreveu = new escreveu;
	    $escreveu->idlivro = $this->livro->id;
	    $escreveu->idautor = $autor->id;
	    $escreveu->inclui();
	}
	return true;
    }

    // Incluo um novo registro nas tabelas livro, escreveu e autores
    function inclui () {
	// Inclui registro na tabela livro
	$this->livro->id = 0;
	if (!$this->livro->inclui()) return false;
	// Processo todos os autores
	foreach ($this->autores as $autor) {
	    // Vejo se autor já está no banco
	    $resultado = $autor->busca("nome='".addslashes($autor->nome)."'");
	    // if (mysql_num_rows ($resultado) == 0) {
		if ($resultado == false) {
		// Não, incluo novo registro
		unset ($autor->id);
		$autor->inclui();
	    }
	    // Incluo um registro em escreveu 
	    $escreveu = new escreveu;
	    $escreveu->idlivro = $this->livro->id;
	    $escreveu->idautor = $autor->id;
	    $escreveu->inclui();
	}
	return true;
    }
    
    // Removo o registro deste livro.
    function remove () {
	assert ($this->livro->id > 0);
	// Removo registro da tabela livro
	$resultado = $this->livro->remove();
	if (!$resultado) return false;
	// Removo registros em escreveu que referem-se a este livro
	// return mysql_query ("delete from escreveu where idlivro = ".$this->livro->id);
    global $conexao;
	return mysqli_query ($conexao, "delete from escreveu where idlivro = ".$this->livro->id);
	
}
    
    // Gera um array com os valores das variáveis
    function atribui_a_array (&$array) {
		
		// Armazeno os campos do livro
	    $this->livro->atribui_a_array ($array);
		
	// Os nomes dos autores são armazenados sob a forma de um array
	$array['autor'] = $this->autores();
    }

    // Preenche com valores de um array
    function atribui_de_array ($array) {
	// Armazeno os campos do livro
	$this->livro = new livro; // Foi preciso cria um novo objeto livro para que o atribui_de_array funcionasse no PHP 8
	$this->livro->atribui_de_array ($array);
	// Crio um objeto autor para cada nome armazenado em $array['autor']
	$this->autores = array();
	if (isset ($array['autor'][0])) {
	    foreach ($array['autor'] as $nome) {
		$autor = new autor;
		$autor->nome = $nome;
		$this->autores [] = $autor;
	    }
	}
    }

    // Exibe o livro e seus autores como uma tabela html.
    function exibe () {
	echo "<table class='exibe'>\n";
	$padrao = "<tr><th>%s<td>%s</tr>\n";
	printf ($padrao,"Título:",$this->livro->titulo);
	printf ($padrao,"Autor(es):",implode ("<br>",$this->autores()));
	printf ($padrao,"Gênero:", $this->livro->genero);
	printf ($padrao,"Ano:", $this->livro->ano);
	printf ($padrao,"Exemplares:", $this->livro->exemplares);
	echo "</table>\n";
    }
    
    // Testa os valores das variáveis procurando por erros. 
    // Caso haja erros, retorna um array cujas chaves são os nomes
    // dos campos incorretos e cujos valores são mensagens de erro.
    // Caso contrário, retorna false.
    function erros () {
	$erros = array (); // varável não usada
	$erro = array();
	if ($this->livro->titulo == '') {
	    $erro['titulo'] = 'Título é obrigatório';
	} 
	if (count($this->autores) == 0) {
	    $erro['autor'] = 'Ao menos um autor é obrigatório';
	} else {
	    foreach ($this->autores() as $nome) {
		if ($nome == '') {
		    $erro['autor'] = 'Autor não pode ter nome vazio';
		}
	    }
	}
	if ($this->livro->genero == '') {
	    $erro['genero'] = 'Escolha o gênero do livro';
	} 
	// if (!ereg('[0-9]+', $this->livro->ano)) { 
	if (!preg_match('/[0-9]+/', $this->livro->ano)) {
	    $erro['ano'] = 'Ano tem que ser numérico';
	} 
	if (count ($erro) > 0) return $erro;
	return false;
    }
}

// Realiza uma busca no banco de dados por um livro dado título, autor, genero e/ou ano
// retorna um recurso sql da busca
function busca_livro ($titulo='', $autor='', $genero='', $ano='') 
{
    $consulta = "select livro.id from livro";
    if ($autor !='') {
	// Busca por autor requer junção com escreveu e autor
	$consulta .= ",escreveu,autor" .
		     " where idlivro=livro.id and autor.id=idautor" .
		     " and nome like '%" . $autor. "%'";
    } else {
	// Cláusula where universal que possivelmente será restrita por
	// cláusulas através do operador 'and'
	$consulta .= " where 1=1";
    }
    if ($titulo !='') $consulta .= " and titulo like '%" . $titulo. "%'";
    if ($genero !='') $consulta .= " and genero = '$genero'";
    if ($ano !='') $consulta .= " and ano = $ano";
    // return mysql_query ($consulta);
	global $conexao;
	return mysqli_query($conexao, $consulta);
}
?>