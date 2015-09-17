<?php

include "include/app_top_admin.php";

// check for permission to edit
if ( isset($_REQUEST["pageID"]) ) {
 $qs = "SELECT id
        FROM User
        WHERE username=:username"; 
 $userID = 0;       
 $rows = mcmSelectQuery( $qs, array('username'=>$_SESSION["username"]) );
 if ( count($rows) )
   $userID = $rows[0]['id'];
 if (!$_SESSION["admin"]) {
   $qs = "SELECT 1
          FROM Permission
          WHERE contentID=:contentID AND
                  userID=:userID"; 
   $params = array(
     'contentID'=>$_GET["pageID"],
     'userID'=>$userID
   );               
   $rows = mcmSelectQuery($qs, $params);
   if ( count($rows) == 0 )
      die('You do not have permission to edit this page!');               
 }
 // admin can edit any page
}

function isSelected($a, $b) {
  if ($a == $b)
     return " selected";    
  return '';
}


$showForm = 0;
$success = 0;
if ( isset($_POST['backupID']) ) {

 // get backup
 $qs = "SELECT content
        FROM Revision_Log
        WHERE id=:id";
 $content = '';       
 $rows = mcmSelectQuery( $qs, array('id'=>$_POST['backupID']) );
 if ( count($rows) )
   $content = $rows[0]['content'];
 
 // restore
 $qs = "UPDATE Content
        SET content=:content
        WHERE id=:id";
 $params = array(
   'content'=>$content,
   'id'=>$_POST['pageID']
 );
 mcmQuery($qs, $params);
 $success = 1;
 
 // also give "success" message
}
else
   $showForm = 1;
?>
<html>
<head>
<title>Restore Backup</title>
</head>
<body>
<?php

include "include/links.php";

if ($showForm) {
?>
 <form method="post">
  <select name="backupID" 
          id="backupID"
          onchange="window.location.href='restoreBackup.php?pageID=<?=(int)$_REQUEST["pageID"]?>&amp;backupID='+document.getElementById('backupID').value;">
     <option value="">Select a Backup</option>
   <?php
   $qs = "SELECT id, revisionDateTime
          FROM Revision_Log
          WHERE contentID=:contentID
          ORDER BY revisionDateTime DESC";
   $rows = mcmSelectQuery( $qs, array('contentID'=>$_GET['pageID']) );
   foreach ($rows as $r) {
     $backupID = $r['id'];
     $dt = $r['revisionDateTime'];
   ?>
     <option value="<?=$backupID?>" <?=isSelected($backupID, $_GET['backupID'])?>><?=$dt?></option>
   <?php
   }
   ?>
  </select>
<?php
  if ( isset($_GET['backupID']) ) {
     // get and show contents of selected revision w/ this backupID
     $qs = "SELECT content
            FROM Revision_Log
            WHERE id=:id";
     $content = '';
     $rows = mcmSelectQuery( $qs, array('id'=>$_GET['backupID']) );
     if ( count($rows) )
       $content = $rows[0]['content'];
     ?>
     <br />
     <strong>Content:</strong> <?=$content?>    
     <br />
     <br />
     <input type="hidden" name="pageID" value="<?=(int)$_REQUEST["pageID"]?>" />
     <input type="submit" value="Restore this Backup" /> 
     <?php
  } 
?>
 </form>
<?php
}
else if ($success) {
?>
  <h3>Backup Restored</h3>
<?php
}
?> 

</body>

</html>