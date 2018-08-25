<?php

	require '../library/db.php';
  require '../library/function.php';
	check_timeout();  
  // Check if user is logged in using the session variable
  if ( $_SESSION['logged_in'] != 1 ) {
    $_SESSION['message'] = "Bạn cần phải đăng nhập!";
    header("location: ../login/error.php");    
  }
 
 getlang();
  if($_SESSION['ngonngu']==0){
    $txt_tenuser= $array_vn[67];
    $txt_tenthietbi= $array_vn[68];
    $txt_themthietbi= $array_vn[69];
    $txt_themthietbithanhcong= $array_vn[70];
    $txt_kotontai= $array_vn[71];
    $txt_thietbidatontai= $array_vn[72];
    $txt_nhapseri= $array_vn[73];
    $txt_nhapvaomaseri= $array_vn[74];
    $txt_soseri= $array_vn[75];
    $txt_moinhapsoseri= $array_vn[76];
     $txt_soserikotontai= $array_vn[77];
  }else{
    $txt_tenuser= $array_en[67];
    $txt_tenthietbi= $array_en[68];
    $txt_themthietbi= $array_en[69];
    $txt_themthietbithanhcong= $array_en[70];
    $txt_kotontai= $array_en[71];
    $txt_thietbidatontai= $array_en[72];
    $txt_nhapseri= $array_en[73];
    $txt_nhapvaomaseri= $array_en[74];
     $txt_soseri= $array_en[75];
     $txt_moinhapsoseri= $array_en[76];
     $txt_soserikotontai= $array_en[77];
  }

	mysqli_set_charset($link, 'UTF8');
  if (isset($_POST['submit'])){ //submit user
    if(!empty( $_POST['seri'])){ 
      $seri = $_POST['seri'];
      $tentaikhoan=$_SESSION['tentaikhoan'];
      $result = mysqli_query($link,"SELECT * FROM seri_thietbi WHERE seri='$seri'");
      if(mysqli_num_rows($result)>0){//ma ton tai
        while($row = mysqli_fetch_assoc($result)){
          $thietbi=$row['thietbi'];
          $tenthietbi=$row['tenthietbi'];
        }
      
        $result = mysqli_query($link,"SELECT * FROM user_thietbi WHERE tenthietbi='$tenthietbi' AND user='$tentaikhoan'");
        if( mysqli_num_rows($result)>0){ //ma bi trung trong csdl
          $kiemtra=3;
        }else{
          $result = mysqli_query($link,"SELECT * FROM seri_thietbi WHERE seri='$seri'");
          if(mysqli_num_rows($result)>0){
            $kiemtra=1;//them thiet bi thanh cong
            mysqli_query($link,"INSERT INTO user_thietbi(thietbi, tenthietbi,user) VALUES ('$thietbi','$tenthietbi','$tentaikhoan')");
            
          }
        }
      }else{//ma khong ton tai
        $kiemtra=2;
      }
    }else{
      $kiemtra=4;
    }
  }
  $user_hientai=$_SESSION['tentaikhoan'];
  if (isset($_POST['submit_admin'])){ 
    $user = $_POST['user'];
    $tenthietbi = $_POST['tenthietbi'];
    if(empty($_POST['user'])){
      $kiemtra=5;
    }elseif(empty($_POST['tenthietbi'])){
      $kiemtra=6;
    }elseif(!empty($_POST['user'])&& !empty($_POST['tenthietbi'])){
      $result = mysqli_query($link,"SELECT * FROM user_thietbi WHERE tenthietbi='$tenthietbi' AND user='$user'");
      $result2 = mysqli_query($link,"SELECT * FROM seri_thietbi WHERE tenthietbi='$tenthietbi' ");
      $result3 = mysqli_query($link,"SELECT * FROM users WHERE username='$user' ");
      if(mysqli_num_rows($result)>0){
        $kiemtra=3;
      }else if(mysqli_num_rows($result2)>0 && mysqli_num_rows($result3)>0){
         
          $kiemtra = 1;//them thiet bi thanh cong
          //$result = mysqli_query($link,"SELECT * FROM seri_thietbi WHERE tenthietbi='$tenthietbi'");
          if(mysqli_num_rows($result2)>0){
            while($row2 = mysqli_fetch_assoc($result2)){
              $thietbi=$row2['thietbi'];
              mysqli_query($link,"INSERT INTO log(user, thongbao,tenthietbi,date_time) VALUES ('$user_hientai','Thêm thiết bị cho user $user','$tenthietbi','now()')");
              mysqli_query($link,"INSERT INTO log_en(user, thongbao,tenthietbi,date_time) VALUES ('$user_hientai','Add device for user $user','$tenthietbi','now()')");
              mysqli_query($link,"INSERT INTO user_thietbi(thietbi, tenthietbi,user) VALUES ('$thietbi','$tenthietbi','$user')");
            }
          }
        
      }else{
        $kiemtra=2;
      }
    }else{
      $kiemtra=4;
    }
    

    
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Thêm thiết bị</title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="../icon/icon.ico">
	
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script src="../js/jquery.min.js-3.3.1.js"></script>  <!-- menu click -->
  <link rel="stylesheet" href="../css/bootstrap.min.css-3.3.1.css">  <!-- menu css -->
  
  <link rel="stylesheet" type="text/css" href="../css/lichsu.css" />
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
  <style type="text/css">
    .header{

    }
    #table_add th{
      border-right:  1px solid gray;
    }
    #table_add td{
      border-right:  1px solid gray;
    }
    #user{
      width: 20%;
    }
    #thietbi_add{
      width: 60%;
    }
    #tuychon{
      width: 30%;
    }
    legend{
    width: 50%;
    }
    .form-control{
        width: 50%;
        color: blue;
        border: 1px solid #abadb2;
    }
    li a,  .dropbtn { 
        text-decoration: none;
    }
    .capnhat{
      margin-right: 20px;
      margin-top: 5px;
      color: blue;
    }
    #btn_capnhat{
      
      width: 100px;
      color:white;
      background-color:#5cb85c;  
      border: 2px  ;
      padding: 5px;
      margin-top: 2px;
      font-size: 14px;
 
    }
    .tenthietbi{
      padding-left: 5px;
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
        if($_SESSION['admin']==1){}else{
          echo "#image2{";
              echo "width: 66px !important;"; 
              echo "height: 66px !important;"; 
          echo "}";
          echo ".dropdown-content-icon{";         
              echo "min-width: 220px !important;";    
          echo "}";   
          if($_SESSION['mode_user'] ==1){
            echo "#xoathietbi{";
                  echo "margin-top: 150px !important ;";
              echo "}";
          }else{
            echo "#xoathietbi{";
                  echo "margin-top: 120px !important ;";
              echo "}";
          }

        }
      ?>
  </style>
  <script type="text/javascript">
    $(document).ready(function(){
      $(".user").click(function() {
        var text = $(this).text();
        $("#tenuser").val(text);
      });
    });
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
    <?php 
      if($_SESSION['admin']==1 ||$_SESSION['mode_user']==1){
    ?>

    <table id = "table_add"  width="100%" >
      <tr>
        <th id="user" class='header'><?php 
               
                echo $txt_tenuser;
              ?> </th>
        <th id="thietbi_add" class='header'><?php 
              
                echo $txt_tenthietbi;
              ?> </th>
        
      </tr>
        <?php
          $result = mysqli_query($link, "SELECT * FROM `users` ORDER BY username ");
          
          
          if($result){
            while($row= mysqli_fetch_assoc($result)){
              $i=0;
              $username=$row['username'];
              $mode=$row['mode'];
              if($username!=$admin && $username!=''&& $mode==0){
                echo "<tr>";
                
                echo "<td><center class='user'>$username</center></td>";
                echo "<td class='tenthietbi'> ";
                $result2 = mysqli_query($link, "SELECT * FROM `user_thietbi` WHERE user='$username'ORDER BY tenthietbi ");
                $rowcount=mysqli_num_rows($result2);
                if($result2){
                  while($row2 = mysqli_fetch_assoc($result2)){
                    $tenthietbi=$row2['tenthietbi'];
                    echo "$tenthietbi";
                    if($i<$rowcount-1){
                      echo ", ";
                    }else{
                      echo ".";
                     
                    }
                    $i++;
                  }
                
                }
                echo " </td>";
                echo "</tr>";
              }
            
            }
          }
        ?>
        

    </table>
    <form method="POST">
      <p id='add_username' style="float:left; " class="capnhat"><?php 
               
                echo $txt_tenuser;
              ?>: 
        <input id="tenuser" list="user_list" type="text" name="user" style="width:100px;" required autocomplete="off" >
      </p>
      <p  style="float:left; " id="tenthietbi" class="capnhat"><?php 
              
                echo $txt_tenthietbi;
              ?>: 
        <input id="thietbi_capnhat" list="thietbi" type="text" name="tenthietbi" style="width:100px;" required autocomplete="off">
      </p>
      <button  class="btn_capnhat" type="submit" name="submit_admin" ><?php 
              
                echo $txt_themthietbi;
              ?> </button>
      <?php
        if (isset($_POST['submit_admin'])){
          echo "<br>";
          if($kiemtra==1){
              
                echo $txt_themthietbithanhcong;
                 
          }elseif($kiemtra==2){
              
                echo $txt_kotontai;
               
          }elseif($kiemtra==3){
              
                echo $txt_thietbidatontai;
          }elseif($kiemtra==5){
              if($_SESSION['ngonngu']==0)
                                echo "Mời nhập tên user";
                              else
                                echo "The device already exists";
          }elseif($kiemtra==6){
             if($_SESSION['ngonngu']==0)
                                echo "Mời nhập thiết bị";
                              else
                                echo "The device already exists";
          }
        }
      ?>
      <datalist id="thietbi">
        <?php  
          
          $result = mysqli_query($link, "SELECT * FROM `seri_thietbi`");
          if($result){
            while($row= mysqli_fetch_assoc($result)){
              $tenthietbi=$row['tenthietbi'];
              echo "<option value=".$tenthietbi.">";
            }
          }
        ?>
      </datalist>
       <datalist id="user_list">
        <?php  
          
          $result = mysqli_query($link, "SELECT * FROM `users`");
          if($result){
            while($row= mysqli_fetch_assoc($result)){
              $user=$row['username'];
              if($user!='' && $user!=$admin)
                echo "<option value=".$user.">";
            }
          }
        ?>
      </datalist>
    </form>
    <?php 
      }else{ //user
    ?>
         <div id='addthietbi' class="container" style="color:blue; padding-top: 10px;padding-left: 30%;">
          <form action="addthietbi.php" method="POST" role="form" enctype="multipart/form-data">
            <legend style="color:red;"><?php 
               
                echo $txt_nhapseri;
              ?> </legend>
        
            <div class="form-group">
              <label for=""><?php 
                 
                  echo $txt_soseri;
              ?> </label>
              <input type="text" class="form-control" id="" placeholder="<?php 
                  if($_SESSION['ngonngu']==0)
                        echo "Nhập vào mã seri";
                      else
                        echo "Enter the serial number ";?> " name="seri" 
               value="<?php 
                          if(isset($seri)) echo $seri;
                      ?>">
            </div>  
                     
            <button type="submit" class="btn btn-primary" name="submit"><?php 
                 
                  echo $txt_themthietbi;
              ?> </button>
              <?php
                if (isset($_POST['submit'])){
                  echo "<br>";
                  if($kiemtra==1){
                     
                        echo $txt_themthietbithanhcong;
                         
                  }elseif($kiemtra==2){
                      
                        echo $txt_soserikotontai;
                       
                  }elseif($kiemtra==3){
                      
                        echo $txt_thietbidatontai;
                       
                  }elseif($kiemtra==4){
                     
                        echo $txt_moinhapsoseri;
                       
                  }
                }
              ?>
          </form>
        </div>

    <?php }?>
         
         <?php  facebook(); ?>
</body>
</html>
  <script src="../popup/popup.js"></script>