<?php
//
// Define classes e fun��es para gerenciar empr�stimos. 
//

// Representa uma linha da tabela emprestimo.
class emprestimo extends tabela_bd 
{
    // variaveis
    var $idlivro; 	// Id de um livro
    var $idusuario; 	// Id de um usuario
    var $datadevolucao; // Data em que o livro tem que ser devolvido
    
    // Calcula a multa pela devolu��o deste empr�stimo caso 
    // seja feita hoje. Devolve 0 caso n�o haja multa.
    function multa () {
	$resultado = mysql_query ("select datediff(curdate(),date('$this->datadevolucao'))");
	$array = mysql_fetch_row($resultado);
	$dias = $array[0];
	if ($dias > 0) return $dias*MULTA_POR_DIA;
	return 0;
    }
    
    // Realiza a opera��o de devolu��o deste empr�stimo atrav�s da 
    // remo��o deste registro da tabela 'emprestimo'. 
    // Retorna false caso haja erro ou o resultado da consulta.
    function devolve() {
	return mysql_query ("delete from emprestimo ".
		 	    "where idlivro=$this->idlivro ".
			    "and idusuario=$this->idusuario");
    }
    
    
    // Exibe uma solicita��o. Primeiro obt�m do bd os dados do livro e do usuario.
    function exibe() {
	$multa = $this->multa();
	$livro = new livro_autores;
	$livro->busca_idlivro ($this->idlivro);
	$usuario = new usuario;
	$usuario->busca ("id = $this->idusuario");
	echo "<table class='exibe'>\n";
	echo "<tr><th rowspan=2>Usu�rio:<th>Nome<th>Login</tr>\n";
	echo "<tr><td>$usuario->nome<td>$usuario->login</tr>\n";
	echo "<tr><th rowspan=2>Livro:<th>T�tulo<th>Autores</tr>\n";
	echo "<tr><td>".$livro->livro->titulo."<td>".implode("<br>/n",$livro->autores())."</tr>\n";
	echo "<tr><th>Data de devolu��o:<td colspan=2>";
	echo strftime ("%e/%m/%Y", strtotime($this->datadevolucao));
	echo "</tr>\n";
	if ($multa>0) {
	    echo "<tr><th style='color: rgb(255, 0, 0)'>Multa por atraso:<td colspan=2>".
		 "R$ " .number_format($multa, 2, ',', '.'). "</tr>\n";
	}
	echo "</table>\n";
    }
}

// Realiza uma busca no banco de dados por empr�stimos dados nome/login de 
// usu�rio e/ou t�tulo/autor de livro. 
// Retorna um array de objetos do tipo 'emprestimo' que satisfazem os crit�rios.
// $nome = nome de usu�rio solicitante.
// $login= login de usu�rio solicitante.
// $titulo= titulo de livro solicitado.
// $autor = nome de autor de livro solicitado.
function busca_emprestimo ($nome='', $login='', $titulo='', $autor='') 
{
    // Vari�veis string s�o inicializados com consulta b�sica: 
    // Obter todas as solicita��es para as quais existe um livro dispon�vel.
    $select = "select emp.idlivro,emp.idusuario,emp.datadevolucao ";
    $from = "from emprestimo emp ";
    $where = "where 1 ";
    // Crit�rios envolvendo usu�rio
    if ($nome != '' || $login !='') {
	// Incluo crit�rios para busca por usu�rio
	$from .= ",usuario ";
	$where .= "and emp.idusuario=usuario.id ";
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
	$from .= ",livro ";
	$where .= "and emp.idlivro=livro.id ";
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
    // Fa�o a consulta ordenando os resultados pela data de devolu��o
    $resultado = mysql_query ($select.$from.$where." order by datadevolucao");
    $emprestimos = array();
    while ($array = mysql_fetch_array ($resultado)) {
	$emprestimo = new emprestimo;
	$emprestimo->atribui_de_array($array);
	$emprestimos[] = $emprestimo;
    }
    return $emprestimos;
}

?>