<?php session_start();?>
<!DOCTYPE html>
<?php
include "db.php";
include "vendor-admin_redirect.php";

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
.product-catalog div{
   height:290px;
}
.product-catalog div:hover{
    opacity:0.60;
}
.product-image{
  max-height: 290px;
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
    <a href="shoppingcart.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe8cc</i>Shoppingcart</a>
    
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
    <!--if a user is logged in display name -->
  <div class="w3-display-topmiddle">
    <?php
      if($loggedIn){
        
          echo '<div class=" w3-container w3-red w3-card w3-hide-small w3-center w3-animate-top">
                  <span>'.$_SESSION['loggedName'].'</span>
                </div>';
      }
    ?>
  </div>
  
  <!-- title-->
  <div class="w3-container" style="margin-top:50px">
    <h1 class="w3-jumbo"><b>Shopping cart</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
    <button class="w3-button w3-red w3-right w3-round" style="margin-bottom: 10px;" onclick="document.forms['product-Id-Form'].submit()">Clear cart</button>
    <form action="removefromcart.php" method="GET" name="product-Id-Form" style="display: none;">      
            <input type="hidden" name="ID" value="0"?>
        </form>
  </div>
  



  <!-- Shoppingcart contents -->

    <table class="w3-table-all w3-hoverable">
            <tr class="w3-red">
              <th>Product Name</th>
              <th>Vendor</th>
              <th>Price</th>
              <th>purchase</th>
              <th>Delete</th>
            </tr>
            <?php
            // check if user is logged in.
            if($loggedIn){           

              //check user's shopping cart in db is empty.
              $loggedId=$_SESSION['loggedID'];
              $sql='SELECT COUNT(*) FROM `shoppingcart` WHERE `User_ID`= "'.$loggedId.'";';
              
              if($result = mysqli_query($conn, $sql)){
                $row = mysqli_fetch_row($result);
                if($row[0]==0){
                  echo '<h3 class="w3-border" style="margin-top:0;">Your shopping cart is empty.</h3>';
                }
  
                else{

                  //get product_ID from shopping cart table for this user and add it to the table.
                  $sql ='SELECT Product_ID FROM shoppingcart WHERE User_ID = "'.$loggedId.'";';
                  $result= mysqli_query($conn,$sql);
                  $product_list=array();

                  while($row = $result->fetch_assoc()){
                    $product_ID = $row['Product_ID'];
                    array_push($product_list,$product_ID);
                  }
                  foreach($product_list as $ProductID){
                    $sql ="SELECT product.Title,vendor.Vendor_Name,product.Price FROM product,vendor WHERE vendor.Vendor_ID = product.Vendor_ID AND product.Product_ID = $ProductID;";
                    if($result = mysqli_query($conn, $sql)){
                      $row = mysqli_fetch_row($result);
                      
                      //place product info in corresponding cells.
                      echo '
                      <tr>
                        <td>'.$row[0].'</td>
                        <td>'.$row[1].'</td>
                        <td>$'.$row[2].'</td>
                        <td><span onclick="document.forms[\'product-purchase-Form'.$ProductID.'\'].submit();" class="w3-button w3-green w3-hover-light-green"><i class="material-icons w3-left">&#xe263</i></span></td>
                        <td><span onclick="document.forms[\'product-delete-Form'.$ProductID.'\'].submit();" class="w3-button w3-red w3-hover-orange"><i class="material-icons w3-left">&#xe872</i></span></td>
                      </tr>
                    
                      <form action="removefromcart.php" method="GET" name="product-delete-Form'.$ProductID.'" style="display: none;">      
                      <input type="hidden" name="ID" value="'.$ProductID.'"?>
                      </form>
                      <form action="purchase.php" method="GET" name="product-purchase-Form'.$ProductID.'" style="display: none;">      
                      <input type="hidden" name="ID" value="'.$ProductID.'"?>
                      </form>';
                    }
                  }
                                   
                }
              }
            }
            else{

            //if user isn't logged in, get list of products from session array.
              if(empty($_SESSION['session_cart'])){echo '<h3 class="w3-border" style="margin-top:0;">Your shopping cart is empty.</h3>';}
                else{
                  foreach($_SESSION['session_cart'] as $ProductID){
                    $sql ="SELECT product.Title,vendor.Vendor_Name,product.Price FROM product,vendor WHERE vendor.Vendor_ID = product.Vendor_ID AND product.Product_ID = $ProductID;";
                    if($result = mysqli_query($conn, $sql)){
                      $row = mysqli_fetch_row($result);
                      
                      //place product info in corresponding cells.
                      echo '
                      <tr>
                        <td>'.$row[0].'</td>
                        <td>'.$row[1].'</td>
                        <td>$'.$row[2].'</td>
                        <td><span onclick="document.forms[\'product-purchase-Form'.$ProductID.'\'].submit();" class="w3-button w3-green w3-hover-light-green"><i class="material-icons w3-left">&#xe263</i></span></td>
                        <td><span onclick="document.forms[\'product-delete-Form'.$ProductID.'\'].submit();" class="w3-button w3-red w3-hover-orange"><i class="material-icons w3-left">&#xe872</i></span></td>
                      </tr>
                    
                      <form action="removefromcart.php" method="GET" name="product-delete-Form'.$ProductID.'" style="display: none;">      
                      <input type="hidden" name="ID" value="'.$ProductID.'"?>
                      </form>
                      <form action="login.php" method="GET" name="product-purchase-Form'.$ProductID.'" style="display: none;">      
                      <input type="hidden" name="ID" value="'.$ProductID.'"?>
                      </form>';
                    }
                  }
              }
            }
        ?>
</table>


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
    </script>    


</body>
</html> 