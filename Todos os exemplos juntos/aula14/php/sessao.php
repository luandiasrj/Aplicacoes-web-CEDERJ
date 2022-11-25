<?php
header("Content-Type: text/html; charset=ISO-8859-1");

// Configurações globais
require_once ('globais.php');

// O sistema de bibliotecas requer acesso ao banco de dados
require_once ('conectabanco.php');

// Algumas funções úteis para formatacao de html
require_once ('htmlutil.php');

// Para poder armazenar objetos em $_SESSION é preciso definir
// suas classes antes de abrir a sessão
require_once ('solicitacao.php');
require_once ('emprestimo.php');
require_once ('usuario.php');
require_once ('livro.php');

// Abrir sessão
session_start ();

// Inibir notices em algumas instalacoes onde php.ini 
// permite todas as mensagens notificacao
error_reporting(E_ALL &~ (E_NOTICE));

// A função assegura_privilegio deve ser chamada por qualquer módulo que
// necessite de um privilégio mínimo de maneira a impedir
// a execução por usuários não credenciados.
// $privilegio = 'M' ou 'A' identificando prilégio de membro
//               ou administrador
function assegura_privilegio ($privilegio) {
    if ($_SESSION['privilegio'] != 'A' &&
	$_SESSION['privilegio'] != $privilegio) {
	echo ('<h2> Acesso a esta parte do sistema é proibida a não membros ou a não administradores. Por favor peça cadastramento ou faça login. Se não possuir login, solicite cadastramento. </h2>');
	exit;
    }
}

// Asseguro que variável $_SESSION['privilegio'] tem algum valor,
// pelo menos o do privilégio default que é 'I':
if (!isset ($_SESSION['privilegio'])) $_SESSION['privilegio'] = 'I';

?>
