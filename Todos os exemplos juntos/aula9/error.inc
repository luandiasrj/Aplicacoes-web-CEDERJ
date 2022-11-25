<?php
  function ExibeErro()
  {
     echo "Erro número: ".mysql_errno().": ".mysql_error();
  }
?>