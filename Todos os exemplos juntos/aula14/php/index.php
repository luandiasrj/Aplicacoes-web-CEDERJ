<?php include ('sessao.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"  http-equiv="content-type">
  <title>Aplicação de Biblioteca</title>
  <link rel="stylesheet" href="estilos.css" type="text/css">
</head>
<body>
<table style="text-align: left; width: 100%;" border="0" cellpadding="2"
 cellspacing="0">
  <tbody>
    <tr align="center">
      <td colspan="2" style="background-color: rgb(0, 0, 102); color: rgb(255, 255, 153);">
      <h1>Cederj - Programação II</h1>
      <h1>Aplicação de Biblioteca</h1>
      </td>
    </tr>
    <tr>
      <td class = "colunaMenu">
	<?php include ("menu.php");?>
      </td>
      <td class="colunaPrincipal">
         <div class="areaPrincipal">
	<?php include ('principal.php');?>
	</div>
      </td>
    </tr>
    <tr>
      <td colspan="2" style="background-color: rgb(0, 0, 102);"></td>
    </tr>
  </tbody>
</table>
<br>
</body>
</html>
