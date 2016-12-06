<?php
$db = new SQLite3('auth.sqlite');
$users= $db->query("select * from users");
$numrows = $db->querySingle("select count(username) from users");
$userpass = $_POST["single_val"];
$allusers = [];
$allusernames = [];
   for($i=0;$i<$numrows;$i++){
       $allusers[$i]=$users->fetchArray();
       $allusernames[$i]=$allusers[$i][username];
       if($userpass==$allusernames[$i]){
           echo $allusers[$i][question];
       }
   }


   //header("Location: index.html");

?>
