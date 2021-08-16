<?php session_start();?>
<!DOCTYPE html>
<?php
include "db.php";
include "vendor-admin_redirect.php";

if(isset($_SESSION['changepass-succ'])){
  $changepass = $_SESSION['changepass-succ'];
  }else $changepass = false;

$_SESSION['loginVal']=false;
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
    <a href="index.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe88a</i> Home</a> 
    <a href="product.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe8cb</i> Products</a> 
    <a href="shoppingcart.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe8cc</i> Shoppingcart</a>
    <!--login-->
    <a href="profile.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe7fd</i> Profile</a>	
	  <a href="support.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">live_help</i> Support</a> 
    <?php
       $loggedId=$_SESSION['loggedID'];
       $sql = 'SELECT COUNT(*) FROM userinbox WHERE Readmsg = 0 AND  User_ID = "'.$loggedId.'"';

       if($result = mysqli_query($conn, $sql)){
           $row = mysqli_fetch_row($result);
           echo  '<a href="inbox.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe156</i>Support Inbox<span class="w3-badge w3-white w3-right">'.$row[0].'</span></a>';  
       }
    ?>
    <a href="logout.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe7ff</i> Logout</a> 
  </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large w3-red w3-xlarge w3-padding">
  <a href="javascript:void(0)" class="w3-button w3-red w3-margin-right" onclick="w3_open()">☰</a>
  <span>Sahara</span>
  <!--logout-->      
  <a class="w3-right w3-large" style="margin-top:10px;" href="logout.php">Logout</a><span class="w3-large w3-right w3-padding"> </span>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">

  <!-- Header -->
  <div class="w3-container" style="margin-top:50px">
    <h1 class="w3-jumbo"><b>Profile</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
  </div>
  <button class="w3-button w3-orange w3-round w3-right" onclick="document.getElementById('Password-change-form').style.display='block'">Change password</button>
  <?php
    $sql='SELECT First_Name, Last_Name,Email,Addres FROM user WHERE User_ID= '.$_SESSION["loggedID"].'';
    if($result = mysqli_query($conn, $sql)){
      $row = mysqli_fetch_row($result);
      echo '<span style="margin-left:10px;"><b>Welcome</b>, '.$row[0]." ".$row[1].'</span>';
    
      echo'<div class="w3-border w3-card-4 w3-container" style="margin-top: 20px;">
      <h5>If you would like to change your account information, please fill it down below.</h5>
      <form  action="profileupdate.php" method="GET">
      
          First Name: <input class="w3-input" type="text" name="firstname" value="'.$row[0].'"><br><br>
          Last Name: <input class="w3-input" type="text" name="lastname" value="'.$row[1].'"><br><br>
          E-mail:  <input class="w3-input" type="email" name="email" value="'.$row[2].'"><br><br>
          Adres:  <input class="w3-input" type="text" name="address" value="'.$row[3].'"><br><br>
          <input type="hidden" name="id" value="'.$_SESSION['loggedID'].'">
          <input type="hidden" name="type" value="0">
          <button class="w3-input w3-button w3-red " type="submit">Update Info</button>
      </form>
    </div>';
    }
  ?>

  <div id="Password-change-form" class="w3-display-middle w3-card w3-container w3-white w3-padding" style="display: none;">
  <span onclick="document.getElementById('Password-change-form').style.display='none'" class="w3-button w3-display-topright">&times;</span>
    <h5>Change password</h5>
    <form action="profileupdate.php">
      <input id="current_password" class="w3-input" type="password" name="currentpw" placeholder="current password" >
      <input id="password" class="w3-input" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="New password" name="password" type="password">
      <input id="confirm_password" class="w3-input" style="margin-bottom: 10px;" placeholder="Confirm Password" name="confirmpw" type="password">
      <input type="hidden" name="type" value="1">
      <input type="hidden" name="id" value="<?php echo $_SESSION['loggedID'];?>">
      <button class="w3-button w3-round w3-red">submit</button>
    </form>
    <?php 
      $sql = 'SELECT password FROM user Where User_ID = '.$loggedId.'';
      if($result = mysqli_query($conn, $sql)){
        $row = mysqli_fetch_row($result); 
        $password = $row[0];       
      }
       ?>
  </div>
  <!--password change successfull popup -->
<div id="changepass-succ" class="w3-modal">
    <div class="w3-modal-content w3-animate-fadin w3-card-4" style="max-width:700px;">
      <div class="w3-container w3-teal w3-center">
        <span onclick="document.getElementById('changepass-succ').style.display='none'" class="w3-button w3-display-topright">&times;</span>
        <h2>Password has been changed!</h2>
      </div>
    </div>
  </div>
</div>






</div>

  <?php include "currentpage.php"?>

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