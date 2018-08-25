<?php
require '../library/db.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Success</title>
  <meta charset="utf-8">
  <link rel="shortcut icon" href="../icon/icon.ico">
  <?php include 'css/css.html'; ?>
   
</head>
<body> 
<div class="form">
    
    <p>
    <?php 
    if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ):
        echo "<h2>";
        echo $_SESSION['message'];    
        echo "</h2>";
    else:
        header( "location: index.php" );
    endif;
    ?>
    </p>
    <a href="signup.php"><button class="button button-block"/>Đăng ký user</button></a>
    <br>
    <a href="../map/thongtin.php"><button class="button button-block"/>Trang chủ</button></a>
</div>
       <?php  facebook(); ?>
</body>
</html>
