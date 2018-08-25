<?php
/* Log out process, unsets and destroys session variables */
require '../library/db.php';
 require '../library/function.php';
  getlang();
//$user = $_SESSION['tentaikhoan'];
//mysqli_query($link,"UPDATE users  SET last_activity = now() WHERE username='$user'");  
 
session_unset();
session_destroy(); 
?>
<!DOCTYPE html>
<html>
<head>
  
  	<title>Đăng xuất</title>

  	<link rel="shortcut icon" href="../icon/icon.ico">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">  
  	<link rel="stylesheet" href="../css/style_login.css">
  	<script src="../js/function.js"></script>
</head>

<body>
	<div class="w3-content w3-display-container" style=" float:left; min-width: 100%;min-height: 100%;  ">
    <img class="mySlides w3-animate-opacity" src="../icon/a.png"  >
    <img class="mySlides w3-animate-opacity" src="../icon/b.png"  >
    <img class="mySlides w3-animate-opacity" src="../icon/c.png"  >
    <img class="mySlides w3-animate-opacity" src="../icon/d.png"  >
    <div class="w3-center w3-container w3-section w3-large w3-text-white w3-display-bottommiddle"  >
      <div class="w3-left w3-hover-text-khaki" onclick="plusDivs(-1)">&#10094;</div>
      <div class="w3-right w3-hover-text-khaki" onclick="plusDivs(1)">&#10095;</div>
      <span class="w3-badge demo w3-border w3-transparent w3-hover-white" onclick="currentDiv(1)"></span>
      <span class="w3-badge demo w3-border w3-transparent w3-hover-white" onclick="currentDiv(2)"></span>
      <span class="w3-badge demo w3-border w3-transparent w3-hover-white" onclick="currentDiv(3)"></span>
      <span class="w3-badge demo w3-border w3-transparent w3-hover-white" onclick="currentDiv(4)"></span>
    </div>
  </div>

  <script>
    showDivs(slideIndex);
  </script>
  <script>
    var myIndex = 0;
    carousel();
  </script>

    <div class="form">
          
              
          <h1>Đăng xuất thành công!</h1>
          
          <center><a href="../index.php"><button class="button button-block"/>Đăng nhập</button></a></center>

    </div>
         <?php  facebook(); ?>
</body>
</html>
