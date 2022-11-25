<?php
require_once ('htmlutil.php');
require_once ('usuario.php');

$array_genero = array ("",
		       "Romance e Novela",
		       "Cr�nicas e textos humor�sticos",
		       "Teatro",
		       "Outros",
		       "Literatura de viagens e informativa",
		       "Poesia",
		       "Conto",
		       "Tradu��o",
		       "Mem�rias",
		       "Cr�tica, teoria e hist�ria liter�rias",
		       "Epistolografia",
		       "Epigramas, pensamentos e prov�rbios",
		       "Discursos e serm�es (textos doutrin�rios e moralizantes)",
		       "Miscel�nea");
		       
// Exibe um formul�rio para busca de livros.
// $acao = url que processa o formul�rio
// $array = array com defaults para os campos
function form_busca_livro ($acao,$default) {
// Cria chaves em branco para o array $default
if (!isset($default['titulo'])) $default['titulo'] = '';
if (!isset($default['autor'])) $default['autor'] = '';
if (!isset($default['genero'])) $default['genero'] = '';
if (!isset($default['ano'])) $default['ano'] = '';

?>
<form method="post" action="<?=$acao?>" name="formbuscalivro">
<table class="formulario" border="0" cellpadding="5"
 cellspacing="0">
  <tbody>
    <tr>
      <th>T�tulo</th>
      <td><input maxlength="120" size="50" name="titulo" value="<?=$default['titulo']?>"></td>
    </tr>
    <tr>
      <th>Autor</th>
      <td><input maxlength="100" size="50" name="autor" value="<?=$default['autor']?>"></td>
    </tr>
    <tr>
      <th>G�nero</th>
      <td><select name="genero" >
      <?php  global $array_genero; gera_option($array_genero,$default['genero']);?>
      </select>
      </td>
    </tr>
    <tr>
      <th>Ano</th>
      <td><input maxlength="4" size="4" name="ano" value="<?=$default['ano']?>"></td>
    </tr>
  </tbody>
</table>
<button name="enviar_busca_livro">Enviar</button><br>
</form>

<?php
}

// Exibe um formul�rio para cadastramento de livros.
// $acao = url que processa o formul�rio.
// $array = array com defaults para os campos.
// $erros = array com mensagens de erro provenientes de um preenchimento anterior.
function form_cadastra_livro ($acao,$default,$erros=array()) {

// Se $erros n�o tiver valores iniciais, cria chaves em branco
if (!isset($default['titulo'])) $default['titulo'] = '';
// iniciar a chave 'autor[0]' com um valor em branco
if (!isset($default['autor'][0])) $default['autor'][0] = '';
if (!isset($default['genero'])) $default['genero'] = '';
if (!isset($default['ano'])) $default['ano'] = '';
if (!isset($default['exemplares'])) $default['exemplares'] = '';

// Se $default n�o tiver valores iniciais, cria chaves em branco
if (!isset($erros['titulo'])) $erros['titulo'] = '';
if (!isset($erros['autor'])) $erros['autor'] = '';
if (!isset($erros['genero'])) $erros['genero'] = '';
if (!isset($erros['ano'])) $erros['ano'] = '';
if (!isset($erros['exemplares'])) $erros['exemplares'] = '';
         
?>
<form method="post" action="<?=$acao?>" name="formcadastralivro">
<table class="formulario" border="0" cellpadding="5"
 cellspacing="0">
  <tbody>
    <tr>
      <th>T�tulo</th>
      <td><?php msg_erro ($erros["titulo"]); ?>
      <input maxlength="120" size="50" name="titulo" value="<?=$default['titulo']?>"></td>
    </tr>
    <tr>
      <th>Autor(es)</th>
      <td><?php msg_erro ($erros["autor"]); ?>
         <input maxlength="100" size="50" name="autor[0]" value="<?=$default['autor'][0]?>">
	<br>
         <?php
	for ($i = 1; isset($default['autor'][$i]); $i++) {
	    echo "<input maxlength='100' size='50' name='autor[$i]' value='".$default['autor'][$i]."'>";
    	    echo "<br>\n";
	}?>
  <input name="enviar_adiciona_autor" value="Adicionar Autor" type="submit">
  <?php
	if (isset($default['autor'][1])) {
	    echo '<input name="enviar_remove_autor" value="Remover Autor" type="submit">';
	}
	?>	
	<input name="enviar_busca_autor" value="Buscar Autor" type="submit">
      </td>
    </tr>
    <tr>
      <th>G�nero</th>
      <td><?php msg_erro ($erros["genero"]); ?>
         <select name="genero" >
	<?php  
	global $array_genero;
	gera_option ($array_genero,$default['genero']);
	?>
      </select>
      </td>
    </tr>
    <tr>
      <th>Ano</th>
      <td><?php msg_erro ($erros["ano"]); ?>
      <input maxlength="4" size="4" name="ano" value="<?=$default['ano']?>"></td>
    </tr>
    <tr>
      <th>Exemplares</th>
      <td><?php msg_erro ($erros["exemplares"]); ?>
      <select name="exemplares" >
      <?php
      gera_option (array(1,2,3,4,5,6,7,8,9,10), $default['exemplares']);
      ?>
      </select>
      </td>
    </tr>  
  </tbody>
</table>
<button name="enviar_cadastra_livro">Enviar</button><br>
</form>

<?php
}
?>
