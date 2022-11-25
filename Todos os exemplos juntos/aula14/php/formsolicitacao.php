<?php
require_once ('htmlutil.php');
		       
// Exibe um formul�rio para busca de solicitacoes.
// $acao = url que processa o formul�rio.
// $default = array com defaults para os campos.
function form_busca_solicitacao ($acao,$default) {
?>
<form method="post" action="<?=$acao?>" name="formbuscasolicitacao">
<table class="formulario">
  <tbody>
    <tr>
      <th colspan=2>Dados do Usu�rio</th>
    </tr>
    <tr>
      <th>Nome</th>
      <td>
      <input maxlength="80" size="60" value="<?=$usuario->nome?>" name="nome"></td>
    </tr>
    <tr>
      <th>Login</th>
      <td>
      <input name="login" value="<?=$usuario->login?>"></td>
    </tr>
    <tr>
      <th colspan=2>Dados do Livro</th>
    </tr>
    <tr>
      <th>T�tulo</th>
      <td><input maxlength="120" size="50" name="titulo" value="<?=$default['titulo']?>"></td>
    </tr>
    <tr>
      <th>Autor</th>
      <td><input maxlength="100" size="50" name="autor" value="<?=$default['autor']?>"></td>
    </tr>
  </tbody>
</table>
<button name="enviar_busca_solicitacao">Buscar</button><br>
</form>
<?php
}

// Exibe um formul�rio solicita��es e um checkbox de confirma��o para cada solicita��o.
// $solicitacoes = array com objetos da classe 'solicitacao'
function form_confirma_entrega ($acao,&$solicitacoes) {
    echo "<form method='post' action='$acao' name='formconfirmasolicitacao'>\n";
    echo "<table class='formulario'>\n";
    foreach ($solicitacoes as $indice=>$solicitacao) {
	echo "<tr><td><input name='$indice' type='checkbox'></td>\n";
	echo "<td>";
	$solicitacao->exibe();
	echo "</td></tr>\n";
    }
    echo "</table>\n";
    echo "<button name='enviar_confirma_entrega'>Confirmar</button><br>\n";
    echo "</form>\n";
}
?>