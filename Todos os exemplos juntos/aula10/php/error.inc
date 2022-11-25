<?php
  function ExibeErro()
  {
     // echo "Erro número: ".mysql_errno().": ".mysql_error();
     echo "Erro número: ".mysqli_errno().": ".mysqli_error();
     exit();
  }
?>