<?php

include "include/app_top_admin.php";

include "include/links.php";


if (!$_SESSION["admin"]) {
   die('You do not have access to this page!');
}


$id = $_GET["userID"];
$userID = $id

// list permissions for user


?>

<h3>Existing Permissions</h3>

<form action="savePermissions.php">

<table cellpadding=5 border=1>
<tr>
      <td>Username</td><td>Page Name</td><td>Permissions</td>
</tr>

<?php
$qs = "SELECT username, pageName, Permission.id as permissionID, Permission.userID as userID, Permission.contentID, Content.id as contentID 
       FROM User, Permission, Content
       WHERE Permission.userID=:userID AND contentID=Content.id AND Permission.userID=User.id AND
              User.admin!=1";
$rows = mcmSelectQuery( $qs, array('userID'=>$userID) );

$permIDStr = "";

foreach ($rows as $r) { 
  $username = $r['username']; 
  $pagename = $r['pageName'];
  $permissionID = $r['permissionID'];
  $permIDStr .= "$permissionID, ";   
?>

  <tr>
      <td><?=$username?></td>
      
      <td><?=$pagename?></td>
      
      <td>
          <select name="permissions_<?=$permissionID?>">
            <option value="1" selected>Access Allowed
            <option value="0">Access Denied
          </select>
      </td>
  </tr>    

<?php

} // end foreach
?>

<tr>
    <td colspan=3>
         <input type="hidden" name="userID" value="<?=$userID?>" />
         <input type="hidden" name="permIDStr" value="<?=$permIDStr?>" />
         <input type="submit" value="Save Changes" />
    </td>
</tr>
</table> 

</form>

<br>
<br>
<br>

<h3>Add a New Permission</h3>

<!--page name-->
<form action="savePermissions.php">
   <select name="pagename">
<?php
$qs = "SELECT id, pageName 
       FROM Content";
$rows = mcmSelectQuery($qs);
foreach ($rows as $r) { 
  $pageID = $r['id']; 
  $pagename = $r['pageName'];

?>   
     <option value=<?=$pageID?>><?=$pagename?>
<?php
} // end foreach
?>                    
   </select>
   <input type="hidden" name="action" value="add" />
   <input type="hidden" name="userID" value="<?=$userID?>" />
   <input type="submit" value="Add New Permission" />
</form>
