<?php

  // file/location config - edit these as needed
  $WS_DIR = "/"; // web directory (e.g. if you install in "new" under your web root, enter "new/")
  $BASE_DIR = substr($_SERVER['DOCUMENT_ROOT'].$WS_DIR, 1); // where mcmsimplecms is installed (physical path no trailing slash)
  // end file/location config editable area
  
  
  date_default_timezone_set('America/Chicago');


  // DB Config/Connect - edit these with your database settings
  $db_server = 'localhost';
  $db_user = '';
  $db_pass = '';
  $db_name = '';
  // end db config editable area

  $saltVal = '';

?>
