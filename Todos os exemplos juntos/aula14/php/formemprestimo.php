<?php
require_once ('htmlutil.php');
		       
// Exibe um formulário para busca de emprestimos.
// $acao = url que processa o formulário.
// $default = array com defaults para os campos.
function form_busca_emprestimo ($acao,$default) {
?>
<form method="post" action="<?=$acao?>" name="formbuscasolicitacao">
<table class="formulario">
  <tbody>
    <tr>
      <th colspan=2>Dados do Usuário</th>
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
      <th>Título</th>
      <td><input maxlength="120" size="50" name="titulo" value="<?=$default['titulo']?>"></td>
    </tr>
    <tr>
      <th>Autor</th>
      <td><input maxlength="100" size="50" name="autor" value="<?=$default['autor']?>"></td>
    </tr>
  </tbody>
</table>
<button name="enviar_busca_emprestimo">Buscar</button><br>
</form>
<?php
}

// Exibe um formulário solicitações e um checkbox de confirmação para cada solicitação.
// $solicitacoes = array com objetos da classe 'solicitacao'
function form_confirma_devolucao ($acao,&$emprestimos) {
    echo "<form method='post' action='$acao' name='formconfirmadevolucao'>\n";
    echo "<table class='formulario'>\n";
    foreach ($emprestimos as $indice=>$emprestimo) {
	echo "<tr><td><input name='$indice' type='checkbox'></td>\n";
	echo "<td>";
	$emprestimo->exibe();
	echo "</td></tr>\n";
    }
    echo "</table>\n";
    echo "<button name='enviar_confirma_devolucao'>Confirmar</button><br>\n";
    echo "</form>\n";
}
?>