<?php session_start();?>
<!DOCTYPE html>
<?php

include "db.php";
include "vendor-admin_redirect.php";

//checking if login has failed before
if(isset($_SESSION['loginVal'])){
$loginVal = $_SESSION['loginVal'];
}else $loginVal = false;

if(isset($_SESSION['regisSucc'])){
  $regisSucc = $_SESSION['regisSucc'];
  }else $regisSucc = false;

unset($_SESSION['regisVal']);

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
<!-- onload triggers if incorrect login is entered. also on correct registration-->    
<body onload="login_failed(<?php echo $loginVal ?>);regis_success(<?php $_SESSION['regisSucc']=false; echo $regisSucc ?>);">

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
<nav class="w3-sidebar w3-red w3-collapse w3-top w3-large w3-padding w3-card" style="z-index:3;width:250px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
  <div class="w3-container">
    <h3 class="w3-padding-16"><b>Sahara</b></h3>
  </div>
  <div class="w3-bar-block">
    <a href="index.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe88a</i>Home</a> 
    <a href="product.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe8cb</i>Products</a> 
    <a href="shoppingcart.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe8cc</i>Shopping cart</a>
  </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large w3-red w3-xlarge w3-padding">
  <a href="javascript:void(0)" class="w3-button w3-red w3-margin-right" onclick="w3_open()">☰</a>
  <span>Sahara</span>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->

<!--registration successfull popup -->
<div id="regissucc" class="w3-modal">
    <div class="w3-modal-content w3-animate-fadin w3-card-4" style="max-width:700px;">
      <div class="w3-container w3-teal w3-center">
        <span onclick="document.getElementById('regissucc').style.display='none'" 
        class="w3-button w3-display-topright">&times;</span>
        <h2>Account has been created!</h2>
      </div>
    </div>
  </div>
</div>

<div class="w3-main" style="margin-left:340px;margin-right:40px">
  <!-- login form -->
  <div class="w3-display-middle w3-card">
      <div class="w3-border w3-gray">
          <div class="w3-orange w3-container"><h2>Login to account</h2></div>
          <form class="w3-container" action="loginVal.php" method="POST">
            <label id="loginfailed" style="display: none;"><p style="color: red;">Incorrect Email\Username or password</p></label>
            <input name="Email" class="w3-input w3-border w3-round" style="margin-bottom: 10px; margin-top: 10px;" placeholder="Email\Username" type="text">
            
            <input name="Password" class="w3-input w3-border w3-round" style="margin-bottom: 10px;" placeholder="Password" type="password">

            <button type="submit" class="w3-btn w3-red w3-round">Login</button>
            <a class="w3-display-bottomright" style="margin-right: 16px; margin-bottom: 10px;" href="register.php">Register here</a>
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

    function login_failed(a){
      if(a){
        document.getElementById("loginfailed").style.display='block';
      }
    }

    function regis_success(b){
      if(b){
        document.getElementById('regissucc').style.display='block'
      }
      
    }
    // Get the modal
    var modal = document.getElementById('regissucc');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
    </script>    


</body>
</html> 