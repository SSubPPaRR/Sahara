<?php
session_start();
include '../db.php';

$productid = $_POST['ID'];
$productname = $_POST['Productname'];
$category = $_POST['category'];
$vendor = $_SESSION['loggedID'];
$Description = $_POST['Description'];
$quantity = $_POST['Quantity'];
$baseprice = $_POST['Baseprice'];
$discount = $_POST['Discount'];
$price =$baseprice - $baseprice*($discount/100);
$keywords = $_POST['Keywords'];

// update photo if needed
if(!(basename($_FILES["image"]["name"]) =='')){

    //delete old image
    $sql = "SELECT Image_Path FROM images WHERE Product_ID = '$productid';" ;
    if($result = mysqli_query($conn, $sql)){
        $row = mysqli_fetch_row($result);
        $file = $row[0];
        if (!unlink($file)) {
            echo ("Error deleting $file");
        } else {
            echo ("Deleted $file");
        }
    }

    include "../upload.php";
    $target_file = str_replace("../","",$target_file);

    $sql="UPDATE images SET Image_Path ='$target_file' WHERE Product_ID = '$productid';";

    if (mysqli_query($conn, $sql)) {
        echo "image path updated successfully";
    } else {
        echo "Error updating image path: " . mysqli_error($conn);
    }
}


$sql="UPDATE product SET Title ='$productname', Cat_ID = '$category', Description = '$Description', Quantity = '$quantity', Base_Price ='$baseprice' , Discount ='$discount' , Price = '$price', Keywords ='$keywords' WHERE Product_ID = '$productid';";

if (mysqli_query($conn, $sql)) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
 ob_start(); // ensures anything dumped out will be caught
 $url = $_SESSION['previous_page']."#".$productid; // this can be set based on whatever

 // clear out the output buffer
 while (ob_get_status()) 
 {
     ob_end_clean();
 }

 // redirect
 header( "Location: $url" );
?>