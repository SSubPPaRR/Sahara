<?php
session_start();
include '../db.php';
$id = $_POST['ID'];
$name = $_POST['name'];
    //edit category
    $sql = "UPDATE categories SET Cat_Title = '$name' WHERE Cat_ID ='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "admin Record deleted successfully<br>";
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