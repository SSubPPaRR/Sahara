<?php
    if(isset($_SESSION['accountype'])){
        $type = $_SESSION['accountype'];
        if($type == 'admin'){
        ob_start(); // ensures anything dumped out will be caught
            $url = "/admin/index.php"; // this can be set based on whatever
            // clear out the output buffer
            while (ob_get_status()) 
            {
                ob_end_clean();
            }
            // redirect
            header( "Location: $url" );
        }
        elseif($type == 'vendor'){
            ob_start(); // ensures anything dumped out will be caught
            $url = "vendor/index.php"; // this can be set based on whatever
            // clear out the output buffer
            while (ob_get_status()) 
            {
                ob_end_clean();
            }
            // redirect
            header( "Location: $url" );
        }             
    }
?>