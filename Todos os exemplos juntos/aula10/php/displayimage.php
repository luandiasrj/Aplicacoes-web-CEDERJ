<?php
 include "error.inc";
 $idlivro = $_GET["idlivro"];
 //if (empty($idlivro)) exit;
 $host = $_SERVER["REMOTE_ADDR"];
 if (!($con = @mysql_connect($host,"aluno","aluno")))
    die("Não pôde abrir conexão com BD");
 if(!mysql_select_db("prog2",$con))
    ExibeErro();
 $consulta = "select fotocapa from livros where idlivro=$idlivro";
 if (!($resultado = @mysql_query($consulta,$con)))
    ExibeErro();
 $data = @mysql_fetch_array($resultado);
 if (!empty($data["fotocapa"])) {
    header("Content-Type: image/gif");
    echo $data["fotocapa"];
 }
?>