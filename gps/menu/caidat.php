<?php 
		require '../library/db.php';
    require '../library/function.php';
    require '../library/Pagination.php';
		check_timeout();  
    
		mysqli_set_charset($link, 'UTF8'); 
    if ($_SESSION['logged_in'] != 1 ) {
      $_SESSION['message'] = "Bạn cần phải đăng nhập!";
      header("location: ../login/error.php");    
    }

    getlang();
    if($_SESSION['ngonngu']==0){
      $txt_soluongdong= $array_vn[31];
      $txt_xacnhan= $array_vn[32];
      $txt_tenthietbi= $array_vn[51];
      $txt_nhietdo= $array_vn[52];
      $txt_doam= $array_vn[53];
      $txt_moinhat= $array_vn[54];
      $txt_nguongduoi= $array_vn[55];
      $txt_nguongtren= $array_vn[56];
      $txt_theodoixe= $array_vn[57];
      $txt_tnguongduoi= $array_vn[58];
      $txt_tnguongtren= $array_vn[59];
      $txt_hnguongduoi= $array_vn[60];
      $txt_hnguongtren= $array_vn[61];
      $txt_capnhat= $array_vn[62];
      $txt_ktrathietbi= $array_vn[63];
      $txt_goiysudung= $array_vn[64];
      $txt_goiynhietdo= $array_vn[65];
      $txt_goiydoam= $array_vn[66];
 
      $txt_timebaoloi =$array_vn[163];
    }else{
      $txt_soluongdong= $array_en[31];
      $txt_xacnhan= $array_en[32];
      $txt_tenthietbi= $array_en[51];
      $txt_nhietdo= $array_en[52];
      $txt_doam= $array_en[53];
      $txt_moinhat= $array_en[54];
      $txt_nguongduoi= $array_en[55];
      $txt_nguongtren= $array_en[56];
      $txt_theodoixe= $array_en[57];
      $txt_tnguongduoi= $array_en[58];
      $txt_tnguongtren= $array_en[59];
      $txt_hnguongduoi= $array_en[60];
      $txt_hnguongtren= $array_en[61];
      $txt_capnhat= $array_en[62];
      $txt_ktrathietbi= $array_en[63];
      $txt_goiysudung= $array_en[64];
      $txt_goiynhietdo= $array_en[65];
      $txt_goiydoam= $array_en[66];
       $txt_timebaoloi =$array_en[163];
    }
 
 
 
     //so luong dong
    $user=$_SESSION['tentaikhoan'];
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
?>
<!DOCTYPE html>
<html>
<head>
	<title>Cài đặt thiết bị</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="HandheldFriendly" content="true">

	<link rel="shortcut icon" href="../icon/icon.ico">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="../css/bootstrap.min.css-3.3.1.css">  <!-- menu css -->
  <link rel="stylesheet" type="text/css" href="../css/lichsu.css" />
  
    
  <script src="../js/jquery.min.js-3.3.1.js"></script>
  <script src="../js/jquery.menu-aim.js"></script> <!-- menu aim -->
  <script src="../js/main.js"></script> <!-- Resource jQuery --> 
  <script src="../js/modernizr.js"></script>
  
  <link rel="stylesheet" type="text/css" href="../css/reset.css" />
  <link rel="stylesheet" type="text/css" href="../css/style_menu.css" />
  <script src="../js/jquery-2.1.1.js"></script>
  <script src="../js/function.js"></script>

  <!--  timeout confirm  -->
 
  <link rel="stylesheet" type="text/css"  href="../lib_timeout_confirm/css/jquery-confirm.css"/>
  <script type="text/javascript"  src="../lib_timeout_confirm/js/jquery-confirm.js"></script>
 
  <link rel="stylesheet" href="../popup/popup.css" />
  <?php 
    style_menu();
  ?>
	<style type="text/css">
    input[type=number]::-webkit-inner-spin-button {
      -webkit-appearance: none;
    }
		.capnhat{
			display:inline-block;
			margin-right:10px;
			width: 200px;
			color: blue;
      font-size:16px;
		}
    .capnhat_time{
      display:inline-block;
      margin-right:10px;
      width: 400px;
      color: blue;
      font-size:16px;
    }
		input{
			width: 60px;
		}
   
	   .pagination{
        position: relative;

     }
     .pagination :hover{

      z-index: 2;
    }
    .switch {
      position: relative;
      display: inline-block;
      margin-top:9px;
      width: 38px;
      height: 20px;
    }

    .switch input {display:none;}

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 14px;
      width: 14px;
      left: 4px;
      bottom: 4px;
      top: 3px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked + .slider {
      background-color: #2196F3;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
      -webkit-transform: translateX(16px);
      -ms-transform: translateX(16px);
      transform: translateX(16px);
    }

    /* Rounded sliders */
    .slider.round {
      border-radius: 30px;
    }

    .slider.round:before {
      border-radius: 50%;
    }
    #thietbi_capnhat{
      z-index: 2;
    }
     #tenthietbi,.tenthietbi{
      position: relative;
       
    }
     .tenthietbi :hover{
      z-index: 3;
    }
    #table{
   
    }
    .header{
      border: 1px solid black;
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
        if($_SESSION['admin']==1 || $_SESSION['mode_user']==1){}else{
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
			$(".tenthietbi").click(function() {
				var text = $(this).text();
				$("#thietbi_capnhat").val(text);
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

    <form method="POST" id='form_soluongdong'style=" float: left;color:blue;margin-top: 5px;margin-bottom: 5px;position: static;margin-right: 10px;">
        <div  ><?php  echo $txt_soluongdong;
              ?>: <input type="text" name="soluongdong" id='input_soluongdong' list="browsers" placeholder="<?php echo $soluongtimkiem; ?>"><button  type="submit" class='btn_capnhat' style='width: 80px;margin-left:10px;'  name="sub_soluongdong"><?php  echo $txt_xacnhan; ?></button>
        </div>
    </form>
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
        <script>
        /*window.onclick = function(event) {
        
            if (!event.target.matches('.material-icons')) {
              var dropdowns = document.getElementsByClassName("dropdown-content-notify");
              var i;
              for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                  openDropdown.classList.remove('show');
                }
              }
            }
        };*/
        </script>
      <?php //$query = "SELECT * FROM $thietbi ORDER BY ID DESC LIMIT $soluongtimkiem";
      if($_SESSION['admin']==1 || $_SESSION['mode_user']==1){
          $query = "SELECT * FROM `seri_thietbi` ";
        }else{
           $user = $_SESSION['tentaikhoan'];
          $query = "SELECT * FROM `user_thietbi`  WHERE user = '$user'";
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
      if($_SESSION['admin']==1 || $_SESSION['mode_user']==1){  
        $result = mysqli_query($link, $query = "SELECT * FROM `seri_thietbi`  LIMIT $start, $soluongtimkiem");
      }else{
        $query = "SELECT * FROM `user_thietbi`  WHERE user = '$user'  LIMIT $start, $soluongtimkiem ";
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
        'caidat' => 1,
        ];
        $page = new Pagination($config);
        echo $page->getPagination();
      ?>
	<table id = "table"  width="100%" cellspacing="0" cellpadding="0">
		 
    <tr>
      <th rowspan="2" class='header' ><?php 
               
                echo $txt_tenthietbi;
              ?> </th>
   
      <th colspan="3"  class='header' ><?php 
              
                echo $txt_nhietdo;
              ?> </th>

      <th colspan="3"   class='header' ><?php 
              
                echo $txt_doam;
              ?></th>
 
      <th rowspan="2" class='header'><?php 
              
                echo $txt_theodoixe;
              ?></th>
    </tr>
    <tr>
      <th  class='header' style="border-right:0px;"><?php 
               
                echo $txt_moinhat;
              ?> </th>
      <th  class='header' style="border-left:0px;border-right:0px;"><?php 
               
                echo $txt_nguongduoi;
              ?> </th>
      <th   class='header' style="border-left:0px;"><?php 
                echo $txt_nguongtren;
              ?></th>
      <th  class='header' style="border-right:0px;"><?php 
                echo $txt_moinhat;
              ?> </th>
      <th  class='header' style="border-left:0px;border-right:0px;"><?php 
                echo $txt_nguongduoi;
              ?></th>
      <th  class='header' style="border-left:0px;"><?php 
                echo $txt_nguongtren;
              ?></th>
    </tr>
		<?php
          if($result){
            $result2 = mysqli_query($link, "SELECT time_active FROM `users`  WHERE id = 1");
            while($row2= mysqli_fetch_assoc($result2)){
              $time_active=$row2['time_active'];
            }
     			  while($row= mysqli_fetch_assoc($result)){
              $thietbi=$row['thietbi'];
              $result2 = mysqli_query($link, "SELECT * FROM `seri_thietbi`  WHERE thietbi = '$thietbi'");
              while($row2= mysqli_fetch_assoc($result2)){
                $id=$row2['id'];
         				$tenthietbi=$row2['tenthietbi'];
      	    		$nhietdo_moinhat=$row2['nhietdo_moinhat'];
      	    		$doam_moinhat=$row2['doam_moinhat'];
      			    $nhietdo_duoi=$row2['nhietdo_duoi'];
      	    		$nhietdo_tren= $row2['nhietdo_tren'];
      			    $doam_duoi= $row2['doam_duoi'];
      			    $doam_tren=$row2['doam_tren'];
                $flag_theodoi=$row2['flag_theodoi'];
                $nhietdo_moinhat =number_format($nhietdo_moinhat,2);
                $doam_moinhat =number_format($doam_moinhat,2);
                if($nhietdo_moinhat>=$nhietdo_duoi&&$nhietdo_moinhat<=$nhietdo_tren){
                  $colort="green";

                }else{
                  $colort="red";
                }
                if($doam_moinhat>=$doam_duoi&&$doam_moinhat<=$doam_tren){
                  $colorh="green";

                }else{
                  $colorh="red";
                }
      	    		echo "<tr>";
      	    		echo "<td><center class='tenthietbi'>$tenthietbi</center> </td>" ;
      	    		echo "<td style='border-left: 1px solid gray;'><center class='thongtin' style='color:".$colort."'>$nhietdo_moinhat".'ºC'."</center> </td>" ;
      	    		
      	    		echo "<td><center class='thongtin'>$nhietdo_duoi".'ºC'."</center> </td>" ;
      	    		echo "<td><center class='thongtin'>$nhietdo_tren".'ºC'."</center>  </td>" ;
                echo "<td style='border-left: 1px solid gray;'><center class='thongtin' style='color:".$colorh."'>$doam_moinhat%</center></td>" ;
      	    		echo "<td><center class='thongtin'>$doam_duoi%</center> </td>" ;
      	    		echo "<td style='border-right: 1px solid gray;'><center class='thongtin'>$doam_tren%</center> </td>" ;
              }
              ?>
              <td><center class='thongtin'>
                <label class="switch">
                  <input id="<?php echo $id;?>" class="input_switch" type="checkbox" name="switch"  <?php if($flag_theodoi==1) echo "checked";?> value="<?php echo $id;?>">
                  <span class="slider round"></span>
                </label>
              </center>  </td>
              <?php
    	    		echo "</td>";
    	    	}
          }
		?>
	</table>
    <div>
  		 
  			<p id="tenthietbi" class="capnhat"><?php  echo $txt_tenthietbi;
              ?>: <input id="thietbi_capnhat" list="browsers" type="text" name="tenthietbi" style="width:100px;" ></p>
  			<p class="capnhat"><?php echo $txt_tnguongduoi;
              ?>:  <input id="nhietdo_duoi" type="number" name="nhietdo_duoi"   ></p>
  			<p class="capnhat"><?php  echo $txt_tnguongtren;
              ?>:  <input id="nhietdo_tren" type="number" name="nhietdo_tren" ></p>
  			<p class="capnhat"><?php  echo $txt_hnguongduoi;
              ?>: <input 	id="doam_duoi"  type="number" name="doam_duoi"  ></p>
  			<p class="capnhat"><?php  echo $txt_hnguongtren;
              ?>:  <input 	id="doam_tren"  type="number" name="doam_tren" ></p>
  			<!--<button id="btn_capnhat"   type="submit" name="submitform" >Cập nhật</button>-->
        <button id="btn_capnhat" class="btn_capnhat" style="z-index: 2;position: relative;" ><?php  echo $txt_capnhat;?> </button>
   			<datalist id="browsers">
          <?php  
            
            $result = mysqli_query($link, $query);
            if($result){
              while($row= mysqli_fetch_assoc($result)){
                $tenthietbi=$row['tenthietbi'];
                echo "<option value=".$tenthietbi.">";
              }
            }
             $result=mysqli_query($link,"SELECT * FROM `users` where id=1");
             while($row= mysqli_fetch_assoc($result)){
                $timeout_confirm=$row['timeout_confirm'];
                $time_check=$row['time_check'];
             }
          ?>
        </datalist>
    </div>
     
    <div>
      
      
      <p class="" style="color:blue;float:left;margin-right: 40px; "><?php 
              
                echo $txt_ktrathietbi;
              ?> : <input id="input_time_check" style="width:40px;" type="number" name=""  placeholder="<?php echo $time_check;?>" ><span style="margin-right: 10px;"><?php if($_SESSION['ngonngu']==0) echo "phút"; else echo "minute"; ?></span><button id="btn_time_check" class="btn_capnhat"  ><?php 
              
                echo $txt_capnhat;
              ?>   </button></p>
      <p style="float:left;color:blue;"><?php  echo $txt_timebaoloi; ?>:
            <input id="input_time_active" type="number" style="width:40px;" name=""  placeholder="<?php echo $time_active;?>"><span style="margin-right: 10px;"><?php if($_SESSION['ngonngu']==0) echo "phút"; else echo "minute"; ?></span><button id="btn_time_active" class="btn_capnhat" style="position: relative;z-index: 2;"  ><?php 
                echo $txt_capnhat;
              ?>   </button>
      </p>
    </div><br> <br> 
    <div style="position: relative;margin-top: 0px;right: 0px;">
      <div ><?php echo $txt_goiysudung; ?>  :</div>
      <div style="">- <?php  echo $txt_goiynhietdo; ?>  </div>
      <div style="">- <?php  echo $txt_goiydoam; ?>  </div>
    </div>
       <!-- <button class="btn btn-primary example20">Delete user</button>  -->
        <script type="text/javascript">
           
            $('#btn_capnhat').on('click', function () {
              $.ajax({
                 url : "../xuly/get_lang.php",              
                 type : "post",          // chọn phương thức gửi là post
                 dataType:"json",           // dữ liệu trả về dạng text
                 success : function (result){
                        $.each (result, function (key, item){
                              lang =  item['lang'];
                              if(lang==0){
                                  $.confirm({
                                      title: 'Cập nhật?',
                                      content: 'Xác nhận cập nhật.',
                                      autoClose: 'Hủy|10000',
                                      buttons: {
                                          xacnhan: {
                                            text: 'Xác nhận',
                                            action: function () {
                                              var tenthietbi=$('#thietbi_capnhat').val();
                                              var nhietdo_duoi=$('#nhietdo_duoi').val();
                                              var nhietdo_tren=$('#nhietdo_tren').val();
                                              var doam_duoi=$('#doam_duoi').val();
                                              var doam_tren=$('#doam_tren').val();
                                              $.ajax({
                                                url : "../xuly/capnhatgiatri.php",              
                                                type : "post",          // chọn phương thức gửi là post
                                                dataType:"text",           // dữ liệu trả về dạng text
                                                //async:false,
                                                data : {               // Danh sách các thuộc tính sẽ gửi đi
                                                  tenthietbi : tenthietbi,
                                                  nhietdo_duoi: nhietdo_duoi,
                                                  nhietdo_tren: nhietdo_tren,
                                                  doam_duoi: doam_duoi,
                                                  doam_tren: doam_tren
                                                },
                                                 success : function (result){
                                                        location.reload();
                                                }
                                              });
                                            }
                                          },
                                          Hủy: function () {
                                             // $.alert('action is canceled');
                                             //
                                          }
                                      }
                                  });
                              }else{
                                $.confirm({
                                        title: 'Update?',
                                        content: 'Confirm update.',
                                        autoClose: 'Cancel|10000',
                                        buttons: {
                                            xacnhan: {
                                              text: 'Confirm',
                                              action: function () {
                                                var tenthietbi=$('#thietbi_capnhat').val();
                                                var nhietdo_duoi=$('#nhietdo_duoi').val();
                                                var nhietdo_tren=$('#nhietdo_tren').val();
                                                var doam_duoi=$('#doam_duoi').val();
                                                var doam_tren=$('#doam_tren').val();
                                                $.ajax({
                                                  url : "../xuly/capnhatgiatri.php",              
                                                  type : "post",          // chọn phương thức gửi là post
                                                  dataType:"text",           // dữ liệu trả về dạng text
                                                  //async:false,
                                                  data : {               // Danh sách các thuộc tính sẽ gửi đi
                                                    tenthietbi : tenthietbi,
                                                    nhietdo_duoi: nhietdo_duoi,
                                                    nhietdo_tren: nhietdo_tren,
                                                    doam_duoi: doam_duoi,
                                                    doam_tren: doam_tren
                                                  },
                                                   success : function (result){
                                                          location.reload();
                                                  }
                                                });
                                              }
                                            },
                                            Cancel: function () {
                                               // $.alert('action is canceled');
                                               //
                                            }
                                        }
                                    });
                              }
                        });
                }
              });
            });

             
             $.ajax({
                 url : "../xuly/get_lang_caidat_thietbi.php",              
                 type : "post",          // chọn phương thức gửi là post
                 dataType:"json",           // dữ liệu trả về dạng text
                 success : function (result){
                        $.each (result, function (key, item){
                          chuathaydoigiatri = item['chuathaydoigiatri'];
                          time_kiemtra = item['time_kiemtra'];
                          txt_time_active = item['time_active'];
                          txt_trangthai = item['txt_trangthai'];
                        });
                 }
            });
            $('#btn_time_check').on('click', function () {
             
               $.ajax({
                 url : "../xuly/get_lang.php",              
                 type : "post",          // chọn phương thức gửi là post
                 dataType:"json",           
                 success : function (result){
                        $.each (result, function (key, item){
                              lang =  item['lang'];
                              if(lang==0){
                                $.confirm({
                                      title: 'Cập nhật?',
                                      content: 'Xác nhận cập nhật.',
                                      autoClose: 'Hủy|10000',
                                      buttons: {
                                            xacnhan: {
                                            text: 'Xác nhận',
                                            action: function () {
                                              var time_check=$('#input_time_check').val();
                                              if(!time_check ){
                                                 $.alert(chuathaydoigiatri)
                                              }else if(time_check<=0){
                                                $.alert(time_kiemtra)
                                              }else{
                                                $.ajax({
                                                    url : "../xuly/time_check.php",               
                                                    type : "post",          // chọn phương thức gửi là post
                                                    dataType:"text",           // dữ liệu trả về dạng text
                                                    data : {               // Danh sách các thuộc tính sẽ gửi đi
                                                      time_check : time_check
                                                    },
                                                    success : function (result){
                                                      location.reload();
                                                    }
                                                });
                                              }
                                             
                                            }
                                          },
                                          Hủy: function () {
                                             
                                          }
                                      }
                                  });

                              }else{
                                $.confirm({
                                      title: 'Update?',
                                      content: 'Confirm update.',
                                      autoClose: 'Cancel|10000',
                                      buttons: {
                                            xacnhan: {
                                            text: 'Confirm',
                                            action: function () {
                                              var time_check=$('#input_time_check').val();
                                              if(!time_check ){
                                                 $.alert(chuathaydoigiatri)
                                              }else if(time_check<=0){
                                                $.alert(time_kiemtra)
                                              }else{
                                                $.ajax({
                                                  url : "../xuly/time_check.php",               
                                                  type : "post",          // chọn phương thức gửi là post
                                                  dataType:"text",           // dữ liệu trả về dạng text
                                                  data : {               // Danh sách các thuộc tính sẽ gửi đi
                                                    time_check : time_check
                                                  },
                                                  success : function (result){
                                                    location.reload();
                                                  }
                                                });
                                              }
                                            }
                                          },
                                          Cancel: function () {
                                             
                                          }
                                      }
                                  });

                              }
                          });
                }
              });
            });
                 
          
            
            $('.input_switch').change( function () {
                 
              // $(document).on('change', '.input_switch', function() {  
                 var id=0;
                 id = $(this).val();
                 var checkbox = document.getElementById(id); 
                  $.ajax({
                 url : "../xuly/get_lang.php",              
                 type : "post",          // chọn phương thức gửi là post
                 dataType:"json",           // dữ liệu trả về dạng text
                 success : function (result){
                        $.each (result, function (key, item){
                              lang =  item['lang'];
                              if(lang==0){
                                 $.confirm({ 
                                        title: 'Theo dõi?',
                                        content:  txt_trangthai,
                                        autoClose: 'Hủy|10000',
                                        buttons: {
                                            logoutUser: {
                                                text: 'Xác nhận',
                                                action: function () {
                                                  $.ajax({
                                                    url:'../xuly/checkbox_theodoi.php',
                                                    method:'POST',
                                                    data:{
                                                      id:id
                                                    }
                                                  }); 
                                                }
                                            },
                                            Hủy: function () {
                                                if (checkbox.checked) {
                                                  //alert("checked");
                                                  document.getElementById(id).checked = false;
                                                }else{
                                                  //alert("unchecked");
                                                  document.getElementById(id).checked = true;
                                                }
                                            }
                                        }
                                    });    
                              }else{
                                 $.confirm({ 
                                        title: 'Tracking?',
                                        content:  txt_trangthai,
                                        autoClose: 'Cancel|10000',
                                        buttons: {
                                            logoutUser: {
                                                text: 'Confirm',
                                                action: function () {
                                                  $.ajax({
                                                    url:'../xuly/checkbox_theodoi.php',
                                                    method:'POST',
                                                    data:{
                                                      id:id
                                                    }
                                                  }); 
                                                }
                                            },
                                            Cancel: function () {
                                                if (checkbox.checked) {
                                                  //alert("checked");
                                                  document.getElementById(id).checked = false;
                                                }else{
                                                  //alert("unchecked");
                                                  document.getElementById(id).checked = true;
                                                }
                                            }
                                        }
                                    });    
                              }
                              });
                }
              });
            });
                 
                   
              $('#btn_time_active').on('click', function () {
               
               $.ajax({
                 url : "../xuly/get_lang.php",              
                 type : "post",          // chọn phương thức gửi là post
                 dataType:"json",           // dữ liệu trả về dạng text
                 success : function (result){

                        $.each (result, function (key, item){
                              lang =  item['lang'];
                              if(lang==0){
                                $.confirm({
                                      title: 'Cập nhật?',
                                      content: 'Xác nhận cập nhật.',
                                      autoClose: 'Hủy|10000',
                                      buttons: {
                                            xacnhan: {
                                            text: 'Xác nhận',
                                            action: function () {
                                              var time_active=$('#input_time_active').val();
                                              if(!time_active){
                                                 $.alert(chuathaydoigiatri)
                                              }else if(time_active<=0){
                                                $.alert(txt_time_active)
                                              }else{
                                                $.ajax({
                                                    url : "../xuly/time_active.php",               
                                                    type : "post",          // chọn phương thức gửi là post
                                                    dataType:"text",           // dữ liệu trả về dạng text
                                                    data : {               // Danh sách các thuộc tính sẽ gửi đi
                                                      time_active : time_active
                                                    },
                                                    success : function (result){
                                                      location.reload();
                                                    }
                                                });
                                              }
                                             
                                            }
                                          },
                                          Hủy: function () {
                                             
                                          }
                                      }
                                  });

                              }else{
                                $.confirm({
                                      title: 'Update?',
                                      content: 'Confirm update.',
                                      autoClose: 'Cancel|10000',
                                      buttons: {
                                            xacnhan: {
                                            text: 'Confirm',
                                            action: function () {
                                              var time_active=$('#input_time_active').val();
                                              if(!time_active ){
                                                 $.alert(chuathaydoigiatri)
                                              }else if(time_active<=0){
                                                $.alert(txt_time_active)
                                              }else{
                                                $.ajax({
                                                  url : "../xuly/time_active.php",               
                                                  type : "post",          // chọn phương thức gửi là post
                                                  dataType:"text",           // dữ liệu trả về dạng text
                                                  data : {               // Danh sách các thuộc tính sẽ gửi đi
                                                    time_active : time_active
                                                  },
                                                  success : function (result){
                                                    location.reload();
                                                  }
                                                });
                                              }
                                            }
                                          },
                                          Cancel: function () {
                                             
                                          }
                                      }
                                  });

                              }
                          });
                }
              });
            });
          </script>
            <?php  facebook(); ?>
</body>
</html>
 
 
  <script src="../popup/popup.js"></script>