<?php
// Processamento do formul�rio de confirma��o de logout
require_once ('sessao.php');
if ($_POST["sair"]=="Sair") {
    // Usu�rio confirmou logout -> exibir mensagem de adeus
    session_destroy();
    header("Location: index.php?acao=logoutok");
}
else {
    // Usu�rio n�o confirmou -> redirecionar para p�gina principal
    header("Location: index.php");
}
?>
