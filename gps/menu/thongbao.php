<?php  
	require '../library/db.php';
	require '../library/Pagination.php';
	require('../Classes/PHPExcel.php');
	require '../library/function.php';
	check_timeout();  
	getlang();
  if(  $_SESSION['ngonngu']==0){
    $txt_soluongdong= $array_vn[31];
    $txt_xacnhan= $array_vn[32];

    $txt_tenthietbi= $array_vn[134];
    $txt_thongbao= $array_vn[135];
    $txt_thoigian= $array_vn[136];
    $txt_tuychon= $array_vn[137];
    $txt_xoaodachon= $array_vn[138];
    
    $txt_ngay= $array_vn[25];
    $txt_gio=$array_vn[26];
    $txt_giobatdau= $array_vn[27];
    $txt_gioketthuc= $array_vn[28];
    $txt_timkiem= $array_vn[29];
    $txt_xuatfile= $array_vn[30];
  }else{
    $txt_soluongdong= $array_en[31];
    $txt_xacnhan= $array_en[32];

    $txt_tenthietbi= $array_en[134];
    $txt_thongbao= $array_en[135];
    $txt_thoigian= $array_en[136];
    $txt_tuychon= $array_en[137];
    $txt_xoaodachon= $array_en[138];

    $txt_ngay= $array_en[25];
    $txt_gio=$array_en[26];
    $txt_giobatdau= $array_en[27];
    $txt_gioketthuc= $array_en[28];
    $txt_timkiem= $array_en[29];
    $txt_xuatfile= $array_en[30];
  }

    if ($_SESSION['logged_in'] != 1 ) {
      $_SESSION['message'] = "Bạn cần phải đăng nhập!";
      header("location: ../login/error.php");    
    }
     
    if(isset($_GET['thietbi'])&&isset($_GET['thoigian'])){ //xoa don
    	$thietbi = $_GET['thietbi'];
    	$thoigian = $_GET['thoigian'];
    	mysqli_query($link, "DELETE FROM thongbao WHERE tenthietbi='$thietbi' AND date_time='$thoigian'");
    	mysqli_query($link, "DELETE FROM thongbao_en WHERE tenthietbi='$thietbi' AND date_time='$thoigian'");
    } 

    $user=$_SESSION["tentaikhoan"];
	 
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
		$sheet->setCellValue('A'.$rowCount,$txt_tenthietbi);
		$sheet->setCellValue('B'.$rowCount,$txt_ngay);
		$sheet->setCellValue('C'.$rowCount,$txt_gio);
		$sheet->setCellValue('D'.$rowCount,$txt_thongbao);
		

		$sheet->getColumnDimension("A")->setAutoSize(true);//dinh dang size cot
		$sheet->getColumnDimension("B")->setAutoSize(true);
		$sheet->getColumnDimension("C")->setAutoSize(true);
		$sheet->getColumnDimension("D")->setAutoSize(true);
		$sheet->getStyle('A1:D1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00ffff00');//dat mau nen
		$sheet->getStyle("A1:D1")->getFont()->setBold( true );//in dam 
		//$result = $mysqli->query("SELECT tenthietbi,thongbao,date_time FROM thongbao ");
		if($_SESSION['admin']==1 || $_SESSION['mode_user']==1){
			if($_SESSION['ngonngu']==0)
				$result = mysqli_query($link, "SELECT * FROM thongbao WHERE date_time BETWEEN '$daytime_start' AND '$daytime_end' ORDER BY date_time ");
			else
				$result = mysqli_query($link, "SELECT * FROM thongbao_en WHERE date_time BETWEEN '$daytime_start' AND '$daytime_end' ORDER BY date_time ");
		}else{
			$i=0;
			$user = $_SESSION['tentaikhoan'];
        	$result = mysqli_query($link,"SELECT * FROM `seri_thietbi` WHERE user='$user'" );
        	if($result){
                while($row = mysqli_fetch_assoc($result)){
                	$mang_tenthietbi[$i] = $row['tenthietbi'];
                	$i++;
                }
            }
            $userStr = implode("', '", $mang_tenthietbi);
            if($_SESSION['ngonngu']==0)
				$result = mysqli_query($link, "SELECT * FROM thongbao WHERE tenthietbi IN ('$userStr') AND date_time BETWEEN '$daytime_start' AND '$daytime_end' ORDER BY date_time");
			else
				$result = mysqli_query($link, "SELECT * FROM thongbao_en WHERE tenthietbi IN ('$userStr') AND date_time BETWEEN '$daytime_start' AND '$daytime_end' ORDER BY date_time");
		}
		while($row = mysqli_fetch_array($result)){
			$rowCount++;
			$sheet->setCellValue('A'.$rowCount,$row['tenthietbi']);
			$sheet->setCellValue('B'.$rowCount,date('Y-m-d', strtotime($row['date_time'])));
			$sheet->setCellValue('C'.$rowCount,date('H:i:s', strtotime($row['date_time'])));
			$sheet->setCellValue('D'.$rowCount,$row['thongbao']);
		}

		//$sheet->getStyle('A'.($rowCount))->getFont()->setBold(true);//in dam cho 1 o
		$styleArray  = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN 
				) 
			)
		); 
		$sheet->getStyle('A1:'. 'D'.($rowCount))->applyFromArray($styleArray);

		$objWriter = new PHPExcel_Writer_Excel2007($objExcel);
		if(  $_SESSION['ngonngu']==0)
			$filename = "$day thongbao.xlsx";
		else
			$filename = "$day notification.xlsx";
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
	<title>Thông báo</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="../icon/icon.ico">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	
	<script src="../js/jquery.min.js-3.3.1.js"></script>	<!-- menu click -->
 
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
	<style type="text/css">
	  	.pagination{
	  		position: relative;
	  		  
	  	}
	  	#table{
	  		position: absolute; 
	  		margin-top: 44px;
	  	}
	  	.pagination :hover{
	  		
	  		z-index: 2;
	  	}
	  	 
	  	#timkiem{
	  		position: fixed; 
	  	}
	  	 #table{
		 	border-right:  1px solid gray;
		    width:78%;
		}
		#tuychon{
		  	min-width: 140px;
		}
		   @media only screen and (max-width: 500px) {
		      #table {
		        margin-top: 70px !important;
		      }
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
	   		if($_SESSION['admin']==1|| $_SESSION['mode_user']==1){}else{
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
	                    url : "../xuly/search_thongbao.php", // gửi ajax đến file result.php
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
	                    	$('#table').empty(); 
            				$('#pagination').empty();
	                    	
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
				             if(lang==0){
				            	$('#table').append("<tr><th class='header'>Tên thiết bị</th>                               												<th class='header'>Thông báo</th>                                       										<th class='header'>Thời gian </th>                                      										<th class='header'>Tùy chọn</th></tr> ");
				            	txt_xoa= "Xóa";
	                    	 }else{
	                    	 	$('#table').append("<tr><th class='header'>Device name</th>                               												<th class='header'>Notification</th>                                       										<th class='header'>Date time </th>                                      										<th class='header'>Option</th></tr> ");
	                    	 	txt_xoa= "Delete";
	                    	 }
				            j=0;
	       					$.each(JSON.parse(result), function(key, item) {
	       						if(j!=(lengthofObject-1)){ 
		                    		tenthietbi = item['tenthietbi'];
									thongbao = item['thongbao'];
		                        	thoigian = item['date_time'];
		                        	id = item['id'];
		                        	$('#table').append("<tr id='"+id+"'><td><center class='thongtin'>"+tenthietbi+"</center></td>													<td><center  class='thongtin'>"+thongbao+"</center> </td>													<td><center class='thongtin'>"+thoigian+"</center> </td>													<td><center class='thongtin' ><a href='thongbao.php?thietbi="+tenthietbi+"&thoigian="+thoigian+"&page="+page+"'  class='btn btn-default' data-placement='top' data-toggle='confirmation'>"+txt_xoa+" </a><input type='checkbox' name='checkbox' value='"+id+"'></center></td></tr>");
		                        }
	                        	j++;
							});  
							//if(lengthofObject==1){
							//	$('#khonghoatdong').append("<center><h2>Thiết bị không hoạt động</h2></center>");  
							//}       
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
    	if($_SESSION['admin']==1 || $_SESSION['mode_user']==1){
    		if($_SESSION['ngonngu']==0)
				$query = "SELECT * FROM thongbao ";
			else
				$query = "SELECT * FROM thongbao_en ";
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
            if($_SESSION['ngonngu']==0)
            	$query = "SELECT * FROM `thongbao` WHERE tenthietbi IN ('$userStr')";
            else
            	$query = "SELECT * FROM `thongbao_en` WHERE tenthietbi IN ('$userStr')";
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
	    	if($_SESSION['admin']==1 || $_SESSION['mode_user']==1){	
	    		if($_SESSION['ngonngu']==0)
					$result = mysqli_query($link, "SELECT * FROM thongbao ORDER BY ID DESC LIMIT $start, $soluongtimkiem");
				else
					$result = mysqli_query($link, "SELECT * FROM thongbao_en ORDER BY ID DESC LIMIT $start, $soluongtimkiem");
			}else{
				if($_SESSION['ngonngu']==0)
					$result = mysqli_query($link,"SELECT * FROM `thongbao` WHERE tenthietbi IN ('$userStr') ORDER BY ID DESC LIMIT $start, $soluongtimkiem ");
				else
					$result = mysqli_query($link,"SELECT * FROM `thongbao_en` WHERE tenthietbi IN ('$userStr') ORDER BY ID DESC LIMIT $start, $soluongtimkiem ");
			}
				 
				$config = [
					'total' => $total_page, 
					'limit' => 1,
					'full' => false,
					'querystring' => 'page',
					'thietbi' => '',
					'ajax' => 0,
					'current_page' =>0,
					'thongbao' => 1,
					'log' => 0,
					'luachon_thietbi' => 0,
	        		'caidat' => 0,
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
 	 
 	
	    <table id = "table"    >
			<tr>
				<th   class='header'><?php  echo $txt_tenthietbi; ?> </th>
				<th  class='header'><?php  echo $txt_thongbao; ?></th>
				<th   class='header'><?php  echo $txt_thoigian; ?> </th>
				<th id='tuychon' class='header'><?php  echo $txt_tuychon; ?> </th>
			</tr>
			<?php
			if($total_rows > 0){
				if($result){
		        	while($row= mysqli_fetch_assoc($result)){
		        		$thongbao=$row['thongbao'];
		   				$tenthietbi=$row['tenthietbi'];
			    		$thoigian=$row['date_time'];
			    		$id=$row['id'];
			    		echo "<tr id='".$row['id']."'>";
			    		echo "<td><center class='tenthietbi'>$tenthietbi </center> </td>" ;
			    		echo "<td><center id='thongbao' class='thongtin'>".$thongbao ."</center> </td>" ;
			    		echo "<td><center class='thongtin'>$thoigian</center></td>" ;
			    		echo "<td><center class='thongtin'  ><a  href='thongbao.php?thietbi=".$tenthietbi."&thoigian=".$thoigian."&page=".$current_page."' class='btn btn-default' data-placement='top' ";
			    			if($_SESSION['ngonngu']==0)
			                        echo "data-toggle='confirmation'data-title='Xóa?' data-btn-ok-label='Xóa'";
			                      else
			                        echo "data-toggle='confirmation'data-title='Delete?' data-btn-ok-label='Delete ' data-btn-cancel-label='Cancel'";
			    		echo ">";  
			    				if($_SESSION['ngonngu']==0)
			                        echo "Xóa";
			                      else
			                        echo "Delete";
			    		 echo "</a><input   type='checkbox' name='checkbox' value='".$row['id']."'></center></td>" ;
			    		echo "</tr>";
			    	}
			    }
			}
			?>
		</table>
		 
 
	
	<div id="timkiem" style="position: relative;margin-left: 78%;">

		<form method="POST">
			<div id="datepicker"></div>
			<div id="ngay_gio">
				<p><?php  echo $txt_ngay; ?>: <input type="text" id="day" name="day" size="10" required autocomplete="off" style="margin: 3px;"></p>
 				<p><?php  echo $txt_giobatdau; ?>: <input type="text" id="time_start" class="time" name="time_start"  style="margin: 3px;"></p>
 				<p><?php  echo $txt_gioketthuc; ?>: <input type="text" id="time_end" class="time" name="time_end"  style="margin: 3px;"></p>
 				<button id="btn_timkiem" type="button"  class="page"><?php echo $txt_timkiem; ?></button>
 				<button id="btn_xuatfile" class="button" name="btnExport" type="submit"><?php  echo $txt_xuatfile; ?></button>
 				<br>
 			</div>
		</form>
		<button type="button"  id="btn_delete" class="button"  ><?php  echo $txt_xoaodachon; ?></button>
		<!--<form method="POST">
			<button id="btn_xoa" class="button" name="btnDeleteAll" type="submit" data-placement='top' data-toggle='confirmation' data-title="Xác nhận xóa tất cả?" data-btn-ok-label="Xóa tất cả">Xóa tất cả</button>
		</form>	-->
		<p hidden id='ngonngu'> <?php echo $_SESSION['ngonngu']; ?></p>
	</div>
 
	<script>
	    $(function() {
	        $('body').confirmation({
	            selector: '[data-toggle="confirmation"]'
	        });

	        $('.confirmation-callback').confirmation({
	            onConfirm: function(event, element) { alert('confirm') },
	            onCancel: function(event, element) { alert('cancel') }
	        });
	    });

    </script>
 			 <?php  facebook(); ?>
</body>
</html>

<script>
$(document).ready(function(){
	$('#btn_delete').click(function(){
   
  // if(confirm("Bạn có muốn xóa những ô đã chọn?"))
 //  {
 		$.ajax({
	         url : "../xuly/get_lang_xoaodachon.php",              
	         type : "post",          // chọn phương thức gửi là post
	         dataType:"json",           // dữ liệu trả về dạng text
	         success : function (result){
	                $.each (result, function (key, item){
	                	xoaodachon =  item['xoaodachon'];
	                	xacnhan_xoaodachon =  item['xacnhan_xoaodachon'];
	                	vuilongchonitnhatmoto =  item['vuilongchonitnhatmoto'];

	                });
	         }
	    });

	 	$.ajax({
	         url : "../xuly/get_lang.php",              
	         type : "post",          // chọn phương thức gửi là post
	         dataType:"json",           // dữ liệu trả về dạng text
	         success : function (result){
	                $.each (result, function (key, item){
	                      lang =  item['lang'];
	                      if(lang==0){
	                      	$.confirm({
						                    title: xoaodachon,
						                    content: xacnhan_xoaodachon ,
						                    autoClose: 'Hủy|10000',
						                    buttons: {
						                        deleteUser: {
						                          text: 'Xác nhận',
						                          action: function () {
						                              $(':checkbox:checked').each(function(i){
													        id[i] = $(this).val();
													     });
													     
													     if(id.length === 0) //tell you if the array is empty
													     {
													        $.alert(vuilongchonitnhatmoto);
													     }
													     else
													     {
													        $.ajax({
													         url:'../xuly/xoa_checkbox.php',
													         method:'POST',
													         data:{id:id},
													         success:function()
													         {
													            //for(var i=0; i<id.length; i++)
													            //{
													            //   $('tr#'+id[i]+'').css('background-color', '#ccc');
													            //   $('tr#'+id[i]+'').fadeOut('slow');
													            //}
													            location.reload();
													         }
													         
													        });
													     }
						   
						                          }
						                        },
						                        Hủy: function () {
						                           // $.alert('action is canceled');
						                           //
						                        }
						                    }
						    });
					    	var id = [];
	                      }else{
	                      	$.confirm({
							                    title: xoaodachon,
							                    content: xacnhan_xoaodachon ,
							                    autoClose: 'Cancel|10000',
							                    buttons: {
							                        deleteUser: {
							                          text: 'Confirm',
							                          action: function () {
							                              $(':checkbox:checked').each(function(i){
														        id[i] = $(this).val();
														     });
														     
														     if(id.length === 0) //tell you if the array is empty
														     {
														        $.alert(vuilongchonitnhatmoto);
														     }
														     else
														     {
														        $.ajax({
														         url:'../xuly/xoa_checkbox.php',
														         method:'POST',
														         data:{id:id},
														         success:function()
														         {
														            //for(var i=0; i<id.length; i++)
														            //{
														            //   $('tr#'+id[i]+'').css('background-color', '#ccc');
														            //   $('tr#'+id[i]+'').fadeOut('slow');
														            //}
														            location.reload();
														         }
														         
														        });
														     }
							   
							                          }
							                        },
							                        Cancel: function () {
							                           // $.alert('action is canceled');
							                           //
							                        }
							                    }
							    });
						    	var id = [];
	                      }
	                }); 
	          }
	    });
	 	 
 
	});
 	
});
</script>
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
<!--  popup  -->
	<script src="../popup/popup.js"></script>