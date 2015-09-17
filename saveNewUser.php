<?php

include "include/app_top_admin.php";

include "include/links.php";


if (!$_SESSION["admin"]) {
   die('You do not have access to this page!');
}



$username = $_POST["username"];
$password = $_POST["password"];

// escape and use salted SHA1 password
$qs = "INSERT INTO User (username, password) 
       VALUES (:username, 
               :password)";
$params = array(
  'username'=>$username,
  'password'=>sha1($saltVal.$_POST['password'])
);
mcmQuery($qs, $params);

?>

<h3>User Added</h3>
