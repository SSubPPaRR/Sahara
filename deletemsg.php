<?php
include "db.php";

if($_GET['type'] == 0){
    echo'type == 0 admin accsess';

    $sql = 'DELETE FROM supportbox WHERE Support_ID ="'.$_GET['ID'].'";';
    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

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

else{
    $sql = 'DELETE FROM userinbox WHERE Support_ID ="'.$_GET['ID'].'";';
    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
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