<?php

include "include/app_top_admin.php";

include "include/links.php";


if (!$_SESSION["admin"]) {
   die('You do not have access to this page!');
}

// list users
?>
<form action="permissions.php">
   Edit Permissions for User: <select name="userID">

<?php

$qs = "SELECT id, username FROM User WHERE admin!=1";
$rows = mcmSelectQuery($qs);
foreach ($rows as $r) { 
  $userID = $r['id'];
  $username = $r['username'];
?>

     <option value="<?=$userID?>"><?=$username?>

<?php

} // end foreach
?>              
   </select>
   <input type="submit" value="Edit Permissions" />
</form>
<br>
<br>
<br>
<h3>Add a New User</h3>
<?php
  // add a new user
?>
<form action="saveNewUser.php" method="post">
  Username: <input type="text" name="username" />
  <br>
  Password: <input type="password" name="password" />
  <br>
  <input type="submit" value="Add New User" />
</form>
