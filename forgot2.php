<?php
$db = new SQLite3('auth.sqlite');
$users= $db->query("select * from users");
$numrows = $db->querySingle("select count(username) from users");
$userpass = $_POST["single_val"];
$allusers = [];
$allusernames = [];
   for($i=0;$i<=count($numrows);$i++){
       $allusers[$i]=$users->fetchArray();
       $allusernames[$i]=$allusers[$i][answer];
       if($userpass==$allusernames[$i]){
           echo $allusers[$i][hashed];
       }
   }


   //header("Location: index.html");

?>