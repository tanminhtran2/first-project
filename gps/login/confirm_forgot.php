<?php 
/* Reset your password form, sends reset.php password link */
require '../library/db.php';
require '../library/function.php';
getlang();
  if(  $_SESSION['ngonngu']==0){
    $h1= $array_vn[8];
    $maxacnhan= $array_vn[9];
    $gui= $array_vn[10];
    $message= $array_vn[11];
  }else{
    $h1=$array_en[8];
    $maxacnhan=$array_en[9];
    $gui=$array_en[10];
    $message=$array_en[11];
  }

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
//Load Composer's autoloader
require 'vendor/autoload.php';
// Check if form submitted with method="post"

if ( isset($_POST['code']) ) 
{   
      $new_pass = mt_rand(100000, 999999);

    if ( $_SESSION['confirm_forgot'] == $_POST['code']) 
    { 
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
              $mail->Subject = 'Xe đông lạnh reset mật khẩu' ;
              $mail->CharSet = "utf-8";
              $mail->Body    = 'Mật khẩu mới của bạn là: <b>'.$new_pass.'</b>';
              //luu ma xt len server
              $new_pass=md5($new_pass);
              $sql = "UPDATE users  SET password = '$new_pass'  WHERE email='$email'";
              $mysqli->query($sql);
              $mail->send();
              
              $_SESSION['message'] = "<p>$message <span>$email</span></p>";
              header("location: success2.php");
          } catch (Exception $e) {
              //echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
          }
       
    }
    else { 
        $_SESSION['message'] = "Mã xác thực không đúng";
        header("location: error.php");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Xác nhận quên mật khẩu</title>
  
  <link rel="shortcut icon" href="../icon/icon.ico">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">  
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
    <div class="w3-center w3-container w3-section w3-large w3-text-white w3-display-bottommiddle" style="width:10%;position: fixed; ">
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

  <div class="form"   >

    <h1><?php  echo $h1; ?></h1>

    <form action="confirm_forgot.php" method="post">
           <div class="field-wrap">
            <label  >
              <?php   echo $maxacnhan; ?><span class="req">*</span>
            </label>
            <input type="text"required autocomplete="off" name="code"/>
          </div>
          <center><button class="button button-block"/><?php echo $gui; ?></button></center>
    </form>
          <div style="padding-top:2%;color:white;">
            <img src="../icon/email_phone.ico" style="height: 40px;width: 40px;float:left;">
            <div style="float:left; margin-left:5px;">
              <div> Hotline: 028 66732777 </div>
              <div>Email: info@tanthanh-tech.vn</div>
            </div>
          </div>
  </div>
  
            </div>
              <?php  facebook(); ?>

</body>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src="../login/js/index.js"></script>
</html>
