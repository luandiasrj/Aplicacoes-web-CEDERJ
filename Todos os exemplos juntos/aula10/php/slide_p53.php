<html>
<head>
<title>Exemplo simples em Javascript</title>
<script type="text/javascript">

function contembrancos(s)
{
   for (var i=0; i < s.value.length; i++)
   {
      var c = s.value.charAt(i);
      if ((c==' ') || (c=='\n') || (c=='\t'))
      {
         alert('O campo não deve conter espaços em branco');
         return false;
      }
   }
   return true;
} 

</script>
</head>
<body>
<h2> Form para entrada de username </h2>
<form onSubmit="return(contembrancos(this.username));"
      method="post" action="teste.php">
 <input type="text" name="username" size=10>
 <input type="submit" value="SUBMIT">
</form>
</body>
</html>
     
