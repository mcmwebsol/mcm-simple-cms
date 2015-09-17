<?php

include "include/app_top_admin.php";

?>

<html>

<head>

      <script>
      function confirmDelete(theForm) {

	if ( confirm('Are you sure you want to delete this page?') )
	   return confirm('It will be permantely deleted');
        else return false;

      }
      </script>

</head>

<body>


<?php

   include "include/links.php";

?>

<br>
<br>

<?php




   function deleteByID($id) {

      $qs = "DELETE FROM Content WHERE id=:id";
      $params = array('id' => $id);
      mcmQuery($qs, $params);

?>

      <h3>Page Deleted</h3>

<?php

   }


   $id = $_GET["id"];

   $submitted = 0;
   if ( isset($_GET["submitted"]) )
      $submitted = 1;

   if ($submitted)
      deleteByID($id);
   else {


?>

<form onSubmit="confirmDelete(this)">
      <input type="submit" value="Click Here to Delete <?=$pageName?>">
      <input type="hidden" name="id" value="<?=strip_tags($id)?>">
      <input type="hidden" name="submitted" value="1">
</form>

<?php

   } // end else

?>

</body>

</html>