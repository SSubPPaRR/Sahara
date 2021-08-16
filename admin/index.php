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

if(isset($_SESSION['changepass-succ'])){
  $changepass = $_SESSION['changepass-succ'];
  }else $changepass = false;

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
<body onload="changePassSucc(<?php $_SESSION['changepass-succ']=false; echo $changepass; ?>)">

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
    <h1>Dashboard</h1>
  </div>
  
  <button class="w3-button w3-orange w3-round w3-left" onclick="document.getElementById('admin-edit-form').style.display='block'">Edit my account</button>
  <button class="w3-button w3-green w3-round "style="margin-bottom: 5px;" onclick="document.getElementById('admin-add-form').style.display='block'">Add a admin</button>
  <form class="w3-container w3-right" action="" method="GET" style="display: flex;">
      <input class="w3-input w3-border w3-round" type="search" placeholder="Search..." name="key">
      <button class="w3-button w3-red w3-round" type="submit">Go</button>
    </form>


  <!-- admin list -->
  <table class="w3-table-all w3-hoverable">
      <tr class="w3-red">
        <th>Product Name</th>
      
        <th>Delete</th>
      </tr>
        <?php

        //check for search key
        if(isset($_GET['key'])){
          $key=$_GET['key'];
          $sql ='SELECT Admin_ID FROM admin WHERE  Name LIKE "%'.$key.'%" ORDER BY Name';
        }
        else $sql ='SELECT Admin_ID FROM admin ORDER BY Name';

              $result= mysqli_query($conn,$sql);
              $admin_list=array();

              while($row = $result->fetch_assoc()){
                $Admin_ID = $row['Admin_ID'];
                array_push($admin_list,$Admin_ID);
              }
              foreach($admin_list as $Admin_ID){

                $sql ='SELECT Name FROM admin WHERE Admin_ID= "'.$Admin_ID.'";';
                if($result = mysqli_query($conn, $sql)){
                  $row = mysqli_fetch_row($result);
                  
                  //place product info in corresponding cells.
                  echo '
                  <tr>
                    <td>'.$row[0].'</td>';
                    if($Admin_ID == $loggedID){
                      echo'<td><span class="w3-button w3-red w3-hover-orange w3-disabled"><i class="material-icons w3-left">&#xe872</i></span></td>';

                    } else echo'<td><span onclick="document.forms[\'admin-delete-Form'.$Admin_ID.'\'].submit();" class="w3-button w3-red w3-hover-orange"><i class="material-icons w3-left">&#xe872</i></span></td>';
                    echo'</tr>
                
                  <form action="removeadmin.php" method="GET" name="admin-delete-Form'.$Admin_ID.'" style="display: none;">      
                  <input type="hidden" name="ID" value="'.$Admin_ID.'"?>
                  </form>';
                }   
          }
        
    ?>
  </table>
 <!--add admin form-->
 <form id="admin-add-form" class="w3-container w3-card w3-padding w3-display-middle w3-white w3-animate-opacity"  action="addadmin.php" method="POST" style="width: 400px; display: none;">
        <header><h3>Add admin</h3></header><span class="w3-display-topright w3-padding w3-hover-grey" onclick="document.getElementById('admin-add-form').style.display='none'">&times;</span>
        
        <input class="w3-input" type="text" name="username" placeholder="Username" required> 
        <input id="password" class="w3-input" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="New password" name="password" type="password" required>
        <input id="confirm_password" class="w3-input" style="margin-bottom: 10px;" placeholder="Confirm Password" type="password" required>
        <button class="w3-btn w3-blue  w3-round w3-margin" type="submit">GO</button>
    </form>


    <!--edit admin form-->
    <?php
    $sql='SELECT Name, User_Name FROM admin WHERE Admin_ID= '.$loggedID.'';
    if($result = mysqli_query($conn, $sql)){
      $row = mysqli_fetch_row($result);
      echo'
        <form id="admin-edit-form" class="w3-container w3-card w3-padding w3-display-middle w3-white w3-animate-opacity"  action="editadmin.php" method="POST" style="width: 400px; display: none;">
        <header><h3>Edit admin</h3></header><span class="w3-display-topright w3-padding w3-hover-grey" onclick="document.getElementById(\'admin-edit-form\').style.display=\'none\'">&times;</span>
        
        <input type="hidden" name="ID" value="'.$loggedID.'">
        <input class="w3-input" type="text" name="name" placeholder="Fullname" value="'.$row[0].'">
        <input class="w3-input" type="text" name="username" placeholder="Username" value="'.$row[1].'"> 
        <input id="current_password" class="w3-input" type="password" name="currentpw" placeholder="current password" >
        <input id="password2" class="w3-input" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="New password" name="password" type="password">
        <input id="confirm_password2" class="w3-input" style="margin-bottom: 10px;" placeholder="Confirm Password" name="confirmpw" type="password">
        <button class="w3-btn w3-blue  w3-round w3-margin" type="submit">GO</button>
    </form>';
    }
    ?>
        
   
 <?php 
    $loggedId = $_SESSION['loggedID'];
    $sql = 'SELECT Password FROM admin Where Admin_ID = '.$loggedId.'';
    if($result = mysqli_query($conn, $sql)){
      $row = mysqli_fetch_row($result); 
      $password = $row[0];       
    }
  ?>
    <!--account change successfull popup -->
<div id="changepass-succ" class="w3-modal">
    <div class="w3-modal-content w3-animate-fadin w3-card-4" style="max-width:700px;">
      <div class="w3-container w3-teal w3-center">
        <span onclick="document.getElementById('changepass-succ').style.display='none'" class="w3-button w3-display-topright">&times;</span>
        <h2>Account info has been changed!</h2>
      </div>
    </div>
  </div>
</div>


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



    function validatePassword2(){
      if(password2.value != confirm_password2.value) {
        confirm_password2.setCustomValidity("Passwords Don't Match");
      } else {
        confirm_password2.setCustomValidity('');
      }
    }
    
    password2.onchange = validatePassword2;
    confirm_password2.onkeyup = validatePassword2;

    function passwordCheck(){
      if(current_password.value != <?php echo "'$password'";?>) {
        current_password.setCustomValidity("Incorrect passwords");
      } else {
        current_password.setCustomValidity('');
      }
    }
    current_password.onkeyup = passwordCheck;


    // Get the modal
    var modal = document.getElementById('changepass-succ');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
     // Get the modal
     var modal = document.getElementById('changepass-succ');

      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function(event) {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      }

      function changePassSucc(b){
        if(b){
          document.getElementById('changepass-succ').style.display='block'
        }
      }
    </script>    


</body>
</html> 