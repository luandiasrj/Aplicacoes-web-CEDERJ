<?php
  if (!(isset($_POST["nome"]))) {
?>
<html>
<head><title>Informa��es para Cadastro</title></head>
<body bgcolor="white">  
<form method="post" action="slide_p22.php">
<h1> Informa��es para Cadastro </h1>
<h3>Por favor, entre com a informa��o solicitada para se cadastrar. Campos mostrados em <font color="red"> vermelho </font> s�o obrigat�rios.</h3>
<table>
<col span="1" align="right">
<tr> <td><font color="red">Sobrenome:</font></td>
   <td><input type="text" name="sobrenome" size=50></td></tr>
<tr> <td><font color="red">Nome:</font></td>
   <td><input type="text" name="nome" size=50></td></tr>
<tr> <td><font color="red">Endere�o:</font></td>
   <td><input type="text" name="endereco" size=50></td></tr>
<tr> <td><font color="red">Cidade:</font></td>
   <td><input type="text" name="cidade" size=50></td></tr>
<tr> <td><font color="red">Data de nascimento (dd/mm/yyyy):</font> </td>
   <td><input type="text" name="ddn" size=10></td></tr>
<tr> <td><font color="red">Email/username:</font></td>
   <td><input type="text" name="email" size=50></td></tr>
<tr> <td><input type="submit" value="Submit"></td></tr>
</table></form></body>
</html>
<?php
  } // fecha if
  else {
    include 'error.inc';
    include 'clean.inc';

    $errorString = "";  
    foreach($_POST as $varname => $value)
        $formVars[$varname] = clean($value, 50);  
    if (empty($formVars["nome"])) 
        $errorString .= "\n<br>O campo nome deve ser digitado.";    
    if (empty($formVars["sobrenome"]))
        $errorString .= "\n<br>O campo sobrenome deve ser digitado.";  
    if (empty($formVars["endereco"]))
        $errorString .= "\n<br>Voc� deve digitar pelo menos uma linha de endere�o.";  
    if (empty($formVars["cidade"]))
        $errorString .= "\n<br>O campo cidade � obrigat�rio.";  
    if (empty($formVars["ddn"]))
        $errorString .= "\n<br>Voc� deve prencher sua data de nascimento.";  
    elseif (!ereg("^([0-9]{2})/([0-9]{2})/([0-9]{4})$", $formVars["ddn"], $partes))
        $errorString .= "\n<br>A data n�o est� no formato correto: DD/MM/YYYY";  
    if (empty($formVars["email"])) 
        $errorString .= "\n<br>O campo email � obrigat�rio.";  
    if (!empty($errorString))
    {
      // H� erros. Mostrar e sair.
?>
     <html>
     <head><title>Erro no cadastramento</title></head>
     <body bgcolor="white">  
     <h1>Erro no Cadastramento</h1>
     <?=$errorString?>
     <br><a href="slide_p22.php">Retornar para o form</a>
     </body>
     </html>
<?php      
      exit;
    }

  // Se o script chegou aqui, � porque os dados foram recebidos e tratados com sucesso
  // Terceira fase!

  if (!($con = @ mysql_pconnect($_SERVER["REMOTE_ADDR"], "aluno", "aluno")))
     die("N�o p�de conectar ao BD");

  if (!mysql_select_db("prog2", $con))
     ExibeErro();
     
  // Formatar data de acordo com formato interno Mysql
  $ddn = " \"$partes[3]-$partes[2]-$partes[1]\"";
  
  // Criar uma consulta com o dado do usu�rio 
  $createTableCadastro = "create table if not exists cadastro (id int key auto_increment, sobrenome varchar(100), nome varchar(50), endereco varchar(100), cidade varchar(50), email varchar(80), ddn varchar(10))";
  if (!(@mysql_query($createTableCadastro,$con))) 
     ExibeErro();
  $consulta = "INSERT INTO cadastro
              set id = 0, " .
              "sobrenome = \"" . $formVars["sobrenome"] . "\", " .
              "nome = \"" . $formVars["nome"] . "\", " .                    
              "endereco = \"" . $formVars["endereco"] . "\", " .
              "cidade = \"" . $formVars["cidade"] . "\", " .
              "email = \"" . $formVars["email"] . "\", " .
              "ddn = $ddn";
  // Rodar a consulta
  if (!(@ mysql_query ($consulta, $con)))
     ExibeErro();   
  // Id do novo membro
  $ID = mysql_insert_id();  
  // Redirecionar usu�rio
  header("Location: notificacao_cadastro.php?ID=$ID");
 } // end else
?>

