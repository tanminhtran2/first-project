<?php
 
	require '../library/db.php';
  require '../library/function.php';
    require '../library/Pagination.php';
	check_timeout();  
  // Check if user is logged in using the session variable
  if ( $_SESSION['logged_in'] != 1 ) {
    $_SESSION['message'] = "Bạn cần phải đăng nhập!";
    header("location: ../login/error.php");    
  }
	mysqli_set_charset($link, 'UTF8');
  getlang();
  if(  $_SESSION['ngonngu']==0){
    $txt_stt= $array_vn[122];
    $txt_tenuser= $array_vn[123];
    $txt_phanquyen= $array_vn[124];
    $txt_xoa= $array_vn[125];
    $txt_thanhcong= $array_vn[97];
  }else{
    $txt_stt= $array_en[122];
    $txt_tenuser= $array_en[123];
    $txt_phanquyen= $array_en[124];
    $txt_xoa= $array_en[125];
    $txt_thanhcong= $array_en[97];
  }

	$user=$_SESSION['tentaikhoan'];
  if(isset($_GET['user'])){
      $user_get=$_GET['user'];
      $query =  "DELETE FROM `users` WHERE username='$user_get'";
      mysqli_query($link, $query);
      if( mysqli_affected_rows($link)==0){

      }else{
        $query =  "DELETE FROM `soluong_thongbao` WHERE user='$user_get'";
        mysqli_query($link, $query);
        $query =  "DELETE FROM `avatar` WHERE user='$user_get'";
        mysqli_query($link, $query);
        mysqli_query($link, "INSERT INTO log(user, thongbao,date_time) VALUES ('$user', 'Xóa user: $user_get',now())");
        mysqli_query($link, "INSERT INTO log_en(user, thongbao,date_time) VALUES ('$user', 'Delete user: $user_get',now())");
      }
  }
    
?>
<!DOCTYPE html>
<html>
<head>
  <title>Xóa user</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../icon/icon.ico">

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script src="../js/jquery.min.js-3.3.1.js"></script>  <!-- menu click -->
  <link rel="stylesheet" href="../css/bootstrap.min.css-3.3.1.css">  <!-- menu css -->
      
  <script src="../js/jquery.menu-aim.js"></script> <!-- menu aim -->
  <script src="../js/main.js"></script> <!-- Resource jQuery --> 
  <script src="../js/modernizr.js"></script>
 
  <link rel="stylesheet" type="text/css" href="../css/lichsu.css" />
  <link rel="stylesheet" type="text/css" href="../css/style_menu.css" />
  <link rel="stylesheet" type="text/css" href="../css/reset.css" />

  <script src="../js/jquery.confirm.js"></script>
  <script src="../js/function.js"></script>
    <!--  timeout confirm  -->
  <link rel="stylesheet" type="text/css"  href="../lib_timeout_confirm/css/jquery-confirm.css"/>
  <script type="text/javascript"  src="../lib_timeout_confirm/js/jquery-confirm.js"></script>
	<link rel="stylesheet" href="../popup/popup.css" />
	<style type="text/css">
        table{
          table-layout: fixed;
          border-left: 1px solid gray;
          border-right:  1px solid gray;
       
        }
      .pagination{
          width: 80%;
          margin-left: 15%;
          float: left;
          position: relative;
        }
        .table{
          width: 50%;
          margin-left: 15%;
          float: left;
          position: relative;
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
        .table{
          width:75%;
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
      }
      @media only screen and (max-width: 400px) {
          .table{
            margin-left: 0px !important;
            width:100% !important;
          }
          .pagination{
            margin-left: 0px !important;
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
    <?php //$query = "SELECT * FROM $thietbi ORDER BY ID DESC LIMIT $soluongtimkiem";
     
          $query = "SELECT * FROM users ";
         
    // BƯỚC 2: TÌM TỔNG SỐ RECORDS
    //$total = mysqli_query($link, "SELECT count(id) as total from `$thietbi`");
      //$row_total = mysqli_fetch_assoc($total);
      
      $result = mysqli_query($link, $query);
      $total_rows = mysqli_num_rows($result);//dem so hang tra ve
    // echo $total_rows;
     // BƯỚC 3: TÌM LIMIT VÀ CURRENT_PAGE
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
          $user=$_SESSION['tentaikhoan'];
         $result2 = mysqli_query($link, "SELECT * FROM users WHERE username='$user'");
         while($row2= mysqli_fetch_assoc($result2)){
          $soluongtimkiem=$row2['soluongdong'];
         }
        $limit = $soluongtimkiem;
        // BƯỚC 4: TÍNH TOÁN TOTAL_PAGE VÀ START
        // tổng số trang
        $total_page = ceil($total_rows / $limit);
        // Giới hạn current_page trong khoảng 1 đến total_page
        if ($current_page > $total_page){
            $current_page = $total_page;
        }
        else if ($current_page < 1){
            $current_page = 1;
        }
        // Tìm Start
      $start = ($current_page - 1) * $limit +2;  
 
      // BƯỚC 5: TRUY VẤN LẤY DANH SÁCH TIN TỨC
      // Có limit và start rồi thì truy vấn CSDL lấy danh sách tin tức
  
      $result = mysqli_query($link, "SELECT * FROM `users` ORDER BY ID   LIMIT $start, $soluongtimkiem");
     
       
      $config = [
        'total' => $total_page, 
        'limit' => 1,
        'full' => false,
        'querystring' => 'page',
        'thietbi' => '',
        'ajax' => 0,
        'current_page' =>0,
        'thongbao' => 0,
        'log' => 0,
        'luachon_thietbi' => 0,
         'caidat' => 0,
          'xoathietbi' => 0,
          'xoa_user' => 1,
        ];
        $page = new Pagination($config);
        echo $page->getPagination();
      ?>
      
   <div id = "div_table" >
    <table class='table' >
      <tr>
        <th id='' class='header'><?php 
               
                echo $txt_stt;
              ?> </th>
        <th id=''  class='header'><?php 
               
                echo $txt_tenuser;
              ?> </th>
        <th id=''  class='header'><?php 
               
                echo $txt_phanquyen;?> </th>
        <th id=''  class='header'><?php 
               
                echo $txt_xoa;
              ?></th>
      </tr>
      <?php
      
        $i=$limit*($current_page-1) + 1;
        $user_session=$_SESSION['tentaikhoan'];
        if($result){
              while($row= mysqli_fetch_assoc($result)){
                  $user=$row['username'];
                 // if($user==$user_session){
                 //   continue;
                 // }
                  $id=$row['id'];
                  $mode=$row['mode'];
                  if($mode==1){
                    $phanquyen = 'admin';
                  }else
                    $phanquyen= 'user';
                  

                  $ngonngu=$_SESSION['ngonngu'];
                  echo "<tr>";
                  echo "<td><center> ".$i." </center></td>" ;
                  echo "<td> <center>".$user."</center> </td>";
                  echo "<td> <center>".$phanquyen."</center> </td>";
                  echo "<td><a  href=\"javascript:DeleteUser('xoa_user.php?user=$user&page=$current_page','$user','$ngonngu')\" > <center>";
                     
                      echo $txt_xoa;
                  echo "</center></a> </td>";
                  echo "</tr>";
                  $i++;
              }
          }
      ?>
    </table>
    
  </div>
  <div id='notify_xoa' class='table'  style="color:blue;font-size: 20px;">
    <?php 
      if(isset($_GET['user']))
      { 
        $user=$_GET['user'];
        echo $txt_xoa;
        echo ' user '.$user.' ';
        echo $txt_thanhcong;

      }
    ?>
      
    </div>

             <?php  facebook(); ?>
</body>
</html>
  <script src="../popup/popup.js"></script>