<?php
// Processamento do formulário de confirmação de logout
require_once ('sessao.php');
if ($_POST["sair"]=="Sair") {
    // Usuário confirmou logout -> exibir mensagem de adeus
    session_destroy();
    header("Location: index.php?acao=logoutok");
}
else {
    // Usuário não confirmou -> redirecionar para página principal
    header("Location: index.php");
}
?>
