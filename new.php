<?php
    function salter($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
    }
    
    $mysalt = salter();
    
    function secure($password,$salt, $iter){
       $temp = hash("sha256","0".$password.$salt);
       for($i=0;$i<$iter-1;$i++){
           $temp = strtoupper(hash("sha256",$temp.$password.$salt));
       }
       return $temp;
   }
   
   $db = new SQLite3('auth.sqlite');
   $stretch = 100;
   
   $inputusername = $_REQUEST["username"];
   $inputpass = $_REQUEST["password"];
   $inputpassrep = $_REQUEST["passwordrep"];
   $secretq = $_REQUEST["secretq"];
   $secreta = $_REQUEST["secreta"];
   $users= $db->query("select * from users");
   $numrows = $db->querySingle("select count(username) from users");
   $allusers = [];
   for($i=0;$i<$numrows;$i++){
       $allusers[$i]=$users->fetchArray();
       $allusers[$i]=$allusers[$i][username];
       if($inputusername==$allusers[$i]){
           echo "Username Taken!";
           die();
       }
   }
   if($inputpass!=$inputpassrep){
       echo "Passwords Must Match!";
   }
   if($inputusername==""){
       die();
   }
   
   $hashing = secure($inputpass, $mysalt, $stretch);
   $db->exec("INSERT INTO USERS VALUES ('$inputusername','$mysalt','$stretch','$hashing','$secretq','$secreta')");
   echo "SUCCESS";
   header("Location: index.html");
   die();
?>
   