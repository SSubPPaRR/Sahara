<?php
session_start();
include '..\db.php';

$name = $_POST['name'];


$sql='INSERT INTO `categories`(`Cat_Title`) VALUES ("'.$name.'")';
if (mysqli_query($conn, $sql)) {
    echo "Record added successfully";
} 
else {
    echo "Error adding record: " . mysqli_error($conn);
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