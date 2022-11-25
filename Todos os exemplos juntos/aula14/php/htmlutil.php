<?php
//
// Gera tags do tipo <option> para um campo <select>
// $opcoes = array cujas chaves são os atributos value e cujos valores
//           são os valores de cada tag
// $default = chave default que deve estar selecionada inicialmente
//
function gera_option ($opcoes, $default=null) {
    foreach ($opcoes as $chave=>$valor) {
	// Se chave é um numero, usar o valor como chave
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

// Gera um botão com um link.
// $msg = rótulo do botão.
// $link = endereço do link.
function botao ($msg,$link) {
    echo "<span class='botao'>" .
         "<a href='$link'> $msg </a>" .
	 "</span>";
}

// Gera um link para retornar à página principal.
function link_pagina_principal () {
   botao ("Retornar à página principal", "index.php");
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