<!DOCTYPE html>
 <head>
   <title>Admin Area</title>
 </head>
<body> 
<a href="selectPageToEdit.php">Edit Pages</a>

&nbsp;

<a href="menu.php">Menus</a>

&nbsp;

<a href="photos.php" target="_blank">Upload Files</a>

&nbsp;

<a href="urlFinder.php" target="_blank">Link Tool</a>

&nbsp;

<?php
if ($_SESSION["admin"]) {
?>
<a href="manageUsers.php">Manage Users</a>

&nbsp;

<a href="setConfig.php">Configuration</a>

&nbsp;

<?php
}
?>
<a href="logoff.php">Log off</a>
<br />
<br />
