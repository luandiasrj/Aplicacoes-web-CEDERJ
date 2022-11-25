<?php
// Processamento do formul�rio de login
require_once ('sessao.php');
require_once ('autenticacao.php');
$usuario = autentica ($_POST['login'], $_POST['senha']);
if ($usuario) {
    // Autentica��o bem-sucedida -> redirecionar para p�gina de boas vindas
    $_SESSION['login']=$usuario->login;
    $_SESSION['idusuario']=$usuario->id;
    $_SESSION['privilegio']=$usuario->privilegio;
    header("Location: index.php?acao=loginok");
} else {
    // Autentica��o falhou -> redirecionar para p�gina com mensagem 
    // de erro
    $_SESSION['privilegio']='I';
    header("Location: index.php?acao=loginfalhou");
}
?>