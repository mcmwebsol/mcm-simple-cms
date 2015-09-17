<?php

include "include/app_top_admin.php";

// check for permission to edit
if ( isset($_GET["pageID"]) ) {
 $qs = "SELECT id
        FROM User
        WHERE username=:username";
 $rows = mcmSelectQuery( $qs, array('username'=>$_SESSION["username"]) );
 $row = array();
 if ( count($rows) )
   $row = $rows[0];
 $userID = $row['id'];
 if (!$_SESSION["admin"]) {
   $qs = "SELECT 1
          FROM Permission
          WHERE contentID=:contentID AND
                  userID=:userID";
   $params = array(
     'contentID'=>$_GET["pageID"],
     'userID'=>$userID
   );
   $rows2 = mcmSelectQuery($qs, $params);
   if ( !count($rows2) )
      die('You do not have permission to edit this page!');               
 }
 // admin can edit any page
}

 include "include/links.php";
?>
<script language="javascript" type="text/javascript" src="include/tiny_mce/tinymce.min.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
   selector: "textarea",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste moxiemanager"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
	  extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style],form[name|id|action|method|enctype|accept-charset|onsubmit|onreset|target|style|class|summary],input[src|target|border|type|name|value|alt]",
	  external_image_list_url : "data/image_list.php",
});
</script>
<?php

   // add or edit a page


  


   function getVars($id) {

      $qs = "SELECT content
             FROM Content
             WHERE id=:id";
      $rows = mcmSelectQuery( $qs, array('id'=>$id) );
      $row = array();
      if ( count($rows) )
        $row = $rows[0];
      $content = $row['content'];

      return $content;

   }



   $id = $_GET["pageID"];


   $content = getVars($id);



   $submitButtonText = "Save Changes";


   $pageName = "";

if ( isset($_GET["pageID"]) ) {

   $pageID = $_GET["pageID"];

   $qs = "SELECT content
          FROM Content
          WHERE id=".(int)$id;
   $rows = mcmSelectQuery( $qs, array('id'=>$id) );
   $row = array();
   if ( count($rows) )
     $row = $rows[0];
   $content = $row['content'];
   
   $metaTitle = getMetaAndTitleFromID($id);

   $submitButtonText = "Save Changes";

}
else {

   $pageName = $_GET["pageName"];
   $submitButtonText = "Add New Page";

}


   // links at top of page
   //include "include/links.php";

?>

<br />

<?php
 // restore backup link if there are any backup(s) for this page
 $qs = "SELECT revisionDateTime
        FROM Revision_Log
        WHERE contentID=:contentID";
 $rows = mcmSelectQuery( $qs, array('contentID'=>$id) );
 if ( count($rows) ) {
?>
<a href="restoreBackup.php?pageID=<?=(int)$id?>">Restore Backup</a>
<br />
<br />
<?php
 }       
        
?>



<iframe src="photos.php" width="100%" height="200" border=0></iframe>

<br />

<form action="save.php" method="POST">
<table cellspacing=10 align="center">
       <td colspan=2 align="center">

          <textarea name="content" cols="100" rows="37"><?=$content?></textarea>
      </td>
  </tr>
  <tr>
       <td>
         Meta Description (255 characters max)
       </td>
       <td>   
          <input type="text" name="metaDescription" size="100" maxsize="255" value="<?=$metaTitle['metaDescription']?>" />
      </td>
  </tr>
  <tr>
      <td>
         Meta Keywords (255 characters max)
       </td>
       <td> 
          <input type="text" name="metaKeywords" size="100" maxsize="255" value="<?=$metaTitle['metaKeywords']?>" />
      </td>
  </tr>
  <tr>
      <td>
         Title Tag (255 characters max)
       </td>
       <td> 
          <input type="text" name="titleTag" size="100" maxsize="255" value="<?=$metaTitle['titleTag']?>" />
      </td>
  </tr>
  <tr>
      <td colspan=2 align="left">
          <input type="submit" value="<?=strip_tags($submitButtonText)?>">
      </td>
  </tr>

</table>
<input type="hidden" name="id" value="<?=strip_tags($id)?>">
<?php
    if ( isset($_GET["pageID"]) ) {
?>
<input type="hidden" name="myaction" value="edit">
<?php
    }
    else {
?>
<input type="hidden" name="pageName" value="<?=strip_tags($pageName)?>">
<?php
    }
?>
</form>

</body>

</html>