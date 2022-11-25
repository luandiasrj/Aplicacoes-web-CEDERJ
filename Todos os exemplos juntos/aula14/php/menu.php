<?php

// Estrutura do menu principal
$menu_principal=array (
    array("principal", "P�gina Inicial", "IMA"),
    array("buscar", "Procurar Livros", "IMA"),
    array("consultar", "Consultar Empr�stimos", "MA"),
    array("dadospessoais", "Alterar/Consultar Dados Cadastrais", "MA"),
    array("login", "Login", "I"),
    array("cadastrar", "Cadastrar-se", "I"),
    array("logout", "Sair", "MA"));

// Estrutura do menu de administra��o de livros
$menu_admin_livro = array (
    array("entregar", "Gerenciar Empr�stimos", "A"),
    array("devolver", "Gerenciar Devolu��es", "A"),
    array("cadastrarlivro", "Incluir novo Livro", "A"),
    array("removerlivro", "Remover livro", "A"),
    array("editarlivro", "Editar cadastro de livro", "A")
    );

// Estrutura do menu de administra��o de usu�rios.
$menu_admin_usuario = array (
    array("alterarusuario", "Alterar/Consultar Dados Cadastrais", "A"),
    array("autorizarusuario","Autorizar Cadastramento","A"),
    array("removerusuario","Remover Usu�rio","A")
    );
    
// Exibe um menu. Os itens s� s�o exibidos se o usu�rio tem
// privil�gios para acessar o link.
// $titulo = T�tulo do menu.
// $itens = Array de itens do menu, cada qual um array com elementos
//          acao, r�tulo e privil�gio.
function exibe_menu ($titulo,$itens) {
    echo "<div class='menu'>";
    echo "<div class='tituloMenu'>" . $titulo . "</div>\n";
    echo "<div class='areaMenu'>\n";
    foreach ($itens as $item) {
	// Emitir itens para os quais usu�rio tem privil�gio
	list($acao,$rotulo,$privilegio) = $item;
	if (strpos($privilegio,$_SESSION['privilegio']) !== false) {
	    echo "<a href='index.php?acao=$acao'>".
		$rotulo."</a> <br> \n";
	}
    }
    echo "</div>\n";
    echo "</div>\n";
}

// Exibe menus
exibe_menu ("Menu Principal", $menu_principal);
if ($_SESSION['privilegio']=='A') {
    exibe_menu ("Ger�ncia de Livros", $menu_admin_livro);
    exibe_menu ("Ger�ncia de Usu�rios", $menu_admin_usuario);
}
?>
