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
    var $hora; 		// Hora em que foi feita a solicita��o
    
    // Registra a entrega deste livro ao usu�rio atrav�s da remo��o deste registro
    // da tabela 'solicitacao' e da inser��o de um registro correspondente
    // na tabela emprestimo.
    // Retorna false em caso de erro.
    function entrega () {
	// Computo a data de devolu��o baseada na data de hoje e 
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
    
    // Retorna o lugar na fila desta solicita��o. 0 significa que o livro est� dispon�vel
    // e pode ser entregue para o usu�rio. 
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
    
    // Exibe uma solicita��o. Primeiro obt�m do bd os dados do livro e do usuario.
    function exibe() {
	$livro = new livro_autores;
	$livro->busca_idlivro ($this->idlivro);
	$usuario = new usuario;
	$usuario->busca ("id = $this->idusuario");
	echo "<table class='exibe'>\n";
	echo "<tr><th rowspan=2>Usu�rio:<th>Nome<th>E-Mail</tr>\n";
	echo "<tr><td>$usuario->nome<td><a href='mailto:$usuario->email'>$usuario->email</a></tr>\n";
	echo "<tr><th rowspan=2>Livro:<th>T�tulo<th>Autores</tr>\n";
	echo "<tr><td>".$livro->livro->titulo."<td>".implode("<br>\n",$livro->autores())."</tr>\n";
	echo "<tr><th>Hora da solicita��o:<td colspan=2>";
	// echo strftime ("%e/%b/%Y, %T", strtotime($this->hora));
	echo date("d/m/Y, H:i:s", strtotime($this->hora));
	echo "</tr>\n";
	echo "<tr><th>Situa��o:<td colspan=2>";
	$lugar = $this->lugar_fila();
	echo ($lugar == 0) ? "Dispon�vel para entrega" : "Em $lugar lugar na fila";
	echo "</tr>\n";
	echo "</table>\n";
    }
}

// Realiza uma busca no banco de dados por uma ou mais solicita��es dados
// o nome/login de usu�rio e/ou t�tulo/autor de livro. 
// Retorna um array de objetos do tipo solicitacao que satisfazem os crit�rios.
// $nome = nome de usu�rio solicitante.
// $login= login de usu�rio solicitante.
// $titulo= titulo de livro solicitado.
// $autor = nome de autor de livro solicitado.
function busca_solicitacao ($nome='', $login='', $titulo='', $autor='') 
{
    // Vari�veis string s�o inicializados com consulta b�sica: 
    // Obter todas as solicita��es para as quais existe um livro dispon�vel.
    $select = "select sol.idlivro,sol.idusuario,sol.hora ";
    $from = "from solicitacao sol,livro ";
    $where = "where sol.idlivro = livro.id ".
	     "and livro.exemplares > ".
	     "    (select count(*) from emprestimo ".
	     "	   where emprestimo.idlivro = sol.idlivro) +".
	     "	  (select count(*) from solicitacao sol2 ".
	     "     where sol2.idlivro = sol.idlivro ".
	     "     and sol2.hora < sol.hora) ";
    // Crit�rios envolvendo usu�rio
    if ($nome != '' || $login !='') {
	// Incluo crit�rios para busca por usu�rio
	$from .= ",usuario ";
	$where .= "and sol.idusuario=usuario.id ";
	if ($nome != '') {
	    $where .= "and usuario.nome like '%$nome%' ";
	}
	if ($login != '') {
	    $where .= "and usuario.login='$login'";
	}
    }
    // Crit�rios envolvendo livro
    if ($titulo !='' || $autor !='') {
	// incluo crit�rios para busca por livro
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
    // Fa�o a consulta ordenando os resultados pela hora da solicita��o
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