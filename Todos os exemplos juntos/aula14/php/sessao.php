<?php
header("Content-Type: text/html; charset=ISO-8859-1");

// Configura��es globais
require_once ('globais.php');

// O sistema de bibliotecas requer acesso ao banco de dados
require_once ('conectabanco.php');

// Algumas fun��es �teis para formatacao de html
require_once ('htmlutil.php');

// Para poder armazenar objetos em $_SESSION � preciso definir
// suas classes antes de abrir a sess�o
require_once ('solicitacao.php');
require_once ('emprestimo.php');
require_once ('usuario.php');
require_once ('livro.php');

// Abrir sess�o
session_start ();

// Inibir notices em algumas instalacoes onde php.ini 
// permite todas as mensagens notificacao
error_reporting(E_ALL &~ (E_NOTICE));

// A fun��o assegura_privilegio deve ser chamada por qualquer m�dulo que
// necessite de um privil�gio m�nimo de maneira a impedir
// a execu��o por usu�rios n�o credenciados.
// $privilegio = 'M' ou 'A' identificando pril�gio de membro
//               ou administrador
function assegura_privilegio ($privilegio) {
    if ($_SESSION['privilegio'] != 'A' &&
	$_SESSION['privilegio'] != $privilegio) {
	echo ('<h2> Acesso a esta parte do sistema � proibida a n�o membros ou a n�o administradores. Por favor pe�a cadastramento ou fa�a login. Se n�o possuir login, solicite cadastramento. </h2>');
	exit;
    }
}

// Asseguro que vari�vel $_SESSION['privilegio'] tem algum valor,
// pelo menos o do privil�gio default que � 'I':
if (!isset ($_SESSION['privilegio'])) $_SESSION['privilegio'] = 'I';

?>
