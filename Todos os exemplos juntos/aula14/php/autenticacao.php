<?php
// Funcao para autenticar login e senha no sistema de bibliotecas.
// Caso a autentica��o seja bem-sucedida, retorna uma instancia da classe usuario;
// caso contr�rio, retorna false.
// $login = login do usu�rio.
// $senha = senha do usu�rio.
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