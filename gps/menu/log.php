<?php
/* Displays all successful messages */
  require '../library/db.php';
  require '../library/function.php';
  require '../library/Pagination.php';
  require('../Classes/PHPExcel.php');
  check_timeout();  
  // Check if user is logged in using the session variable
  if ( $_SESSION['logged_in'] != 1 ) {
    $_SESSION['message'] = "Bạn cần phải đăng nhập!";
    header("location: ../login/error.php");    
  }
  getlang();
  if($_SESSION['ngonngu']==0){
    $txt_soluongdong= $array_vn[31];
    $txt_xacnhan= $array_vn[32];
    $txt_tenuser= $array_vn[126];
    $txt_thongbao= $array_vn[127];
    $txt_thietbi= $array_vn[128];
    $txt_thoigian= $array_vn[129];

    $txt_ngay= $array_vn[25];
    $txt_gio=$array_vn[26];
    $txt_giobatdau= $array_vn[27];
    $txt_gioketthuc= $array_vn[28];
    $txt_timkiem= $array_vn[29];
    $txt_xuatfile= $array_vn[30];

    $txt_errordong=$array_vn[163];
  }else{
    $txt_soluongdong= $array_en[31];
    $txt_xacnhan= $array_en[32];
    $txt_tenuser= $array_en[126];
    $txt_thongbao= $array_en[127];
    $txt_thietbi= $array_en[128];
    $txt_thoigian= $array_en[129];

    $txt_ngay= $array_en[25];
    $txt_gio=$array_en[26];
    $txt_giobatdau= $array_en[27];
    $txt_gioketthuc= $array_en[28];
    $txt_timkiem= $array_en[29];
    $txt_xuatfile= $array_en[30];

    $txt_errordong=$array_en[163];
  }

  $user=$_SESSION["tentaikhoan"];
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

   //xuat file
    if(isset($_POST['btnExport'])){
        $day = $_POST['day'];
        $time_start = $_POST['time_start'];
        $time_end = $_POST['time_end']; 
        $daytime_end =$day." ".$time_end;
        $daytime_start =$day." ".$time_start;

        $objExcel = new PHPExcel;
        $objExcel->setActiveSheetIndex(0);
        $sheet = $objExcel->getActiveSheet()->setTitle('thongbao');

        $rowCount = 1;
        $sheet->setCellValue('A'.$rowCount,$txt_tenuser);
        $sheet->setCellValue('B'.$rowCount,$txt_thongbao);
        $sheet->setCellValue('C'.$rowCount,$txt_thietbi);
        $sheet->setCellValue('D'.$rowCount,$txt_ngay);
        $sheet->setCellValue('E'.$rowCount,$txt_gio);

        $sheet->getColumnDimension("A")->setAutoSize(true);//dinh dang size cot
        $sheet->getColumnDimension("B")->setAutoSize(true);
        $sheet->getColumnDimension("C")->setAutoSize(true);
        $sheet->getColumnDimension("D")->setAutoSize(true);
        $sheet->getColumnDimension("E")->setAutoSize(true);
        $sheet->getStyle('A1:E1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00ffff00');//dat mau nen
        $sheet->getStyle("A1:E1")->getFont()->setBold( true );//in dam 
        //$result = $mysqli->query("SELECT tenthietbi,thongbao,date_time FROM thongbao ");
        if($_SESSION['ngonngu']==0)
          $result = mysqli_query($link, "SELECT * FROM log WHERE date_time BETWEEN '$daytime_start' AND '$daytime_end' ORDER BY date_time ");
        else
          $result = mysqli_query($link, "SELECT * FROM log_en WHERE date_time BETWEEN '$daytime_start' AND '$daytime_end' ORDER BY date_time ");
        while($row = mysqli_fetch_array($result)){
          $rowCount++;
          $sheet->setCellValue('A'.$rowCount,$row['user']);
          $sheet->setCellValue('B'.$rowCount,$row['thongbao']);
          $sheet->setCellValue('C'.$rowCount,$row['tenthietbi']);
          $sheet->setCellValue('D'.$rowCount,date('Y-m-d', strtotime($row['date_time'])));
          $sheet->setCellValue('E'.$rowCount,date('H:i:s', strtotime($row['date_time'])));
        }

        //$sheet->getStyle('A'.($rowCount))->getFont()->setBold(true);//in dam cho 1 o
        $styleArray  = array(
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN 
            ) 
          )
        ); 
        $sheet->getStyle('A1:'. 'E'.($rowCount))->applyFromArray($styleArray);

        $objWriter = new PHPExcel_Writer_Excel2007($objExcel);
        $filename = "$day log.xlsx";
        $objWriter->save($filename);

        header('Content-Disposition: attachment; filename="' . $filename . '"');  
        header('Content-Type: application/vnd.openxmlformatsofficedocument.spreadsheetml.sheet');  
        header('Content-Length: ' . filesize($filename));  
        header('Content-Transfer-Encoding: binary');  
        header('Cache-Control: must-revalidate');  
        header('Pragma: no-cache');  
        readfile($filename);  
        return;
      }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Log</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../icon/icon.ico">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  
  <script src="../js/jquery.min.js-3.3.1.js"></script>  <!-- menu click -->
 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script> <!-- xoa bootstrap -->
    <script src="../js/bootstrap-confirmation.min.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.min.css-3.3.1.css">  <!-- menu css -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"><!--css xoa bootstrap -->
    <script src="../js/function.js"></script>

    <!-- dinh dang va xu ly data picker  -->
  <link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/start/jquery-ui.min.css" rel="stylesheet">
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  <!-- dinh dang va xu ly time picker  -->
  <link rel="stylesheet" type="text/css" href="../css/mtimepicker.css" />
  <script type="text/javascript" src="../js/mtimepicker.js"></script>  

    <script src="../js/jquery.menu-aim.js"></script> <!-- menu aim -->
    <script src="../js/main.js"></script> <!-- Resource jQuery --> 
    <script src="../js/modernizr.js"></script>

    <link rel="stylesheet" type="text/css" href="../css/lichsu.css" />
    <link rel="stylesheet" type="text/css" href="../css/thongbao.css" />
    <link rel="stylesheet" type="text/css" href="../css/reset.css" />
    <link rel="stylesheet" type="text/css" href="../css/style_menu.css" />
 
  <!--  timeout confirm  -->
  <link rel="stylesheet" type="text/css"  href="../lib_timeout_confirm/css/jquery-confirm.css"/>
  <script type="text/javascript"  src="../lib_timeout_confirm/js/jquery-confirm.js"></script>

  <link rel="stylesheet" href="../popup/popup.css" />
  <?php 
    style_menu();
  ?>
  <style type="text/css">
   
  #table{
    <?php 
      if($_SESSION['mode_user']==0){
        echo "margin-left: 11%;";
      } 
     ?>
    border-left: 1px solid gray;
    border-right:  1px solid gray;
    width:78%;
  }
 
  
  #ten_user{
    width:15%;
  }
 
  #thongbao_log{

    width:50%;
  }
   
  #datetime{
    width:25%;
  }
  #thietbi_log{
    width:15%;
  }
  .pagination {
     
    
  
    position: relative;
  }
  .pagination :hover{

    z-index: 2;
  }
  .thongtin{
    padding-left: 5px;
  }
  #thongbao{
    text-align:left;
  }
   
  #thoigian_log{
    min-width: 150px;
  }
   @media only screen and (max-width: 700px) {

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
 
      #table {
        margin-top: 70px !important;
      }
   }
  }
  </style> 
  <script type="text/javascript">
    $(function() {
        $.datepicker.setDefaults({
             dateFormat: 'yy-mm-dd'
        });
        $("#datepicker").datepicker({ 

          onSelect: function(dateText, inst) {
            var date = $.datepicker.parseDate($.datepicker._defaults.dateFormat, $("#day").val());
            $("#day").val(dateText);
          }
        });
      });

    $(document).ready( function(){
      $('#time_start').mTimePicker().mTimePicker( 'setTime', '00:00' );
          $('#time_end').mTimePicker().mTimePicker( 'setTime', '23:59' );
      });  
  </script>
  <script type="text/javascript">
    var j=0;
    $(document).ready(function(){
      $("body").on("click", ".page",function () {
              var lang = $('#ngonngu').text();
              var page = $(this).text();  //lay  thiet bi
              if(page == "Tìm kiếm" || page =="Search"){
                page =1;
              }else if(page == "Pre" ){ 
                page = $(".active").text();
                 page =Number(page)-1;
              }
              else if(page == "Next" ){
                page = $(".active").text();
                page =Number(page)+1;
              }
              else{
                page =Number(page);
              }
              $.ajax({
                      url : "../xuly/search_log.php", // gửi ajax đến file result.php
                      type : "get", // chọn phương thức gửi là get
                      dateType:"json", // dữ liệu trả về dạng json
                      async:false,
                      data : { // Danh sách các thuộc tính sẽ gửi đi
                           day : $('#day').val()  ,
                           time_end : $('#time_end').val() ,
                           time_start : $('#time_start').val() ,
                           current_page : page
                           //thietbi: $('#hidden_thietbi').html()           
                      },
                      success : function (result){
                        var json = JSON.parse(result);
                        var lengthofObject = json.length;//chieu dai ma json tra ve
                        var data = $.parseJSON(result); //ma hoa result
                        
                        var total_page = Math.ceil(data[lengthofObject-1].num_rows/<?php echo $soluongtimkiem;?>);
                         
                        //alert(total_page);
                        if(lengthofObject==1){
                          $('#form_soluongdong').empty();
                        }
                        $('#table').empty();
                        $('#pagination').empty();
                        if(lang==0){
                          $('#table').append("<tr><th id='ten_user' class='header'>Tên user</th> <th  class='header' id='thongbao_log'>Thông báo</th>                                           <th id='thietbi_log' class='header'>Thiết bị</th>                                              <th id='thoigian'  class='header'>Thời gian</th></tr> ");
                        }else{
                           $('#table').append("<tr><th class='header'>Username</th> <th  class='header' id='thongbao_log' >Notification</th>                                           <th class='header'>Device</th>                                              <th class='header'>Date time</th></tr> ");
                        }

                        $.ajax({
                              url : "../xuly/search_pagination.php", // gửi ajax đến file result.php
                              type : "get", // chọn phương thức gửi là get
                              dateType:"text", // dữ liệu trả về dạng json
                              async:false,
                              data : { // Danh sách các thuộc tính sẽ gửi đi
                                   total_page:total_page,
                                   current_page : page      
                              },
                              success : function (result){
                                $('#pagination').append(result);
                              }
                         });
                       
                        j=0;
                        $.each(JSON.parse(result), function(key, item) {
                          if(j!=(lengthofObject-1)){ 
                              ten_user = item['ten_user'];
                              thongbao = item['thongbao'];
                              tenthietbi=item['tenthietbi'];
                              thoigian = item['date_time'];
                              id = item['id'];
                              $('#table').append("<tr id='"+id+"'><td><center              class='thongtin'>"+ten_user+"</center></td>                    <td><center   class='thongtin'>"+thongbao+"</center> </td>                             <td><center   class='thongtin'>"+tenthietbi+"</center> </td>                             <td><center   class='thongtin' >"+thoigian+"</center></td></tr>");
                            }
                            j++;
                        });        
                      }
                });
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
     
        <div id='soluongdong' style="float: left;color:blue;margin-top: 5px;margin-bottom: 5px;margin-right:10px;" ><?php  echo $txt_soluongdong;
              ?>: <input type="text" name="soluongdong" id='input_soluongdong' list="browsers" placeholder="<?php echo $soluongtimkiem; ?>"><button id="btn_soluongdong" type="submit" class='btn_capnhat' style='width: 80px;margin-left:10px;'  name="sub_soluongdong"><?php  echo $txt_xacnhan; ?></button>
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
    <?php 
      if($_SESSION['ngonngu']==0)
        $result = mysqli_query($link,"SELECT * FROM `log` ORDER BY ID DESC ");
      else
        $result = mysqli_query($link,"SELECT * FROM `log_en` ORDER BY ID DESC ");
      $total_rows = mysqli_num_rows($result);//dem so hang tra ve
     // BƯỚC 3: TÌM LIMIT VÀ CURRENT_PAGE
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = $soluongtimkiem;
        // BƯỚC 4: TÍNH TOÁN TOTAL_PAGE VÀ START
        // tổng số trang
        if($soluongtimkiem>0){
         
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
            if($_SESSION['ngonngu']==0)
              $result = mysqli_query($link, "SELECT * FROM `log` ORDER BY ID DESC LIMIT $start, $soluongtimkiem");
            else
              $result = mysqli_query($link, "SELECT * FROM `log_en` ORDER BY ID DESC LIMIT $start, $soluongtimkiem");

            $config = [
                'total' => $total_page, 
                'limit' => 1,
                'full' => false,
                'querystring' => 'page',
                'thietbi' => '',
                'ajax' => 0,
                'current_page' =>0,
                'thongbao' => 0,
                'log' => 1
              ];
            $page = new Pagination($config);
            echo $page->getPagination();
          }else{
            echo "<div style='margin-top:8px;color:red;'>";
            echo $txt_errordong;
            echo "</div>";
            $total_rows=-1;
          }
      ?>
   
      
     <div id="thongbao"  >
      <table id="table"  style="position: absolute;  margin-top: 44px;" >
        <tr>
          <th id="ten_user" class='header'><?php  echo $txt_tenuser; ?> </th>
          <th id="thongbao_log" class='header'><?php  echo $txt_thongbao; ?>  </th>
          <th id="thietbi_log" class='header'><?php  echo $txt_thietbi; ?> </th>
          <th id="thoigian" class='header'><?php  echo $txt_thoigian; ?> </th>
        </tr>
        <?php
          if($total_rows > 0){
            if($result){
              while($row=mysqli_fetch_assoc($result)){
                $user=$row['user'];
                $thongbao=$row['thongbao'];
                $tenthietbi=$row['tenthietbi'];
                $datetime=$row['date_time'];
                echo "<tr>";
                echo "<td><center class='thongtin'> ".$user." </center></td>" ;
                echo "<td><center class='thongtin'> ".$thongbao."</center></td>";
                echo "<td><center class='thongtin'> ".$tenthietbi."</center></td>";
                echo "<td><center class='thongtin'> ".$datetime."</center></td>";
                echo "</td>";
              }
            }
          }
        ?>
      </table>

 </div>
 <?php if($_SESSION['mode_user']==1){?>
     <div id="timkiem" style="position: relative;margin-left: 78%;margin-top: 0px;">
        <form method="POST">
          <div id="datepicker"></div>
          <div id="ngay_gio">
            <p><?php  echo $txt_ngay;  ?>: <input type="text" id="day" name="day" size="10" required autocomplete="off" style="margin: 3px;"></p>
            <p><?php  echo $txt_giobatdau; ?>: <input type="text" id="time_start" class="time" name="time_start"  style="margin: 3px;"></p>
            <p><?php  echo $txt_gioketthuc; ?>: <input type="text" id="time_end" class="time" name="time_end"  style="margin: 3px;"></p>
            <button id="btn_timkiem" type="button"  class="page"><?php echo $txt_timkiem;?></button>
            <button id="btn_xuatfile" class="button" name="btnExport" type="submit"><?php echo $txt_xuatfile;?></button>
            <br>
          </div>
        </form>
        <p hidden id='ngonngu'> <?php echo $_SESSION['ngonngu']; ?></p>
  </div>
<?php } ?>
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