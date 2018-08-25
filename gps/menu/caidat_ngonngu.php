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
    $txt_soluongdong= $array_vn[31];$txt_xacnhan= $array_vn[32];
    $txt_tiengviet= $array_vn[130];
    $txt_tienganh= $array_vn[131];
    $txt_vitri= $array_vn[132];
    $txt_thaydoi= $array_vn[133];
  }else{
    $txt_soluongdong= $array_en[31];$txt_xacnhan= $array_en[32];
    $txt_tiengviet= $array_en[130];
    $txt_tienganh= $array_en[131];
    $txt_vitri= $array_en[132];
    $txt_thaydoi= $array_en[133];
  }
  $user=$_SESSION['tentaikhoan'];
  $query = "SELECT soluongdong FROM users WHERE username='$user'";
  $result = mysqli_query($link, $query);
  while($row = mysqli_fetch_array($result)){
    $soluongtimkiem=$row['soluongdong'];
  }

  //so luong dong
  if(isset($_POST['sub_soluongdong'])) {
    if(isset($_POST['soluongdong'])){
      $soluongdong=$_POST['soluongdong'];
      mysqli_query($link, "UPDATE users  SET soluongdong = $soluongdong WHERE username='$user'");
    }
  }
  $query = "SELECT soluongdong FROM users WHERE username='$user'";
  $result = mysqli_query($link, $query);
  while($row = mysqli_fetch_array($result)){
    $soluongtimkiem=$row['soluongdong'];
  }
	
  if(isset($_GET['user'])){
      $user_get=$_GET['user'];
      $query =  "DELETE FROM `users` WHERE username='$user_get'";
      mysqli_query($link, $query);
      $query =  "DELETE FROM `soluong_thongbao` WHERE user='$user_get'";
      mysqli_query($link, $query);
      $query =  "DELETE FROM `avatar` WHERE user='$user_get'";
      mysqli_query($link, $query);

      mysqli_query($link, "INSERT INTO log(user, thongbao,date_time) VALUES ('$user', 'Xóa user: $user_get',now())");
      mysqli_query($link, "INSERT INTO log_en(user, thongbao,date_time) VALUES ('$user', 'Xóa user: $user_get',now())");
  }
 
  //
  if(isset($_POST['submitform'])) 
  {
    $id=(int)$_POST['id'];
    if(!empty($_POST['vn'])){
      $vn=$_POST['vn'];

      $result = mysqli_query($link, "SELECT * FROM languages WHERE id=$id");//chon du lieu cu
      while($row = mysqli_fetch_array($result)){
        $vn_old=$row['vn'];
      }
      if($vn_old!= $vn){      //kiem tra du lieu co khac voi csdl ko
        mysqli_query($link, "UPDATE languages SET vn='$vn' WHERE id=$id");
        
      }
      
    }
 
    if(!empty($_POST['en'])){
      $en=$_POST['en'];
      $result = mysqli_query($link, "SELECT * FROM languages WHERE id=$id");
      while($row = mysqli_fetch_array($result)){
        $en_old=$row['en'];
      }
      if($en_old!= $en){
        mysqli_query($link, "UPDATE languages SET en='$en' WHERE id='$id'");
        
      }
    }

  }  
?>
<!DOCTYPE html>
<html>
<head>
  <title>Cài đặt ngôn ngữ</title>
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
  <?php 
    style_menu();
  ?>
	<style type="text/css">
        *{
            margin: 0px;
         
          }
        table{
          table-layout: fixed;
          border-left: 1px solid gray;
          border-right: 1px solid gray;
        }
      .pagination{
          width: 80%;
          float: left;
          position: relative;
        }
        .table{
          width: 100%;
          float: left;
          position: relative;
        }
        .btn_xacnhan{
            color:white ;
            background-color:#5cb85c;  
            padding: 3px;
        }
        .btn_xacnhan:hover{
             background-color:#99014a;  
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
        #table{
          width:70%;
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
    <div id='soluongdong' style="float: left;color:blue;margin-top: 5px;margin-bottom: 5px;margin-right:10px;"><?php  echo $txt_soluongdong;
                  ?>: <input type="text" id='input_soluongdong' list="browsers" name="soluongdong" style=" " placeholder="<?php echo $soluongtimkiem; ?>"><button id='btn_soluongdong' type="submit" class='btn_capnhat' style='width: 80px;margin-left:10px;'  name="sub_soluongdong"><?php 
                      echo $txt_xacnhan;
                  ?></button>
        </div>
    <datalist id="browsers">
      <option value="5">
            <option value="10">
            <option value="15">
            <option value="20">
            <option value="25">
            <option value="30">
            <option value="35">
      <option value="40">
    </datalist>
    <?php //$query = "SELECT * FROM $thietbi ORDER BY ID DESC LIMIT $soluongtimkiem";
     
          $query = "SELECT * FROM languages ";
         
    // BƯỚC 2: TÌM TỔNG SỐ RECORDS
    //$total = mysqli_query($link, "SELECT count(id) as total from `$thietbi`");
      //$row_total = mysqli_fetch_assoc($total);
      
      $result = mysqli_query($link, $query);
      $total_rows = mysqli_num_rows($result);//dem so hang tra ve
    // echo $total_rows;
     // BƯỚC 3: TÌM LIMIT VÀ CURRENT_PAGE
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = $soluongtimkiem;
    if($soluongtimkiem>0){    
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
      $start = ($current_page - 1) * $limit ;  
 
      // BƯỚC 5: TRUY VẤN LẤY DANH SÁCH TIN TỨC
      // Có limit và start rồi thì truy vấn CSDL lấy danh sách tin tức
  
      $result = mysqli_query($link, "SELECT * FROM `languages` ORDER BY page ASC  LIMIT $start, $limit");
     
       
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
          'xoa_user' => 0,
          'caidat_ngonngu' =>1,
        ];
        $page = new Pagination($config);
        echo $page->getPagination();
    }
      ?>
 
    <table class='table' >
      <tr>
        <th class='header'><?php  echo $txt_tiengviet; ?> </th>
        <th class='header'><?php  echo $txt_tienganh; ?></th>
        <th class='header'><?php  echo $txt_vitri; ?></th>
        <th class='header'><?php  echo $txt_thaydoi; ?> </th>
      </tr>
     
      <?php
      
        $i=15*($current_page-1) + 1;
        if($result){
              while($row= mysqli_fetch_assoc($result)){
                  $id=$row['id'];
                  $vn=$row['vn'];
                  $en=$row['en'];
                  $page=$row['page'];
                  if($vn=='')
                    continue;
                  echo "<tr>";  
                  echo "<form action='caidat_ngonngu.php?page=$current_page' method='post' >";
                  echo "<td><center><input type='text' value='".$vn."' style='width:100%;' name='vn' > </center></td>" ;
                  echo "<td> <center><input type='text' value='".$en."' style='width:100%;' name='en' > </center></td>";
                  echo "<td> <center>".$page."</center> </td>";
                  echo "<p hidden ><input type='number' name='id' value='".$id."'> </p>";
                  echo "<td ><center><button class='btn_xacnhan ' name='submitform'>";
                        echo $txt_thaydoi;
                  echo "</button></center></td>";
                  echo " </form>";
                  echo "</tr>";
                 
                  $i++;
              }
          }
      ?>
       
    </table>
             <?php  facebook(); ?>
</body>
</html>
<script type="text/javascript">
       $('#btn_soluongdong').on('click', function () {
         soluongdong = $('#input_soluongdong').val();
              $.ajax({
                  url : "../xuly/get_lang_soluongdong.php",              
                  type : "post",          // chọn phương thức gửi là post
                  dataType:"json",           // dữ liệu trả về dạng text
                  
                   success : function (result){
                      $.each (result, function (key, item){
                        chuanhapgiatri=item['chuanhapgiatri'];
                        error_nhohonko=item['error_nhohonko'];

                        if(!soluongdong){
                                    $.alert(chuanhapgiatri);
                                  }
                                    else if(soluongdong>0){
                                         $.ajax({
                                                url : "../xuly/capnhat_soluongdong.php",              
                                                type : "post",          // chọn phương thức gửi là post
                                                dataType:"text",           // dữ liệu trả về dạng text
                                                //async:false,
                                                data : {               // Danh sách các thuộc tính sẽ gửi đi
                                                  soluongdong : soluongdong,
                                                },
                                                 success : function (result){
                                                        location.reload();
                                                }
                                              });
                                    }else{
                                      $.alert(error_nhohonko);
                                    }
                      });
                  }
                });
            });
  </script>
  <script src="../popup/popup.js"></script>