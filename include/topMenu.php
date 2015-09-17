<SCRIPT>

// CSS Top Menu- By JavaScriptKit.com (http://www.javascriptkit.com)

// Adopted from SuckerFish menu

// For this and over 400+ free scripts, visit JavaScript Kit- http://www.javascriptkit.com/

// Please keep this credit intact



startMenu = function() {

if (document.all&&document.getElementById) {

cssmenu = document.getElementById("csstopmenu");



if (cssmenu != null) {

for (i=0; i<cssmenu.childNodes.length; i++) {

node = cssmenu.childNodes[i];

if (node.nodeName=="LI") {

node.onmouseover=function() {

this.className+=" over";

}

node.onmouseout=function(){

this.className=this.className.replace(" over", "")

}

}

}

}

}

}



if (window.attachEvent)

window.attachEvent("onload", startMenu)

else

window.onload=startMenu;







//-->

</SCRIPT>



<style type="text/css">


body { 

    color: black; 

}



a { color: #b9ecfd; font-weight: bold; } /* was 33ccff red */   







.myText { color: white; font-weight: bold; }

.contactHeader { font-size: 11pt; font-family: arial; font-weight: bold; }

.mylinks { color: white; font: bold 10px verdana,arial,sans-serif}

li { font-family: Arial; font-size: 13px; }



.maintable {

/* padding-right: 40px; */

}



#csstopmenu, #csstopmenu ul{

padding: 0;

margin: 0;

list-style: none;

}



#csstopmenu li{

float: left;

position: relative;

}



#csstopmenu a{

text-decoration: none;

}



.mainitems{

/*background-color: #0c803f;*/

padding-left: 14px;

padding-right: 14px;

padding-top: 0px;

padding-right: 0px;

border-left-width: 0;

}



.headerlinks a{

margin: auto 8px;

font-weight: bold;

color: black;

}



.submenus{

display: none;

width: 8em;

position: absolute;

top: 1.2em;

left: 2px;

background-color: #0c803f;

border: 1px solid black;

}



.submenus li{

width: 100%;

font-family :  Arial;

font-weight: bold;

font-size: 11px;

}



.submenus li a{

display: block;

width: 100%;

text-indent: 6px;

color: white;

}



html>body .submenus li a{ /* non IE browsers */

width: auto;

}



.submenus li a:hover{

background-color: black;

color: white;

}



#csstopmenu li>ul {/* non IE browsers */

top: auto;

left: auto;

}



#csstopmenu li:hover ul, li.over ul {

display: block;

color: white;

}



html>body #clearmenu{ /* non IE browsers */

height: 3px;

}



form {



padding-bottom: 0;

margin-bottom: 0;



}



    .mainPageLinks { color: black; font-weight: bold; }


    

.arial-normal {

        font-family: Arial;

        font-size: 10pt;

}



.arial-bold {

        font-family: Arial;

        font-size: 10pt;

        font-weight: bold;

}



.arial-italic {

        font-family: Arial;

        font-size: 10pt;

        font-style: italic; 

}

    



</style>
<ul id="csstopmenu">
<?php 

   // loop throught, pull each menu (within each menu, pull its menu items)
   $qs = "SELECT name, href, id, orderNum FROM Menu ORDER BY orderNum";
   $rows = mcmSelectQuery($qs);
   foreach ($rows as $r) { 
     $menuName = $r['name'];
     $menuHref = $r['href'];
     $menuID = $r['id'];   
?>
<li class="mainitems">
<div class="headerlinks">
  <?php if ($menuHref != "") { ?>
           <a href="<?=$pathStr.$menuHref?>">
  <?php } // end if ?>
  
               <?=$menuName?>
  <?php if ($menuHref != "") { ?>
           </a>
  <?php } // end if ?>
</div>


<?php 
   // loop through menu items for this menuID
   $qs2 = "SELECT * FROM Menu_Item WHERE menuID=:menuID ORDER BY orderNum";
   $rows2 = mcmSelectQuery( $qs2, array('menuID'=>$menuID) );
   $ct = 0;
   $isSubmenu = 0;
   
   foreach ($rows2 as $r2) { 
         $menuItemName = $r['name']; 
         $pageID = $r['pageID']; 
         $itemOrderNum = $r['orderNum']; 
         $isHeader = $r['isHeader']; 
         $href = $r['name']; 
           
         $hasLink = 1;
         if ($ct == 0) {
            $isSubmenu = 1;
?>         
            <ul class="submenus">             
<?php         
         }

         $ct++;
         if ( ($href == '') && ($pageID != "") && ($pageID != 0) ) 
            $href = "index.php?act=$pageID";        
         
         if ($href == "")
            $hasLink = 0;
            
         if ($isHeader == "1") {
            $menuItemName = "<u><span style='text-indent: 0px;'>$menuItemName</span></u>";
            
            if ($itemOrderNum > 1) {
?>
               <li>&nbsp;</li>
<?php
            }   
               
               
         }   
?>
<li>
    <?php 
      if ($hasLink) {         
    ?>
         <a href="<?=$href?>">
    <?php
      } // end if
    ?>
           <?=$menuItemName?>
    <?php 
      if ($hasLink) { 
    ?>
         </a>
    <?php
      } // end if
    ?> 
</li>

<?php
  } // end inner while
  if ($isSubmenu) {
?>
     </ul>
<?php
  }
?>
</li>

 

<?php

   } // end outer while

?>

<div id="clearmenu" style="clear: left"></div>
</div>
