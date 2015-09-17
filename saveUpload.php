<?php

include "include/app_top_admin.php";

// file upload
set_time_limit(900);

for ($i = 1; $i < 4; $i++) {
    $photo = trim($_FILES["photo$i"]['name']);


  if ($photo != "") {
     $photo = upload("photo$i", 
                       'uploads', 
                          array('jpg','jpeg','gif','png','bmp','.pdf'), 
                            8*1024*1024, 
                             array("image/x-png", "image/pjpeg", "image/gif", "image/jpeg", "image/bmp", 'application/pdf', 'application/x-pdf', 'text/pdf', 'application/vnd.pdf'), 
                              0, 
                               0);              
      
      
  }

} // end for

?>
<h3>File(s) Uploaded</h3>
<?php


function upload($fieldName, $IMAGE_DIR, $fileExtsAllowed, $max_size, $mimeTypesAllowed, $width, $widthL) {

global $BASE_DIR;

$debug = 0;

error_reporting(E_ALL); // DEBUG CODE


$userfile = $_FILES[$fieldName]['name'];

if ( trim($userfile) == '' )
   return '';

$image_to_edit = $userfile;

$uploaddir = $BASE_DIR;


print " dir=// $uploaddir  $IMAGE_DIR  $image_to_edit  // "; // debug

$uploadfile = $uploaddir . $IMAGE_DIR . "/" . $image_to_edit;

if ($debug)
   print "uploadfile=$uploadfile";



// add action

$tmpFilename = $_FILES[$fieldName]['tmp_name'];


$imname = $_FILES[$fieldName]["name"];


$sArr = explode(".", $imname); // get the extension
$ct = count($sArr) - 1;
$ext = $sArr[$ct];

$imtype = $_FILES[$fieldName]['type'];

$fileMimeTypeOk = 0;
foreach ($mimeTypesAllowed as $mimeType) {
   if ( strcasecmp($imtype, $mimeType) == 0 ) {
      $fileMimeTypeOk = 1;
      break;
   }
}
if (!$fileMimeTypeOk) {
   //echo $closeS;
   exit("Please upload images with the extensions ".implode(',', $fileExtsAllowed)." only (not $imtype)");
}

$fileExtOk = 0;
foreach ($fileExtsAllowed as $fileExt) {
   if ( strcasecmp($ext, $fileExt) == 0 ) {  
      $fileExtOk = 1;
      break;  
   }   
}
if (!$fileExtOk) {
   //echo $closeS;
   exit("Please upload images with the extensions ".implode(',', $fileExtsAllowed)." only (not $imname)");
}

// rejects all .exe, .com, .bat, .zip, and .doc files, etc.
if( preg_match("/.exe$|.com$|.bat$|.zip$|.php$|.asp$|.html$|.htm$|.shtml$|.js$|.shtm$|.doc$/i", $imname) ) {
  //echo $closeS;
  exit("You cannot upload this type of file.");
}


// make sure the file is $max_size bytes or smaller
if ($_FILES[$fieldName]['size'] > $max_size) {
   echo $closeS;
   exit("The file you are trying to upload is too large.");
}

$success = 0;

// check file type (extension and mime type)



// copy the file to destination
if ( is_uploaded_file($tmpFilename) ) {

   $ct = 0;
   while ( file_exists($uploadfile) ) {
        $uploadfile .= $ct; // new filename
        $ct++;
   }

   if ( copy($tmpFilename, $uploadfile) ) {

      $success = 1;
      echo "\n<p><b>File uploaded successfully</b>";
   }
   else
      echo "COPY FAILED $tmpFilename, $uploadfile"; // DEBUG CODE
}
else {
   switch($_FILES[$fieldName]['error']) {
    case 0: // no error; possible file attack!
      echo "There was a problem with your upload.";
      break;
    case 1: // uploaded file exceeds the upload_max_filesize directive in php.ini
      echo "The file you are trying to upload is too big.";
      break;
    case 2: // uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form
      echo "The file you are trying to upload is too big (bigger than MAX_FILE_SIZE).";
      break;
    case 3: // uploaded file was only partially uploaded
      echo "The file you are trying upload was only partially uploaded.";
      break;
    case 4: // no file was uploaded
      echo "No file selected.";//You must select an image for upload.";
      break;
    default: // a default error, just in case!  :)
      echo "There was a problem with your upload.";
      break;
   }
}


  
  if ($width > 0) {
  
    $thumb = $uploadfile."_thumb"; // overwrite file

    $err = my_makeThumbnail($uploadfile, $width, $thumb);

    print $err;
    
    $err = my_makeThumbnail($uploadfile, $widthL, $uploadfile);

    print $err;

  }


  return $uploadfile;

 }



?>