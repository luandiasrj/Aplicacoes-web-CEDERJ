<?php
// 
// Preenche as tabelas livro, autor e escreveu com dados baseados na tabela tablivros
//
header("Content-Type: text/html; charset=ISO-8859-1");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" 
    "http://www.w3.org/TR/html4/loose.dtd" > 
<html> 
  <head><title>Criação das tabelas 'livro', 'escreveu' e 'autor'</title></head> 
  <body> 
      <h2> Criação das tabelas 'livro', 'escreveu' e 'autor' </h2>

<?php
$servidor = $_SERVER["REMOTE_ADDR"];
$conexao = mysql_connect($servidor,"aluno","aluno"); 
mysql_select_db("prog2", $conexao);
$consulta = mysql_query ("select * from tablivros") or die ("Erro consultando tablivros");
$autor_id = array(); // Associa nomes de autores com seus ids
$autor = array(); 
$livro = array();
$escreveu = array ();
$nidautor = 0;
for ($idlivro = 1; 
    ($linha = mysql_fetch_row($consulta)); $idlivro++) {
    list($titulo,$nomeautor,$genero,$ano)=$linha;
    if (!isset ($autor_id[$nomeautor])) {
	$nidautor++;
	$autor_id[$nomeautor]=$nidautor;
	$autor[] = array($nidautor,$nomeautor);
    }
    $idautor = $autor_id[$nomeautor];
    $livro[] = array($idlivro,$titulo,1,$genero,$ano);
    $escreveu[] = array($idlivro,$idautor);
}

echo "Inserindo livros <br>";
foreach ($livro as $row) {
    list($idlivro,$titulo,$exemplares,$genero,$ano) = $row;
    $consulta = "insert into livro value($idlivro,\"$titulo\",$exemplares,\"$genero\",$ano)";
    echo "$consulta<br>";
    mysql_query ($consulta) or die ("Erro inserindo livro");
}

echo "Inserindo autores <br>";
foreach ($autor as $row) {
    list ($id,$nome)=$row;
    $consulta = "insert into autor value($id,\"$nome\")";
    echo "$consulta<br>";
    mysql_query ($consulta) or die ("Erro inserindo autor");
}

echo "Inserindo escreveu <br>";
foreach ($escreveu as $row) {
    list ($idlivro,$idautor)=$row;
    $consulta = "insert into escreveu value($idlivro,$idautor)";
    echo "$consulta<br>";
    mysql_query ($consulta) or die ("Erro inserindo escreveu");
}

?>
    <h3>OK!</h3>
</body> 
</html>