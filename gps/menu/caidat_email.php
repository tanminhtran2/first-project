<?php
/* Displays all successful messages */
  require '../library/db.php';
  require '../library/function.php';
  check_timeout();  
    // Check if user is logged in using the session variable
    if( $_SESSION['logged_in'] != 1 ){
      $_SESSION['message'] = "Bạn cần phải đăng nhập!";
      header("location: ../login/error.php");    
    }
  getlang();
  if($_SESSION['ngonngu']==0){
    $txt_thongtinemail= $array_vn[198];
    $txt_diachiserver= $array_vn[199];
    $txt_matkhaucu= $array_vn[200];
    $txt_matkhaumoi= $array_vn[201];
    $txt_nhaplaimkmoi= $array_vn[202];
    $txt_tennguoigui= $array_vn[203];
    $txt_tieude= $array_vn[204];
    $txt_noidung= $array_vn[205];
    $txt_luuthaydoi= $array_vn[144];

    $txt_nhapmkcu=$array_vn[206];
    $txt_matkhaucukodung=$array_vn[207];
    $txt_nhapmkmoi=$array_vn[208];
    $txt_nhaplaimkmoi=$array_vn[209];
    $txt_matkhaukotrungkhop=$array_vn[210];
    $txt_capnhatmkthanhcong=$array_vn[211];
    $txt_khongthaydoi=$array_vn[212];
  }else{
    $txt_thongtinemail= $array_en[198];
    $txt_diachiserver= $array_en[199];
    $txt_matkhaucu= $array_en[200];
    $txt_matkhaumoi= $array_en[201];
    $txt_nhaplaimkmoi= $array_en[202];
    $txt_tennguoigui= $array_en[203];
    $txt_tieude= $array_en[204];
    $txt_noidung= $array_en[205];
    $txt_luuthaydoi= $array_en[144];

    $txt_nhapmkcu=$array_en[206];
    $txt_matkhaucukodung=$array_en[207];
    $txt_nhapmkmoi=$array_en[208];
    $txt_nhaplaimkmoi=$array_en[209];
    $txt_matkhaukotrungkhop=$array_en[210];
    $txt_capnhatmkthanhcong=$array_en[211];
    $txt_khongthaydoi=$array_en[212];
  }

  $kiemtra=0;
  if(isset($_POST['save'])) {
    if(!empty($_POST['host'])){ 
      $host=$_POST['host'];
      mysqli_query($link, "UPDATE `email` SET host = '$host' ");
    }
    if(!empty($_POST['email'])){ 
      $email=$_POST['email'];
      mysqli_query($link, "UPDATE `email` SET username = '$email' ");
    }
    if(!empty($_POST['fromfullname'])){ 
      $fromfullname=$_POST['fromfullname'];
      mysqli_query($link, "UPDATE `email` SET fromfullname = '$fromfullname' ");
    }
    if(!empty($_POST['subject'])){ 
      $subject=$_POST['subject'];
      mysqli_query($link, "UPDATE `email` SET subject = '$subject' ");
    }
    if(!empty($_POST['content'])){ 
      $content=$_POST['content'];
      mysqli_query($link, "UPDATE `email` SET content = '$content' ");
    }
  
    if(empty($_POST['host'])&&empty($_POST['email'])&&empty($_POST['fromfullname'])&&empty($_POST['subject'])&&empty($_POST['content'])&&empty($_POST['password_old'])&&empty($_POST['password_new'])&&empty($_POST['confirm_password'])) { 
      $kiemtra=7;//ko tdoi
     }else if(!empty($_POST['password_new'])&&!empty($_POST['confirm_password'])&&!empty($_POST['password_old'])){ //du dk cap nhat mat khau
        $result=mysqli_query($link, "SELECT * FROM `email`");
        while($row= mysqli_fetch_assoc($result)){
          $password=$row['password'];
        }
        if($password!=$_POST['password_old']){
          $kiemtra=2; //mat khau cu ko dung
        }elseif($_POST['password_new']!=$_POST['confirm_password']){
          $kiemtra=1;//mk ko trung khop
        }else{
          $password_new =  $_POST['password_new'];
          mysqli_query($link, "UPDATE `email` SET password = '$password_new'");
          $kiemtra=6;//cap nhat mk thanh cong
        }
     }else if(empty($_POST['password_old'])){
      $kiemtra=3;//chua nhap mk cu
     }else if(empty($_POST['password_new'])){
      $kiemtra=4;//chua nhap mk moi
     }else if(empty($_POST['confirm_password'])){
      $kiemtra=5;
     }else {

     }
  }
  
  $result = mysqli_query($link, "SELECT * FROM email");
  while($row = mysqli_fetch_array($result)){
    $fromfullname = $row['fromfullname'];
    $host = $row['host'];
    $username = $row['username'];
    $password = $row['password'];
    $subject=$row['subject'];
    $content=$row['content'];
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Cài đặt email</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../icon/icon.ico">
  <link rel="stylesheet" type="text/css" href="../css/lichsu.css" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script src="../js/jquery.min.js-3.3.1.js"></script>
  <script src="../js/function.js"></script>
    

   <link rel="stylesheet" type="text/css" href="../css/uploadfile.css" />

  <script src="../js/jquery.menu-aim.js"></script> <!-- menu aim -->
  <script src="../js/main.js"></script> <!-- Resource jQuery --> 
  <script src="../js/modernizr.js"></script>
 
  <link rel="stylesheet" type="text/css" href="../css/reset.css" />
  <link rel="stylesheet" type="text/css" href="../css/style_menu.css" />
  <script src="../js/jquery-2.1.1.js"></script>
  <link rel="stylesheet" type="text/css"  href="../lib_timeout_confirm/demo/libs/bundled.css"><!--confirm timeout fix center-->
  <link rel="stylesheet" type="text/css"  href="../lib_timeout_confirm/css/jquery-confirm.css"/>
  <script type="text/javascript"  src="../lib_timeout_confirm/js/jquery-confirm.js"></script>

  <link rel="stylesheet" href="../popup/popup.css" />
  <?php 
    style_menu();
  ?>
  <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blah')
                      .attr('src', e.target.result)
                      .width(150)
                      .height(150);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <style type="text/css">
      label {
        color: blue;
      }
      
      #info{
        margin:auto;
        width:30%;
     
      }
      .form-control {
        display:inline;
      }
      a{
        font-size: 16px;
      }
      @media only screen and (max-width: 700px) {
        .cd-dropdown{
              <?php

                if($_SESSION['admin']==1){    /* administrator */
                  echo "height: 210px !important;";
                }elseif($_SESSION['mode_user']==1)  {
                  echo "height: 180px !important;";
                }else{
                  echo "height: 150px !important;";
                }
 
              ?>
          }
          <?php
              if($_SESSION['admin']==1 || $_SESSION['mode_user'] ==1 ){}else{
                echo "#image2{";
                    echo "width: 66px !important;"; 
                    echo "height: 66px !important;"; 
                echo "}";
                echo ".dropdown-content-icon{";         
                    echo "min-width: 220px !important;";    
                echo "}"; 
              }
          ?>
      }
      @media only screen and (max-width: 500px) {
        #info{
          margin:0px !important;
          width:100% !important;
        }
      }
    </style>
</head>
<body>
  <?php bar_menu($link,$admin,$soluongthongbao); ?>
    <script type="text/javascript" language="javascript">
       $(document).ready(function() {
          $("#notify").click(function () {
            $('#sothongbao' ).fadeOut('slow');
            document.getElementById("notify_drop").classList.toggle("show");
             $.ajax({
                url: "../xuly/reset_thongbao.php",
                success: function(result){

                }
            });
          });
       });
    </script>
  
     
  <div id='info'>
    <?php
       
      $result = mysqli_query($link,"SELECT * FROM `users` WHERE username='$user'");
      while($row=mysqli_fetch_array($result)){
        $user=$row['username'];
        $email=$row['email'];
        $sdt=$row['sodt'];
      }
    ?>
    <form action="" method="POST" role="form" enctype="multipart/form-data"> 
      <h2 style="color:red;"><?php  echo $txt_thongtinemail;?> </h2>
  
            <div class="form-group">
                <label ><?php  echo $txt_diachiserver;?> </label>
                <input type="text" class="form-control" id="" placeholder="<?php echo $host; ?>" name="host">
            </div>
            <div class="form-group">
                <label >Email</label>
                <input type="email" class="form-control" id="" placeholder="<?php echo $username; ?>" name="email">
            </div>
            <div class="form-group">
                <label ><?php  echo $txt_matkhaucu;?> </label>
                <input type="password" minlength='8' class="form-control" id="" placeholder="" name="password_old" 
                      value="<?php 
                            if(isset($_POST['password_old'])) echo $_POST['password_old'];
                        ?>">   
                        <div style="color:red;"><?php
                            if($kiemtra==3){
                               echo $txt_nhapmkcu;
                               
                            }elseif($kiemtra==2){
                                echo $txt_matkhaucukodung;
                               
                            }
                        ?></div>   
            </div>
             <div class="form-group">
                <label ><?php  echo $txt_matkhaumoi;?> </label>
                <input type="password" minlength='8' class="form-control" id="" placeholder="" name="password_new"
                value="<?php 
                            if(isset($_POST['password_new'])) echo $_POST['password_new'];
                        ?>"><div style="color:red;"><?php
                          if($kiemtra==4){
                             echo $txt_nhapmkmoi;
                             
                          }
                        ?></div>
            </div>
            <div class="form-group">
                <label ><?php  echo $txt_nhaplaimkmoi;?> </label>
                <input type="password" minlength='8' class="form-control" id="" placeholder="" name="confirm_password"
                value="<?php 
                            if(isset($_POST['confirm_password'])) echo $_POST['confirm_password'];
                        ?>"><div style="color:red;"><?php
                          if($kiemtra==5){
                            echo $txt_nhaplaimkmoi;
                             
                          }
                        ?></div>
            </div>
            <div class="form-group">
                <label ><?php  echo $txt_tennguoigui;?> </label>
                <input type="text" class="form-control" id="" placeholder="<?php echo $fromfullname; ?>" name="fromfullname">
            </div>
            <div class="form-group">
                <label ><?php  echo $txt_tieude;?> </label>
                <input type="text" class="form-control" id="" placeholder="<?php echo $subject; ?>" name="subject">
            </div>
            <div class="form-group">
                <label ><?php  echo $txt_noidung;?> </label>
                <input type="text" class="form-control" id="" placeholder="<?php echo $content; ?>" name="content">
            </div>

            <button type="submit" class="btn btn-primary" name="save"><?php   echo $txt_luuthaydoi;?></button>
            <br>
            <div style="color:red;"> 
              <?php 
                  
                  if($kiemtra==1){
                      echo $txt_matkhaukotrungkhop;
                  }elseif($kiemtra==6){
                      echo "<div style='color:blue;'>".$txt_capnhatmkthanhcong."</div>";
                  }elseif($kiemtra==7){
                      echo "<div style='color:blue;'>".$txt_khongthaydoi."</div>";    
                  }
               ?>
             </div>
        </form> 
  </div>
             <?php  facebook(); ?>    
</body>
</html>
  <script src="../popup/popup.js"></script>