<?php
//
// Gera tags do tipo <option> para um campo <select>
// $opcoes = array cujas chaves s�o os atributos value e cujos valores
//           s�o os valores de cada tag
// $default = chave default que deve estar selecionada inicialmente
//
function gera_option ($opcoes, $default=null) {
    foreach ($opcoes as $chave=>$valor) {
	// Se chave � um numero, usar o valor como chave
	if (is_numeric($chave)) $chave = $valor;
        echo "<option value='$chave' " .
           ($chave==$default?"selected=1 ":" ") .
           "> $valor </option>\n";
    }
}

//
// Gera html para uma mensagem de erro.
// $msg = texto da mensagem.
function msg_erro ($msg) {
  if (isset ($msg)) {
    echo "<font color='#FF0000'>$msg</font> <br>";
  }
}

// Gera um bot�o com um link.
// $msg = r�tulo do bot�o.
// $link = endere�o do link.
function botao ($msg,$link) {
    echo "<span class='botao'>" .
         "<a href='$link'> $msg </a>" .
	 "</span>";
}

// Gera um link para retornar � p�gina principal.
function link_pagina_principal () {
   botao ("Retornar � p�gina principal", "index.php");
}

// Exibe um array como uma linha de tabela html. 
// $array = array a formatar.
// $header = se verdadeiro, gera cabecalhos de tabela.
function linha_tabela ($array,$header=false) {
    echo "<tr>\n";
    foreach ($array as $linha) {
	echo $header?"<th>":"<td>";
	if (is_array ($linha)) {
	    echo implode ("<br>", $linha);
	} else {
	    echo $linha;
	}
	echo $header?"</th>":"</td>";
    }
    echo "</tr>\n";
}
?>