<?php
// Executa uma ação dependendo do valor de $_GET['acao']
switch (@$_GET['acao']) {
    case 'login': 
	include ('login.php');
	break;
    case 'loginok': 
	include ('loginok.php');
	break;
    case 'loginfalhou': 
	include ('loginfalhou.php');
	break;
    case 'logout';
	include ('logout.php');
	break;
    case 'logoutok':
	include ('logoutok.php');
	break;
    case 'cadastrar': 
	include ('cadastrar.php');
	break;
    case 'dadospessoais';
	include ('dadospessoais.php');
	break;
    case 'buscar';
	include ('buscar.php');
	break;
    case 'solicitar':
	include ('solicitar.php');
	break;
    case 'consultar':
	include ('consultar.php');
	break;
    case 'entregar':
 	include ('entregar.php');
	break;
    case 'devolver':
 	include ('devolver.php');
	break;
    case 'cadastrarlivro':
 	include ('cadastrarlivro.php');
	break;
    case 'editarlivro':
 	include ('editarlivro.php');
	break;	
    case 'editarcadastrolivro':
 	include ('editarcadastrolivro.php');
	break;	
    case 'removerlivro':
 	include ('removerlivro.php');
	break;
    case 'alterarusuario':
 	include ('alterarusuario.php');
	break;
    case 'autorizarusuario':
 	include ('autorizarusuario.php');
	break;
    case 'removerusuario':
 	include ('removerusuario.php');
	break;
      default:
	include ('default.php');
	break;
}
//} else include ('default.php'); 
?>
<br><br>