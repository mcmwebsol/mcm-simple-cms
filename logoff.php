<?php
@session_start();

$_SESSION['isloged'] = NULL;
$_SESSION['username'] = NULL;
$_SESSION['admin'] = NULL;

$_SESSION = array();
session_destroy();
header("Location: login.php");
exit();
?>