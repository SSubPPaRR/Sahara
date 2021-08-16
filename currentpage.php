<?php
  //get the last page for later redirect 
  if(isset ($_GET['CatID'])){
  $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
  $curPageName = $curPageName."?CatID=".$_GET['CatID'];              
  }
  else $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);              
  
  $_SESSION['previous_page']= $curPageName;
  ?>
  