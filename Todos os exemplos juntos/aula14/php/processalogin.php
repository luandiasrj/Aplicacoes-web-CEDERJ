<?php
// Processamento do formulсrio de login
require_once ('sessao.php');
require_once ('autenticacao.php');
$usuario = autentica ($_POST['login'], $_POST['senha']);
if ($usuario) {
    // Autenticaчуo bem-sucedida -> redirecionar para pсgina de boas vindas
    $_SESSION['login']=$usuario->login;
    $_SESSION['idusuario']=$usuario->id;
    $_SESSION['privilegio']=$usuario->privilegio;
    header("Location: index.php?acao=loginok");
} else {
    // Autenticaчуo falhou -> redirecionar para pсgina com mensagem 
    // de erro
    $_SESSION['privilegio']='I';
    header("Location: index.php?acao=loginfalhou");
}
?>