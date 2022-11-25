<h2>Autorizar Cadastramento de Usuário</h2>
<?php
//
// Módulo para buscar e alterar inscrição do usuário
//

// Apenas administradores podem acessar
assegura_privilegio ('A');

// Incluo módulo com formulários de usuário
require_once ('formusuario.php');

// Crio uma instância da classe 'usuario'.
$usuario= new usuario;

// Vejo se usuário a ser autorizado foi definido.
if (isset ($_GET['id'])) {
    // Obtenho o id
    $id = $_GET['id'];
    // Apresento o formulário de autorização de usuário.
    $usuario->busca ("id=$id");
    $usuario->exibe ();
    // Vejo se autorização foi confirmada.
    if (isset ($_GET["confirma"])) {
	$usuario->privilegio='M';
	$usuario->atualiza(false); // atualiza sem re-encriptar a senha
	echo "<h3> Usuário Autorizado </h3>";
    } 
    else {
	echo "<h3> Confirma autorização? </h3>";
	botao ("Sim", "index.php?acao=autorizarusuario&id=$id&confirma=1");
    }
    link_pagina_principal();
}
// Vejo se formulário já foi preenchido
elseif (isset ($_POST['enviar_busca_usuario'])) {
    // Faço uma busca baseada nos dados preenchidos
    $usuario->atribui_de_array ($_POST);
    $expressao = array ();
    if ($usuario->nome != '') $expressao [] = "nome like '%" . addslashes($usuario->nome). "%'";
    if ($usuario->login != '') $expressao [] = "login = '" . addslashes($usuario->login). "'";
    $expressao [] = "privilegio = 'I'"; // busco apenas usuários inscritos que aguardam autorização
    // obtenho o primeiro resultado
    $resultado = $usuario->busca (implode (" and ", $expressao));
    if (!$resultado) {
	echo "<h3> Nenhum usuário satisfaz os critérios. </h3>";
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
    // Apresento o formulário de busca de usuários.
    form_busca_usuario ("index.php?acao=autorizarusuario",$usuario);
}

?>

    
    
