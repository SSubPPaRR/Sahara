<?php
session_start();
include '..\db.php';

$productname = $_POST['Productname'];
$category = $_POST['category'];
$vendor = $_SESSION['loggedID'];
$Description = $_POST['Description'];
$quantity = $_POST['Quantity'];
$baseprice = $_POST['Baseprice'];
$discount = $_POST['Discount'];
$price =$baseprice - $baseprice*($discount/100);
$keywords = $_POST['Keywords'];

$sql='INSERT INTO product(Title,Cat_ID,Vendor_ID,Description,Quantity,Base_Price,Discount,Price,Keywords) 
VALUES("'.$productname.'","'.$category.'","'.$vendor.'","'.$Description.'","'.$quantity.'","'.$baseprice.'","'.$discount.'","'.$price.'","'.$keywords.'")';
if (mysqli_query($conn, $sql)) {
    echo "Record added successfully";
} 
else {
    echo "Error adding record: " . mysqli_error($conn);
}

//add image
$sql = 'SELECT Product_ID FROM product WHERE Title = "'.$productname.'"';
if($result = mysqli_query($conn, $sql)){
    $row = mysqli_fetch_row($result);
    include "..\upload.php";

    $target_file = str_replace("../","",$target_file);
    $sql = 'INSERT INTO images VALUES ("'.$row[0].'","'.$target_file.'")';
    
    if (mysqli_query($conn, $sql)) {
        echo 'image path inserted';
    } 
    else {
        echo "Error adding record: " . mysqli_error($conn);
    }

    
} 
else {
    echo "Error getting record: " . mysqli_error($conn);
}

mysqli_close($conn);
 ob_start(); // ensures anything dumped out will be caught
 $url = $_SESSION['previous_page']; // this can be set based on whatever

 // clear out the output buffer
 while (ob_get_status()) 
 {
     ob_end_clean();
 }

 // redirect
 header( "Location: $url" );
 
?>