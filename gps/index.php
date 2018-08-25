 <?php 
/* Main page with two forms: sign up and log in */
  require 'library/db.php';
  require 'library/function.php';
  getlang();

  if(empty($_SESSION['ngonngu'])){
    $_SESSION['ngonngu']=0;
  }
  
  //thiet  dat nn
  if(  $_SESSION['ngonngu']==0){
    $h1= $array_vn[1];
    $tentaikhoan= $array_vn[2];
    $matkhau= $array_vn[3];
    $quenmatkhau= $array_vn[4];
    $dangnhap= $array_vn[5];
  }else{
    $h1=$array_en[1];
    $tentaikhoan=$array_en[2];
    $matkhau=$array_en[3];
    $quenmatkhau=$array_en[4];
    $dangnhap=$array_en[5];
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Đăng nhập</title>
  
  <link rel="shortcut icon" href="icon/icon.ico">

</head>
  
<?php 
  if ($_SERVER['REQUEST_METHOD'] == 'POST') 
  {
      if (isset($_POST['login'])) { //user logging in
          require 'login/login.php';          
      }
  }

?>
  

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">  
  <link rel="stylesheet" href="css/style_login.css">

  <script src="js/function.js"></script>
   <style type="text/css">
     
      
   </style>
<body  style="">
   
    <div id="dropdown" style="position: fixed;margin-left:  4px; float: left;z-index: 3;right: 0; margin-right: 1%;margin-top: 20px;">
      <div id="dropdown-content"  >
        <a class='lang' href="?lang=0" style="margin-right:10px;" ><img class='lang_icon' src="icon/vietnamese.png" style=" height:30px;width:30px; ">  </a>
        <a class='lang' href="?lang=1"><img class='lang_icon' src="icon/british.png" style=" height:30px;width:30px;">  </a>
      </div>
    </div>
 
 
  <div class="w3-content w3-display-container" style="float:left; min-width: 100%;height: auto;  ">
    <img class="mySlides w3-animate-opacity" src="icon/a.png"   >
    <img class="mySlides w3-animate-opacity" src="icon/b.png"  >
    <img class="mySlides w3-animate-opacity" src="icon/c.png"   >
    <img class="mySlides w3-animate-opacity" src="icon/d.png"  >
    <div class="w3-center w3-container w3-section w3-large w3-text-white w3-display-bottommiddle" style=" ">
      <div  class="w3-left w3-hover-text-khaki" onclick="plusDivs(-1)">&#10094;</div>
      <div  class="w3-right w3-hover-text-khaki" onclick="plusDivs(1)">&#10095;</div>
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


  <div class="form" >
      
          <h1><?php   echo $h1; ?></h1>
          
          <form action="index.php" method="post" autocomplete="off">
          
              <div class="field-wrap">
                    <label >
                      <?php   echo $tentaikhoan; ?><span class="req">*</span>
                    </label>
                    <input type="text" required autocomplete="off" name="username"/>
              </div>
            
              <div class="field-wrap" style="">
                    <label>
                      <?php echo $matkhau; ?><span class="req">*</span>
                    </label>
                    <input type="password" required autocomplete="off" name="password"/>
              </div>

              <p class="forgot" style=""><a href="login/forgot.php"><?php  echo $quenmatkhau; ?></a></p>

              <center>
                  <button class="button button-block" name="login"><?php  echo $dangnhap; ?></button>
              </center>
          
          </form>

          <div style="padding-top:2%;color:white;">
            <img src="icon/email_phone.ico" style="height: 40px;width: 40px;float:left;">
            <div style="float:left; margin-left:5px;">
              <div> Hotline: 028 66732777 </div>
              <div>Email: info@tanthanh-tech.vn</div>
            </div>
          </div>
    
    </div>
           <?php  facebook(); ?>
      
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src="login/js/index.js"></script>

</body>
</html>
