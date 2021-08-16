<?php
include "db.php";

if($_GET['type'] == 0){
echo 'type == 0';
    if($_GET['markread'] == true){
        echo'true checked';
        $sql = 'UPDATE supportbox SET Readmsg = 1 WHERE Support_ID = '.$_GET['ID'].'';
    }
    else $sql = 'UPDATE supportbox SET Readmsg = 0 WHERE Support_ID = '.$_GET['ID'].'';
    
    if (mysqli_query($conn, $sql)) {
        echo "Record added successfully";
    } 
    else {
        echo "Error adding record: " . mysqli_error($conn);
    }

    if($r2m){
        mysqli_close($conn);
        ob_start(); // ensures anything dumped out will be caught
        $url = "support-inbox.php"; // this can be set based on whatever

        // clear out the output buffer
        while (ob_get_status()) 
        {
            ob_end_clean();
        }

        // redirect
        header( "Location: $url" );
    }
    else{

        mysqli_close($conn);
        ob_start(); // ensures anything dumped out will be caught
        $url = "admin\support-inbox.php"; // this can be set based on whatever

        // clear out the output buffer
        while (ob_get_status()) 
        {
            ob_end_clean();
        }

        // redirect
        header( "Location: $url" );
    }

}
else{
    if($_GET['markread'] == true||$_GET['markread'] == 1){
        echo'true checked';
        $sql = 'UPDATE userinbox SET Readmsg = 1 WHERE Support_ID = '.$_GET['ID'].'';
    }
    else $sql = 'UPDATE userinbox SET Readmsg = 0 WHERE Support_ID = '.$_GET['ID'].'';

    if (mysqli_query($conn, $sql)) {
        echo "Record added successfully";
    } 
    else {
        echo "Error adding record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
    ob_start(); // ensures anything dumped out will be caught
    $url = "inbox.php"; // this can be set based on whatever
   
    // clear out the output buffer
    while (ob_get_status()) 
    {
        ob_end_clean();
    }
   
    // redirect
    header( "Location: $url" );

   



}






?>