<?php
session_start();
include "db.php";
$username = $_POST['Email'];
$password = $_POST['Password'];

//admin login
//check admin user name
$sql='SELECT COUNT(*) FROM admin WHERE User_Name = "'.$username.'";';
if($result = mysqli_query($conn, $sql)){
    $row = mysqli_fetch_row($result);
    if($row[0] > 0){
        //check admin password
        $sql = 'SELECT Password FROM admin WHERE User_Name = "'.$username.'"';
        if($result = mysqli_query($conn, $sql)){
            $row = mysqli_fetch_row($result);
            if($row[0]==$password){
                
                //log admin in
                echo 'admin login success ';
               
                $_SESSION['loginVal']=false;

                //login successfull
                $_SESSION['loggedIn']=true;
                
                //setting userid and username for logged in pages(like profile)
                $sql = 'SELECT Admin_ID FROM admin WHERE User_Name = "'.$username.'"';
                if($result = mysqli_query($conn, $sql)){
                    $row = mysqli_fetch_row($result);
                    $_SESSION['loggedID']=$row[0];
                    $_SESSION['loggedName']=$username;
                    $_SESSION['accountype']='admin';
                }
                mysqli_close($conn);
                ob_start(); // ensures anything dumped out will be caught
                $url = "admin\index.php"; // this can be set based on whatever
                // clear out the output buffer
                while (ob_get_status()) 
                {
                    ob_end_clean();
                }
                // redirect
                header( "Location: $url" );

            }
            else{//login fails----------------------------------------------------------------------
                
                mysqli_close($conn);
                $_SESSION['loginVal']= true;
                ob_start(); // ensures anything dumped out will be caught
                $url = "login.php"; // this can be set based on whatever
                // clear out the output buffer
                while (ob_get_status()) 
                {
                    ob_end_clean();
                }
                // redirect
                header( "Location: $url" );
            }

        }
    }
    else{//vendor login--------------------------------------------------------------------------------------------------
        //check vendor user name
        $sql='SELECT COUNT(*) FROM vendor WHERE User_Name = "'.$username.'";';
        if($result = mysqli_query($conn, $sql)){
            $row = mysqli_fetch_row($result);
            if($row[0] > 0){
                echo 'vendor name exi';
                //check vendor password
                $sql = 'SELECT Password FROM vendor WHERE User_Name = "'.$username.'"';
                if($result = mysqli_query($conn, $sql)){
                    $row = mysqli_fetch_row($result);
                    if($row[0]==$password){

                        //log vendor in
                        echo 'user vendor success ';
                        $_SESSION['loginVal']=false;
                        $_SESSION['accountype']='vendor';
                        //login successfull
                        $_SESSION['loggedIn']=true;
                        
                        //setting userid for logged in pages(like profile)
                        $sql = 'SELECT Vendor_ID FROM vendor WHERE User_Name = "'.$username.'"';
                        if($result = mysqli_query($conn, $sql)){
                            $row = mysqli_fetch_row($result);
                            $_SESSION['loggedID']=$row[0];
                            $_SESSION['loggedName']=$username;
                            

                        }
                        mysqli_close($conn);
                        ob_start(); // ensures anything dumped out will be caught

                        $url = "vendor\\index.php"; // this can be set based on whatever

                        // clear out the output buffer
                        while (ob_get_status()) {
                            ob_end_clean();
                        }

                        // redirect
                        header( "Location: $url" );
                    }
                    else{//login fails----------------------------------------------------------------------
                        mysqli_close($conn);
                        $_SESSION['loginVal']= true;
                        ob_start(); // ensures anything dumped out will be caught
                        $url = "login.php"; // this can be set based on whatever
                        // clear out the output buffer
                        while (ob_get_status()) 
                        {
                            ob_end_clean();
                        }
                        // redirect
                        header( "Location: $url" );
                    }
                }

            }
            else{//normal user login-----------------------------------------------------------------------
                
                //check user email
                $sql='SELECT COUNT(*) FROM user WHERE Email = "'.$username.'";';
                if($result = mysqli_query($conn, $sql)){
                    $row = mysqli_fetch_row($result);
                    if($row[0] > 0){
                        echo 'correct user email ';
                        //check User password
                        $sql = 'SELECT Password FROM user WHERE Email = "'.$username.'"';
                        if($result = mysqli_query($conn, $sql)){
                            $row = mysqli_fetch_row($result);
                            if($row[0]==$password){

                                //log User in
                                echo 'user login success ';
                                $_SESSION['loginVal']=false;

                                //login successfull
                                $_SESSION['loggedIn']=true;
                                
                                //setting userid for logged in pages(like profile)
                                $sql = 'SELECT User_ID FROM user WHERE Email = "'.$username.'"';
                                if($result = mysqli_query($conn, $sql)){
                                    $row = mysqli_fetch_row($result);
                                    $_SESSION['loggedID']=$row[0];
                                    $_SESSION['loggedName']=$username;
                                    $loggedId= $_SESSION['loggedID'];
                                    $_SESSION['accountype']='user';

                                }
                                
                                //import cart items from session to db.
                                //check if there are products in session list.
                                if(!empty($_SESSION['session_cart'])){

                                    $sql ='SELECT Product_ID FROM shoppingcart WHERE User_ID = "'.$loggedId.'";';
                                    $result= mysqli_query($conn,$sql);
                                    $product_list=array();

                                    while($row = $result->fetch_assoc()){
                                        $product_ID = $row['Product_ID'];
                                        array_push($product_list,$product_ID);
                                    }

                                    foreach($_SESSION['session_cart'] as $ProductID){
                                        if(!in_array($ProductID,$product_list)){
                                            $sql='INSERT INTO shoppingcart VALUES("'.$loggedId.'","'.$ProductID.'")';
                                            if (mysqli_query($conn, $sql)) {
                                                echo "New record created successfully";
                                            }
                                        }
                                    }

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

                            }
                            else{//login fails----------------------------------------------------------------------
                                mysqli_close($conn);
                                $_SESSION['loginVal']= true;
                                ob_start(); // ensures anything dumped out will be caught
                                $url = "login.php"; // this can be set based on whatever
                                // clear out the output buffer
                                while (ob_get_status()) 
                                {
                                    ob_end_clean();
                                }
                                // redirect
                                header( "Location: $url" );
                            }
                        }
                        
                    }
                    else{//login fails----------------------------------------------------------------------
                        mysqli_close($conn);
                        $_SESSION['loginVal']= true;
                        ob_start(); // ensures anything dumped out will be caught
                        $url = "login.php"; // this can be set based on whatever
                        // clear out the output buffer
                        while (ob_get_status()) 
                        {
                            ob_end_clean();
                        }
                        // redirect
                        header( "Location: $url" );
                    }
                }
            }
        }
    }  
}
?>