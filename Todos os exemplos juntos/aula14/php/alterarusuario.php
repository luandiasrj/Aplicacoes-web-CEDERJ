<h2>Alterar Usu�rio</h2>
<?php
//
// M�dulo para buscar e alterar dados de usu�rios
//

// Incluo m�dulo com formul�rios de usu�rio
require_once ('formusuario.php');

// Crio uma inst�ncia da classe 'usuario'.
$usuario= new usuario;

// Vejo se usu�rio a ser alterado foi definido.
if (isset ($_GET['id'])) {
    // Obtenho o id
    $id = $_GET['id'];
    // Vejo se o formul�rio de altera��o foi enviado
    if (isset ($_POST["enviar_usuario"])) {
	// Preencho a instancia com os dados do formul�rio.
	$usuario->atribui_de_array ($_POST);
	$usuario->id = $id;
	// Fa�o a cr�tica do formul�rio
	$erros = $usuario->erros();
	// Alguns testes adicionais
	$usuario2 = new usuario;
	$usuario2->busca ("id = $id");
	if ($usuario->login != '' && $usuario->login_existe() && 
	    $usuario2->login != $usuario->login) {
	    $erros ["login"] = "Este login j� est� sendo usado";
	}
	if ($_POST["senha2"] != $_POST["senha"]) {
	    $erros ["senha2"] = "Senhas n�o s�o id�nticas";
	}
	// Atualizo banco de dados se n�o h� erros
	if (!$erros) {
	    if ($usuario->atualiza()) {
		echo "<p>Dados de $usuario->nome foram atualizados </p><br>\n";
	    } else {
		msg_erro ("Erro ao atualizar usu�rio");
		msg_erro (mysql_error());
	    }
	    link_pagina_principal ();
	} else {
	    // Caso contr�rio, reapresento formul�rio com os erros indicados.
	    form_usuario ("index.php?acao=alterarusuario&id=$id", $usuario, true, $erros);
	}
    } 
    else {
	// Apresento o formul�rio de altera��o de dados do usu�rio.
	$usuario->busca ("id=$id");
	form_usuario ("index.php?acao=alterarusuario&id=$id", $usuario, true);
    }
}
// Vejo se formul�rio j� foi preenchido
elseif (isset ($_POST['enviar_busca_usuario'])) {
    // Fa�o uma busca baseada nos dados preenchidos
    $usuario->atribui_de_array ($_POST);
    $expressao = array ();
    if ($usuario->nome != '') $expressao [] = "nome like '%" . addslashes($usuario->nome). "%'";
    if ($usuario->login != '') $expressao [] = "login = '" . addslashes($usuario->login). "'";
    // obtenho o primeiro resultado
    $resultado = $usuario->busca (implode (" and ", $expressao));
    if (!$resultado) {
	echo "<h3> Nenhum usu�rio satisfaz os crit�rios. </h3>";
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
    // Apresento o formul�rio de busca de usu�rios.
    form_busca_usuario ("index.php?acao=alterarusuario",$usuario);
}

?>

    
    
