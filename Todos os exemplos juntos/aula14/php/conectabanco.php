<?php
$servidor = $_SERVER["REMOTE_ADDR"];
$conexao = mysql_connect($servidor,"aluno","aluno"); 

// Asseguro que a conexao ao banco de dados foi bem sucedida
if (!mysql_select_db("prog2", $conexao)) {
    echo "<h2> N�o foi poss�vel se conectar ao banco de dados. </h2>\n";
    echo "<p> Assegure-se de que o banco de dados do sistema de bibliotecas".
         " est� dispon�vel na m�quina $servidor </p>";
    exit;
}

?>