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
    <h1>Vendors</h1>
  </div>
  
  <button class="w3-button w3-green w3-round "style="margin-bottom: 5px;" onclick="document.getElementById('vendor-add-form').style.display='block'">Add a vendor</button>
  <form class="w3-container w3-right" action="" method="GET" style="display: flex;">
      <input class="w3-input w3-border w3-round" type="search" placeholder="Search..." name="key">
      <button class="w3-button w3-red w3-round" type="submit">Go</button>
    </form>


  <!-- vendor list -->
  <table class="w3-table-all w3-hoverable">
      <tr class="w3-red">
        <th>Vendor Name</th>
      
        <th>Delete</th>
      </tr>
        <?php

        //check for search key
        if(isset($_GET['key'])){
          $key=$_GET['key'];
          $sql ='SELECT Vendor_ID FROM vendor WHERE  Vendor_Name LIKE "%'.$key.'%" ORDER BY Vendor_Name';
        }
        else $sql ='SELECT Vendor_ID FROM vendor ORDER BY Vendor_Name';

              $result= mysqli_query($conn,$sql);
              $vendor_list=array();

              while($row = $result->fetch_assoc()){
                $Vendor_ID = $row['Vendor_ID'];
                array_push($vendor_list,$Vendor_ID);
              }
              foreach($vendor_list as $Vendor_ID){

                $sql ='SELECT Vendor_Name FROM vendor WHERE Vendor_ID = "'.$Vendor_ID.'";';
                if($result = mysqli_query($conn, $sql)){
                  $row = mysqli_fetch_row($result);
                  
                  //place product info in corresponding cells.
                  echo '
                <tr>
                    <td>'.$row[0].'</td>
                    <td><span onclick="document.forms[\'vendor-delete-Form'.$Vendor_ID.'\'].submit();" class="w3-button w3-red w3-hover-orange"><i class="material-icons w3-left">&#xe872</i></span></td>
                </tr>
                
                  <form action="removevendor.php" method="GET" name="vendor-delete-Form'.$Vendor_ID.'" style="display: none;">      
                  <input type="hidden" name="ID" value="'.$Vendor_ID.'"?>
                  </form>';
                }   
          }
        
    ?>
  </table>
 <!--add vendor form-->
 <form id="vendor-add-form" class="w3-container w3-card w3-padding w3-display-middle w3-white w3-animate-opacity"  action="addvendor.php" method="POST" style="width: 400px; display: none;">
        <header><h3>Add vendor</h3></header><span class="w3-display-topright w3-padding w3-hover-grey" onclick="document.getElementById('vendor-add-form').style.display='none'">&times;</span>
        
        <input class="w3-input" type="text" name="name" placeholder="Vendor name" required> 
        <input class="w3-input" type="text" name="username" placeholder="Username" required> 
        <input id="password" class="w3-input" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Password" name="password" type="password" required>
        <input id="confirm_password" class="w3-input" style="margin-bottom: 10px;" placeholder="Confirm Password" type="password" required>
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

    function validatePassword(){
      if(password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Passwords Don't Match");
      } else {
        confirm_password.setCustomValidity('');
      }
    }
    
    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;


    function passwordCheck(){
      if(current_password.value != <?php echo "'$password'";?>) {
        current_password.setCustomValidity("Incorrect passwords");
      } else {
        current_password.setCustomValidity('');
      }
    }
    current_password.onkeyup = passwordCheck;


    </script>    


</body>
</html> 