<?php
session_start();
include 'db.php';

$loggedId=$_SESSION['loggedID'];

if(isset($_SESSION['loggedIn'])){
    $loggedIn = $_SESSION['loggedIn'];
  }else $loggedIn =false;

//check if user is logged in
if($loggedIn){

    //check if the value is already in db
    $sql ='SELECT Product_ID FROM shoppingcart WHERE User_ID = "'.$loggedId.'";';
    $result= mysqli_query($conn,$sql);
    $product_list=array();

    while($row = $result->fetch_assoc()){
      $product_ID = $row['Product_ID'];
      array_push($product_list,$product_ID);
    }

    if(!in_array($_GET['ID'],$product_list)){
        $sql='INSERT INTO shoppingcart VALUES("'.$loggedId.'","'.$_GET['ID'].'")';
        if (mysqli_query($conn, $sql)) {
            echo "Record added successfully";
             $_SESSION['product_added'] = true;
        } else {
            echo "Error adding record: " . mysqli_error($conn);
        }
       
    }

}
else{
    //if user is not logged in
    if(!in_array($_GET['ID'],$_SESSION['session_cart'])){
    array_push($_SESSION['session_cart'],$_GET['ID']);
    $_SESSION['product_added'] = true;
    }
}

mysqli_close($conn);
ob_start(); // ensures anything dumped out will be caught

// do stuff here
$url = $_SESSION['previous_page']; // this can be set based on whatever

// clear out the output buffer
while (ob_get_status()) 
{
    ob_end_clean();
}

// no redirect
header( "Location: $url" );
?>