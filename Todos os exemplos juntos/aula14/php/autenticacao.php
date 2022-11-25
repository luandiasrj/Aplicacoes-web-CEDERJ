<?php
// Funcao para autenticar login e senha no sistema de bibliotecas.
// Caso a autenticação seja bem-sucedida, retorna uma instancia da classe usuario;
// caso contrário, retorna false.
// $login = login do usuário.
// $senha = senha do usuário.
function autentica ($login, $senha) {
  if (isset($login) && isset($senha)) { 
    // Realizar consulta
    require_once ('usuario.php');
    $usuario = new usuario;
    $usuario->login = $login;
    $usuario->senha = $senha;
    $usuario->encripta_senha();
    if ($usuario->busca("login = '$login' and senha = '$usuario->senha'")) {
      // Se busca bem sucedida, retornar o usuario
      return $usuario;
    }
  }
  return false;
} 
?>