<?php
  session_start();
  include 'db.php';
  if(isset($_SESSION['loggedIn'])){
    $loggedIn = $_SESSION['loggedIn'];
  }else $loggedIn =false;
  $loggedId=$_SESSION['loggedID'];
  $productID =$_GET['ID'];

  //clear full cart
  if($productID == 0){
    //if login delete from db.
    if($loggedIn){

      $sql = 'DELETE FROM shoppingcart WHERE User_ID ="'.$loggedId.'";';
      if (mysqli_query($conn, $sql)) {
          echo "Record deleted successfully";
      } else {
          echo "Error deleting record: " . mysqli_error($conn);
      }
    }
    //if not logged in delete from session.
    else $_SESSION['session_cart'] = array();
  }

  //remove 1 item from cart
  else{
    //if login delete from db.
    if($loggedIn){

      $sql = 'DELETE FROM shoppingcart WHERE Product_ID ="'.$productID.'";';
      if (mysqli_query($conn, $sql)) {
          echo "Record deleted successfully";
      } else {
          echo "Error deleting record: " . mysqli_error($conn);
      }

    }
    else{
      //if not logged in delete from session.
      if (($key = array_search($productID, $_SESSION['session_cart'])) !== false) {
        unset($_SESSION['session_cart'][$key]);
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
?>