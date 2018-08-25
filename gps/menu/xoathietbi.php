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
  if($_SESSION['ngonngu']==0){
    $txt_stt= $array_vn[92];
    $txt_tenthietbi= $array_vn[93];
    $txt_seri= $array_vn[94];
    $txt_xoathietbi= $array_vn[95];
    $txt_xoa= $array_vn[96];
    $txt_thanhcong= $array_vn[97];
  }else{
    $txt_stt= $array_en[92];
    $txt_tenthietbi= $array_en[93];
    $txt_seri= $array_en[94];
    $txt_xoathietbi= $array_en[95];
    $txt_xoa= $array_en[96];
    $txt_thanhcong= $array_en[97];
  }

  	$user = $_SESSION['tentaikhoan'];
    $query = "SELECT soluongdong FROM users WHERE username='$user'";
    $result = mysqli_query($link, $query);
    while($row = mysqli_fetch_array($result)){
      $soluongtimkiem=$row['soluongdong'];
    }
  	if(isset($_GET['thietbi'])&&isset($_GET['tenthietbi']))
  	{
  		$tenthietbi=$_GET['tenthietbi'];
      $thietbi=$_GET['thietbi'];
      $query =  "DELETE FROM `seri_thietbi` WHERE thietbi='$thietbi'";//xóa mot lan
		  mysqli_query($link, $query);
      if( mysqli_affected_rows($link)==0){

      }else{
  	  	$query =  "DELETE FROM `user_thietbi` WHERE thietbi='$thietbi'";
  	  	mysqli_query($link, $query);
        $query =  "DELETE FROM `hoatdong_thietbi` WHERE tenthietbi='$tenthietbi'";
        mysqli_query($link, $query);
    		$query =  "DELETE FROM `images` WHERE thietbi='$thietbi'";
    		mysqli_query($link, $query);
    		$query =  "DROP TABLE $thietbi;";//xoa 1 lan
    		mysqli_query($link, $query);
  		 
  		  //cap nhat log
  		  mysqli_query($link, "INSERT INTO log(user, thongbao,tenthietbi,date_time) VALUES ('$user', 'Xóa thiết bị','$tenthietbi',now())");
        mysqli_query($link, "INSERT INTO log_en(user, thongbao,tenthietbi,date_time) VALUES ('$user', 'Delete Device','$tenthietbi',now())");
      }
  	}
	 	
  
?> 
<!DOCTYPE html>
<html>
<head>
  <title>Xóa thiết bị</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../icon/icon.ico">

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script src="../js/jquery.min.js-3.3.1.js"></script>  <!-- menu click -->
  <link rel="stylesheet" href="../css/bootstrap.min.css-3.3.1.css">  <!-- menu css -->
     
  <script src="../js/jquery.confirm.js"></script>
  <script src="../js/function.js"></script>

  <script src="../js/jquery.menu-aim.js"></script> <!-- menu aim -->
  <script src="../js/main.js"></script> <!-- Resource jQuery --> 
  <script src="../js/modernizr.js"></script>
 
  <link rel="stylesheet" type="text/css" href="../css/lichsu.css" />
  <link rel="stylesheet" type="text/css" href="../css/style_menu.css" />
  <link rel="stylesheet" type="text/css" href="../css/reset.css" />

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
        if($_SESSION['admin']==1 || $_SESSION['mode_user']==1 ){}else{
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
    @media only screen and (max-width: 400px) {
      .table{
        margin-left: 0px !important;
        width:100%;
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
      if($_SESSION['admin']==1||$_SESSION['mode_user']==1){
          $query = "SELECT * FROM seri_thietbi ";
        }else{
          $i=0;
          $mang_tenthietbi = array();
          //tim user dang quan ly thiet bi nao
          $user = $_SESSION['tentaikhoan'];
          $result_user = mysqli_query($link,"SELECT * FROM `user_thietbi` WHERE user='$user'" );
          if($result_user){
              while($row_user = mysqli_fetch_assoc($result_user)){
                $mang_tenthietbi[$i] = $row_user['tenthietbi'];
                $i++;
              }
          }
          $userStr = implode("', '", $mang_tenthietbi);
          $query = "SELECT * FROM `seri_thietbi` WHERE tenthietbi IN ('$userStr')";
        }
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
        $start = ($current_page - 1) * $limit;  
   
        // BƯỚC 5: TRUY VẤN LẤY DANH SÁCH TIN TỨC
        // Có limit và start rồi thì truy vấn CSDL lấy danh sách tin tức
        if($_SESSION['admin']==1||$_SESSION['mode_user']==1){  
          $result = mysqli_query($link, "SELECT * FROM `seri_thietbi` ORDER BY ID   LIMIT $start, $soluongtimkiem");
        }else{
          $query = "SELECT * FROM `seri_thietbi` WHERE tenthietbi IN ('$userStr') ORDER BY ID   LIMIT $start, $soluongtimkiem ";
          $result = mysqli_query($link,$query);
        }
         
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
            'xoathietbi' => 1
          ];
          $page = new Pagination($config);
          echo $page->getPagination();
        }
      ?>
	 <div id = "div_table" >
    <table class='table' >
      <tr>
        <th id='' class='header'><?php 
              
                echo $txt_stt;
              ?></th>
        <th id=''  class='header'><?php 
               
                echo $txt_tenthietbi;
              ?> </th>
        <th id=''  class='header'><?php 
               
                echo $txt_seri;
              ?> </th>
        <th id=''  class='header'><?php 
               
                echo $txt_xoathietbi;
              ?></th>
      </tr>
      <?php
      
        $i=$soluongtimkiem*($current_page-1) + 1;
        if($result){
              while($row= mysqli_fetch_assoc($result)){
                
                  $thietbi=$row['thietbi'];
                  $tenthietbi=$row['tenthietbi'];
                  $id=$row['id'];
                  $seri=$row['seri'];
                  $ngonngu=$_SESSION['ngonngu'];
                  echo "<tr>";
                  echo "<td><center> ".$i." </center></td>" ;
                  echo "<td> <center>".$tenthietbi."</center> </td>";
                  echo "<td> <center>".$seri."</center> </td>";
                  echo "<td><a href=\"javascript:DeleteThietbi('../menu/xoathietbi.php?thietbi=$thietbi&tenthietbi=$tenthietbi&page=$current_page','$tenthietbi','$ngonngu')\"> <center>";
                     
                      echo $txt_xoa;
                  echo "</center></a> </td>";
                  echo "</tr>";
                  $i++;
              }
          }
      ?>
    </table>
    
  </div>
  <div id='notify_xoa' class='table' style="color:blue;font-size: 20px;">
    <?php 
      if(isset($_GET['thietbi'])&&isset($_GET['tenthietbi']))
      { 
        $tenthietbi=$_GET['tenthietbi'];
         
                echo $txt_xoathietbi;
        echo ' '.$tenthietbi.' ' ;
        
                echo $txt_thanhcong;
      }
    ?>
      
    </div>

            <?php  facebook(); ?>
</body>
</html>
  <script src="../popup/popup.js"></script>