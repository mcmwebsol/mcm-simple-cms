<?php

   include "include/app_top_admin.php";

   include "include/links.php";

   function isSelected($currID, $id) {

      if ($currID == $id)
         return "selected";

   }


   $action = $_POST["action"];

   $id = $_POST["menuID"];

   $changesSubmitted = $_POST["changesSubmitted"];
if ($action == "editMenu") {



  if ($changesSubmitted) {

   $name = $_POST["name"];
   $orderNum = $_POST["orderNum"];
   $href = $_POST["href"];
   $pageID = $_POST["pageID"];
   $id = $_POST["thisID"];

   if ($pageID > 0) {
      if ($config['USE_SEO_URLS']) {
         $href=genSEOPageNameFromID((int)$pageID).'.html';
      }
      else
         $href = "index.php?act=$pageID";
   }


   $qs = "UPDATE Menu
          SET name=:name,
               href=:href,
                orderNum=:orderNum
          WHERE id=:id";
   $params = array('id'=>$id,
                   'name'=>$name,
                   'href'=>$href,
                   'orderNum'=>$orderNum
             );
   mcmQuery($qs, $params);
?>
      <h3>Changes Saved</h3>
<?php

  }
  else {

      $qs = "SELECT * FROM Menu WHERE id=:id ORDER BY name";
      $rows = mcmSelectQuery( $qs, array('id'=>$id) );
      $row = array();
      if ( count($rows) )
        $row = $rows[0];
      $id = $row['id'];
      $name = $row['name'];
      $orderNum = $row['orderNum'];
      $href = $row['href'];

      $pageID = 0;
      if ( ( strpos($href, "index.php?act=") === 0 ) || (strpos($href, ".html") !== FALSE) ) {
         if ($config['USE_SEO_URLS']) {
            $pageName = genSEOPageName(substr($href, 0, strlen($href)-5));

            $qs = "SELECT id
                   FROM Content
                   WHERE seoPageName=:seoPageName";
            $rows = mcmSelectQuery( $qs, array('seoPageName'=>$pageName) );
            $row = array();
            if ( count($rows) )
              $row = $rows[0];
            $pageID = $row['id'];
         }
         else // no seo url pref
           $pageID = substr($href, 12);
      }

?>
      <form action="editMenu.php" method="POST">
 <input type="hidden" name="action" value="editMenu">
 <input type="hidden" name="thisID" value="<?=$id?>">
 <input type="hidden" name="changesSubmitted" value="1">
 Menu Name: <input type="text" name="name" value="<?=$name?>">
 <br>
 Menu Link (optional - what page you want to link the top of the menu to):
 <select name="pageID">
       <option value="0">Select...
   <?php

     $qs = "SELECT id, pageName FROM Content ORDER BY pageName";
     $rows = mcmSelectQuery($qs);
     foreach ($rows as $r) {
       $pc_id = $r['id'];
       $pc_name = $r['pageName'];
   ?>
       <option value="<?=$pc_id?>" <?=isSelected($pc_id, $pageID)?>><?=$pc_name?>
   <?php
     } // end foreach
   ?>
 </select>
 <br>
 &nbsp;Or enter the URL/link here:
 <input type="text" name="href" value="<?=$href?>">
 <br>
 Order Number (0 - leftmost, higher # further right):
 <input type="text" name="orderNum" value="<?=$orderNum?>">
 <br>
 <input type="submit" value="Save">
</form>
<?php
  }

} // end if ($action == "editMenu")

else if ($action == "editMenuItem") {


  if ($changesSubmitted) {

   $name = $_POST["name"];
   $orderNum = $_POST["orderNum"];
   $href = $_POST["href"];
   $pageID = $_POST["pageID"];
   $menuID = $_POST["menuID"];
   $isHeader = $_POST["isHeader"];
   $id = $_POST["thisID"];

   if ($pageID > 0) {
    if ($config['USE_SEO_URLS']) {
      $href=genSEOPageNameFromID((int)$pageID).'.html';
    }
    else
      $href = "index.php?act=$pageID";
   }

   $qs = "UPDATE Menu_Item
          SET name=:name,
               menuID=:menuID,
                pageID=:pageID,
                 orderNum=:orderNum,
                  isHeader=:isHeader,
                   href=:href
          WHERE id=:id";

   $params = array('id'=>$id,
                   'name'=>$name,
                   'href'=>$href,
                   'orderNum'=>$orderNum,
                   'menuID'=>$menuID,
                   'pageID'=>$pageID,
                   'isHeader'=>$isHeader
             );
   mcmQuery($qs, $params);
?>
      <h3>Changes Saved</h3>
<?php

  }
  else {

      $qs = "SELECT * FROM Menu_Item WHERE id=:id ORDER BY name";
      $row = array();
      $rows = mcmSelectQuery( $qs, array('id'=>$id) );
      if ( count($rows) )
        $row = $rows[0];
      $id = $row['id'];
      $name = $row['name'];
      $menuID = $row['menuID'];
      $pageID = $row['pageID'];
      $orderNum = $row['orderNum'];
      $isHeader = $row['isHeader'];
      $href = $row['href'];
?>
      <form action="editMenu.php" method="POST">
 <input type="hidden" name="action" value="editMenuItem">
 <input type="hidden" name="changesSubmitted" value="1">
 <input type="hidden" name="thisID" value="<?=strip_tags($id)?>)">
 Menu Item Name: <input type="text" name="name" value="<?=strip_tags($name)?>">
 <br>
 Menu Item Link (what page you want to link menu item to):
 <select name="pageID">
   <option value="0">Select...
   <?php

     $qs = "SELECT id, pageName FROM Content ORDER BY pageName";
     $row = array();
     $rows = mcmSelectQuery($qs);
     foreach ($rows as $r) {
       $pc_id = $r['id'];
       $pc_name = $r['pageName'];
   ?>
       <option value="<?=$pc_id?>" <?=isSelected($pc_id, $pageID)?>><?=$pc_name?>
   <?php
     } // end while

   ?>
 </select>
 <br>
 &nbsp;Or enter the URL/link here:
 <input type="text" name="href" value="<?=$href?>">
 <br>
 Menu to add to:
 <select name="menuID">
  <?php

    $qs = "SELECT id, name FROM Menu ORDER BY name";
    $rows = mcmSelectQuery($qs);
    foreach ($rows as $row) {
      $menu_id = $row['id'];
      $menu_name = $row['name'];
  ?>
       <option value="<?=$menu_id?>" <?=isSelected($menu_id, $menuID)?>><?=$menu_name?>
  <?php
    } // end foreach
  ?>
 </select>
 <br>
 Order Number (0 - topmost, higher # further down):
 <input type="text" name="orderNum" value="<?=$orderNum?>">
 <br />
 <input type="submit" value="Save">
</form>
<?php
  }

} // end if ($action == "editMenuItem")
else {

?>

<h3>Edit Menu</h3>
<form action="editMenu.php" method="POST">
 <input type="hidden" name="action" value="editMenu">
 <select name="menuID">
  <?php

    $qs = "SELECT id, name, orderNum FROM Menu ORDER BY name";
    $rows = mcmSelectQuery($qs);
    foreach ($rows as $row) {
      $menu_id = $row['id'];
      $menu_name = $row['name'];
  ?>
       <option value="<?=$menu_id?>"><?=$menu_name?>
  <?php
    } // end foreach
  ?>
 </select>
 <input type="submit" value="Edit Menu">
</form>

<h3>Edit Menu Item</h3>
<form action="editMenu.php" method="POST">
 <input type="hidden" name="action" value="editMenuItem">
 <select name="menuID">
  <?php

    $qs = "SELECT id, name, menuID, orderNum FROM Menu_Item ORDER BY name";
    $rows = mcmSelectQuery($qs);
    foreach ($rows as $row) {
      $menu_id = $row['id'];
      $menu_name = $row['name'];
  ?>
       <option value="<?=$menu_id?>"><?=$menu_name?>
  <?php
    } // end foreach
  ?>
 </select>
 <input type="submit" value="Edit Menu Item">
</form>

<?php

} // end else

?>