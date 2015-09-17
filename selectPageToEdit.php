<?php

include "include/app_top_admin.php";

include "include/links.php";

?>
<h3>Edit Page</h3>
<form action="ae.php">
 <select name="pageID">


<?php
  $qs = "SELECT id
         FROM User
         WHERE username=:username"; 
  $rows = mcmSelectQuery( $qs, array('username'=>$_SESSION["username"]) );       
  $row = array();
  if ( count($rows) )
    $row = $rows[0];
  $userID = $row['id'];

  // pull page names from database (ONLY SHOW PAGES USER HAS PERMISSION TO EDIT)
  $params = array();
  if (!$_SESSION["admin"]) {
     $qs = "SELECT Content.id, pageName
            FROM Content, Permission
            WHERE Permission.contentID=Content.ID AND
                  userID=:userID"; //$userID;
     $params = array('userID'=>$userID);             
  }
  else { // admin
     $qs = "SELECT Content.id, pageName
            FROM Content";
  }
  $rows = mcmSelectQuery( $qs, $params );    
  foreach ($rows as $row) {
    $id = $row['id']; 
    $pageName = $row['pageName'];
?>
        <option value="<?=$id?>"><?=$pageName?>
<?php
  }
?>
 </select>
 <input type="submit" value="Edit Page">
</form>
<br />
<br />
<br />
<h3>Add New Page</h3>
<form action="ae.php">
Name of New Page: <input type="text" name="pageName" />
<input type="submit" value="Add New Page" />
</form>
<br />
<br />
<br />
<h3>Delete Page</h3>
<form action="delete.php">
<select name="id">
<?php
// list pages in DB
$qs = '';
if ($_SESSION["admin"]) {
   $qs = "SELECT id, pageName, content FROM Content ORDER BY pageName";
}
$rows = mcmSelectQuery($qs);
foreach ($rows as $row) {
  $id = $row['id']; 
  $pageName = $row['pageName'];
  $content = $row['content'];
?>
  <option value="<?=$id?>"><?=$pageName?>
<?php

} // end foreach
?>
</select>
<input type="submit" value="Delete Selected Page" />
</form>         