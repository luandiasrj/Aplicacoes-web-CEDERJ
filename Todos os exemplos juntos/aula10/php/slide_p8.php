<?php
  include "error.inc";
  include "clean.inc";
  if (empty($_POST["titulo"]) || empty($_POST["descricao"]))
  {
?>
     <html>
     <head>
       <title> Inserção de novos dados </title>
     </head>
     <body>
     <form enctype="multipart/form-data"
           action="slide_p8.php" method="post">
     Novo título:
     <br><input type="text" name="titulo" size=80>
     <br> Descrição:
     <br> <textarea name="descricao" rows=4 cols=80></textarea>
     <input type="hidden"
       name="MAX_FILE_SIZE" value="100000">
     <br> Capa (formato GIF):
     <input name="capa" type="file">
     <br><input type="submit">
     <form> </body> </html>
<?php
  } else {
     $titulo = $_POST["titulo"];
     $descricao = $_POST["descricao"];
     $capa = $_FILES["capa"]["tmp_name"];
//     $filetype = $FILES["capa"]["type"];
     $titulo = clean($titulo,50);
     $descricao = clean($descricao,2048);
     $host = $_SERVER["REMOTE_ADDR"];
     // if (!($con = @mysql_connect($host,"aluno","aluno")))
     if (!($con = @mysqli_connect($host,"aluno","aluno","prog2")))
        die("Não pode conectar ao banco de dados");
     // if(!mysql_select_db("prog2",$con))  
     //    ExibeErro();
     if (is_uploaded_file($capa)) 
     {
//        echo "Um arquivo foi uploaded.\n";
        $arquivo = fopen($capa,"r");
        $arqconts = fread($arquivo,filesize($capa));
        $arqconts = AddSlashes($arqconts);
     } else {
        $arqconts = NULL;
     }
     $createTableLivros = "create table if not exists livros (idlivro int key auto_increment, titulo varchar(80), descricao varchar(100), fotocapa longblob);";
     // if ((!(@mysql_query($createTableLivros,$con)))) {
       if ((!(@mysqli_query($con,$createTableLivros)))) {
        echo "Erro ao criar tabela.<br>";
        exit;
     }
//     $id = mysql_insert_id($con);
     $inseredado = "INSERT INTO livros (titulo,descricao,fotocapa) VALUES ("."\"$titulo\"".","."\"$descricao\"".","."\"$arqconts\"".")";
     // if ((@mysql_query($inseredado,$con)) && @mysql_affected_rows() == 1)
       if ((@mysqli_query($con,$inseredado)) && @mysqli_affected_rows($con) == 1)
        // header("Location: notificacao.php?"."idlivro=".mysql_insert_id($con)."&status=T");
        header("Location: notificacao.php?"."idlivro=".mysqli_insert_id($con)."&status=T");
     else
        header("Location: notificacao.php?"."status=F");
  }
?>
