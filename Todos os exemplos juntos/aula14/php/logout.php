<?php
// Exibe um formul�rio para confirmar a��o de sair do sistema
?>
<h2> Logout </h2>
<p>Voc� deseja realmente sair do sistema?"</p>
<form method="post" action="processalogout.php" name="form_logout">
  <input value="Sair" name="sair" type="submit">
  <input value="Cancelar" name="sair" type="submit">
</form>
