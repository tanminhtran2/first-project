<?php
/* Displays all error messages */
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Error</title>
  <meta charset="utf-8">
    <link rel="shortcut icon" href="../icon/icon.ico">
   <link rel="stylesheet" href="../css/style_login.css">
</head>
<body>
<div class="form">
     
    <h1>
    <?php 
    if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ): 
        echo $_SESSION['message'];    
    else:
        header( "location: index.php" );
    endif;
    ?>
    </h1>     
    <a href="signup.php"><button class="button button-block"/>Đăng ký user</button></a>
    
</div>
</body>
</html>
