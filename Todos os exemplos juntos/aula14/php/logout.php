<?php
// Exibe um formulário para confirmar ação de sair do sistema
?>
<h2> Logout </h2>
<p>Você deseja realmente sair do sistema?"</p>
<form method="post" action="processalogout.php" name="form_logout">
  <input value="Sair" name="sair" type="submit">
  <input value="Cancelar" name="sair" type="submit">
</form>
