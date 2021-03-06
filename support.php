<?php session_start();?>
<!DOCTYPE html>
<?php
include "db.php";
include "vendor-admin_redirect.php";

$_SESSION['loginVal']=false;

if(isset($_SESSION['msg_sent'])){
  $msg_sent = $_SESSION['msg_sent'];
}else $msg_sent =false;
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
<body onload="sent_modal(<?php $_SESSION['msg_sent'] = false; echo $msg_sent; ?>)">

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
  <a href="javascript:void(0)" class="w3-button w3-red w3-margin-right" onclick="w3_open()">???</a>
  <span>Sahara</span>
  <!--logout-->      
  <a class="w3-right w3-large" style="margin-top:10px;" href="logout.php">Logout</a><span class="w3-large w3-right w3-padding"> </span>
  
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">
<div id="message-sent" class="w3-modal">
      <div class="w3-modal-content w3-animate-fadin w3-card-4" style="max-width:700px;">
        <div class="w3-container w3-teal w3-center">
          <span onclick="document.getElementById('message-sent').style.display='none'" 
          class="w3-button w3-display-topright">&times;</span>
          <h2>Message has been sent!</h2>
        </div>
      </div>
    </div>

  <!-- Header -->
  <div class="w3-container" style="margin-top:50px">
    <h1 class="w3-jumbo"><b>Support</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
  </div>
  <b>Welcome,</b> 
  <span><?php echo $_SESSION['loggedName']?></span>
  
  <br>
  <br>

<!--Support Ticket Form-->
<form action="supportbox.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="id" value=<?php echo '"'.$_SESSION['loggedID'].'"' ?>>
  <fieldset class="w3-card-4">
    <legend><b>Support Ticket Form:</b></legend>
    <br>
    Subject:
    <br>
    <input class="w3-input w3-animate-input w3-border w3-round" style="width: 30%" type="text" name="subject" required>
    <br>
    <br>
    Describe the issue:
    <br>
    <textarea  name="description" class="w3-round" cols="32" required></textarea>
    <br>
    <br>
    <label for="image">Upload Attachment:</label>
    <br>
    <input type="hidden" name="dir" value="Support_Attachments/">
    <input class="form-control w3-button w3-round" type="file"  id="image" name="image" ><br><br>
    <input class=" w3-button w3-round w3-red" type="submit" value="Submit">
  </fieldset>
</form>
</div>
  

    <!-- End page content -->
  <?php include "currentpage.php"
  
  ?>
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

    function sent_modal(a){
      if(a){
        document.getElementById('message-sent').style.display='block'
      }
    }

    // Get the modal
    var modal = document.getElementById('message-sent');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
    </script>    


</body>
</html> 