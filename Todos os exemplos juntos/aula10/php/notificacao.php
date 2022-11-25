<html>
<head> <title>Notificação</title>
</head>
<body bgcolor="white">
<?php          
// notificacao.php                                                
   include "error.inc";
   include "clean.inc";
   $host = $_SERVER["REMOTE_ADDR"];
   $idlivro = $_GET["idlivro"];
   $status = $_GET["status"];
   $idlivro = clean($idlivro,4);
   $status = clean($status,2);
   switch ($status) // operação foi bem sucedida?
   {
      case "T": // operação bem sucedida, apenas mostra res
        $consulta = "SELECT * FROM livros WHERE idlivro=".$idlivro;
        // if (!($con = @mysql_connect($host,"aluno","aluno")))
        if(!($con = mysqli_connect($host,"aluno","aluno","prog2")))
           die("Não pôde conectar ao BD");
        // if (!mysql_select_db("prog2",$con))
        if (!mysqli_select_db($con,"prog2"))
          ExibeErro();
        // if (!($res = @mysql_query($consulta,$con)))
        if (!($res = mysqli_query($con,$consulta)))
          ExibeErro();
        // if ($row = @mysql_fetch_array($res)) {
        if ($row = mysqli_fetch_array($res)) {
            echo "O seguinte título foi adicionado ao BD: ";
            echo $row["titulo"];
	    echo "\n<br><img src=\"displayimage.php?idlivro=$idlivro\">";
//            header("Content-Type: image/gif");
//	    $foto = $row["fotocapa"];
//	    $arq = fopen("/tmp/xxx.gif","w");
//            fwrite($arq, $foto);
//	    echo "\n<br><img src=\"http://localhost/~kurumin/xxx.gif\">";
//            echo "sera que executou o displayimage?";
        }
        break;
      case "F":
         echo "A operação de inserção falhou! Tabela precisa ser criada.";
         break;
      default:
         echo "Erro inesperado";
   }
?>
</body>
</html>
