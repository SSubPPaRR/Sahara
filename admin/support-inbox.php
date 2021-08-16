<?php session_start();?>
<!DOCTYPE html>
<?php
include "..\db.php";
include "..\user-redirect.php";

$_SESSION['loginVal']=false;

//is a user logged in
if(isset($_SESSION['loggedIn'])){
  $loggedIn = $_SESSION['loggedIn'];
}else $loggedIn =false;

?>

<html>
<title>Sahara</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
  <link rel="stylesheet" href="..\styles.css">
  <link rel="stylesheet" href="..\w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>    
<body>

<style>
body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
body {font-size:16px;}
.product-catalog div{
   height:290px;
}
.product-catalog div:hover{
    opacity:0.60;
}
.product-image{
  max-height: 290px;
}
</style>


<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-red w3-collapse w3-top w3-large w3-padding w3-card" style="z-index:3;width:250px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
  <div class="w3-container">
    <h3 class="w3-padding-16"><b>Sahara</b></h3>
  </div>
  <div class="w3-bar-block">
    <a href="index.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe88a</i>Dashboard</a> 
    <a href="categories.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe2c7</i>Categories</a>
    <a href="vendors.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe8cc</i>Vendors</a>
    <a href="support-inbox.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe156</i>Support Inbox</a> 
    <!--login-->
    <?php
      echo '<a href="..\logout.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"><i class="material-icons w3-left">&#xe7ff</i>Logout</a>';   
    ?>  
  </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large w3-red w3-xlarge w3-padding">
  <a href="javascript:void(0)" class="w3-button w3-red w3-margin-right" onclick="w3_open()">☰</a>
  <span>Sahara</span>
  <!--login-->
  <?php
    echo'<a class="w3-right w3-large" style="margin-top:10px;" href="..\logout.php">Logout</a><span class="w3-large w3-right w3-padding">'.$_SESSION['loggedName'].'</span>';
  ?>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">

 
  <!-- Header -->
  <div class="w3-container" style="margin-top:50px" id="showcase">
    <h1>Support inbox</h1>
  </div>
  
  <!-- Shoppingcart contents -->

  <table class="w3-table w3-border w3-hoverable" >
            <tr class="w3-orange">
              <th>Date</th>
              <th>Subject</th>
              <th>Attachment</th>
              <th>Open</th>
			  <th>Read</th>
              <th>Delete</th>
            </tr>
            <?php      

              //check user's inbox is empty.
              $loggedId=$_SESSION['loggedID'];
              $sql='SELECT COUNT(*) FROM supportbox ;';
              if($result = mysqli_query($conn, $sql)){
                $row = mysqli_fetch_row($result);
                if($row[0]==0){
                  echo '<h3 class="w3-border" style="margin-top:0;">Your inbox empty.</h3>';
                }
  
                else{

                  //get msg admins and add it to the table.
                  $sql ='SELECT Support_ID FROM supportbox ORDER BY `Readmsg` ASC,`Date`DESC';
                  $result= mysqli_query($conn,$sql);
                  $msg_list=array();

                  while($row = $result->fetch_assoc()){
                    $msg_ID = $row['Support_ID'];
                    array_push($msg_list,$msg_ID);
                  }
                  foreach($msg_list as $msgID){
                    $sql ="SELECT `Date`, `Subject`, `Readmsg`,`Description`,`Replied`,`Attachment` FROM supportbox WHERE Support_ID = $msgID;";
                    if($result = mysqli_query($conn, $sql)){
                      $row = mysqli_fetch_row($result);
                      
                      if($row[2]==1){
                            $color = 'light-grey';
                      }else $color = 'white';
                      
                      //place msg info in corresponding cells.
                      echo '
                      <tr id="'.$msgID.'" class="w3-'.$color.'">
                        <td>'.$row[0].'</td>
                        <td>'.$row[1].'</td>';

                        if(!($row[5]=="")){
                          echo  '<td><a class="w3-text-red" href="'.$row[5].'" target="_blank" disabled>Click here</a></td>';
                        }else echo'<td></td>';

						// checks if support msg has been read already
						if($row[2]==1){
                            $color = '<i class="material-icons w3-xxlarge">&#xe5ca</i>';
                      }else $color = '';
					  
					  
                  echo '<td><span onclick="document.forms[\'msg-open-Form'.$msgID.'\'].submit();" class="w3-button w3-green w3-hover-orange"><i class="material-icons w3-left">&#xe89d</i></span></td>
					<td>'.$color.'</td>
                        <td><span onclick="document.forms[\'msg-delete-Form'.$msgID.'\'].submit();" class="w3-button w3-red w3-hover-orange"><i class="material-icons w3-left">&#xe872</i></span></td>
                      </tr>
                    
                      <form action="" method="POST" name="msg-open-Form'.$msgID.'" style="display: none;">      
                      <input type="hidden" name="ID" value="'.$msgID.'"?>
                      <input type="hidden" name="Date" value="'.$row[0].'"?>
                      <input type="hidden" name="Subject" value="'.$row[1].'"?>
                      <input type="hidden" name="Msg" value="'.$row[3].'"?>
                      <input type="hidden" name="checkbx" value="'.$row[2].'"?>
                      <input type="hidden" name="replied" value="'.$row[4].'"?>
                      </form>	

                      <form action="..\deletemsg.php" method="GET" name="msg-delete-Form'.$msgID.'" style="display: none;">      
                        <input type="hidden" name="type" value="0">
                        <input type="hidden" name="ID" value="'.$msgID.'"?>
                      </form>
                     ';
                    }
                  }
                                   
                }
              }
        ?>
</table>

    <div id="msg" class="w3-card-4 w3-display-middle w3-padding w3-animate-opacity w3-deep-orange" style="display: none;">
        <span class="w3-display-topright w3-padding w3-hover-grey" onclick="document.forms['read-form'].submit()">&times;</span>
        <h5>Date: <span><?php echo $_POST['Date']; ?></span></h5>
        <h5>Subject: <span><?php echo $_POST['Subject']; ?></span></h5>
        <div class="w3-border w3-padding w3-white" style="width: 400px;height: 450px">
        
        <?php echo $_POST['Msg']; ?>
        
        </div>
        <button class="w3-button w3-round w3-right w3-blue" style="margin-top: 5px" onclick='document.getElementById("rply").style.display="block";document.getElementById("msg").style.display="none"' <?php if($_POST['replied']==1){echo'disabled';}?>>Reply</button>
        <form action="..\markasread.php" name="read-form" method="GET" style="width: 200px">
            <input type="hidden" name="ID" value= <?php echo'"'.$_POST['ID'].'"' ?>>
            <input type="hidden" name="type" value="0">
            <input class="w3-check" type="checkbox" name="markread" id="markread" <?php if($_POST['checkbx']==1){echo'checked';}?>>
            <label for="markread">mark as read</label> 
        </form>
    </div>           


    <!--reply box-->
    <div id="rply" class="w3-card-4 w3-display-middle w3-padding w3-animate-opacity w3-deep-orange" style="display: none;max-width: 432px;">
            <span class="w3-display-topright w3-padding w3-hover-grey" onclick='document.getElementById("rply").style.display="none"'>&times;</span>
                <h5>Subject: <span><?php echo $_POST['Subject'].'(reply)'; ?></span></h5>
                <h5>Reply here:</h5>
                <form action="replytomsg.php" name="read-form" method="GET">
                    <textarea name="msg" style="min-width: 400px;min-height: 450px;max-width: 400px;max-height: 450px" ></textarea>
                    <input type="hidden" name="ID" value= <?php echo'"'.$_POST['ID'].'"' ?>>
                    <input type="hidden" name="type" value="0">
                    <input type="hidden" name="subject" value="<?php echo $_POST['Subject'].'(reply)'; ?>">
                    <input type="hidden" name="markread" value= "1">
                    <button type="submit" class="w3-button w3-right w3-round w3-blue">Send</button>
                </form>
            </div>


</div>
  <?php include "../currentpage.php"?>

    <!-- End page content -->

  </div>

    <!-- W3.CSS Container -->
    <div class="w3-light-grey w3-container w3-padding-32 " style="margin-top:75px;padding-right:58px;"></div>

    <script>
    // Script to open and close sidebar
    function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
    }
    
    function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
    }

    </script>  
    <script>
      if(<?php echo isset($_POST['ID'])?>){
            document.getElementById('msg').style.display='block'
        }
    
    </script>  


</body>
</html> 