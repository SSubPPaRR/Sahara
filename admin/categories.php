<?php session_start();?>
<!DOCTYPE html>
<?php
include "..\db.php";
include "..\user-redirect.php";
$_SESSION['loginVal']=false;

//is a user logged in
if(isset($_SESSION['loggedIn'])){
  $loggedIn = $_SESSION['loggedIn'];
}else $loggedIn =false;
$loggedID = $_SESSION['loggedID'];

?>

<html>
<title>Sahara</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
  <link rel="stylesheet" href="..\styles.css">
  <link rel="stylesheet" href="..\w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>    
<body >

<style>
body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
body {font-size:16px;}

</style>


<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-red w3-collapse w3-top w3-large w3-padding w3-card" style="z-index:3;width:250px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
  <div class="w3-container">
    <h3 class="w3-padding-16"><b>Sahara</b></h3>
  </div>
  <div class="w3-bar-block">
    <a href="index.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe88a</i>Dashboard</a> 
    <a href="categories.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe2c7</i>Categories</a>
    <a href="vendors.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe8cc</i>Vendors</a>
    <a href="support-inbox.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe156</i>Support Inbox</a> 
    
    <!--login-->
    <?php
      echo '<a href="..\logout.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe7ff</i>Logout</a>';   
    ?>  
  </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large w3-red w3-xlarge w3-padding">
  <a href="javascript:void(0)" class="w3-button w3-red w3-margin-right" onclick="w3_open()">☰</a>
  <span>Sahara</span>
  <!--login-->
  <?php
    echo'<a class="w3-right w3-large" style="margin-top:10px;" href="..\logout.php">Logout</a><span class="w3-large w3-right w3-padding">'.$_SESSION['loggedName'].'</span>';
  ?>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">

 
  <!-- Header -->
  <div class="w3-container" style="margin-top:50px" id="showcase">
    <h1>Categories</h1>
  </div>
  
  <button class="w3-button w3-green w3-round "style="margin-bottom: 5px;" onclick="document.getElementById('cat-add-form').style.display='block'">Add a category</button>
  <form class="w3-container w3-right" action="" method="GET" style="display: flex;">
      <input class="w3-input w3-border w3-round" type="search" placeholder="Search..." name="key">
      <button class="w3-button w3-red w3-round" type="submit">Go</button>
    </form>


  <!-- vendor list -->
  <table class="w3-table-all w3-hoverable">
      <tr class="w3-red">
        <th>Category</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
        <?php

        //check for search key
        if(isset($_GET['key'])){
          $key=$_GET['key'];
          $sql ='SELECT Cat_ID FROM categories WHERE  Cat_Title LIKE "%'.$key.'%" ORDER BY Cat_Title';
        }
        else $sql ='SELECT Cat_ID FROM categories ORDER BY Cat_Title';

              $result= mysqli_query($conn,$sql);
              $cat_list=array();

              while($row = $result->fetch_assoc()){
                $Cat_ID = $row['Cat_ID'];
                array_push($cat_list,$Cat_ID);
              }
              foreach($cat_list as $Cat_ID){

                $sql ='SELECT Cat_Title FROM categories WHERE Cat_ID = "'.$Cat_ID.'";';
                if($result = mysqli_query($conn, $sql)){
                  $row = mysqli_fetch_row($result);
                  
                  //place product info in corresponding cells.
                  echo '
                <tr>
                    <td>'.$row[0].'</td>
                    <td><span onclick="document.getElementById(\'cat-edit-form'.$Cat_ID.'\').style.display=\'block\'"" class="w3-button w3-green w3-hover-orange"><i class="material-icons w3-left">&#xe3c9</i></span></td>
                    <td><span onclick="document.forms[\'category-delete-Form'.$Cat_ID.'\'].submit();" class="w3-button w3-red w3-hover-orange"><i class="material-icons w3-left">&#xe872</i></span></td>
                </tr>

                  <form action="removecat.php" method="GET" name="category-delete-Form'.$Cat_ID.'" style="display: none;">      
                  <input type="hidden" name="ID" value="'.$Cat_ID.'"?>
                  </form>';
                }   
          }
       
    ?>
  </table>
  
        <?php
            foreach($cat_list as $Cat_ID){
                $sql ='SELECT Cat_Title FROM categories WHERE Cat_ID = "'.$Cat_ID.'";';
                if($result = mysqli_query($conn, $sql)){
                  $row = mysqli_fetch_row($result);
                echo '
                <!--edit cat form-->
                <form id="cat-edit-form'.$Cat_ID.'" class="w3-container w3-card w3-padding w3-display-middle w3-white w3-animate-opacity"  action="editcat.php" method="POST" style="width: 400px; display: none;">
                    <header><h3>Edit category</h3></header><span class="w3-display-topright w3-padding w3-hover-grey" onclick="document.getElementById(\'cat-edit-form'.$Cat_ID.'\').style.display=\'none\'">&times;</span>
                    <input type="hidden" name="ID" value="'.$Cat_ID.'">
                    <input class="w3-input" type="text" name="name" placeholder="Category name" value="'.$row[0].'"required> 
                    <button class="w3-btn w3-blue  w3-round w3-margin" type="submit">GO</button>
                </form>
                
                ';
                }
            }
        ?>



 <!--add cat form-->
 <form id="cat-add-form" class="w3-container w3-card w3-padding w3-display-middle w3-white w3-animate-opacity"  action="addcat.php" method="POST" style="width: 400px; display: none;">
        <header><h3>Add category</h3></header><span class="w3-display-topright w3-padding w3-hover-grey" onclick="document.getElementById('cat-add-form').style.display='none'">&times;</span>
        
        <input class="w3-input" type="text" name="name" placeholder="Category name" required> 
        <button class="w3-btn w3-blue  w3-round w3-margin" type="submit">GO</button>
    </form>

    
       
   


</div>
  <?php include "../currentpage.php"?>

    <!-- End page content -->

  </div>

    <!-- W3.CSS Container -->
    <div class="w3-light-grey w3-container w3-padding-32 " style="margin-top:75px;padding-right:58px;"></div>

    <script>
    // Script to open and close sidebar
    function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
    }
    
    function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
    }

    </script>    


</body>
</html> 