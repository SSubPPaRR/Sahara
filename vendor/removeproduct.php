<?php
session_start();
include '../db.php';

//delete image
$sql = 'SELECT Image_Path FROM images WHERE Product_ID ="'.$_GET['ID'].'";';
if($result = mysqli_query($conn, $sql)){
    $row = mysqli_fetch_row($result);
    $file = $row[0];
    if (!unlink($file)) {
        echo ("Error deleting $file");
      } else {
        echo ("Deleted $file");
      }
}

//delete image path from images
$sql = 'DELETE FROM images WHERE Product_ID ="'.$_GET['ID'].'";';
if (mysqli_query($conn, $sql)) {
    echo "image Record deleted successfully<br>";

    //delete product
    $sql = 'DELETE FROM product WHERE Product_ID ="'.$_GET['ID'].'";';
    if (mysqli_query($conn, $sql)) {
        echo "product Record deleted successfully<br>";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} 
else {
    echo "Error deleting record: " . mysqli_error($conn);
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