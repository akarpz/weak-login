<?php
function secure($password,$salt, $iter){
    $temp = hash("sha256","0".$password.$salt);
    for($i=0;$i<$iter-1;$i++){
        $temp = strtoupper(hash("sha256",$temp.$password.$salt));
    }
    return $temp;
}
$db = new SQLite3('auth.sqlite');
$inputusername = $_POST["username"];
$dbsalt = $db->querySingle("select salt from users where username='$inputusername'");
$dbstretch = $db->querySingle("select stretch from users where username='$inputusername'");
$newpass = $_POST["newpass"];
$newhashed = secure($newpass,$dbsalt,$dbstretch);
$db->exec("UPDATE USERS SET HASHED = '$newhashed' WHERE username = '$inputusername'");
echo "Success! Your new password is {$newpass}, try to remember it this time!";


//header("Location: index.html");

?>
