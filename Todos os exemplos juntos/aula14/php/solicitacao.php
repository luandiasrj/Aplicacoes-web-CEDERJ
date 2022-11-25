<?php
//
// Define classes e funcoes para gerenciar solicitacoes 
//


require_once ('tabelabd.php');

// Representa uma linha da tabela solicitacao
class solicitacao extends tabela_bd 
{
    // variaveis
    var $idlivro; 	// Id de um livro
    var $idusuario; 	// Id de um usuario
    var $hora; 		// Hora em que foi feita a solicitação
    
    // Registra a entrega deste livro ao usuário através da remoção deste registro
    // da tabela 'solicitacao' e da inserção de um registro correspondente
    // na tabela emprestimo.
    // Retorna false em caso de erro.
    function entrega () {
	// Computo a data de devolução baseada na data de hoje e 
	// na constante DIAS_POR_EMPRESTIMO
	$devolucao = date ("Y-m-d", time()+DIAS_POR_EMPRESTIMO*24*60*60);
	// removo e insiro
	// $resultado = mysql_query ("delete from solicitacao ".
	global $conexao;
	$resultado = mysqli_query($conexao, "delete from solicitacao ".
		  	          "where idlivro=$this->idlivro ".
			          "and idusuario=$this->idusuario " .
				  "and hora='$this->hora'");
	if (!$resultado) return false;
	// return mysql_query ("insert into emprestimo ".
	return mysqli_query($conexao, "insert into emprestimo ".
		         "values($this->idlivro, $this->idusuario, '$devolucao')");
    }
    
    // Retorna o lugar na fila desta solicitação. 0 significa que o livro está disponível
    // e pode ser entregue para o usuário. 
    function lugar_fila () {
	$consulta = "select (select count(*) from solicitacao ".
		    "        where idlivro = $this->idlivro ".
		    "        and hora < '$this->hora') " .
		    "     + (select count(*) from emprestimo ". 
		    "	     where idlivro = $this->idlivro) ".
		    "	  - (select exemplares from livro " .
		    "        where id = $this->idlivro)";
 	// $resultado = mysql_query ($consulta);
	global $conexao;
	$resultado = mysqli_query ($conexao, $consulta);
	// $array = mysql_fetch_row($resultado);
	$array = mysqli_fetch_row($resultado);
	$lugar = $array [0]+1;
	if ($lugar<0) $lugar = 0;
	return $lugar;
    }
    
    // Exibe uma solicitação. Primeiro obtém do bd os dados do livro e do usuario.
    function exibe() {
	$livro = new livro_autores;
	$livro->busca_idlivro ($this->idlivro);
	$usuario = new usuario;
	$usuario->busca ("id = $this->idusuario");
	echo "<table class='exibe'>\n";
	echo "<tr><th rowspan=2>Usuário:<th>Nome<th>E-Mail</tr>\n";
	echo "<tr><td>$usuario->nome<td><a href='mailto:$usuario->email'>$usuario->email</a></tr>\n";
	echo "<tr><th rowspan=2>Livro:<th>Título<th>Autores</tr>\n";
	echo "<tr><td>".$livro->livro->titulo."<td>".implode("<br>\n",$livro->autores())."</tr>\n";
	echo "<tr><th>Hora da solicitação:<td colspan=2>";
	// echo strftime ("%e/%b/%Y, %T", strtotime($this->hora));
	echo date("d/m/Y, H:i:s", strtotime($this->hora));
	echo "</tr>\n";
	echo "<tr><th>Situação:<td colspan=2>";
	$lugar = $this->lugar_fila();
	echo ($lugar == 0) ? "Disponível para entrega" : "Em $lugar lugar na fila";
	echo "</tr>\n";
	echo "</table>\n";
    }
}

// Realiza uma busca no banco de dados por uma ou mais solicitações dados
// o nome/login de usuário e/ou título/autor de livro. 
// Retorna um array de objetos do tipo solicitacao que satisfazem os critérios.
// $nome = nome de usuário solicitante.
// $login= login de usuário solicitante.
// $titulo= titulo de livro solicitado.
// $autor = nome de autor de livro solicitado.
function busca_solicitacao ($nome='', $login='', $titulo='', $autor='') 
{
    // Variáveis string são inicializados com consulta básica: 
    // Obter todas as solicitações para as quais existe um livro disponível.
    $select = "select sol.idlivro,sol.idusuario,sol.hora ";
    $from = "from solicitacao sol,livro ";
    $where = "where sol.idlivro = livro.id ".
	     "and livro.exemplares > ".
	     "    (select count(*) from emprestimo ".
	     "	   where emprestimo.idlivro = sol.idlivro) +".
	     "	  (select count(*) from solicitacao sol2 ".
	     "     where sol2.idlivro = sol.idlivro ".
	     "     and sol2.hora < sol.hora) ";
    // Critérios envolvendo usuário
    if ($nome != '' || $login !='') {
	// Incluo critérios para busca por usuário
	$from .= ",usuario ";
	$where .= "and sol.idusuario=usuario.id ";
	if ($nome != '') {
	    $where .= "and usuario.nome like '%$nome%' ";
	}
	if ($login != '') {
	    $where .= "and usuario.login='$login'";
	}
    }
    // Critérios envolvendo livro
    if ($titulo !='' || $autor !='') {
	// incluo critérios para busca por livro
	if ($titulo !='') {
	    $where .= "and titulo like '%$titulo%' ";
	}
	if ($autor !='') {
	    $from .= ",escreveu,autor ";
	    $where .= "and autor.id = escreveu.idautor ".
		      "and livro.id = escreveu.idlivro ".
		      "and autor.nome like '%$autor%' ";
	}
    } 
    // Faço a consulta ordenando os resultados pela hora da solicitação
    // $resultado = mysql_query ($select.$from.$where." order by hora");
	global $conexao;
	$resultado = mysqli_query ($conexao, $select.$from.$where." order by hora");
    $solicitacoes = array();
    // while ($array = mysql_fetch_array ($resultado)) {
	while ($array = mysqli_fetch_array ($resultado)) {
	$solicitacao = new solicitacao;
	$solicitacao->atribui_de_array($array);
	$solicitacoes[] = $solicitacao;
    }
    return $solicitacoes;
}

?>