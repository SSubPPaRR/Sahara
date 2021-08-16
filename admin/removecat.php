<?php
session_start();
include '../db.php';


    //delete category
    $sql = 'DELETE FROM categories WHERE Cat_ID ="'.$_GET['ID'].'";';
    if (mysqli_query($conn, $sql)) {
        echo "category Record deleted successfully<br>";
    } else {
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