<?php 
 
require '../library/db.php';
require '../library/function.php';
check_timeout();
if ( $_SESSION['logged_in'] != 1 ) {
    $_SESSION['message'] = "Bạn cần phải đăng nhập!";
    header("location: ../login/error.php");    
  }
  // Check if user is logged in using the session variable
  if ( $_SESSION['mode_user'] == 0) {
    $_SESSION['message'] = "Bạn cần đăng nhập bằng tài khoản có quyền thêm user!";
    header("location: ../login/error.php");    
  }
   
  getlang();
  if(  $_SESSION['ngonngu']==0){
    $txt_nhapthongtinusermoi= $array_vn[104];
    $txt_tenuser= $array_vn[105];
    $txt_nhaptenuser= $array_vn[106];
    $txt_nhapemail= $array_vn[107];
    $txt_sodienthoai= $array_vn[108];
    $txt_nhapsodienthoai= $array_vn[109];
    $txt_matkhau= $array_vn[110];
    $txt_nhapmatkhau= $array_vn[111];
    $txt_nhaplaimatkhau= $array_vn[112];
    $txt_useradmin= $array_vn[113];
    $txt_dangkyuser= $array_vn[114];
    $txt_chonanh= $array_vn[115];

    $txt_usertontai= $array_vn[116];
    $txt_emailtontai= $array_vn[117];
    $txt_sdttontai= $array_vn[118];
    $txt_matkhaukotrungkhop= $array_vn[119];
    $txt_thanhcong= $array_vn[120];
    $txt_sdtkohople=  $array_vn[121];
  }else{
    $txt_nhapthongtinusermoi= $array_en[104];
    $txt_tenuser= $array_en[105];
    $txt_nhaptenuser= $array_en[106];
    $txt_nhapemail= $array_en[107];
    $txt_sodienthoai= $array_en[108];
    $txt_nhapsodienthoai= $array_en[109];
    $txt_matkhau= $array_en[110];
    $txt_nhapmatkhau= $array_en[111];
    $txt_nhaplaimatkhau= $array_en[112];
    $txt_useradmin= $array_en[113];
    $txt_dangkyuser= $array_en[114];
    $txt_chonanh= $array_en[115];

    $txt_usertontai= $array_en[116];
    $txt_emailtontai= $array_en[117];
    $txt_sdttontai= $array_en[118];
    $txt_matkhaukotrungkhop= $array_en[119];
    $txt_thanhcong= $array_en[120];
    $txt_sdtkohople=  $array_en[121];
  }


  $user=$_SESSION['tentaikhoan'];
  $kiemtra=0;
  if(isset($_POST['submit'])){ 
    if(isset($_POST['checkbox']) && $_POST['checkbox'] == 'Yes')
    {
     $mode_user = 1;
    }
    else
    {
      $mode_user = 0;
    }  
    $username = $_POST['name'];
    $email=  $_POST['email'];
    $sdt = $_POST['sdt'];
    $password=  $_POST['password'];
    $confirm_password =  $_POST['confirm_password'];
    //kiem tra ten va email co trung voi csdl
    $result = $mysqli->query("SELECT * FROM users WHERE username='$username'") or die($mysqli->error());
    $result2 = $mysqli->query("SELECT * FROM users WHERE email='$email'") or die($mysqli->error());
    $result3 = $mysqli->query("SELECT * FROM users WHERE sodt='$sdt'") or die($mysqli->error());
    if ( $result->num_rows > 0 ) {
      $kiemtra=1; //username da ton tai
    }else if( $result2->num_rows > 0 ) {
      $kiemtra=2; //email da ton tai
    }else if( $result3->num_rows > 0 ) {
      $kiemtra=3; //sdt da ton tai
    }else if( $password != $confirm_password) {
      $kiemtra=4; //mat khau confirm_password khong trung khop

    }else if($sdt[0]=48){
      $kiemtra=5;
    }else{ //tao tai khoan thanh cong
       $sql = "INSERT INTO users( username,email, password,sodt,mode,timeout,soluongdong)  VALUES ('$username','$email','".md5($password)."','$sdt',$mode_user,30,15)";
        $mysqli->query($sql);
        $sql = "INSERT INTO soluong_thongbao(soluong_thongbao, user)  VALUES (0,'$username')";
        $mysqli->query($sql);

        //log
        mysqli_query($link, "INSERT INTO `log`(user,thongbao ,`date_time`) values ('$user','Tạo user $username' ,now())" );

         //upload anh
        $dir="../upload/";
        if($_FILES['uploadfile']['name']==null)
        {
            
        }
        else{
            $image=$_FILES['uploadfile']['name'];
            $temp_name=$_FILES['uploadfile']['tmp_name'];
            if($image!="")
            {
                //if(file_exists($dir.$image))
                //{
                //  $image= time().'_'.$image;
                //}
                $fdir= $dir.$image;
                move_uploaded_file($temp_name, $fdir);
            }
             
            $query="DELETE FROM `avatar` WHERE  user= '$username';";
            mysqli_query($link,$query) or die(mysqli_error($link));     
            $query="INSERT IGNORE INTO `avatar` (`id`,`user`,`file`) values ('','$username','$image')";
            mysqli_query($link,$query) or die(mysqli_error($link));     
        }  
        $kiemtra=10;
    }
  }
?> 
<!DOCTYPE html>
<html>
<head>
  <title>Đăng ký user</title>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
    <link rel="stylesheet" type="text/css" href="../css/lichsu.css" />
    <link rel="shortcut icon" href="../icon/icon.ico">
    <link rel="stylesheet" type="text/css" href="../css/uploadfile.css" />
    <link rel="stylesheet" href="../css/bootstrap.min.css-3.3.1.css">  <!-- menu css -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 
    <script src="../js/jquery.min.js-3.3.1.js"></script>  <!-- menu click -->
    <script src="../js/function.js"></script>

    <script src="../js/jquery.menu-aim.js"></script> <!-- menu aim -->
    <script src="../js/main.js"></script> <!-- Resource jQuery --> 
    <script src="../js/modernizr.js"></script>
 
    <link rel="stylesheet" type="text/css" href="../css/reset.css" />
    <link rel="stylesheet" type="text/css" href="../css/style_menu.css" />
    <script src="../js/jquery-2.1.1.js"></script>
    <!--  timeout confirm  -->
    <link rel="stylesheet" type="text/css"  href="../lib_timeout_confirm/css/jquery-confirm.css"/>
    <script type="text/javascript"  src="../lib_timeout_confirm/js/jquery-confirm.js"></script>
    <link rel="stylesheet" href="../popup/popup.css" />
    <?php 
      style_menu();
    ?>
  <style>
        legend{
             width:100%;
        }
        .form-control{
            width: 100%;
            color: blue;
            border: 1px solid #abadb2;
        }
        li a,  .dropbtn {

            text-decoration: none;
        }
        #img{
          position: relative;
      
        }
        #img:hover{
          z-index: 13;
      
        }

          /* The container */
        #container {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 16px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Hide the browser's default checkbox */
        #container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        /* Create a custom checkbox */
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #d8d4d4;
        }

        /* On mouse-over, add a grey background color */
        #container:hover input ~ .checkmark {
            background-color: #ccc;
        }

        /* When the checkbox is checked, add a blue background */
        #container input:checked ~ .checkmark {
            background-color: #2196F3;
        }

        /* Create the checkmark/indicator (hidden when not checked) */
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the checkmark when checked */
        #container input:checked ~ .checkmark:after {
            display: block;
        }

        /* Style the checkmark/indicator */
        #container .checkmark:after {
            left: 9px;
            top: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }
          #image{
            padding-top:5%;
            padding-left:20%;
            float:left;
            min-width: 40%;
          }
          #info{
            color:blue; padding-top: 10px; ;
           padding-left:2%;
            float:left;
            width: 30%;
          }
          #blah{
  
          }
          @media only screen and (max-width: 700px) {
            
            #blah{
              width:120px !important;
              height: 120px !important;
            
            }
            #info{
              width: 60% !important;
              padding-left:0px!important ;
               
            }
            .form-control{
              width: 100% !important;
            }
            legend{
              width:100% !important;
            }
             #image{
               min-width: 100px !important;
               padding-right:0px!important ;
             }
             #img{
               max-width: 120px !important;
             }

          }
  </style>
  <style type="text/css">
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
        if($_SESSION['admin']==1){}else{
          echo "#image2{";
              echo "width: 66px !important;"; 
              echo "height: 66px !important;"; 
          echo "}";
        echo ".dropdown-content-icon{";         
            echo "min-width: 220px !important;";    
        echo "}"; 
           
        }
      ?>

  </style>
   <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(250)
                        .height(250);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
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
    <div id='image'>
       <form id='form' action="signup.php" method="POST" role="form" enctype="multipart/form-data" autocomplete="off" >
        
       <input  id="file-1"   type="file" name="uploadfile"  class="inputfile inputfile-1" data-multiple-caption="{count} files selected" onchange="readURL(this);"/>  <!-- them multiple de chon nhieu anh-->
                        <label id='img' for="file-1" style="max-width: 200px; "><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span ><?php echo $txt_chonanh; ?> &hellip;</span></label><br>
                        <img id="blah" style="position: relative;" />
                    <script src="../js/custom-file-input.js"></script> 
    </div>

    <div id='info'>
            <legend style="color:red;"><?php echo $txt_nhapthongtinusermoi; ?></legend>
            <div class="form-group">
                <label for=""><?php echo $txt_tenuser; ?></label>
                <input   minlength="8" type="text" class="form-control" id="" placeholder="<?php echo $txt_nhaptenuser; ?>" name="name" required autocomplete="off" value="<?php 
                          if(isset($username)&&$kiemtra!=0) echo $username;
                      ?>">
                <div style="color:red"><?php 
                                    if($kiemtra==1) echo $txt_usertontai;
                                    ?>  </div>
            </div>
            
            <div class="form-group">
                <label for=""> Email </label>
                <input minlength="10"  type="text" class="form-control" id="" placeholder="<?php echo $txt_nhapemail; ?>" name="email" required autocomplete="off" value="<?php
                          if(isset($email)&&$kiemtra!=0) echo $email;
                      ?>">
                <div style="color:red"><?php 
                                    if($kiemtra==2) echo $txt_emailtontai;
                                    ?> </div>
            </div>  
            <div class="form-group">
                <label for=""><?php echo $txt_sodienthoai; ?> </label>
                <input minlength="10" type="number" class="form-control" id="" placeholder="<?php echo $txt_nhapsodienthoai; ?>" name="sdt"  required autocomplete="off"   value="<?php 
                          if(isset($sdt)&&$kiemtra!=0) echo $sdt;
                      ?>">
                <div style="color:red"> <?php 
                                      if($kiemtra==3) echo $txt_sdttontai;
                                      elseif($kiemtra==5) echo $txt_sdtkohople;
                                    ?> </div>
            </div>
             <div class="form-group">
                <label for=""><?php echo $txt_matkhau; ?></label>
                <input  minlength="8" type="password" class="form-control" id="" placeholder="<?php echo $txt_nhapmatkhau; ?>" name="password"   required autocomplete="off"  value="<?php 
                          if(isset($password)&&$kiemtra!=0) echo $password;
                      ?>">
                <div style="color:red">  </div>
            </div>
             <div class="form-group">
                <label for=""><?php echo $txt_nhaplaimatkhau; ?></label>
                <input  minlength="8" type="password" class="form-control" id="" placeholder="<?php echo $txt_nhaplaimatkhau; ?>" name="confirm_password"  required autocomplete="off"  value="<?php 
                          if(isset($confirm_password)&&$kiemtra!=0) echo $confirm_password;
                      ?>">
                <div style="color:red"> <?php 
                                    if($kiemtra==4) echo $txt_matkhaukotrungkhop;
                                    ?> </div>
            </div>
             
            <label id="container"><?php echo $txt_useradmin; ?>
              <input type="checkbox" name="checkbox" value="Yes">
              <span class="checkmark"></span>
            </label>
               
            <button type="submit" class="btn btn-primary" name="submit"><?php echo $txt_dangkyuser; ?> </button><br>
            <div style="color:red"><?php 
                                    if($kiemtra==10) echo $txt_thanhcong;
                                    ?>
            </div>
        </form>
 
  </div>

              <?php  facebook(); ?>
</body>
</html>

<script src="../popup/popup.js"></script>