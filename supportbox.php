<?php
session_start();
include 'db.php';

$id = $_POST['id'];
$subject = $_POST['subject'];
$subject = addslashes($subject);
$description = $_POST['description'];

if(!(basename($_FILES["image"]["name"]) =='')){
    include "upload.php";
    $attachment = $target_file;
    $sql="INSERT INTO supportbox (User_ID,Subject,Description,Attachment) VALUES ('".$id."','".$subject."','".$description."','".$attachment."');";

} else{
    echo'ata not exist';
    $sql="INSERT INTO supportbox (User_ID,Subject,Description) VALUES ('".$id."','".$subject."','".$description."')";

}


if (mysqli_query($conn, $sql)) {
    echo "Record added successfully";
     $_SESSION['msg_sent'] = true;



     
     mysqli_close($conn);
     ob_start(); // ensures anything dumped out will be caught
     $url = "support.php"; // this can be set based on whatever
    
     // clear out the output buffer
     while (ob_get_status()) 
     {
         ob_end_clean();
     }
    
     // redirect
     header( "Location: $url" );
    


} else {
    echo "Error adding record: " . mysqli_error($conn);
    $_SESSION['msg_sent'] = false;
}



 ?>