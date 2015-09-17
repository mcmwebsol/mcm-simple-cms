<?php

   include "include/app_top_admin.php";

   include "include/links.php";

   $action = $_POST["action"];

   $id = $_POST["menuID"];

if ($action == "deleteMenuItem") {

   $qs = "DELETE FROM Menu_Item WHERE id=:id";
   $params = array('id'=>$id);
   mcmQuery($qs, $params);
?>
      <h3>Menu Item Deleted</h3>
<?php
}
else if ($action == 'deleteMenu') {
 
   $qs = "DELETE FROM Menu WHERE id=:id";
   $params = array('id'=>$id);
   mcmQuery($qs, $params);
?>
      <h3>Menu Deleted</h3>
<?php
}
else {

?>

<h3>Delete Menu</h3>
<form action="deleteMenu.php" method="POST">
 <input type="hidden" name="action" value="deleteMenu">
 <select name="menuID">
  <?php

    $qs = "SELECT id, name FROM Menu ORDER BY name";
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
 <input type="submit" value="Delete Menu">
</form>

<br />

<h3>Delete Menu Item</h3>
<form action="deleteMenu.php" method="POST">
 <input type="hidden" name="action" value="deleteMenuItem">
 <select name="menuID">
  <?php

    $qs = "SELECT id, name, menuID, orderNum FROM Menu_Item ORDER BY name";
    $rows = mcmSelectQuery($qs);
    foreach ($rows as $row) {
  ?>
       <option value="<?=$row['id']?>"><?=$row['name']?>
  <?php
    } // end foreach
  ?>
 </select>
 <input type="submit" value="Delete Menu Item" />
</form>

<?php

} // end else

?>