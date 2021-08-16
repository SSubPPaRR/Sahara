<?php session_start();?>
<!DOCTYPE html>
<?php
include "..\db.php";
include "..\user-redirect.php";

unset($_SESSION['loginVal']);
unset($_SESSION['regisVal']);

//is a user logged in
if(isset($_SESSION['loggedIn'])){
  $loggedIn = $_SESSION['loggedIn'];
}else $loggedIn =false;

if(isset($_POST['Edit'])){
  $edit = $_POST['Edit'];
}else $edit =false;

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
<body>

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
    <a href="index.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe88a</i>Vendor info</a> 
    <a href="products.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe8cb</i>Products</a> 
    <a href="..\logout.php"  onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white" >Logout</a>
    </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large w3-red w3-xlarge w3-padding">
  <a href="javascript:void(0)" class="w3-button w3-red w3-margin-right" onclick="w3_open()">☰</a>
  <span>Sahara</span>
  <!--login-->
    <a class="w3-right w3-large" style="margin-top:10px;" href="..\logout.php">Logout</a><span class="w3-large w3-right w3-padding"><?php echo $_SESSION['loggedName']?></span>
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
    <h1 class="w3-jumbo"><b>Products</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
    <form class="w3-container w3-right" action="products.php" method="GET" style="display: flex;">
      <input class="w3-input w3-border w3-round" type="search" placeholder="Search..." name="key">
      <button class="w3-button w3-red w3-round" type="submit">Go</button>
    </form>
    <button class="w3-button w3-green w3-left w3-round" style="margin-bottom: 10px;" onclick="document.getElementById('product-add-form').style.display='block'">Add product</button>
  </div>
  



  <!-- Vendor products -->

    <table class="w3-table-all w3-hoverable">
            <tr class="w3-red">
              <th>Product Name</th>
              <th>Category</th>
              <th>Description</th>
              <th>Base price</th>
              <th>Discount</th>
              <th>keywords</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
            <?php
              //check if the vendor has any products.
              $loggedId=$_SESSION['loggedID'];
              $sql='SELECT COUNT(*) FROM `product` WHERE `Vendor_ID`= "'.$loggedId.'";';
              
              if($result = mysqli_query($conn, $sql)){
                $row = mysqli_fetch_row($result);
                if($row[0]==0){
                  echo '<h3 class="w3-border" style="margin-top:0;">You don\'t have any products.</h3>';
                }
  
                else{
                  //check for search key
                  if(isset($_GET['key'])){
                    $key=$_GET['key'];
                    $sql ='SELECT Product_ID FROM product WHERE  Keywords LIKE "%'.$key.'%" AND Vendor_ID = "'.$loggedId.'";';
                  }
                  else $sql ='SELECT Product_ID FROM product WHERE Vendor_ID = "'.$loggedId.'";';

                  $result= mysqli_query($conn,$sql);
                  $product_list=array();

                  while($row = $result->fetch_assoc()){
                    $product_ID = $row['Product_ID'];
                    array_push($product_list,$product_ID);
                  }
                  foreach($product_list as $ProductID){

                    $sql ='SELECT Title,Cat_Title,Description,Base_Price,Discount,Keywords,product.Cat_ID,Quantity FROM product,categories WHERE product.Cat_ID=categories.Cat_ID AND Product_ID= "'.$ProductID.'";';
                    if($result = mysqli_query($conn, $sql)){
                      $row = mysqli_fetch_row($result);
                      
                      //place product info in corresponding cells.
                      echo '
                      <tr id="'.$ProductID.'">
                        <td>'.$row[0].'</td>
                        <td>'.$row[1].'</td>
                        <td>'.$row[2].'</td>
                        <td>$'.$row[3].'</td>
                        <td>'.$row[4].'%</td>
                        <td>'.$row[5].'</td>
                        <td><span onclick="document.forms[\'product-edit-FormVal'.$ProductID.'\'].submit();" class="w3-button w3-green w3-hover-light-green"><i class="material-icons w3-left">&#xe3c9</i></span></td>
                        <td><span onclick="document.forms[\'product-delete-Form'.$ProductID.'\'].submit();" class="w3-button w3-red w3-hover-orange"><i class="material-icons w3-left">&#xe872</i></span></td>
                      </tr>
                    
                      <form action="removeproduct.php" method="GET" name="product-delete-Form'.$ProductID.'" style="display: none;">      
                      <input type="hidden" name="ID" value="'.$ProductID.'"?>
                      </form>

                      <form action="" method="POST" name="product-edit-FormVal'.$ProductID.'" style="display: none;">      
                        <input type="hidden" name="Edit" value="true"?>
                        <input type="hidden" name="ID" value="'.$ProductID.'"?>
                        <input type="hidden" name="Productname" value="'.$row[0].'"?>
                        <input type="hidden" name="Category" value="'.$row[6].'"?>
                        <input type="hidden" name="Description" value="'.$row[2].'"?>
                        <input type="hidden" name="Baseprice" value="'.$row[3].'"?>
                        <input type="hidden" name="Discount" value="'.$row[4].'"?>
                        <input type="hidden" name="Keywords" value="'.$row[5].'"?>
                        <input type="hidden" name="Quantity" value="'.$row[7].'"?>
                      </form>';
                    }
                  }   
                }    
              }
            
        ?>
</table>
<!--product add form-->
<form id="product-add-form" class="w3-container w3-card w3-padding w3-display-middle w3-white w3-animate-opacity"  action="addproduct.php" method="POST" enctype="multipart/form-data" style="width: 400px; display: none;">
        <header><h3>Add product</h3></header><span class="w3-display-topright w3-padding w3-hover-grey" onclick="document.getElementById('product-add-form').style.display='none'">&times;</span>
        <input class="w3-input" type="text" name="Productname" placeholder="Product name" required>
        <select  class="w3-select" name="category" required>
          <option value="" disabled selected>category</option>
          <?php
            //getting categories
            $sql ='SELECT Cat_ID FROM categories';
            $result = mysqli_query($conn,$sql);
            $cat_list= array();

            while($row = $result->fetch_assoc()){
              $cat_ID = $row['Cat_ID'];
              array_push($cat_list,$cat_ID);
            }
            foreach($cat_list as $cat_ID){
              $sql ='SELECT Cat_Title FROM categories WHERE Cat_ID = "'.$cat_ID.'"';

              if($result = mysqli_query($conn, $sql)){
                $row = mysqli_fetch_row($result);
                
                echo'<option value="'.$cat_ID.'">'.$row[0].'</option>';

              }
            }
          ?>
        </select>
        <input class="w3-input" type="text" name="Description" placeholder="Description" required>
        <input class="w3-input" type="number" min="1" name="Quantity" placeholder="Quantity" required>
        <input class="w3-input" type="number" step="0.01" name="Baseprice" placeholder="Base price($)" required>
        <input class="w3-input" type="number" min="0" max="100" name="Discount" placeholder="Discount(%)" required>
        <input class="w3-input" type="text" name="Keywords" placeholder="Keywords E.g(Sport,Basketball,Ball)" required>
        <input type="hidden" name="dir" value="../images/">
        <input class="form-control w3-button w3-round" type="file"  id="image" name="image" required><br>

        <button class="w3-btn w3-blue  w3-round w3-margin" type="submit">GO</button>
    </form>

    <!--product edit form-->
    <form id="product-edit-form" class="w3-container w3-card w3-padding w3-display-middle w3-white w3-animate-opacity"  action="editproduct.php" method="POST" enctype="multipart/form-data" style="width: 400px; display: none;">
        <header><h3>Edit product</h3></header><span class="w3-display-topright w3-padding w3-hover-grey" onclick="document.getElementById('product-edit-form').style.display='none'">&times;</span>
        <input type="hidden" name="ID" value=<?php echo '"'.$_POST['ID'].'"' ?>>
        <input class="w3-input" type="text" name="Productname" placeholder="Product name" value=<?php echo '"'.$_POST['Productname'].'"' ?>>
        <select  class="w3-select" value="1" name="category" id="">
            <option value="" disabled >category</option>
            <?php
                //getting categories
                $sql ='SELECT Cat_ID FROM categories';
                $result = mysqli_query($conn,$sql);
                $cat_list= array();

                while($row = $result->fetch_assoc()){
                $cat_ID = $row['Cat_ID'];
                array_push($cat_list,$cat_ID);
                }
                foreach($cat_list as $cat_ID){
                $sql ='SELECT Cat_Title FROM categories WHERE Cat_ID = "'.$cat_ID.'"';

                if($result = mysqli_query($conn, $sql)){
                  $row = mysqli_fetch_row($result);
                  
                  if($cat_ID == $_POST['Category']){
                      echo'<option value="'.$cat_ID.'" selected>'.$row[0].'</option>';
                  }else echo'<option value="'.$cat_ID.'">'.$row[0].'</option>';
                }
              }
            ?>  
        </select>
        <input class="w3-input" type="text" name="Description" placeholder="Description" value=<?php echo '"'.$_POST['Description'].'"' ?>>
        <input class="w3-input" type="number" min="1" name="Quantity" placeholder="Quantity" value=<?php echo '"'.$_POST['Quantity'].'"' ?>>
        <input class="w3-input" type="number" step="0.01" name="Baseprice" placeholder="Base price" value=<?php echo '"'.$_POST['Baseprice'].'"' ?>>
        <input class="w3-input" type="number" min="0" max="100" name="Discount" placeholder="Discount" value=<?php echo '"'.$_POST['Discount'].'"' ?>>
        <input class="w3-input" type="text" name="Keywords" placeholder="Keywords e.g(Sport,Basketball,Ball)" value=<?php echo '"'.$_POST['Keywords'].'"' ?>>
        <input type="hidden" name="dir" value="../images/">
        <input class="form-control w3-button w3-round" type="file"  id="image" name="image"><br>
        <button class="w3-btn w3-blue  w3-round w3-margin" type="submit">GO</button>
    </form>

</div>
  <?php 
    include "..\currentpage.php";
    mysqli_close($conn);
  ?>

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
    <script>
      if(<?php echo $edit?>){
            document.getElementById('product-edit-form').style.display='block'
        }
    </script>

</body>
</html> 