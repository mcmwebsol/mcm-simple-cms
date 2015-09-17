<?php

include "include/app_top_admin.php";

include "include/links.php";


if (!$_SESSION["admin"]) {
   die('You do not have access to this page!');
}


function updateConfigField($fieldName, $fieldVal) {

   $qs = "UPDATE `Config`
          SET `value`=:value
          WHERE `key`=:key";
   $params = array('value'=>$fieldVal,
                   'key'=>$fieldName);
   mcmQuery($qs, $params);       

?>
   <h3>Config <?=$fieldName?> Saved</h3>
<?php
}


if ( isset($_POST['submitted']) ) { // save
   $fieldsStr = $_POST['fieldsStr'];
   $fieldsArr = explode(',', $fieldsStr);
   foreach ($fieldsArr as $field) {
           updateConfigField($field, $_POST[$field]);
   }
}
else { // show form
?>
<form method="post">
<?php 
 $fieldsArr = array();
 foreach ($config as $key=>$value) {
?>
  <?=ucwords(strtolower(str_replace('_', ' ', $key)))?>: <input type="text" name="<?=$key?>" value="<?=$value?>" />
  <br />
  <br />
<?php
  $fieldsArr[] = $key;
 }  
 $fieldsStr = implode(',', $fieldsArr);
?>  
  <input type="hidden" name="fieldsStr" value="<?=$fieldsStr?>" />
  <input type="hidden" name="submitted" value="1" />
  <input type="submit" name="submit" value="Save Changes" />
</form>
<?php
}
?>