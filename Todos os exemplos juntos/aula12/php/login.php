<?php 
header("Content-Type: text/html; charset=ISO-8859-1"); 
include "autenticacao.inc";
session_start ();
if (isset ($_POST["logout"])) {
   session_destroy ();
   pagina_logout ();
} elseif (isset ($_SESSION["usuario"])) {
   pagina_conteudo ();
} elseif (autentica ($_POST["nome"], $_POST["senha"],$conexao)) {
   $_SESSION["usuario"] = $_POST["nome"];
   pagina_conteudo ();
} else pagina_login ();

// Exibe página de login
function pagina_login () {
   // Pagina login segue...
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
  "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Página de Login</title>
</head>
<body>
<h2>Página de LOGIN</h2>
<form method="post" action="login.php" name="form_login">
  <table style="text-align: left;" border="0" cellpadding="6"
 cellspacing="0">
    <tbody>
      <tr>
        <td>Nome</td>
        <td><input name="nome"></td>
      </tr>
      <tr>
        <td>Senha</td>
        <td><input name="senha" type="password"></td>
      </tr>
    </tbody>
  </table>
  <button>Entrar</button></form>
</body>
</html>

<?php 
} // Fim pagina_login

// Exibe pagina de conteúdo
function pagina_conteudo () {
   // Página de conteúdo segue ...
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
  "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Página de Conteúdo</title>
</head>
<body>
<h2>Bem-Vindo <?php echo $_SESSION["usuario"] ?></h2>
<p> Para sair da sessão, aperte o botão "sair" </p>
<form method="post" action="login.php" name="form_logout">
  <button name="logout" value="logout">SAIR</button></form>
</body>
</html>
<?php 
} // Fim pagina_conteudo

// Exibe pagina de logout
function pagina_logout () {
   // Página de logout segue ...
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
  "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Fim de sessão</title>
</head>
<body>
<h2>Fim de sessão</h2>
<p> Volte breve! </p>
</body>
</html>
<?php 
} // Fim pagina_lotout

?>
