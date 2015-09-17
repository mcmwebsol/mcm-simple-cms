<?php


  include_once('include/configure.php');
  
  try {            
    $dbh = new PDO('mysql:host='.$db_server.';dbname='.$db_name, $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // throw exceptions on PDO errors
  } 
  catch (PDOException $e) {
    print " Error!: Unable to connect to database ";
        
    // DO NOT ENABLE BELOW 2 LINES   
    /* 
    print $e->getMessage();
    print $e->getTraceAsString();    
     */
    die();
  } 

  $config_qs = "SELECT `key`, `value`
                FROM `Config`";
  $rows = mcmSelectQuery($config_qs);
  $config = array();
  foreach ($rows as $config_row) {
    $config[$config_row['key']] = $config_row['value'];
  }


// functions
 function mcmQuery($qs, $params) {
 
   global $dbh;
 
   try {
     $stmt = $dbh->prepare($qs);
     foreach ($params as $k=>$v) {
       $stmt->bindValue(':'.$k, $v);
     }
     $stmt->execute();
   }
   catch (PDOException $e) {
      print " Error! in query ";
      //print $e->getMessage(); // DEBUG - REMOVE!
      //print $e->getTraceAsString(); // DEBUG - REMOVE!   
   }
 
 }
 
 function mcmSelectQuery( $qs, $params=array() ) {
 
   global $dbh;
 
   $rows = array();
 
   try {
     $stmt = $dbh->prepare($qs);
     if ( count($params) ) {
       foreach ($params as $k=>$v) {
         $stmt->bindValue(':'.$k, $v);
       }
     }  
     $stmt->execute();
     
     $rows = $stmt->fetchAll();
   }
   catch (PDOException $e) {
      print " Error! in query ";                               
      //print $e->getMessage(); // DEBUG - REMOVE!
      //print $e->getTraceAsString(); // DEBUG - REMOVE!   
   }
   
   return $rows;
 
 }

function isMobile() {

    $mobile_browser = 0;         
   
    if(preg_match('/(iphone|ipod)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
        $mobile_browser++;
    } 
     
    if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
        $mobile_browser++;
    }
     
    if((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')>0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
        $mobile_browser++;
    }    
      
    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
    $mobile_agents = array(
        'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
        'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
        'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
        'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
        'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
        'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
        'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
        'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
        'wapr','webc','winw','winw','xda','xda-',"android",
            "blackberry",
            "opera mini",
            "avantgo","blazer","elaine","hiptop","palm","plucker","xiino",
            "iemobile","ppc","smartphone",
            "kindle","mobile","mmp","midp","o2","pda","pocket","psp","treo","up.browser","up.link","vodafone","wap"    
        );
     
    if(in_array($mobile_ua,$mobile_agents)) {
        $mobile_browser++;
    }
     
    if (strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini')>0) {
        $mobile_browser++;
    }
     
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows')>0) {
        $mobile_browser=0;
    }
    
    if(preg_match('/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($_SERVER['HTTP_USER_AGENT'],0,4)))
      $mobile_browser++;
 

    return $mobile_browser;
  
}


function getMetaAndTitle($pageName) {

  global $config;

  if ( ctype_digit($pageName) ) { // numeric id for page name
     return getMetaAndTitleFromID($pageName);
  }
  else {

    if ($config['USE_SEO_URLS']) {
     $qs = "SELECT titleTag, metaDescription, metaKeywords
            FROM Content
            WHERE seoPageName=:pageName"; 
    }
    else {
     $qs = "SELECT titleTag, metaDescription, metaKeywords
            FROM Content
            WHERE pageName=:pageName"; 
    } 
    $arr = array();
    $rows = mcmSelectQuery( $qs, array('pageName'=>$pageName) );
    if ( count($rows) )
      $arr = $rows[0];

    return $arr;

  }


} // end getMetaAndTitle()


function getMetaAndTitleFromID($id) {

  $qs = "SELECT titleTag, metaDescription, metaKeywords
         FROM Content
         WHERE id=:id";
  $arr = array();
  $rows = mcmSelectQuery( $qs, array('id'=>$id) );
  if ( count($rows) )
    $arr = $rows[0];

  return $arr;

} // end getMetaAndTitleFromID()


function getContent($pageName) {

  global $config;

  if ( ctype_digit($pageName) ) { // numeric id for page name
     return getContentFromID($pageName);
  }
  else {

    if ($config['USE_SEO_URLS']) {
     $qs = "SELECT content FROM Content WHERE seoPageName=:pageName";
    }
    else {
     $qs = "SELECT content
            FROM Content
            WHERE pageName=:pageName";
    }  
    
    // IF MOBILE VERSION, FILTER OUT BASED ON COMMENTS
    

    $content = '';
    $rows = mcmSelectQuery( $qs, array('pageName'=>$pageName) );
    if ( count($rows) ) {
      $arr = $rows[0];
      $content = $arr['content']; 
    }  

    return $content;

  }

} // end getContent()


function getContentFromID($id) {

  $qs = "SELECT content FROM Content WHERE id=:id";
  $content = '';
  $rows = mcmSelectQuery( $qs, array('id'=>$id) );
  if ( count($rows) ) {
    $arr = $rows[0];
    $content = $arr['content']; 
  }  

  return $content;

} // end getContentFromID()

?>