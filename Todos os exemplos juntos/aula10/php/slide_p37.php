<?php
  include 'error.inc';  
  function AtualizaDesconto($idCliente, $IdItem, $desc, $min, $con)
  {
     echo "idcliente = $idCliente, iditem = $IdItem, min = $min<br>";
     $ok = false;
     // Lock todas as tabelas envolvidas nesta transação
     $cons = "LOCK TABLES itens READ, compras WRITE, cliente READ";
     if (!mysql_query($cons, $con))
        ExibeErro();
     echo "Tabelas estão locked!<br>";
     // Quanto o usuário gastou até o momento?
     $cons = "SELECT SUM(preco*qtde) FROM itens, compras, cliente WHERE cliente.id = compras.idCliente AND compras.IdItem = itens.IdItem AND compras.idItem =". $IdItem." AND cliente.id =".$idCliente;
     if (!($result = mysql_query($cons, $con))) ExibeErro();
     $row = mysql_fetch_array($result);
     // A qtde comprada é maior do que um mínimo?
     echo "valor de preco*qtde = ".$row["SUM(preco*qtde)"]."<br>";
     if ($row["SUM(preco*qtde)"] > $min) // se sim, dar desconto
     {
        $cons = "UPDATE compras SET desconto =".$desc."WHERE idCliente =".$idCliente." AND IdItem = ".$IdItem;
        if (!mysql_query($cons, $con)) ExibeErro();
        $ok = true;
     }
     $cons = "UNLOCK TABLES"; // Unlock tabelas
     if (!mysql_query($cons, $con)) ExibeErro();
     return $ok; // Retorna se desconto foi concedido ou não
  }  

// MAIN -----
  if (!($con = @ mysql_connect($_SERVER["REMOTE_ADDR"],"aluno","aluno")))
     die("Não pôde conectar ao DB");
  if (!mysql_select_db("prog2"))
     ExibeErro();
  // Dá um desconto de $4.95 ao cliente 653 na compra do item #2, se gastou mais de $10 
  $desc = AtualizaDesconto(653, 2, 4.95, 10, $con);
?>
<html>
<head>
  <title>Exemplo do uso de locks</title>
</head>
<body bgcolor="white">
<?php
  if ($desc == true)
     echo "<h4>Valor de compras maior do que 10. Cliente tem direito a um desconto de 4.95 no total de compras.</h4>";
  else
     echo "<h3>Sem desconto</h3>";
?>
</body>
</html>