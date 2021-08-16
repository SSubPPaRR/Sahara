<?php session_start();?>
<!DOCTYPE html>
<?php
include "db.php";
if(isset($_SESSION['regisVal'])){
  $regisVal = $_SESSION['regisVal'];
  }else $regisVal = false;
?>

<html>
<title>Sahara</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>    
<body onload="regis_failed(<?php echo $regisVal ?>)">

<style>
body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
body {font-size:16px;}

html{

  background-image: url("images\\Person-walking-over-the-Sahara-Desert.jpg");
  min-height: 100%;
  background-position: center;
  background-size: cover;
}
</style>


<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-red w3-collapse w3-top w3-large w3-padding w3-card w3-card" style="z-index:3;width:250px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
  <div class="w3-container">
    <h3 class="w3-padding-16"><b>Sahara</b></h3>
  </div>
  <div class="w3-bar-block">
    <a href="index.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe88a</i>Home</a> 
    <a href="product.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe8cb</i>Products</a> 
    <a href="shoppingcart.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe8cc</i>Shopping cart</a>
    <!--login-->
    <a href="login.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe7fd</i>Login</a>
  </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large w3-red w3-xlarge w3-padding">
  <a href="javascript:void(0)" class="w3-button w3-red w3-margin-right" onclick="w3_open()">☰</a>
  <span>Sahara</span>
  <!--login-->
  <a class="w3-right" href="login.php">Login</a>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">

  <!-- register form-->
  <div class="w3-display-middle w3-card">
      <div class="w3-border w3-gray">
          <div class="w3-orange w3-container"><h2>Register new account</h2></div>
          <form class="w3-container" action="registerValAdd.php" method="POST">

            <input  class="w3-input w3-border w3-round" style="margin-bottom: 10px; margin-top: 10px;" title="First letter must be capital" pattern="([A-Z])\w+" placeholder="Firstname" name="firstname" type="text">
           
            <input class="w3-input w3-border w3-round" style="margin-bottom: 10px;" title="First letter must be capital" pattern="([A-Z])\w+" placeholder="Lastname" name="lastname" type="text">

            <input class="w3-input w3-border w3-round" style="margin-bottom: 10px;" placeholder="Adress" name="adress" type="text">
            <label id="registerfailed" style="display: none;"><p style="color: red;">Email in use try again</p></label>

            <input class="w3-input w3-border w3-round" style="margin-bottom: 10px;" title="Insert a valid email" placeholder="Email" name="email" type="email">

            <input id="password" class="w3-input w3-border w3-round" style="margin-bottom: 10px;" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Password" name="password" type="password">

            <input id="confirm_password" class="w3-input w3-border w3-round" style="margin-bottom: 10px;" placeholder="Confirm Password" name="confirmpw" type="password">

            <button class="w3-btn w3-red w3-round" type="submit">Register</button>

    </div>
</div>


    <!-- End page content -->
  </div>


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
    var password = document.getElementById("password"),confirm_password = document.getElementById("confirm_password");
  

    function validatePassword(){
      if(password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Passwords Don't Match");
      } else {
        confirm_password.setCustomValidity('');
      }
    }
    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;

    function regis_failed(a){
      if(a){
        document.getElementById("registerfailed").style.display='block';
      }
    }
    </script>    
   


</body>
</html> 