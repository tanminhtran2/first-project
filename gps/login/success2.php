<?php
 require '../library/db.php';
 require '../library/function.php';
  getlang();
  if(  $_SESSION['ngonngu']==0){
   
    $dangnhap= $array_vn[5];
  }else{
   
    $dangnhap= $array_en[5];
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Success</title>
  <meta charset="utf-8">
  <link rel="shortcut icon" href="../icon/icon.ico">
 
  <link rel="stylesheet" href="../css/style_login.css">
   <script src="../js/function.js"></script>

</head>
<body> 
  <div id="dropdown" style="position: fixed;margin-left:  4px; float: left;z-index: 3;right: 0; margin-right: 1%;margin-top: 20px;">
      <div id="dropdown-content"  >
        <a class='lang' href="?lang=0" style="margin-right:10px;" ><img class='lang_icon' src="../icon/vietnamese.png" style=" height:30px;width:30px; ">  </a>
        <a class='lang' href="?lang=1"><img class='lang_icon' src="../icon/british.png" style=" height:30px;width:30px;">  </a>
      </div>
    </div>
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
    
    <div>
      <?php 
      if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ):
          echo "<h2>";
          echo $_SESSION['message'];    
          echo "</h2>";
      else:
          header( "location: ../index.php" );
      endif;
      ?>
    </div>
     
    <center><a href="../index.php"><button class="button button-block"/><?php   echo $dangnhap; ?></button></a></center>
</div>

     <?php  facebook(); ?>
</body>
</html>