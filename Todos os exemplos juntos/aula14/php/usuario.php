<?php

require_once ("tabelabd.php");

// Classe que representa uma linha da tabela usuario
class usuario extends tabela_bd_com_id
{
    // Variáveis
    var $id; 	// Id do usuário no bd
    var $nome = ''; 	// Nome do usuário
    var $login = '';	// Login do usuário
    var $senha = '';	// Senha do usuário
    var $email = '';	// Email do usuário
    var $endereco = '';	// Endereço do usuário
    var $cidade = ''; 	// Cidade do usuário
    var $estado = '';	// Estado do usuário
    var $telefone = ''; // Telefone do usuário
    var $privilegio = 'I'; // Código de privilégio: 
    // 'I': inscrito mas nao autorizado, 'M': membro
    // 'A': administrador
    
    // Encripta o campo senha
    function encripta_senha () {
	// Computar o sal para o crypt 
	$sal = substr($this->login, 0, 2);
	// Atualiza senha com senha encriptada
	$this->senha = crypt($this->senha, $sal);
    }
    
    // Atualiza o banco de dados com os dados deste usuário.
    // Pré-condição: já existe uma linha na tabela com este id.
    // Retorna verdadeiro se atualização bem-sucedida.
    // $encripta diz se senha deve ser encriptada antes da atualização.
    function atualiza ($encripta=true) {
	if ($encripta) $this->encripta_senha();
	return parent::atualiza("id=$this->id");
    }
    
    // Inclui o usuário no banco de dados.
    // Pré-condição: usuário com esse login não deve existir na tabela.
    // Retorna verdadeiro se inclusão bem-sucedida.
    // Efeito colateral: variável id tem o id da nova linha inserida na tabela.
    function inclui () {
	global $conexao;
	$this->encripta_senha();
	$resultado = parent::inclui();
	if (!$resultado) return false;
	// $this->id = mysql_insert_id();
	$this->id = mysqli_insert_id($conexao);
	return $resultado; 
    }
      
    // Exibe usuário, chamado por autorizarusuario.php
    function exibe () {
	$this->busca ("privilegio = 'I'");
	echo "<table class='exibe'>\n";
	echo "<tr><th rowspan=2>Usuário:<th>Nome<th>Login</tr>\n";
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
    
    // Testa os valores das variáveis procurando por erros. 
    // Caso haja erros, retorna um array cujas chaves são os nomes
    // dos campos incorretos e cujos valores são mensagens de erro.
    // Caso contrário, retorna false.
    function erros () {
	$erros = array (); // Código original que não é utilizado
	$erro = array (); 

	if ($this->nome == '') {
	    $erro['nome'] = 'Nome é obrigatório';
	} elseif (count(explode(" ",$this->nome)) < 2) {
	    $erro['nome'] = 'Nome deve ter ao menos prenome e sobrenome';
	}
	if ($this->login == '') {
	    $erro['login'] = 'Login é obrigatório';
	// } elseif (!ereg('^[A-Za-z]+[0-9A-Za-z]*$', $this->login)) {
	} elseif (!preg_match('/^[A-Za-z]+[0-9A-Za-z]*$/', $this->login)) {
	    $erro['login'] = 'Login tem que ser alfanumérico e começar com letra';
	}
	if ($this->senha == '') {
	    $erro['senha'] = 'Senha é obrigatória';
	// } elseif (!ereg('^[0-9A-Za-z]+$', $this->senha)) {
	} elseif (!preg_match('/^[0-9A-Za-z]+$/', $this->senha)) {
	    $erro['senha'] = 'Senha tem que ser alfanumérica';
	}
	if ($this->email == '' ) { 
	    $erro['email'] = 'E-mail é obrigatório';
	// } elseif (!ereg('^[0-9A-Za-z\\.\\-]+@([0-9A-Za-z]+\\.)*[0-9A-Za-z]+$', $this->email)) {
	} elseif (!preg_match('/^[0-9A-Za-z\\.\\-]+@([0-9A-Za-z]+\\.)*[0-9A-Za-z]+$/', $this->email)) {
	    $erro['email'] = 'E-mail inválido';
	}
	if ($this->endereco == '') { 
	    $erro['endereco'] = 'Endereço é obrigatório';
	}
	if ($this->cidade == '') { 
	    $erro['cidade'] = 'Cidade é obrigatória';
	}
	if ($this->estado == '') { 
	    $erro['estado'] = 'Estado é obrigatório';
	}
	// if ($this->telefone != '' && !ereg('[0-9\\.\\-]+', $this->telefone)) { 
	if ($this->telefone != '' && !preg_match('/[0-9\\.\\-]+/', $this->telefone)) {
	    $erro['telefone'] = 'Telefone deve conter apenas algarismos e traços';
	}
	
	if (count ($erro) > 0) return $erro;
	return false;
    }
}


?>
