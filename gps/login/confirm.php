<?php 
require '../library/db.php';
 require '../library/function.php';
 require 'smtp.php';
getlang();
  if(  $_SESSION['ngonngu']==0){
    $h1=$array_vn[12];
    $maxacnhan=$array_vn[13];
    $txt_xacnhan=$array_vn[14];
    $guilaixacnhan=$array_vn[15];
  }else{
    $h1=$array_en[12];
    $maxacnhan=$array_en[13];
    $txt_xacnhan=$array_en[14];;
     $guilaixacnhan=$array_en[15];
  }

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
//Load Composer's autoloader
require 'vendor/autoload.php';
//$email = $_SESSION['email'];
$query = "SELECT * FROM `users` WHERE username='$admin'";
$result = mysqli_query($link, $query);
while($row = mysqli_fetch_assoc($result)){
  $xacnhan = $row['xacnhan'];
} 

$user = $_SESSION['tentaikhoan'];
$confirm_number = mt_rand(100000, 999999);

if($xacnhan[0]=='1'){/*
  $query = "SELECT * FROM `email` ";
  $result = mysqli_query($link, $query);
  while($row = mysqli_fetch_assoc($result)){
    $fromfullname = $row['fromfullname'];
    $host = $row['host'];
    $username = $row['username'];
    $password = $row['password'];
  } 
  $frommail="tracking@tanthanh-tech.vn";
  $tomail="tanminhtran2@gmail.com";
  $subject="test";
  $content="hello";
  SendMail($frommail, $tomail, $subject, $content, $fromfullname,$host,$username,$password);
  */
  $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
  try {
      //Server settings
      $mail->SMTPDebug = 0;                                 // Enable verbose debug output
      $mail->isSMTP();                                      // Set mailer to use SMTP
      $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'xedonglanh.tanthanh@gmail.com';                 // SMTP username
      $mail->Password = 'tanthanh1516';                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 587;                                    // TCP port to connect to

      //Recipients
      $email = $_SESSION['email'];
      $mail->setFrom($email, 'Xe đông lạnh');
      $mail->addAddress($email, '');     // Add a recipient
      
      //Attachments
      //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
      //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

      //Content
      $mail->isHTML(true);   
      $mail->Subject = 'Mã xác thực' ;
      $mail->CharSet = "utf-8";
      $mail->Body    = 'Mã xác thực <b>'.$confirm_number.'</b>';
      //luu ma xt len server
      $sql = "UPDATE users  SET code = '$confirm_number',date_time = now(),flag_code=1  WHERE username='$user'";
      $mysqli->query($sql);
      $mail->send();
      //echo 'Message has been sent';
  } catch (Exception $e) {
      echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
  } 
}
if($xacnhan[1]=='1'){
    //lay sdt cua user
  
    $result = mysqli_query($link,"SELECT * FROM `users` WHERE username='$user'" );
    if($result){
      while($row = mysqli_fetch_assoc($result)){
        $sodt = $row['sodt'];
      }
    }
    //cap nhat ma xnhan cho user
    $sql = "UPDATE users  SET code = '$confirm_number', date_time = now(),flag_code=1  WHERE username='$user'";
    $mysqli->query($sql);
    //cap nhat de gui cho sim
    $sql = "UPDATE users SET code = '$confirm_number',sodt = '$sodt' ,flag_code_tinnhan=1 WHERE id=1";
    $mysqli->query($sql);
    
}
  
?>
<!DOCTYPE html>
<html>
<head>
  <title>Xác nhận</title>
  
  <link rel="shortcut icon" href="../icon/icon.ico">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">  
  <link rel="stylesheet" href="../css/style_login.css">
    <script src="../js/function.js"></script>
  <style>
    .mySlides { }
    .w3-left, .w3-right, .w3-badge {cursor:pointer}
    .w3-badge {height:13px;width:13px;padding:0;color: black;background-color: black; }
    html, body {margin:0; padding:0; width:100%;max-height:100%; overflow: hidden;  text-align:left;}
    .mySlides{ float:left; width:100%; max-height:100%;}

  </style>
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
    <div class="w3-center w3-container w3-section w3-large w3-text-white w3-display-bottommiddle" >
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
      
  
          <h1><?php echo $h1; ?></h1>
          
          <form action="confirm2.php" method="post" autocomplete="off">
          
            <div class="field-wrap">
              <label>
                <?php echo $maxacnhan;  ?><span class="req">*</span>
              </label>
              <input type="text" required autocomplete="off" name="code"/>
            </div>
    

              <center><button class="button button-block" name="confirm" /><?php  echo $txt_xacnhan; ?></button></center>
            <br>
            
          </form>
          <form action="" method="post" autocomplete="off">
            <center><button class="button button-block"  style="width:100%;"><?php  echo $guilaixacnhan; ?></button></center>
          </form>
      
        <div style="padding-top:2%;color:white;">
            <img src="../icon/email_phone.ico" style="height: 40px;width: 40px;float:left;">
            <div style="float:left; margin-left:5px;">
              <div> Hotline: 028 66732777 </div>
              <div>Email: info@tanthanh-tech.vn</div>
            </div>
          </div>
      </div><!-- tab-content -->
    

 
        </div>
               <?php  facebook(); ?>
 
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src="../login/js/index.js"></script>
 
</body>
</html>

