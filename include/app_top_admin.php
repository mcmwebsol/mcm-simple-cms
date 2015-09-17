<?php

  // login check
  if (!$isLogin) {
     @session_start();
     if ($_SESSION['isloged'] != 'yes'){
	    header("Location: login.php");
	    exit();
     }
  }

  include_once('include/app_top.php');

  function genSEOPageName($pageName) {

   // remove non-alpha numeric characters (other than spaces)
   $pattern = '/[^A-Za-z0-9 ]/'; // was "([^[:alnum:][:space:]])+";  
   
   // also makes everything lowercase
   $ret = preg_replace($pattern, '', strtolower($pageName)); // was ereg_replace($pattern, '', strtolower($pageName));   

   // replace all spaces with "-"      
   $ret = str_replace(' ', '-', $ret); // was ereg_replace($pattern, '-', $ret);        


   return $ret;

 }

 function genSEOPageNameFromID($pageID) {

   $qs = "SELECT seoPageName
          FROM Content
          WHERE id=:id";
   $row = array();
   $rows = mcmSelectQuery( $qs, array('id'=>$pageID) );
   if ( count($rows) ) {
     $row = $rows[0];
     return $row['seoPageName'];
   }  

   return '';

 }

 function saveNewRevision($content, $pageID) {

   global $config;
   
   if ( getNumRevisionsForPage($pageID) >= $config['MAX_NUM_REVISIONS'] )  {
      // delete old revision

      // find oldest revision for this page
      $oldestID = getOldestRevisionForPage($pageID);

      $qs = "DELETE FROM Revision_Log
             WHERE id=:id";
      mcmQuery( $qs, array('id'=>$oldestID) );
   }

   // add new revision
   $qs = "INSERT INTO Revision_Log (contentID, revisionDateTime, content)
          VALUES (:contentID,
                    :dt,
                     :content)";
   $params = array(
     'contentID'=>$pageID,
     'dt'=>date('Y-m-d H:i:s'),
     'content'=>$content
   );
   mcmQuery($qs, $params);

 }


 function restoreRevision($pageID, $revisionID) {

   // get content from revision # $revisionID
   $qs = "SELECT content
          FROM Revision_Log
          WHERE id=:revisionID";
   $contentArr = array();
   $rows = mcmSelectQuery( $qs, array('revisionID'=>$revisionID) );
   if ( count($rows) )
     $contentArr = $rows[0];

   // update Content
   $qs = "UPDATE Content
          SET content=:content
          WHERE id=:pageID";
   $params = array(
     'content'=>$contentArr['content'],
     'pageID'=>$pageID
   );       
   mcmQuery( $qs, $params );

   // update time on this revision
   $qs = "UPDATE Revision_Log
          SET revisionDateTime=NOW()
          WHERE id=:revisionID";
   mcmQuery( $qs, array('revisionID'=>$revisionID) );

 }


 function getOldestRevisionForPage($pageID) {

  $qs = "SELECT id
         FROM Revision_Log
         WHERE contentID=:pageID
         ORDER BY revisionDateTime ASC";
  $row = array();
  $rows = mcmSelectQuery( $qs, array('pageID'=>$pageID) );
  if ( count($rows) )
    $row = $rows[0];

  return $row['id'];

 }


 function getNumRevisionsForPage($pageID) {

  $qs = "SELECT id
         FROM Revision_Log
         WHERE contentID=:contentID";
  $rows = mcmSelectQuery( $qs, array('contentID'=>$pageID) );
  $numRows = count($rows);

  return $numRows;

 }


 function getRevisions($pageID) {

  $qs = "SELECT id, UNIX_TIMESTAMP(revisionDateTime) as revisionTimestamp
         FROM Revision_Log
         WHERE contentID=:contentID
         ORDER BY revisionDateTime ASC";
  $rows = mcmSelectQuery( $qs, array('contentID'=>$pageID) );
  
  $arr = array(0=>'Select..');
  foreach ($rows as $row) {
      $arr[$row['id']] = date('n/j/Y g:i:s A', $row['revisionTimestamp']);
  }

  // delete last revision (it's the current one)
  array_pop($arr);

  return $arr;

 }


 function getRevision($pageID, $revisionID) {

  $qs = "SELECT content
         FROM Revision_Log
         WHERE id=:id";
  $row = array();
  $rows = mcmSelectQuery( $qs, array('id'=>$revisionID) );
  if ( count($rows) )
    $row = $rows[0];

  return $row;

 }
 
 

?>