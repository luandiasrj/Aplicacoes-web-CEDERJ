<h2>Altera��o de Dados Pessoais</h2>
<?php

// Apenas membros logados podem alterar dados pessoais.
assegura_privilegio ('M');

// M�dulo com formul�rio de dados pessoais.
require_once ('formusuario.php');

// Crio uma nova instancia da classe usuario e preencho com os dados
// do usu�rio corrente.
$usuario = new usuario;
$usuario->busca ("login = '" . $_SESSION["login"] ."'");

// Vejo se o formul�rio foi enviado
if (isset ($_POST["enviar_usuario"])) {
    // Preencho a instancia com os dados do formul�rio.
    $usuario->atribui_de_array ($_POST);
    // Fa�o a cr�tica do formul�rio
    $erros = $usuario->erros();
    if(!is_array($erros)) $erros = array(); // Evita erro no PHP 8.1 na convers�o de n�o array para array
    // Alguns testes adicionais
    if ($usuario->login != '' && $usuario->login_existe() && 
	$_SESSION["login"] != $usuario->login) {
	$erros ["login"] = "Este login j� est� sendo usado";
    }
    if ($_POST["senha2"] != $_POST["senha"]) {
    	$erros ["senha2"] = "Senhas n�o s�o id�nticas";
    }
    // Atualizo banco de dados se n�o h� erros
    if (!$erros) {
	if ($usuario->atualiza()) {
	    $_SESSION["usuario"] = $usuario;
	    echo "<h3>Seus dados foram atualizados </h3>\n";
	    link_pagina_principal ();
	} else {
	    msg_erro ("Erro ao atualizar usu�rio");
	    // msg_erro (mysql_error());
        msg_erro ($conexao->error);
	}
    } else {
	// Caso contr�rio, reapresento formul�rio com os erros indicados.
	form_usuario ("index.php?acao=dadospessoais", $usuario, false, $erros);
    }
} 
else {
    // Apresento o formul�rio.
    form_usuario ("index.php?acao=dadospessoais", $usuario, false);
}
?>
