<?php
  // do ls on uploads and images 
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
     if ( ($__file != '.') && ($__file != '..') ) 
       array_push($__ls,$__file);

   closedir($__dir_h);
   sort($__ls,SORT_STRING);
  }

 return $__ls;
}

$imageDirList = ls('../images/');

$uploadDirList = ls('../uploads/');

$arr = array();
?>

var tinyMCEImageList = new Array(

<?php
  foreach ($imageDirList as $f) {
    $arr[] = '["'.$f.'", "images/'.$f.'"]';
  }
  
  foreach ($uploadDirList as $f) {
    $arr[] = '["'.$f.'", "uploads/'.$f.'"]';  
  }
?> 
<?=implode(',', $arr)?> 
);