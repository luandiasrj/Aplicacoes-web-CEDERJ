<h2>Autorizar Cadastramento de Usu�rio</h2>
<?php
//
// M�dulo para buscar e alterar inscri��o do usu�rio
//

// Apenas administradores podem acessar
assegura_privilegio ('A');

// Incluo m�dulo com formul�rios de usu�rio
require_once ('formusuario.php');

// Crio uma inst�ncia da classe 'usuario'.
$usuario= new usuario;

// Vejo se usu�rio a ser autorizado foi definido.
if (isset ($_GET['id'])) {
    // Obtenho o id
    $id = $_GET['id'];
    // Apresento o formul�rio de autoriza��o de usu�rio.
    $usuario->busca ("id=$id");
    $usuario->exibe ();
    // Vejo se autoriza��o foi confirmada.
    if (isset ($_GET["confirma"])) {
	$usuario->privilegio='M';
	$usuario->atualiza(false); // atualiza sem re-encriptar a senha
	echo "<h3> Usu�rio Autorizado </h3>";
    } 
    else {
	echo "<h3> Confirma autoriza��o? </h3>";
	botao ("Sim", "index.php?acao=autorizarusuario&id=$id&confirma=1");
    }
    link_pagina_principal();
}
// Vejo se formul�rio j� foi preenchido
elseif (isset ($_POST['enviar_busca_usuario'])) {
    // Fa�o uma busca baseada nos dados preenchidos
    $usuario->atribui_de_array ($_POST);
    $expressao = array ();
    if ($usuario->nome != '') $expressao [] = "nome like '%" . addslashes($usuario->nome). "%'";
    if ($usuario->login != '') $expressao [] = "login = '" . addslashes($usuario->login). "'";
    $expressao [] = "privilegio = 'I'"; // busco apenas usu�rios inscritos que aguardam autoriza��o
    // obtenho o primeiro resultado
    $resultado = $usuario->busca (implode (" and ", $expressao));
    if (!$resultado) {
	echo "<h3> Nenhum usu�rio satisfaz os crit�rios. </h3>";
    } else {
	echo "<table class='tabelabusca'>\n";
	linha_tabela (array('Nome', 'Login', 'E-mail'), true);
	$link = "<a href='index.php?acao=autorizarusuario&id=%d'>%s</a>";
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
    form_busca_usuario ("index.php?acao=autorizarusuario",$usuario);
}

?>

    
    
