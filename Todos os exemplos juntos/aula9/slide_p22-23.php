<html>
<head><title> formatacao</title></head>
<body><pre>
<?php
  $con = mysql_connect($_SERVER["REMOTE_ADDR"],"aluno","aluno");
  mysql_select_db("prog2",$con);
  $res = mysql_query("SELECT * FROM cliente LIMIT 1", $con);
  print str_pad("Field",20).str_pad("Type",14).
        str_pad("Null",6).str_pad("Key",5).
        str_pad("Extra",12)."\n";
  for ($i=0;$i<mysql_num_fields($res);$i++)
  {
     $info = mysql_fetch_field($res);
     print str_pad($info->name, 20);
     print str_pad($info->type, 6);
     print str_pad("(".$info->max_length.")",8);
    
     if ($info->not_null != 1) print "YES";
     else print str_pad("",6);

     if ($info->primary_key == 1) print "PRI";
     elseif ($info->multiple_key == 1) print "MUL";
     elseif ($info->unique_key == 1) print "UNI";

     if ($info->zerofill) print "Zero filled";
     print "\n";
  }
  mysql_close($con);
?></pre>
</body>
</html>

