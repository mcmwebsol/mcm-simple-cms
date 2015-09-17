<?php

   include "include/app_top_admin.php";

   include "include/links.php";


   function updateAction($arr, $id) {

        $debug = 0;
   
        $content = $_POST["content"];
      if (!$_SESSION["admin"]) {  
        $qs = "SELECT id 
               FROM User
               WHERE username=:username";
        $row = array();       
        $rows = mcmSelectQuery( $qs, array('username'=>$_SESSION["username"]) );
        if ( count($rows) )
          $row = $rows[0];
        $userID = $row['id'];
        
        // check for access
        $qs= "SELECT id
              FROM Permission
              WHERE contentID=:contentID AND
                     userID=:userID";
        $params = array(
          'contentID'=>$id,
          'userID'=>$userID
        );
        //print_r($params);
        $rows = mcmSelectQuery($qs, $params);
        if ( count($rows) ) {
   
          $qs = "UPDATE Content
                 SET content=:content,
                     titleTag=:titleTag, 
                     metaDescription=:metaDescription, 
                     metaKeywords=:metaKeywords      
                 WHERE id=:id";
          $params = array(
            'content'=>$content,
            'titleTag'=>$_POST['titleTag'],
            'metaDescription'=>$_POST['metaDescription'],
            'metaKeywords'=>$_POST['metaKeywords'],
            'id'=>$id
          );
          mcmQuery($qs, $params);
        }
        else {
          die('You do not have permission to edit this page');
        }
       }
       else {
         
          $qs = "UPDATE Content
                 SET content=:content,
                     titleTag=:titleTag, 
                     metaDescription=:metaDescription, 
                     metaKeywords=:metaKeywords      
                 WHERE id=:id";
          $params = array(
            'content'=>$content,
            'titleTag'=>$_POST['titleTag'],
            'metaDescription'=>$_POST['metaDescription'],
            'metaKeywords'=>$_POST['metaKeywords'],
            'id'=>$id
          );
          mcmQuery($qs, $params);
       } 
     ?>

        <h3>Your changes have been saved</h3>

     <?php

   }

function addAction($arr, $id) {
  
     global $dbh;
  
     $content = $_POST["content"];
     $pageName = $_POST["pageName"];

     $qs = "INSERT INTO Content (pageName, content, seoPageName, titleTag, metaDescription, metaKeywords)
            VALUES (:pageName,
                     :content,
                       :seoPageName,
                       :titleTag, 
                        :metaDescription, 
                         :metaKeywords)";

     $params = array(
            'pageName'=>$pageName,
            'content'=>$content,
            'seoPageName'=>genSEOPageName($pageName),
            'titleTag'=>$_POST['titleTag'],
            'metaDescription'=>$_POST['metaDescription'],
            'metaKeywords'=>$_POST['metaKeywords']
     );
     mcmQuery($qs, $params);
     $id = $dbh->lastInsertId();

     ?>

        <h3>The new page has been added</h3>

     <?php
     
     return $id;

}





   $id = $_POST["id"];


   $myaction = trim($_POST["myaction"]);
   $id = (int)$_POST["id"];

   if ($myaction == "edit")
      updateAction($_POST, $id);
   else
      $id = addAction($_POST, $id);
      
   saveNewRevision($_POST["content"], $id);   

?>