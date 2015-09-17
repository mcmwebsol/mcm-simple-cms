<?php

include "include/app_top_admin.php";

include "include/links.php";

if (!$_SESSION["admin"]) {
   die('You do not have access to this page!');
}

$action = $_GET["action"];
$userID = $_GET["userID"];
$contentID = $_GET["pagename"];

if ($action == "add") {

   // insert query
   $qs = "INSERT INTO Permission (contentID, userID) 
          VALUES (:contentID, :userID)";
   $params = array('contentID'=>$contentID,
                   'userID'=>$userID);
   mcmQuery($qs, $params);       
?>
<h3>
   New permission was added
</h3>
<?php
}
else { // edit

   $permIDStr = $_GET["permIDStr"];

   $permArr = explode(",", $permIDStr);

   $debug = 0;

   foreach ($permArr as $perm) {
   
       if ($perm == "")
          continue;
   
       $perm = trim($perm);
   
       $permissionID = $perm; 
       
       if ($debug)
          print "permissionID=$permissionID<br>";
       
       $enable = $_GET["permissions_$perm"];
       
       $this_userID = $userID;
       if (!$enable)
          $this_userID = 0;
   
       $qs = "UPDATE Permission
              SET userID=:userID
              WHERE id=:id";
       $params = array('id'=>$permissionID, 'userID'=>$this_userID);
       mcmQuery($qs, $params);       
   }       

?>
<h3>
    Your changes were saved
</h3>
<?php

}

?>