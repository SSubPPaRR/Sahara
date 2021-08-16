<?php session_start();?>
<!DOCTYPE html>
<?php
include "vendor-admin_redirect.php";
include "db.php";
unset($_SESSION['loginVal']);
unset($_SESSION['regisVal']);

//is a user logged in
if(isset($_SESSION['loggedIn'])){
  $loggedIn = $_SESSION['loggedIn'];
}else $loggedIn =false;

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
<body>

<style>
body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
body {font-size:16px;}

html{
  overflow: hidden;
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
    <!--login-->
    <?php
    if($loggedIn){

      echo '<a href="profile.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe7fd</i>Profile</a>   
            <a href="support.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">live_help</i> Support</a>';
            
            $loggedId=$_SESSION['loggedID'];
            $sql = 'SELECT COUNT(*) FROM userinbox WHERE Readmsg = 0 AND  User_ID = "'.$loggedId.'"';
            if($result = mysqli_query($conn, $sql)){
                $row = mysqli_fetch_row($result);
                echo  '<a href="inbox.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe156</i>Support Inbox<span class="w3-badge w3-white w3-right">'.$row[0].'</span></a>';  
            }

      echo  '<a href="logout.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe7ff</i>Logout</a>';
    }
    else echo '<a href="login.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe7fd</i>Login</a>';
    ?>
  </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large w3-red w3-xlarge w3-padding">
  <a href="javascript:void(0)" class="w3-button w3-red w3-margin-right" onclick="w3_open()">☰</a>
  <span>Sahara</span>
  <!--login-->
  <?php
     if($loggedIn){
      
        echo'<a class="w3-right w3-large" style="margin-top:10px;" href="logout.php">Logout</a><span class="w3-large w3-right w3-padding">'.$_SESSION['loggedName'].'</span>';
     }
     else echo'<a class="w3-right" href="login.php">Login</a>';
  ?>
 
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">

  <!-- Header -->
  <div class="w3-display-middle">

  <?php
     if($loggedIn){
      
        echo '<div class=" w3-container w3-red w3-card w3-hide-small w3-center w3-animate-top">
                <span>'.$_SESSION['loggedName'].'</span>
              </div>';
     }
  ?>

    

    <h1 class="w3-jumbo w3-animate-top">WELCOME</h1>
    <hr class="w3-border-grey" style="margin:auto;width:40%">
    <p class="w3-large w3-center w3-animate-bottom">Sahara</p>
  </div>


  <?php include "currentpage.php"?>
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
    </script>    


</body>
</html> 