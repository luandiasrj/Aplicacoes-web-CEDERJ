<h2>Remover Usu�rio</h2>
<?php
//
// M�dulo para buscar e remover usu�rios
//

// Apenas administradores podem acessar
assegura_privilegio ('A');

// Incluo m�dulo com formul�rios de usu�rio
require_once ('formusuario.php');

// Crio uma inst�ncia da classe 'usuario'.
$usuario= new usuario;

// Vejo se usu�rio a ser alterado foi definido.
if (isset ($_GET['id'])) {
    // Obtenho o id
    $id = $_GET['id'];
    // Vejo se remo��o foi confirmada.
    if (isset ($_GET['confirma'])) {
	// Sim, remo��o foi confirmada.
	// Tem solicita��es? Estas devem ser removidas
	$resultado = mysql_query("select * from solicitacao where idusuario = $id");
	if ( mysql_num_rows($resultado) > 0 ) {
	    // remover solicita��es do usu�rio
	    mysql_query("delete from solicitacao where idusuario = $id");
	    msg_erro ("Usu�rio tinha solicita��es de empr�stimo que foram removidas.");
	}
	// remover usu�rio
	mysql_query("delete from usuario where id = $id");
	echo "Usu�rio foi removido com sucesso.";
    }
    else {
	$usuario->busca ("id=$id");
	$usuario->exibe ();
	// Usu�rio tem empr�stimos? n�o pode ser removido
	$emprestimos = "select * from emprestimo where idusuario = $id";
	$resultado = mysql_query($emprestimos);
	if ( $resultado && mysql_num_rows($resultado) > 0 ) { // usu�rio tem livros emprestados?
	    msg_erro ("Usu�rio est� com livros emprestados. N�o pode ser removido.");
	}
	else {
	    echo "<h3> Confirma remo��o? </h3>";
	    botao ("Sim", "index.php?acao=removerusuario&id=$id&confirma=1");	    
	}	
    } 
    link_pagina_principal();
}
// Vejo se formul�rio j� foi preenchido
elseif (isset ($_POST['enviar_busca_usuario'])) {
    // Fa�o uma busca baseada nos dados preenchidos
    $nome = $_POST['nome'];
    $login = $_POST['login'];
    $expressao = array ();
    if ($nome != '') $expressao [] = "nome like '%" . addslashes($nome). "%'";
    if ($login != '') $expressao [] = "login = '" . addslashes($login). "'";
    // obtenho o primeiro resultado
    $resultado =  $usuario->busca (implode (" and ", $expressao));
    if (!$resultado) {
	msg_erro ("Nenhum usu�rio satisfaz os crit�rios.");
	link_pagina_principal();
    } else {
	echo "<table class='tabelabusca'>\n";
	linha_tabela (array('Nome', 'Login', 'E-mail'), true);
	$link = "<a href='index.php?acao=removerusuario&id=%d'>%s</a>";
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
    form_busca_usuario ("index.php?acao=removerusuario",$usuario);
}

?>

    
    
