<?php session_start();?>
<!DOCTYPE html>
<?php
//db connection
include "db.php";
include "vendor-admin_redirect.php";

unset($_SESSION['loginVal']);
unset($_SESSION['regisVal']);

if(isset($_SESSION['product_added'])){
  $added= $_SESSION['product_added'];
}else $added= $_SESSION['product_added'] = false;

//is a user logged in
if(isset($_SESSION['loggedIn'])){
  $loggedIn = $_SESSION['loggedIn'];
}else $loggedIn =false;

if(isset($_SESSION['loggedID'])){
  $loggedId=$_SESSION['loggedID'];
}else $loggedId=$_SESSION['loggedID']=false;

if(!(isset($_SESSION['session_cart']))){
  $_SESSION['session_cart'] = array();
}
?>


<html>
<title>Sahara</title>
<meta charset="UTF-8">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>    
<body onload="added_alert(<?php $_SESSION['product_added'] = false; echo $added; ?>)">

<style>
body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
body {font-size:16px;}
.product-image{
  max-height: 200px;
  height: 100%;
  max-width: 100%;
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
    


    <!-- All categories -->
    <span><h2 style="margin-top: 20px; margin-bottom: 0;">Categories</h2></span>

    <?php
      //geting all the categories and placing them in the side-menu
      $sql = "SELECT Cat_Title,Cat_ID FROM categories;";
      $result = mysqli_query($conn,$sql);
      while($row = $result->fetch_assoc()){
        $categories = $row['Cat_Title'];
        $CatID = $row['Cat_ID'];
        echo '<a  onclick="w3_close();document.forms[\'category-Id-Form'.$CatID.'\'].submit();" class="w3-bar-item w3-button w3-hover-white">'.$categories.'</a>';
        
        echo'<form action="product.php" method="GET" name="category-Id-Form'.$CatID.'" style="display: none;">      
        <input type="hidden" name="CatID" value="'.$CatID.'"?>></form>';
      }  
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

  <!--product added popup-->
  <div id="productadded" class="w3-modal">
      <div class="w3-modal-content w3-animate-fadin w3-card-4" style="max-width:700px;">
        <div class="w3-container w3-teal w3-center">
          <span onclick="document.getElementById('productadded').style.display='none'" 
          class="w3-button w3-display-topright">&times;</span>
          <h2>Product added to cart!</h2>
        </div>
      </div>
    </div>

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


  <?php 
    // get category name to place in the header
    if(isset ($_GET['CatID'])){
      $CatID = $_GET['CatID'];
      $sql = "SELECT Cat_Title FROM categories WHERE Cat_ID = $CatID;";
      $result = mysqli_query($conn,$sql);
      while($row = $result->fetch_assoc()){
        $categoryName = $row['Cat_Title'];
      }
    }
    else $categoryName = "Full Catalog";
  ?>
  <div class="w3-container" style="margin-top:50px" id="showcase">
    <h1 class="w3-jumbo"><b><?php echo $categoryName?></b></h1>
  </div>
  
  

 <!-- Product Catalog -->
  <div class="w3-container" style="margin-top:30px">
    <h1 class="w3-xxxlarge w3-text-red"><b>Products</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
    
    <form class="w3-container w3-right" action="product.php" method="GET" style="display: flex;">
      <input class="w3-input w3-border w3-round" type="search" placeholder="Search..." name="key">
      <button class="w3-button w3-red w3-round" type="submit">Go</button>
    </form>
  </div>


     
    <div class="w3-row-padding w3-border w3-topbar w3-bottombar">
      <?php
      // checks if a catagory has been selected
      if(isset ($_GET['CatID'])){
        $CatID = $_GET['CatID'];
        $sql2= " SELECT Product_ID FROM product WHERE Cat_ID = $CatID;";
        //check if something has been searched for
      }elseif(isset($_GET['key'])){
        $key=$_GET['key'];
        $sql2= " SELECT Product_ID FROM product WHERE Keywords LIKE '%$key%';";
      }
      //if not then just show all products
      else $sql2 = "SELECT Product_ID FROM product;";

        $result = mysqli_query($conn,$sql2);
        $product_list= array();

        //getting product_ID and putting it into a array
        while($row = $result->fetch_assoc()){
          $product_ID = $row['Product_ID'];
          array_push($product_list,$product_ID);
        }
            //looping through the product_ID array and getting all the corresponding title and image_path
            foreach($product_list as $product_ID){
					
              $sql= "SELECT Title,Image_Path,Price,Discount,Vendor_Name FROM Product,Images,Vendor WHERE product.Product_ID = images.Product_ID AND product.Vendor_ID = vendor.Vendor_ID AND product.Product_ID = $product_ID;";
			
			  
			 	
              if($result = mysqli_query($conn, $sql)){
                    $row = mysqli_fetch_row($result);
                    //echo div with image, title, price and 'cart' & 'purchase' buttons and their forms.
					
			
					
                    echo'  <div class="w3-col m3 w3-margin-top w3-margin-bottom w3-border " style="overflow:hidden;padding-right: 0px;padding-left: 0px;">';
                              
                            if($row[3]!=0){
                              echo' 
                              <div class="w3-red">
                                <span>Discount: '.$row[3].'%</span>
                              </div>';   
                            }else { echo' <div class="w3-amber"style="height: 24px;"></div>';}
                   
                    echo     '<div class="w3-display-container w3-hover-opacity">
                                <div class="product-catalog" style="padding-right: 8px;padding-left: 8px;padding-bottom: 8px;">
                                        <div>
                                        <h3 class="crop-text" style="margin-bottom: 0;">'.$row[0].'</h3>
                                        <img class="product-image" src= "'.$row[1].'">
                                        </div>
                                </div>	
                              </div>
                                <div class="w3-orange"> 
                                        <span style="heigth:16px; width:100%;padding-left: 3px;">Price: $'.$row[2].'</span><button title="Purchase" onClick="document.forms[\'product-purchase-Form'.$product_ID.'\'].submit();" class="w3-button w3-hover-light-green w3-green w3-round w3-tiny w3-padding-small w3-right" style="margin-right: 3px;"><i class="material-icons w3-right w3-medium">&#xe227</i></button><button id="p.button'.$product_ID.'" onClick="document.forms[\'product-cart-Form'.$product_ID.'\'].submit();" title="Add to cart" class="w3-button w3-hover-orange w3-red w3-round w3-tiny w3-padding-small w3-right" style=" margin-right: 8px; "><i class="material-icons w3-right w3-medium">&#xe854</i></button><span style="heigth:16px; width:100%;padding-left: 3px;"></span><br><span>Vendor: '.$row[4].' </span>
                                    </div>
                            </div>
								
                            
                            <form action="addtocart.php" method="GET" name="product-cart-Form'.$product_ID.'" style="display: none;">      
                            <input type="hidden" name="ID" value="'.$product_ID.'"?>>
                        </form>
                        
                        <form action="purchase.php" method="GET" name="product-purchase-Form'.$product_ID.'" style="display: none;">      
                            <input type="hidden" name="ID" value="'.$product_ID.'"?>>
                        </form>'
                            ;
                  }   
              } 
              
        ?>
    </div>
         <?php include "currentpage.php";
          if($loggedIn){
            $sql ='SELECT Product_ID FROM shoppingcart WHERE User_ID = "'.$loggedId.'";';
            $result= mysqli_query($conn,$sql);
            $array=array();

            while($row = $result->fetch_assoc()){
              $product_ID = $row['Product_ID'];
              array_push($array,$product_ID);
            }
          }
          else{
            $array = $_SESSION['session_cart'];
          }

        
         
         
         ?>
         
    <!-- End page content -->
  </div>

    <!-- W3.CSS Container -->
    <div class="w3-light-grey w3-container w3-padding-32" style="margin-top:75px;padding-right:58px"></div>


    <script type="text/javascript">
    // Script to open and close sidebar
    function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
    }
    
    function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
    }

    function added_alert(a){
      if(a){
        document.getElementById('productadded').style.display='block'
      }
    }

    // Get the modal
    var modal = document.getElementById('productadded');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
    //disable products in shoppincart
    var array = <?php echo json_encode($array)?>;
    console.log(array[0])
    array.forEach(
    function (item){
      document.getElementById("p.button"+ item).disabled = true;
    });
    </script>    


</body>
</html> 