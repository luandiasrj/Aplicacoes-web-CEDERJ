<h2>Cadastro de Livro</h2>
<?php
//
// Modulo que trata do cadastramento de livros
//

// Apenas administradores podem acessar
assegura_privilegio ('A');

require_once ('formlivro.php');

// Crio uma variável para guardar o livro e seus autores
$livro_autores= new livro_autores;

// Vejo se o livro tem valores default
if (isset ($_POST['titulo'])) {
    // Há um post anterior - inicializo deste post
    $livro_autores->atribui_de_array($_POST);
    // Faço a verificacao dos valores preenchidos.
    $erros = $livro_autores->erros();
} 
else {
    if (isset ($_GET['id'])) {
	// Existe um id de livro especificado. Inicializo deste id
	$livro_autores->busca_idlivro ($_GET['id']);
    }
    $erros = false;
}

// Vejo se o formulario foi preenchido sem erros e enviado para cadastro.
if (isset ($_POST['enviar_cadastra_livro']) && !$erros) {
    // Incluo ou atualizo livro
    if (isset ($_GET['id'])) {
	echo "Atualizando livro ". $_GET['id']. "<br>";
	$livro_autores->livro->id = $_GET['id'];
	$livro_autores->atualiza();
    }
    else {
	echo "Cadastrando novo livro";
	$livro_autores->inclui();
    }
    $livro_autores->exibe();
} else {
    // Usuario clicou um dos botões que controlam os autores, 
    // o preenchimento teve erros ou esta é
    // a primeira exibição do formulário de cadastramento.
    
    // Descubro quantos autores o livro tem ate o momento.
    if (isset ($livro_autores->autores)) { // Condicional para evitar erro fatal se nao houver autores
    $n = count ($livro_autores->autores);
    }
    else { 
        $n = 0;
    }
    if (isset ($_POST['enviar_remove_autor'])) {
	// Remover o último autor
	if ($n>1) unset ($livro_autores->autores[$n-1]);
    } 
    elseif (isset ($_POST['enviar_adiciona_autor'])) {
	// Acrescentar um autor
	$livro_autores->autores[$n] = new autor;
    }
    elseif (isset ($_POST['enviar_busca_autor'])) {
	// Usar o nome para buscar no cadastro de autores
	$resultado = $livro_autores->autores[$n-1]
		     ->busca("nome like '%".$_POST['autor'][$n-1]."%'");
    }
    // Preparo o formulario atualizado
    $array = array();
    // Atribui os autores do livro
    if (isset ($livro_autores->autores)) { // Condicional para evitar erro fatal se nao houver autores
    $livro_autores->atribui_a_array ($array);  
    }
    $acao = "index.php?acao=cadastrarlivro";
    if (isset ($_GET['id'])) {
	$acao .= "&id=".$_GET['id'];
    } 
    // Exibo o formulário
    if ($erros) {
	form_cadastra_livro ($acao,$array,$erros);
    } else {
	form_cadastra_livro ($acao,$array);
    }
}
?>
