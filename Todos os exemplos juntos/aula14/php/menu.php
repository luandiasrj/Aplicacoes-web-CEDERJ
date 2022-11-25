<?php

// Estrutura do menu principal
$menu_principal=array (
    array("principal", "Página Inicial", "IMA"),
    array("buscar", "Procurar Livros", "IMA"),
    array("consultar", "Consultar Empréstimos", "MA"),
    array("dadospessoais", "Alterar/Consultar Dados Cadastrais", "MA"),
    array("login", "Login", "I"),
    array("cadastrar", "Cadastrar-se", "I"),
    array("logout", "Sair", "MA"));

// Estrutura do menu de administração de livros
$menu_admin_livro = array (
    array("entregar", "Gerenciar Empréstimos", "A"),
    array("devolver", "Gerenciar Devoluções", "A"),
    array("cadastrarlivro", "Incluir novo Livro", "A"),
    array("removerlivro", "Remover livro", "A"),
    array("editarlivro", "Editar cadastro de livro", "A")
    );

// Estrutura do menu de administração de usuários.
$menu_admin_usuario = array (
    array("alterarusuario", "Alterar/Consultar Dados Cadastrais", "A"),
    array("autorizarusuario","Autorizar Cadastramento","A"),
    array("removerusuario","Remover Usuário","A")
    );
    
// Exibe um menu. Os itens só são exibidos se o usuário tem
// privilégios para acessar o link.
// $titulo = Título do menu.
// $itens = Array de itens do menu, cada qual um array com elementos
//          acao, rótulo e privilégio.
function exibe_menu ($titulo,$itens) {
    echo "<div class='menu'>";
    echo "<div class='tituloMenu'>" . $titulo . "</div>\n";
    echo "<div class='areaMenu'>\n";
    foreach ($itens as $item) {
	// Emitir itens para os quais usuário tem privilégio
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
    exibe_menu ("Gerência de Livros", $menu_admin_livro);
    exibe_menu ("Gerência de Usuários", $menu_admin_usuario);
}
?>
