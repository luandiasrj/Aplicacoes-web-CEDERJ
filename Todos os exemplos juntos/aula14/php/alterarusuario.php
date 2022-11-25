<h2>Alterar Usuário</h2>
<?php
//
// Módulo para buscar e alterar dados de usuários
//

// Incluo módulo com formulários de usuário
require_once ('formusuario.php');

// Crio uma instância da classe 'usuario'.
$usuario= new usuario;

// Vejo se usuário a ser alterado foi definido.
if (isset ($_GET['id'])) {
    // Obtenho o id
    $id = $_GET['id'];
    // Vejo se o formulário de alteração foi enviado
    if (isset ($_POST["enviar_usuario"])) {
	// Preencho a instancia com os dados do formulário.
	$usuario->atribui_de_array ($_POST);
	$usuario->id = $id;
	// Faço a crítica do formulário
	$erros = $usuario->erros();
	// Alguns testes adicionais
	$usuario2 = new usuario;
	$usuario2->busca ("id = $id");
	if ($usuario->login != '' && $usuario->login_existe() && 
	    $usuario2->login != $usuario->login) {
	    $erros ["login"] = "Este login já está sendo usado";
	}
	if ($_POST["senha2"] != $_POST["senha"]) {
	    $erros ["senha2"] = "Senhas não são idênticas";
	}
	// Atualizo banco de dados se não há erros
	if (!$erros) {
	    if ($usuario->atualiza()) {
		echo "<p>Dados de $usuario->nome foram atualizados </p><br>\n";
	    } else {
		msg_erro ("Erro ao atualizar usuário");
		msg_erro (mysql_error());
	    }
	    link_pagina_principal ();
	} else {
	    // Caso contrário, reapresento formulário com os erros indicados.
	    form_usuario ("index.php?acao=alterarusuario&id=$id", $usuario, true, $erros);
	}
    } 
    else {
	// Apresento o formulário de alteração de dados do usuário.
	$usuario->busca ("id=$id");
	form_usuario ("index.php?acao=alterarusuario&id=$id", $usuario, true);
    }
}
// Vejo se formulário já foi preenchido
elseif (isset ($_POST['enviar_busca_usuario'])) {
    // Faço uma busca baseada nos dados preenchidos
    $usuario->atribui_de_array ($_POST);
    $expressao = array ();
    if ($usuario->nome != '') $expressao [] = "nome like '%" . addslashes($usuario->nome). "%'";
    if ($usuario->login != '') $expressao [] = "login = '" . addslashes($usuario->login). "'";
    // obtenho o primeiro resultado
    $resultado = $usuario->busca (implode (" and ", $expressao));
    if (!$resultado) {
	echo "<h3> Nenhum usuário satisfaz os critérios. </h3>";
    } else {
	echo "<table class='tabelabusca'>\n";
	linha_tabela (array('Nome', 'Login', 'E-mail'), true);
	$link = "<a href='index.php?acao=alterarusuario&id=%d'>%s</a>";
	while ($resultado) {
	    linha_tabela (array (sprintf ($link,$usuario->id,$usuario->nome), 
			         $usuario->login, 
				 $usuario->email));
	    $resultado=$usuario->busca_proximo($resultado);
	}
	echo "</table>\n";
    }
} 
else {
    // Apresento o formulário de busca de usuários.
    form_busca_usuario ("index.php?acao=alterarusuario",$usuario);
}

?>

    
    
