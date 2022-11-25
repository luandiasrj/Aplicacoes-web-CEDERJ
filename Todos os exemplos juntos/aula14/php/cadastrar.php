<h2>Formulário de Cadastramento de Usuário</h2>
<?php
require_once ('formusuario.php');
require_once ('htmlutil.php');
$usuario = new usuario;
if (isset ($_POST["enviar_usuario"])) {
    $usuario->atribui_de_array ($_POST);
    $erros = $usuario->erros();
    if ($usuario->login != '' && $usuario->login_existe()) {
	$erros = $erros ? $erros : array ();
	$erros ["login"] = "Este login já está sendo usado";
    }
    if ($_POST["senha2"] != $_POST["senha"]) {
    	$erros ["senha2"] = "Senhas não são idênticas";
    }
    if (!$erros) {
	if ($usuario->inclui()) {
	    echo "Você foi cadastrado provisoriamente com login $usuario->login<br>";
	    echo "Dirija-se a um administrador com seus documentos ".
		 "para autorizar seu cadastramento definitivo <br>";
	} else {
	    msg_erro ("Erro ao incluir usuário");
	    // msg_erro (mysql_error());
		msg_erro(mysqli_error($conexao));
	}
    } else {
	form_usuario ("index.php?acao=cadastrar", $usuario, false, $erros);
    }
} 
else {
    form_usuario ("index.php?acao=cadastrar", $usuario, false);
}
?>
