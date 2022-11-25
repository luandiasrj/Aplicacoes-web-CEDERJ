<html>
<head>
<title> PHP: Express\&otilde;es Regulares </title>
</head>
<body>
<?php 
  echo ereg("^[A-Z].*", "O gato pulou do telhado"), "<br>";
  echo ereg("^[A-Z].*", "O"), "<br>";
  echo ereg("^[A-Z].*", ""), "<br>";
  echo ereg("^[0-9]{5}(\-[0-9]{3})?$","21920-030"), "<br>";
  echo ereg("^[0-9]{5}(\-[0-9]{3})?$","21920"), "<br>";
  echo ereg("^[0-9]{5}(\-[0-9]{3})?$","A2192"), "<br>";
  echo ereg("^[0-9]{5}(\-[0-9]{3})?$","30000"), "<br>";
?>
</body>
</hmtl>

