<?php
// 
// Teste de rotina para incluir usu�rio
//
header("Content-Type: text/html; charset=ISO-8859-1");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
  <title>Biblioteca - Formul�rio de Cadastro de Usu�rios</title>
</head>
<body>
    <h1>Biblioteca - Formul�rio de Cadastro de Usu�rios</h1>
    <?php

    require ('formusuario.php');
    require ('conectabanco.php');
    $usuario = new usuario;
    if (isset ($_POST["enviar_usuario"])) {
	$usuario->atribui_de_array ($_POST);
	$erros = $usuario->erros();
	if ($usuario->login != '' && $usuario->login_existe()) {
		if (!is_array($erros)) $erros = array();
	    $erros ["login"] = "Este login j� est� sendo usado";
	}
	if (!$erros) {
	    if ($usuario->inclui()) {
		echo "Usuario $usuario->login inclu�do<br>";
	    } else {
		msg_erro ("Erro ao incluir usu�rio");
		// msg_erro (mysql_error());
		msg_erro (mysqli_error($conexao));
	    }
	} else {
	    form_usuario ("incluiusuario.php", $usuario, true, $erros);
	}
    } 
    else {
	form_usuario ("incluiusuario.php", $usuario, true);
    }
    ?>
    <br>
</body>
</html>
