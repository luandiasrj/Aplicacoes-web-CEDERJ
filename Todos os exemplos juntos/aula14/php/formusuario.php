<?php
require_once ('htmlutil.php');
require_once ('usuario.php');

// Array com nomes e siglas de estados do Brasil
$estados = array ("--"=>"--Escolha--",
		  "AC"=>"Acre",
		  "AL"=>"Alagoas",
		  "AP"=>"Amap&aacute;",
		  "AM"=>"Amazonas",
		  "BA"=>"Bahia",
		  "CE"=>"Cear&aacute;",
		  "DF"=>"Distrito Federal",
		  "GO"=>"Goi&aacute;s",
		  "ES"=>"Esp&iacute;rito Santo",
		  "MA"=>"Maranh&atilde;o",
		  "MT"=>"Mato Grosso",
		  "MS"=>"Mato Grosso do Sul",
		  "MG"=>"Minas Gerais",
		  "PA"=>"Par&aacute;",
		  "PB"=>"Paraiba",
		  "PR"=>"Paran&aacute;",
		  "PE"=>"Pernambuco",
		  "PI"=>"Piau&iacute;",
		  "RJ"=>"Rio de Janeiro",
		  "RN"=>"Rio Grande do Norte",
		  "RS"=>"Rio Grande do Sul",
		  "RO"=>"Rond&ocirc;nia",
		  "RR"=>"Roraima",
		  "SP"=>"S&atilde;o Paulo",
		  "SC"=>"Santa Catarina",
		  "SE"=>"Sergipe",
		  "TO"=>"Tocantins");
		  
// Gera html para um formulario de dados de usuário.
// $acao = url do script que vai processar o formulário
// $usuario = instancia da classe usuario com os valores default.
// $admin = booleano que diz se o campo "administrador" deve ser mostrado.
// $erros = array com mensagens de erro provenientes de um preenchimento anterior.
function form_usuario ($acao, $usuario, $admin=0, $erros=array()) {

// verifica se $erros não tem as chaves necessárias e cria-as em branco
if (!isset($erros['nome'])) $erros['nome'] = '';
if (!isset($erros['login'])) $erros['login'] = '';
if (!isset($erros['email'])) $erros['email'] = '';
if (!isset($erros['senha'])) $erros['senha'] = '';
if (!isset($erros['senha2'])) $erros['senha2'] = '';
if (!isset($erros['estado'])) $erros['estado'] = '';
if (!isset($erros['cidade'])) $erros['cidade'] = '';
if (!isset($erros['endereco'])) $erros['endereco'] = '';
if (!isset($erros['telefone'])) $erros['telefone'] = '';
if (!isset($erros['privilegio'])) $erros['privilegio'] = '';

?>
<form method="post" action="<?=$acao?>" name="formusuario">
<table class="formulario" border="0" cellpadding="10" cellspacing="0">
  <tbody>
    <tr>
      <th>Nome</th>
      <td><?php msg_erro ($erros["nome"]); ?>
      <input maxlength="80" size="60" value="<?=$usuario->nome?>" name="nome"></td>
    </tr>
    <tr>
      <th>Login</th>
      <td><?php msg_erro ($erros["login"]); ?>
      <input name="login" maxlength="30" size="30" value="<?=$usuario->login?>"></td>
    </tr>
    <tr>
      <th>Senha</th>
      <td><?php msg_erro ($erros["senha"]); ?>
      <input name="senha" type="password"></td>
    </tr>
    <tr>
      <th>Senha (novamente)</th>
      <td><?php msg_erro ($erros["senha2"]); ?>
      <input name="senha2" type="password"></td>
    </tr>
    <tr>
      <th>E-mail</th>
      <td><?php msg_erro ($erros["email"]); ?>
      <input name="email" value="<?=$usuario->email?>"></td>
    </tr>
    <tr>
      <th>Endere&ccedil;o</th>
      <td><?php msg_erro ($erros["endereco"]); ?>
      <input value="<?=$usuario->endereco?>" size="60" maxlength="60" name="endereco"></td>
    </tr>
    <tr>
      <th>Cidade</th>
      <td><?php msg_erro ($erros["cidade"]); ?>
      <input maxlength="60" size="30" name="cidade" value="<?=$usuario->cidade?>"></td>
    </tr>
    <tr>
      <th>Estado</th>
      <td><?php msg_erro ($erros["estado"]); ?>
      <select name="estado" >
      <?php
      global $estados;
      gera_option ($estados, $usuario->estado);
     ?>
      </select>
      </td>
    </tr>
    <tr>
      <th>Telefone</th>
      <td><?php msg_erro ($erros["telefone"]); ?>
      <input maxlength="20" size="20" name="telefone" value="<?=$usuario->telefone?>"></td>
    </tr>
    <?php 
    if ($admin) {
    ?>
    <tr>
      <th>Privilégio</th>
      <td><?php msg_erro ($erros["privilegio"]); ?>
      <select name="privilegio">
      <?php
      gera_option (array ("I" => "Inscrito",
			  "M" => "Membro", 
			  "A" => "Administrador"), $usuario->privilegio);
      ?>
      </select>
      </td>
    </tr>
    <?php 
    } 
    ?>
  </tbody>
</table>
<button name="enviar_usuario">Enviar</button><br>
</form>
<?php 
} // form_usuario

// Exibe um formulário para busca de usuários por nome e/ou login
// $acao = url do script que vai processar o formulário.
// $usuario = instancia da classe usuario com os valores default.
function form_busca_usuario ($acao,$usuario) {
?>
<form method="post" action="<?=$acao?>" name="formusuario">
<table class="formulario" border="0" cellpadding="10" cellspacing="0">
  <tbody>
    <tr>
      <th>Nome</th>
      <td>
      <input maxlength="80" size="60" value="<?=$usuario->nome?>" name="nome"></td>
    </tr>
    <tr>
      <th>Login</th>
      <td>
      <input name="login" maxlength="30" size="30" value="<?=$usuario->login?>"></td>
    </tr>
  </tbody>
</table>
<button name="enviar_busca_usuario">Enviar</button><br>
</form>
<?php 
} // form_busca_usuario
?>