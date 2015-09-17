<?php

   include "include/app_top_admin.php";

   include "include/links.php";




   function ls($__dir="./",$__pattern="*.*")
{
 settype($__dir,"string");
 settype($__pattern,"string");

 $__ls=array();
 $__regexp=preg_quote($__pattern,"/");
 $__regexp=preg_replace("/[\\x5C][\x2A]/",".*",$__regexp);
 $__regexp=preg_replace("/[\\x5C][\x3F]/",".", $__regexp);

 if(is_dir($__dir))
  if(($__dir_h=@opendir($__dir))!==FALSE)
  {
   while(($__file=readdir($__dir_h))!==FALSE)
   if(preg_match("/^".$__regexp."$/",$__file))
     array_push($__ls,$__file);

   closedir($__dir_h);
   sort($__ls,SORT_STRING);
  }

 return $__ls;
}



$action = $_POST["action"];


if ($action == "addMenuItem") {

$href = "";

$name = $_POST["name"];
$orderNum = $_POST["orderNum"];
$href = $_POST["href"];
$pageID = $_POST["pageID"];
$menuID = $_POST["menuID"];
$isHeader = intval($_POST["isHeader"]);

if ( $pageID > 0 ) {
   if ($config['USE_SEO_URLS'])
      $href=genSEOPageNameFromID((int)$pageID).'.html';
   else
      $href='index.php?act=$pageID';
}

$qs = "INSERT INTO Menu_Item (name, menuID, pageID, orderNum, isHeader, href)
       VALUES (:name,
                :menuID,
                 :pageID,
                  :orderNum,
                   :isHeader,
                    :href)";
$params = array(
  'name'=>$name, 
  'menuID'=>$menuID, 
  'pageID'=>$pageID, 
  'orderNum'=>$orderNum, 
  'isHeader'=>$isHeader, 
  'href'=>$href
);
mcmQuery($qs, $params);
?>
   <h3>Menu Item Added</h3>
<?php

}
if ($action == "addMenu") {

$href = "";

$name = $_POST["name"];
$orderNum = $_POST["orderNum"];
$href = $_POST["href"];
$pageID = $_POST["pageID"];
$linkFileDownloadable = $_POST["linkFileDownloadable"];


if ($pageID > 0) {
   if ($config['USE_SEO_URLS']) {
      $href=genSEOPageNameFromID((int)$pageID).'.html';
   }
   else
      $href = "index.php?act=$pageID";
}


$qs = "INSERT INTO Menu (name, orderNum, href)
       VALUES (:name,
                :orderNum,
                 :href)";
$params = array(
  'name'=>$name, 
  'orderNum'=>$orderNum, 
  'href'=>$href
);                 
mcmQuery($qs, $params);
?>
   <h3>Menu Added</h3>
<?php

}
else {

?>
<h3>Add New Menu</h3>
<form action="addMenu.php" method="POST">
 <input type="hidden" name="action" value="addMenu">
 Menu Name: <input type="text" name="name">
 <br>
 Menu Link (optional - what page you want to link the top of the menu to):
 <select name="pageID">
       <option value="0" selected>Select...
   <?php

     $qs = "SELECT id, pageName FROM Content ORDER BY pageName";
     $rows = mcmSelectQuery($qs);
     foreach ($rows as $row) {
       $pc_id = $row['id'];
       $pc_name =  $row['pageName'];
   ?>
       <option value="<?=$pc_id?>"><?=$pc_name?>
   <?php
     } // end foreach
   ?>
 </select>
 <br>
 &nbsp;Or enter the URL/link here:
 <input type="text" name="href">
 <br>
 Order Number (0 - leftmost, higher # further right):
 <input type="text" name="orderNum">
 <br>
 <input type="submit" value="Add New Menu">
</form>

<h3>Add New Menu Item</h3>
<form action="addMenu.php" method="POST">
 <input type="hidden" name="action" value="addMenuItem">
 Menu Item Name: <input type="text" name="name">
 <br>
 Menu Item Link (what page you want to link menu item to):
 <select name="pageID">
   <option value="0" selected>Select...
   <?php

     $qs = "SELECT id, pageName FROM Content ORDER BY pageName";
     $rows = mcmSelectQuery($qs);
     foreach ($rows as $row) {
       $pc_id = $row['id'];
       $pc_name = $row['pageName'];
   ?>
       <option value="<?=$pc_id?>"><?=$pc_name?>
   <?php
     } // end foreach
   ?>
 </select>
 <!--
 <br>
 &nbsp;Or select a file to link to here:
 <select name="linkFileDownloadable">
    <option value="0" selected>Select...
   <?php

     // list files in folder "/downloadable"
     $dirlist = array();

     $dirlist = ls($BASE_DIR."/images", "*");

     sort($dirlist);

     $max = 0;
     $max = count($dirlist);

     for ($i=0;$i<$max;$i++) {
         $my_down_filename = $dirlist[$i];
         if ( ($my_down_filename == ".") || ($my_down_filename == "..") )
            continue;
   ?>
       <option value="<?=$my_down_filename?>"><?=$my_down_filename?>
   <?php
     } // end loop

   ?>
 </select>
 -->
 <br>
 &nbsp;Or enter the URL/link here:
 <input type="text" name="href">
 <br>
 Menu to add to:
 <select name="menuID">
  <?php

    $qs = "SELECT id, name FROM Menu ORDER BY name";
    $rows = mcmSelectQuery($qs);
    foreach ($rows as $row) {
  ?>
       <option value="<?=$row['id']?>"><?=$row['name']?>
  <?php
    } // end foreach
  ?>
 </select>
 <br>
 Order Number (0 - topmost, higher # further down):
 <input type="text" name="orderNum">
 <br>
 <input type="submit" value="Add New Menu Item" />
</form>

<?php

} // end else

?>