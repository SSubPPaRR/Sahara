<?php
include "db.php";
session_start();

$userid= $_GET['id'];




//profile update type, 0 = user, 1 = user password, 2 = vendor, 3= vendor password 

switch($_GET['type']){

    case 0:
        $firstname = $_GET['firstname'];
        $lastname= $_GET['lastname'];
        $email = $_GET['email'];
        $address = $_GET['address'];

        $sql="UPDATE user SET  First_Name = '$firstname', Last_Name = '$lastname', Addres = '$address',Email = '$email' WHERE User_ID = '$userid'";
        if (mysqli_query($conn, $sql)) {
            echo 'profile updated';
            


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
        } 
        else {
            echo "Error adding record: " . mysqli_error($conn);
        }


    break;
   
    case 1:
        $password =$_GET['password'];

        $sql="UPDATE user SET  Password = '$password' WHERE User_ID = '$userid'";
        if (mysqli_query($conn, $sql)) {
            echo 'profile updated';
            
            $_SESSION['changepass-succ'] = true;

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
        } 
        else {
            echo "Error adding record: " . mysqli_error($conn);
        }

    break;
    
    case 2:

        $vendorname = $_GET['vendorname'];
        $username= $_GET['username'];
        $address = $_GET['address'];
        $phonenumber = $_GET['phonenumber'];

        $sql="UPDATE vendor SET  Vendor_Name = '$vendorname', User_Name = '$username', Address = '$address', Phone_Number = '$phonenumber' WHERE Vendor_ID = '$userid';";
        if (mysqli_query($conn, $sql)) {
            echo 'profile updated';
            


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
        } 
        else {
            echo "Error adding record: " . mysqli_error($conn);
        }


    break;
    
    case 3:
    $password =$_GET['password'];

    $sql="UPDATE vendor SET  Password = '$password' WHERE Vendor_ID = '$userid'";
    if (mysqli_query($conn, $sql)) {
        echo 'profile updated';
        
        $_SESSION['changepass-succ'] = true;

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
    } 
    else {
        echo "Error adding record: " . mysqli_error($conn);
    }
    break;
}


   
?>