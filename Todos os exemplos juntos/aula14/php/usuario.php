<?php

require_once ("tabelabd.php");

// Classe que representa uma linha da tabela usuario
class usuario extends tabela_bd_com_id
{
    // Vari�veis
    var $id; 	// Id do usu�rio no bd
    var $nome = ''; 	// Nome do usu�rio
    var $login = '';	// Login do usu�rio
    var $senha = '';	// Senha do usu�rio
    var $email = '';	// Email do usu�rio
    var $endereco = '';	// Endere�o do usu�rio
    var $cidade = ''; 	// Cidade do usu�rio
    var $estado = '';	// Estado do usu�rio
    var $telefone = ''; // Telefone do usu�rio
    var $privilegio = 'I'; // C�digo de privil�gio: 
    // 'I': inscrito mas nao autorizado, 'M': membro
    // 'A': administrador
    
    // Encripta o campo senha
    function encripta_senha () {
	// Computar o sal para o crypt 
	$sal = substr($this->login, 0, 2);
	// Atualiza senha com senha encriptada
	$this->senha = crypt($this->senha, $sal);
    }
    
    // Atualiza o banco de dados com os dados deste usu�rio.
    // Pr�-condi��o: j� existe uma linha na tabela com este id.
    // Retorna verdadeiro se atualiza��o bem-sucedida.
    // $encripta diz se senha deve ser encriptada antes da atualiza��o.
    function atualiza ($encripta=true) {
	if ($encripta) $this->encripta_senha();
	return parent::atualiza("id=$this->id");
    }
    
    // Inclui o usu�rio no banco de dados.
    // Pr�-condi��o: usu�rio com esse login n�o deve existir na tabela.
    // Retorna verdadeiro se inclus�o bem-sucedida.
    // Efeito colateral: vari�vel id tem o id da nova linha inserida na tabela.
    function inclui () {
	global $conexao;
	$this->encripta_senha();
	$resultado = parent::inclui();
	if (!$resultado) return false;
	// $this->id = mysql_insert_id();
	$this->id = mysqli_insert_id($conexao);
	return $resultado; 
    }
      
    // Exibe usu�rio, chamado por autorizarusuario.php
    function exibe () {
	$this->busca ("privilegio = 'I'");
	echo "<table class='exibe'>\n";
	echo "<tr><th rowspan=2>Usu�rio:<th>Nome<th>Login</tr>\n";
	echo "<tr><td>$this->nome<td>$this->login</tr>\n";
	echo "</tr>\n";
	echo "</table>\n";

    }
    
    // Faz uma busca por login para ver se existe.
    // Retorna true em caso positivo.
    function login_existe () {
	$tmp = new usuario;
	return ($tmp->busca ("login = '$this->login'"));
    }
    
    // Testa os valores das vari�veis procurando por erros. 
    // Caso haja erros, retorna um array cujas chaves s�o os nomes
    // dos campos incorretos e cujos valores s�o mensagens de erro.
    // Caso contr�rio, retorna false.
    function erros () {
	$erros = array (); // C�digo original que n�o � utilizado
	$erro = array (); 

	if ($this->nome == '') {
	    $erro['nome'] = 'Nome � obrigat�rio';
	} elseif (count(explode(" ",$this->nome)) < 2) {
	    $erro['nome'] = 'Nome deve ter ao menos prenome e sobrenome';
	}
	if ($this->login == '') {
	    $erro['login'] = 'Login � obrigat�rio';
	// } elseif (!ereg('^[A-Za-z]+[0-9A-Za-z]*$', $this->login)) {
	} elseif (!preg_match('/^[A-Za-z]+[0-9A-Za-z]*$/', $this->login)) {
	    $erro['login'] = 'Login tem que ser alfanum�rico e come�ar com letra';
	}
	if ($this->senha == '') {
	    $erro['senha'] = 'Senha � obrigat�ria';
	// } elseif (!ereg('^[0-9A-Za-z]+$', $this->senha)) {
	} elseif (!preg_match('/^[0-9A-Za-z]+$/', $this->senha)) {
	    $erro['senha'] = 'Senha tem que ser alfanum�rica';
	}
	if ($this->email == '' ) { 
	    $erro['email'] = 'E-mail � obrigat�rio';
	// } elseif (!ereg('^[0-9A-Za-z\\.\\-]+@([0-9A-Za-z]+\\.)*[0-9A-Za-z]+$', $this->email)) {
	} elseif (!preg_match('/^[0-9A-Za-z\\.\\-]+@([0-9A-Za-z]+\\.)*[0-9A-Za-z]+$/', $this->email)) {
	    $erro['email'] = 'E-mail inv�lido';
	}
	if ($this->endereco == '') { 
	    $erro['endereco'] = 'Endere�o � obrigat�rio';
	}
	if ($this->cidade == '') { 
	    $erro['cidade'] = 'Cidade � obrigat�ria';
	}
	if ($this->estado == '') { 
	    $erro['estado'] = 'Estado � obrigat�rio';
	}
	// if ($this->telefone != '' && !ereg('[0-9\\.\\-]+', $this->telefone)) { 
	if ($this->telefone != '' && !preg_match('/[0-9\\.\\-]+/', $this->telefone)) {
	    $erro['telefone'] = 'Telefone deve conter apenas algarismos e tra�os';
	}
	
	if (count ($erro) > 0) return $erro;
	return false;
    }
}


?>
