<h2>Alteração de Dados Pessoais</h2>
<?php

// Apenas membros logados podem alterar dados pessoais.
assegura_privilegio ('M');

// Módulo com formulário de dados pessoais.
require_once ('formusuario.php');

// Crio uma nova instancia da classe usuario e preencho com os dados
// do usuário corrente.
$usuario = new usuario;
$usuario->busca ("login = '" . $_SESSION["login"] ."'");

// Vejo se o formulário foi enviado
if (isset ($_POST["enviar_usuario"])) {
    // Preencho a instancia com os dados do formulário.
    $usuario->atribui_de_array ($_POST);
    // Faço a crítica do formulário
    $erros = $usuario->erros();
    if(!is_array($erros)) $erros = array(); // Evita erro no PHP 8.1 na conversão de não array para array
    // Alguns testes adicionais
    if ($usuario->login != '' && $usuario->login_existe() && 
	$_SESSION["login"] != $usuario->login) {
	$erros ["login"] = "Este login já está sendo usado";
    }
    if ($_POST["senha2"] != $_POST["senha"]) {
    	$erros ["senha2"] = "Senhas não são idênticas";
    }
    // Atualizo banco de dados se não há erros
    if (!$erros) {
	if ($usuario->atualiza()) {
	    $_SESSION["usuario"] = $usuario;
	    echo "<h3>Seus dados foram atualizados </h3>\n";
	    link_pagina_principal ();
	} else {
	    msg_erro ("Erro ao atualizar usuário");
	    // msg_erro (mysql_error());
        msg_erro ($conexao->error);
	}
    } else {
	// Caso contrário, reapresento formulário com os erros indicados.
	form_usuario ("index.php?acao=dadospessoais", $usuario, false, $erros);
    }
} 
else {
    // Apresento o formulário.
    form_usuario ("index.php?acao=dadospessoais", $usuario, false);
}
?>
