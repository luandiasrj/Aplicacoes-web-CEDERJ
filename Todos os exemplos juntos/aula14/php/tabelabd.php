<?php

// tabela_bd encapsula a correspond�ncia entre linhas de 
// uma rela��o e inst�ncias de uma classe PHP.
class tabela_bd
{
    // Retorna uma string no formato var1=valor1, var2=valor2, ... varN=valorN
    // para todas as vari�veis da classe corrente. � usada para construir
    // consultas do tipo insert e update
    function string_atribuicoes () {
	$atribuicao = array();
	$variaveis = get_object_vars($this);
	// Itero sobre todas as vari�veis de classe
	// while ($variavel = each($variaveis)) {
	foreach ($variaveis as $variavel => $valor) {
	    // $nome = $variavel["key"];
		$nome = $variavel;
	    if (isset ($this->$nome)) {
		$atribuicao [] = $nome . "= '". addslashes($this->$nome) . "'";
	    }
	}
	// Retorno atribui��es separadas por v�rgula
	return implode(",", $atribuicao);
    }
    
    // Gera uma consulta do tipo update para todas as variaveis da classe
    function string_consulta_atualiza () {
	return "update ". get_class($this) . 
	       " set " . $this->string_atribuicoes ();
    }
    
    // Atualiza tabela usando uma clausula where
    function atualiza ($where) {
	$consulta = $this->string_consulta_atualiza ().
		    " where $where";
	// return mysql_query($consulta);
	global $conexao;
	return mysqli_query($conexao, $consulta);
    }

    // Gera uma consulta do tipo insert para todas as variaveis da classe
    function string_consulta_inclui () {
	return "insert into ". get_class($this) . 
	       " set " . $this->string_atribuicoes ();
    }
    
    // Inclui um novo registro contendo todas as variaveis da classe
    // Retorna o resultado da consulta mysql
    function inclui () {
	$consulta = $this->string_consulta_inclui ();
	// return mysql_query($consulta);
	global $conexao;
	return mysqli_query($conexao, $consulta);
    }
    
    
    // Atualiza vari�veis da classe a partir de um array (tipicamente obtido com
    // mysql_fetch_array).
    // $array = array com chaves iguais aos das nomes das vari�veis da classe.
    // Efeito colateral: todas as vari�veis cujos nomes aparecem como chaves no
    // array s�o alteradas com os valores respectivos.
    function atribui_de_array ($array) {
	$variaveis = get_object_vars($this);
	// Itero sobre todas as vari�veis do objeto
	// while ($variavel = each($variaveis)) {
	foreach ($variaveis as $nome => $valor) {
	    // $nome = $variavel["key"];
		$nome = $nome;
	    if (isset ($array[$nome])) {
		$this->$nome = $array[$nome];
	    }
	}
    }
    
    // Atribui as vari�veis da classe a um array. Usado tipicamente para 
    // copiar os elementos a campos de um array como $_POST ou $_SESSION.
    // $array = refer�ncia a um array pre-existente.
    function atribui_a_array (&$array) {
	$variaveis = get_object_vars($this);
	// Itero sobre todas as vari�veis do objeto
	// while ($variavel = each($variaveis)) {
	foreach ($variaveis as $nome => $valor) {
	    // $nome = $variavel["key"];
		$nome = $nome;
	    //$array[$nome] = $variavel["value"];
		$array[$nome] = $valor;
	}
    }
    
    // Carrega inst�ncia a partir de uma consulta ao banco de dados. 
    // Retorna o resultado da consulta se bem-sucedido ou false caso contr�rio.
    // $expressao = string contendo uma express�o para cl�usula 'where' do sql.
    // $ordem = string com o nome do atributo para ordernar a consulta; se vazio, 
    //          busca � feita sem ordem.
    function busca ($expressao = '', $ordem='') {
	// Preparo a consulta
	$consulta = "select * from ". get_class($this);
	if ($expressao != '') $consulta .= " where " . $expressao;
	if ($ordem != '') $consulta .= " order by " . $ordem;
	// Obtenho uma linha do resultado caso exista
	// $resultado = mysql_query ($consulta);
	global $conexao;
	$resultado = mysqli_query ($conexao, $consulta);
	if (!$resultado) return false;
	// $linha = mysql_fetch_array($resultado);
	$linha = mysqli_fetch_array($resultado);
	if (!$linha) return false;
	// Preencho as vari�veis da inst�ncia
	$this->atribui_de_array ($linha);
	return $resultado;
    }
    
 	// Carrega inst�ncia a partir de uma consulta feita anteriormente ao banco de dados, 
    // Retorna o resultado da consulta se bem-sucedido ou false caso contr�rio.
    // $resultado = resultado de uma consulta mysql_query anterior.
    function busca_proximo (&$resultado) {
	// Carrego mais uma linha
	// $linha = mysql_fetch_array($resultado);
	$linha = mysqli_fetch_array($resultado);
	if (!$linha) return false;
	// Preencho as vari�veis da inst�ncia
	$this->atribui_de_array ($linha);
	return $resultado;
    }
    
    // Remove linhas que satisfa�am o crit�rio dado.
    // $expressao = expressao sql que identifica as linhas a serem removidas.
    function remove ($expressao) {
	$consulta = "delete from ". get_class($this) . " where $expressao";
	// return mysql_query ($consulta);
	global $conexao;
	return mysqli_query ($conexao, $consulta);
    }
}

//
// Classe derivada de tabela_bd, com a particularidade de que garantidamente possui
// um campo auto_increment chamado 'id'. 
//
class tabela_bd_com_id extends tabela_bd 
{
    // Inclui um novo registro no banco. 
    // Retorna o resultado da consulta e atualiza o campo id
    function inclui () {
	$resultado = parent::inclui ();
	if (!$resultado) return false;
	// $this->id = mysql_insert_id();
	global $conexao;
	$this->id = mysqli_insert_id($conexao);
	return $resultado; 
    }
    
    // Remove registro corrente baseado no id
    function remove ($expressao='') {
	return parent::remove ("id = $this->id");
    }
}
?>