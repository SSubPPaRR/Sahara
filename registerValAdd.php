<?php
session_start();
include "db.php";

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$adress = $_POST['adress'];
$email = $_POST['email'];
$password = $_POST['password'];

//check if email is already in use
$sql = 'SELECT COUNT(*) FROM `user` WHERE `Email`="'.$email.'"';
if($result = mysqli_query($conn, $sql)){
    $row = mysqli_fetch_row($result);
    if($row[0] > 0){
        echo 'register fail';
        
        //var that indicates the registration failed
        $_SESSION['regisVal']= true;
        //send back to register page
        ob_start(); // ensures anything dumped out will be caught
        $url = "register.php"; // this can be set based on whatever
        // clear out the output buffer
        while (ob_get_status()) 
        {
            ob_end_clean();
        }
        // redirect
        header( "Location: $url" );

    }
    else{
        $sql='INSERT INTO user (First_Name,Last_Name,Addres,Email,Password) VALUES ("'.$firstname.'","'.$lastname.'","'.$adress.'","'.$email.'","'.$password.'")';
        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
            
            $_SESSION['regisSucc']= true;
            ob_start(); // ensures anything dumped out will be caught
            $url = "login.php"; // this can be set based on whatever
            // clear out the output buffer
            while (ob_get_status()) 
            {
                ob_end_clean();
            }
            // redirect
            header( "Location: $url" );

        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        
        mysqli_close($conn);
    }
}
?>