<?php
include "..\db.php";
$supportID= $_GET['ID'];
$subject=$_GET['subject'];
$msg=$_GET['msg'];
$r2m=true;
    $sql ='SELECT User_ID FROM supportbox WHERE Support_ID = "'.$supportID.'"';
    $result= mysqli_query($conn,$sql);
    if($row = $result->fetch_assoc()){
        $userID=$row['User_ID'];

        $sql = "INSERT INTO userinbox (`Support_ID`,`User_ID`,`Subject`,`Msg`) VALUES ('".$supportID."','".$userID."','".$subject."', '".$msg."')";
        if (mysqli_query($conn, $sql)) {
            echo "Record added successfully";
            
            $sql ="UPDATE `supportbox`SET Replied = 1 ";
            if (mysqli_query($conn, $sql)) {
                echo "Record updated successfully";
            } 
            else {
                echo "Error updating record: " . mysqli_error($conn);
            }   


            include '..\markasread.php';
           
        } 
        else {
            echo "Error adding record: " . mysqli_error($conn);
        }

    }


?>