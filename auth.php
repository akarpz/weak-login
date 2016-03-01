<?php
   $username = $_REQUEST["username"];
   $pwd = $_REQUEST["password"];
   if ($username == "andy" && $pwd == "rules") {
      $_SESSION["logged_in"] = true;
      echo "You logged in!";
   } else {
      $_SESSION["logged_in"] = false;
      header("Location: index.html"); /* Redirect browser */
      exit();
   }
?>