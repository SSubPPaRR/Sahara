<?php
session_start();
include '../db.php';

$adminid = $_POST['ID'];
$username = $_POST['username'];
$name =  $_POST['name'];

if(!($_POST['password']=="")){
echo'password change';
    $password = $_POST['password'];
    $sql="UPDATE admin SET User_name ='$username', Password = '$password', Name = '$name' WHERE Admin_ID = '$adminid';";

    if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully";
       $_SESSION['changepass-succ'] = true;
       
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
else{
    $sql="UPDATE admin SET User_name ='$username', Name = '$name' WHERE Admin_ID = '$adminid';";
    
    if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully";
        $_SESSION['changepass-succ']  = true;

    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
 ob_start(); // ensures anything dumped out will be caught
 $url = $_SESSION['previous_page']."#".$adminid; // this can be set based on whatever

 // clear out the output buffer
 while (ob_get_status()) 
 {
     ob_end_clean();
 }

 // redirect
 header( "Location: $url" );
?>