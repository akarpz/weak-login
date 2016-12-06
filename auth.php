
<?php
//I96rB0H4SsfDMnPr6_zROUzZ
    function salter($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
    }
    
    $mysalt = salter;
    
    function secure($password,$salt, $iter){
       $temp = hash("sha256","0".$password.$salt);
       for($i=0;$i<$iter-1;$i++){
           $temp = strtoupper(hash("sha256",$temp.$password.$salt));
       }
       return $temp;
   }
   $db = new SQLite3('auth.sqlite');
   $inputusername = $_REQUEST["username"];
   $inputpass = $_REQUEST["password"];
   $users= $db->query("select username from users");
   $numrows = $db->querySingle("select count(username) from users");
   $flag=0;
   $allusers = [];
   for($i=0;$i<$numrows;$i++){
       $allusers[$i]=$users->fetchArray();
       $allusers[$i]=$allusers[$i][username];
       if($inputusername==$allusers[$i]){
           $flag=1;
       }
   }
   if($flag==1){
       $dbpass = $db->querySingle("select hashed from users where username='$inputusername'");
       $dbsalt = $db->querySingle("select salt from users where username='$inputusername'");
       $dbstretch = $db->querySingle("select stretch from users where username='$inputusername'");
   }else{
       $dbname="NOT IN DATABASE";
       $dbpass="NOT IN DATABASE";
       $dbsalt=0;
       $dbstretch=0;
   }
   $google_email = $_POST["single_val"];
   print_r($google_email);
   
   if ($flag==1 && $dbpass == secure($inputpass,$dbsalt,$dbstretch)) {
      $_SESSION["logged_in"] = true;
      $output = secure("pass123",$mysalt,20000);
      $lengthof = strlen($output);
      echo "SUCCESS";
      //echo $lengthof;
   } else {
      $_SESSION["logged_in"] = false;
      header("Location: index.html"); /* Redirect browser */
      exit();
   }
   
   
?>
