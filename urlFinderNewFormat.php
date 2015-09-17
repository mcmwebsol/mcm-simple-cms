<?php


include "include/app_top_admin.php";



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


// linear code start

$submitted = $_GET["submitted"];

if ($submitted == 1) {

   $pageName = $_GET["pageName"];

   if ($config['USE_SEO_URLS'])
      $href=genSEOPageName($pageName).'.html';
   else
      $href="index.php?act=$pageName";

?>
   <?=$href?>
<?php
} // end if
else if ($submitted == 2) {

   $href = "uploads/".$_GET["linkFileDownloadable"];

?>
   <?=$href?>
<?php
} // end else if
else {
?>

<form action="">
<select name="pageName">
   <option value="0" selected>Select A Page To Link To
   <?php

     $qs = "SELECT pageName FROM Content ORDER BY pageName";
     $rows = mcmSelectQuery($qs);
     foreach ($rows as $r) {
       $pc_name = $r['pageName'];
   ?>
       <option value="<?=$pc_name?>"><?=$pc_name?>
   <?php
     } // end foreach
   ?>
</select>
<input type="hidden" name="submitted" value="1">
<input type="submit" value="Get Link URL">
</form>
<?php
} // end else
?>
<br />
<br />
<br />

<?php
 if ($handle = opendir('uploads/')) {
   while (false !== ($file = readdir($handle)))
      {
          if ($file != "." && $file != "..")
	  {
          	$thelist .= '<a href="'.$file.'">'.$file.'</a><br>';
          }
       }
  closedir($handle);
  }
?>
<p>List of files in upload directory:</p>
<p><?=$thelist?></p>
