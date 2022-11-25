<h2>Remover Usuário</h2>
<?php
//
// Módulo para buscar e remover usuários
//

// Apenas administradores podem acessar
assegura_privilegio ('A');

// Incluo módulo com formulários de usuário
require_once ('formusuario.php');

// Crio uma instância da classe 'usuario'.
$usuario= new usuario;

// Vejo se usuário a ser alterado foi definido.
if (isset ($_GET['id'])) {
    // Obtenho o id
    $id = $_GET['id'];
    // Vejo se remoção foi confirmada.
    if (isset ($_GET['confirma'])) {
	// Sim, remoção foi confirmada.
	// Tem solicitações? Estas devem ser removidas
	$resultado = mysql_query("select * from solicitacao where idusuario = $id");
	if ( mysql_num_rows($resultado) > 0 ) {
	    // remover solicitações do usuário
	    mysql_query("delete from solicitacao where idusuario = $id");
	    msg_erro ("Usuário tinha solicitações de empréstimo que foram removidas.");
	}
	// remover usuário
	mysql_query("delete from usuario where id = $id");
	echo "Usuário foi removido com sucesso.";
    }
    else {
	$usuario->busca ("id=$id");
	$usuario->exibe ();
	// Usuário tem empréstimos? não pode ser removido
	$emprestimos = "select * from emprestimo where idusuario = $id";
	$resultado = mysql_query($emprestimos);
	if ( $resultado && mysql_num_rows($resultado) > 0 ) { // usuário tem livros emprestados?
	    msg_erro ("Usuário está com livros emprestados. Não pode ser removido.");
	}
	else {
	    echo "<h3> Confirma remoção? </h3>";
	    botao ("Sim", "index.php?acao=removerusuario&id=$id&confirma=1");	    
	}	
    } 
    link_pagina_principal();
}
// Vejo se formulário já foi preenchido
elseif (isset ($_POST['enviar_busca_usuario'])) {
    // Faço uma busca baseada nos dados preenchidos
    $nome = $_POST['nome'];
    $login = $_POST['login'];
    $expressao = array ();
    if ($nome != '') $expressao [] = "nome like '%" . addslashes($nome). "%'";
    if ($login != '') $expressao [] = "login = '" . addslashes($login). "'";
    // obtenho o primeiro resultado
    $resultado =  $usuario->busca (implode (" and ", $expressao));
    if (!$resultado) {
	msg_erro ("Nenhum usuário satisfaz os critérios.");
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
    // Apresento o formulário de busca de usuários.
    form_busca_usuario ("index.php?acao=removerusuario",$usuario);
}

?>

    
    
