<?php
	require '../library/db.php';
	require '../Classes/PHPExcel.php';
	require '../library/function.php';
	require '../library/Pagination.php';
	check_timeout();
	mysqli_set_charset($link, 'UTF8'); 
	// Check if user is logged in using the session variable
	if ($_SESSION['logged_in'] != 1 ) {
		$_SESSION['message'] = "Bạn cần phải đăng nhập!";
	  	header("location: ../login/error.php");    
	}

	getlang();
	  if(  $_SESSION['ngonngu']==0){
	    $txt_tenthietbi= $array_vn[21];
	    $txt_seri= $array_vn[22];
	    $txt_tmoinhat= $array_vn[23];
	    $txt_hmoinhat=$array_vn[24];
	    $txt_ngay=$array_vn[25];
	    $txt_gio=$array_vn[26];
	    $txt_chonanh=$array_vn[33];
	    $txt_capnhatanh=$array_vn[34];
	    $txt_soluongdong=$array_vn[31];
	    $txt_xacnhan=$array_vn[32];
	    $txt_thoigian=$array_vn[35];
	    $txt_nhietdo=$array_vn[36];
	    $txt_doam=$array_vn[37];
	    $txt_bando=$array_vn[38];
	    $txt_chitiet=$array_vn[39];
	    $txt_giobatdau=$array_vn[27];
	    $txt_gioketthuc=$array_vn[28];
	    $txt_timkiem=$array_vn[29];
	    $txt_xuatfile=$array_vn[30];
	    $txt_loi=$array_vn[40];

	    $txt_nhietdoduoi=$array_vn[41];
	    $txt_nhietdotren=$array_vn[42];
	    $txt_doamduoi=$array_vn[43];
	    $txt_doamtren=$array_vn[44];
	    $txt_ttnhietdo=$array_vn[45];
	    $txt_ttdoam=$array_vn[46];
	    $txt_dat=$array_vn[47];
	    $txt_kodat=$array_vn[48];
	    $txt_vido=$array_vn[49];
	    $txt_kinhdo=$array_vn[50];

	    $txt_trangchu=$array_vn[146];
	    $txt_lichsu=$array_vn[147];
	    $txt_quanlythietbi=$array_vn[148];
	    $txt_caidatthietbi=$array_vn[149];
	    $txt_themthietbi=$array_vn[150];
	    $txt_taothietbi=$array_vn[151];
	    $txt_xoathietbi=$array_vn[152];
	    $txt_quanlyuser=$array_vn[153];
	    $txt_caidatuser=$array_vn[154];
	    $txt_dangkyuser=$array_vn[155];
	    $txt_xoauser=$array_vn[156];
	    $txt_log=$array_vn[157];
	    $txt_caidathethong=$array_vn[158];
	    $txt_caidatngonngu=$array_vn[196];
	    $txt_caidatemail=$array_vn[197];
	    $txt_lienhe=$array_vn[159];
	    $txt_chinhsuathongtin=$array_vn[160];
	    $txt_dangxuat=$array_vn[161];
		
	    $txt_errordong=$array_vn[163];
	  }else{
	    $txt_tenthietbi= $array_en[21];
	    $txt_seri= $array_en[22];
	    $txt_tmoinhat= $array_en[23];
	    $txt_hmoinhat=$array_en[24];
	    $txt_ngay=$array_en[25];
	    $txt_gio=$array_en[26];
	    $txt_chonanh=$array_en[33];
	    $txt_capnhatanh=$array_en[34];
	    $txt_soluongdong=$array_en[31];
	    $txt_xacnhan=$array_en[32];
	    $txt_thoigian=$array_en[35];
	    $txt_nhietdo=$array_en[36];
	    $txt_doam=$array_en[37];
	    $txt_bando=$array_en[38];
	    $txt_chitiet=$array_en[39];
	    $txt_giobatdau=$array_en[27];
	    $txt_gioketthuc=$array_en[28];
	    $txt_giobatdau=$array_en[29];
	    $txt_gioketthuc=$array_en[30];
	    $txt_timkiem=$array_en[29];
	    $txt_xuatfile=$array_en[30];
	    $txt_loi=$array_en[40];

	    $txt_nhietdoduoi=$array_en[41];
	    $txt_nhietdotren=$array_en[42];
	    $txt_doamduoi=$array_en[43];
	    $txt_doamtren=$array_en[44];
	    $txt_ttnhietdo=$array_en[45];
	    $txt_ttdoam=$array_en[46];
	    $txt_dat=$array_en[47];
	    $txt_kodat=$array_en[48];
	    $txt_vido=$array_en[49];
	    $txt_kinhdo=$array_en[50];

	    $txt_trangchu=$array_en[146];
	    $txt_lichsu=$array_en[147];
	    $txt_quanlythietbi=$array_en[148];
	    $txt_caidatthietbi=$array_en[149];
	    $txt_themthietbi=$array_en[150];
	    $txt_taothietbi=$array_en[151];
	    $txt_xoathietbi=$array_en[152];
	    $txt_quanlyuser=$array_en[153];
	    $txt_caidatuser=$array_en[154];
	    $txt_dangkyuser=$array_en[155];
	    $txt_xoauser=$array_en[156];
	    $txt_log=$array_en[157];
	    $txt_caidathethong=$array_en[158];
	    $txt_caidatngonngu=$array_en[196];
	    $txt_caidatemail=$array_en[197];
	    $txt_lienhe=$array_en[159];
	    $txt_chinhsuathongtin=$array_en[160];
	    $txt_dangxuat=$array_en[161];

	    $txt_errordong=$array_en[163];
	  }

	$_SESSION["thietbi"]=$_GET['thietbi'];
	$thietbi =$_GET['thietbi'];

	$user=$_SESSION["tentaikhoan"];
	$kiemtra=1;
	 
	$query = "SELECT soluongdong FROM users WHERE username='$user'";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_array($result)){
		$soluongtimkiem=$row['soluongdong'];
	}


	if(isset($_POST['submitform'])) 
	{
		$dir="../upload/";
		//if(isset($_FILES['uploadfile']))
		//{
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
					//	$image= time().'_'.$image;
					//}
					$fdir= $dir.$image;
					move_uploaded_file($temp_name, $fdir);
				}
				 
				$query="DELETE FROM `images` WHERE  thietbi= '$thietbi';";
				mysqli_query($link,$query) or die(mysqli_error($link));		
				$query="INSERT IGNORE INTO `images` (`id`,`thietbi`,`file`) values ('','$thietbi','$image')";
				mysqli_query($link,$query) or die(mysqli_error($link));		
			}
		//}
	}
	//xuat file
	if(isset($_POST['btnExport'])){
		$day = $_POST['day'];
		$time_start = $_POST['time_start'];
		$time_end = $_POST['time_end'];
		$daytime_end =$day." ".$time_end;
		$daytime_start =$day." ".$time_start;
		//lay ten tb
		$query = "SELECT tenthietbi FROM seri_thietbi WHERE thietbi='$thietbi'";
		$result = mysqli_query($link, $query);
		$tenthietbi = $result->fetch_assoc();
		$tenfile = $day.' '.$tenthietbi['tenthietbi'];

		$objExcel = new PHPExcel;
		$objExcel->setActiveSheetIndex(0);
		$sheet = $objExcel->getActiveSheet()->setTitle('gps');

		$rowCount = 1;
		$sheet->setCellValue('A'.$rowCount,$txt_tenthietbi);
		$sheet->setCellValue('B'.$rowCount,$txt_nhietdo);
		$sheet->setCellValue('C'.$rowCount,$txt_doam);
		$sheet->setCellValue('D'.$rowCount,$txt_nhietdoduoi);
		$sheet->setCellValue('E'.$rowCount,$txt_nhietdotren);
		$sheet->setCellValue('F'.$rowCount,$txt_doamduoi);
		$sheet->setCellValue('G'.$rowCount,$txt_doamtren);
		$sheet->setCellValue('H'.$rowCount,$txt_ngay);
		$sheet->setCellValue('I'.$rowCount,$txt_gio);
		$sheet->setCellValue('J'.$rowCount,$txt_ttnhietdo);
		$sheet->setCellValue('K'.$rowCount,$txt_ttdoam);
		$sheet->setCellValue('L'.$rowCount,$txt_vido);
		$sheet->setCellValue('M'.$rowCount,$txt_kinhdo);

		$sheet->getColumnDimension("A")->setWidth(12);
		$sheet->getColumnDimension("B")->setAutoSize(true);
		$sheet->getColumnDimension("C")->setAutoSize(true);
		$sheet->getColumnDimension("D")->setWidth(14);
		$sheet->getColumnDimension("E")->setWidth(14);
		$sheet->getColumnDimension("F")->setWidth(13);
		$sheet->getColumnDimension("G")->setWidth(13);
		$sheet->getColumnDimension("H")->setAutoSize(true);
		$sheet->getColumnDimension("I")->setAutoSize(true);
		$sheet->getColumnDimension("J")->setWidth(14);
		$sheet->getColumnDimension("K")->setWidth(14);
		$sheet->getColumnDimension("L")->setWidth(9);
		$sheet->getColumnDimension("M")->setWidth(10);
		$sheet->getStyle('A1:M1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00ffff00');//dat mau nen
		$sheet->getStyle("A1:M1")->getFont()->setBold( true );//in dam
		$objExcel->getActiveSheet()->getStyle('B1:M360')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	 	$objExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(45);
	 	//$objExcel->getActiveSheet()->getColumnDimension('A')->setWidth(140);
	 	$objExcel->getActiveSheet()->getStyle('A1:M1')->getAlignment()->setWrapText(true); 
	 	 $style = array(
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        )
	    );

	    $sheet->getStyle("A1:M1")->applyFromArray($style);
		$result = mysqli_query($link, "SELECT * FROM $thietbi WHERE date_time BETWEEN '$daytime_start' AND '$daytime_end' ORDER BY date_time ");
		
		//$result = $mysqli->query("SELECT * FROM $thietbi ");
		if($result){
			while($row = mysqli_fetch_array($result)){
				$rowCount++;
				$sheet->setCellValue('A'.$rowCount,$tenthietbi['tenthietbi']);
				if($row['nhietdo']>100){
					$objExcel->getActiveSheet()->getStyle('B'.$rowCount)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
					$objExcel->getActiveSheet()->getStyle('C'.$rowCount)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
					$sheet->setCellValue('B'.$rowCount,$txt_loi);
					$sheet->setCellValue('C'.$rowCount,$txt_loi);
				}else{
					if($row['nhietdo']>=$row['nhietdo_duoi'] && $row['nhietdo']<=$row['nhietdo_tren'])
						$objExcel->getActiveSheet()->getStyle('B'.$rowCount)->getFont()->getColor()->setARGB('01a331');
					else
						$objExcel->getActiveSheet()->getStyle('B'.$rowCount)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
					
					if($row['doam']>=$row['doam_duoi'] && $row['doam']<=$row['doam_tren']){
						$objExcel->getActiveSheet()->getStyle('C'.$rowCount)->getFont()->getColor()->setARGB('01a331');
					}else
						$objExcel->getActiveSheet()->getStyle('C'.$rowCount)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
					$sheet->setCellValue('B'.$rowCount,$row['nhietdo']);
					$sheet->setCellValue('C'.$rowCount,$row['doam']);
				}
				if($row['vido']==0){
					$objExcel->getActiveSheet()->getStyle('L'.$rowCount)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
					$objExcel->getActiveSheet()->getStyle('M'.$rowCount)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
					$sheet->setCellValue('L'.$rowCount,$txt_loi);
					$sheet->setCellValue('M'.$rowCount,$txt_loi);
				}else{
					$sheet->setCellValue('L'.$rowCount,$row['vido']);
					$sheet->setCellValue('M'.$rowCount,$row['kinhdo']);
				}
				
				$sheet->setCellValue('D'.$rowCount,$row['nhietdo_duoi']);
				$sheet->setCellValue('E'.$rowCount,$row['nhietdo_tren']);
				$sheet->setCellValue('F'.$rowCount,$row['doam_duoi']);
				$sheet->setCellValue('G'.$rowCount,$row['doam_tren']);
				$sheet->setCellValue('H'.$rowCount,date('Y-m-d', strtotime($row['date_time'])));
				$sheet->setCellValue('I'.$rowCount,date('H:i:s', strtotime($row['date_time'])));
				if($row['nhietdo']>=$row['nhietdo_duoi'] && $row['nhietdo']<=$row['nhietdo_tren']){
					$sheet->setCellValue('J'.$rowCount,$txt_dat);
					$objExcel->getActiveSheet()->getStyle('J'.$rowCount)->getFont()->getColor()->setARGB('01a331');
				}else{
					$sheet->setCellValue('J'.$rowCount,$txt_kodat);
					$objExcel->getActiveSheet()->getStyle('J'.$rowCount)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
				}
				if($row['doam']>=$row['doam_duoi'] && $row['doam']<=$row['doam_tren']){
					$sheet->setCellValue('K'.$rowCount,$txt_dat);
					$objExcel->getActiveSheet()->getStyle('K'.$rowCount)->getFont()->getColor()->setARGB('01a331');
				}else{
					$sheet->setCellValue('K'.$rowCount,$txt_kodat);
					$objExcel->getActiveSheet()->getStyle('K'.$rowCount)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
				}
			}
		}
		$styleArray  = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN 
				) 
			)
		); 
		$sheet->getStyle('A1:'. 'M'.($rowCount))->applyFromArray($styleArray);

		
		$objWriter = new PHPExcel_Writer_Excel2007($objExcel);
		if(  $_SESSION['ngonngu']==0)
			$filename = "$tenfile lich su.xlsx";
		else
			$filename = "$tenfile history.xlsx";
		$objWriter->save($filename);

		header('Content-Disposition: attachment; filename="' . $filename . '"'); 

		header('Content-Type: application/vnd.openxmlformatsofficedocument.spreadsheetml.sheet');  
		header('Content-Length: ' . filesize($filename));  

		header('Content-Transfer-Encoding: binary');  
		header('Cache-Control: must-revalidate');  
		header('Pragma: no-cache');  
		readfile($filename);  

		$objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
		ob_start();
		$objWriter->save('php://output');
		$excelOutput = ob_get_clean();
		return;
	}

?>

<html lang="en" class="no-js">
<head>

<title>Lịch sử</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="../icon/icon.ico">

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
 	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	 <!-- dinh dang va xu ly data picker  -->
	<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/start/jquery-ui.min.css" rel="stylesheet">
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

		
	<!-- dinh dang va xu ly time picker  -->
	<link rel="stylesheet" type="text/css" href="../css/mtimepicker.css" />
	<script type="text/javascript" src="../js/mtimepicker.js"></script>  

	<script src="../js/jquery.confirm.js"></script>
	<script src="../js/function.js"></script>

	<script src="../js/jquery.menu-aim.js"></script> <!-- menu aim -->
	<script src="../js/main.js"></script> <!-- Resource jQuery --> 
	<script src="../js/modernizr.js"></script>
   
	<link rel="stylesheet" type="text/css" href="../css/uploadfile.css" />
	<link rel="stylesheet" type="text/css" href="../css/lichsu.css" />
    <link rel="stylesheet" type="text/css" href="../css/style_menu.css" />
    <link rel="stylesheet" type="text/css" href="../css/reset.css" />

    <!--  timeout confirm  -->
	<link rel="stylesheet" type="text/css"  href="../lib_timeout_confirm/css/jquery-confirm.css"/>
	<script type="text/javascript"  src="../lib_timeout_confirm/js/jquery-confirm.js"></script>
	
	<link rel="stylesheet" href="../popup/popup.css" />
	<?php 
		style_menu();
	?>
	
 

<style type="text/css">

	  #img{
	  	position: relative;
	  	background-color: #5cb85c;
	  	-webkit-transition: .5s ease;
    	transition: .5s ease;
	  }
	  #img:hover{
	  	z-index: 13;
	  	background-color: orange;
	  }
	  #btn_capnhatanh{
      position: relative;
    }
     #table{
	    
	    border-left: 1px solid gray;
	    border-right:  1px solid gray;
 
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
	   		if($_SESSION['admin']==1 ||$_SESSION['mode_user'] ==1 ){}else{
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
</style>

<script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(300)
                        .height(200);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
</script>
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
 
<script >
			var nhietdo,doam;		
			var thietbi = "<?php echo $_GET['thietbi']; ?>";
			var j=0;
			$(document).ready(function(){
				$(".page").live("click", function () {
					var lang = $('#ngonngu').text();
					//alert(lang);
		            var page = $(this).text(); 

		            if(page == "Tìm kiếm" || page =="Search" ){
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
	                    url : "../xuly/search.php", // gửi ajax đến file result.php
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
							var lengthofObject = json.length;
 
	                    	var data = $.parseJSON(result); //ma hoa result
	                    	//alert(lengthofObject);
	                    	//alert(data[lengthofObject-1].num_rows);
	                    	var total_page = Math.ceil(data[lengthofObject-1].num_rows/<?php echo $soluongtimkiem;?>);
	                    	$('#table').empty();
	                    	$('#khonghoatdong').empty();
	                    	$('#pagination').empty();
	                    	if(lang==0){
	                    		$('#table').append("<tr><th class='header'>Thời gian</th>                                   											<th class='header'>Nhiệt độ</th>                                   												<th class='header'>Độ ẩm</th>  	                                    											<th class='header'>Bản đồ</th></tr> ");
	                    		txt_chitiet="Chi tiết";
	                    		txt_loi="Lỗi";
	                    	}
	                    	
	                    	else{
	                    		
	                    		$('#table').append("<tr><th class='header'>Date time</th>                                   													<th class='header'>Temperature</th>                                   														<th class='header'>Humidity</th>                     									                 					<th class='header'>Map</th></tr> ");
	                    		txt_chitiet="Detail";
	                    		txt_loi="Error";
	                    	}
				            $.ajax({
				            	url : "../xuly/search_pagination.php", // gửi ajax đến file result.php
			                    type : "get", // chọn phương thức gửi là get
			                    dateType:"text", // dữ liệu trả về dạng json
			                    async:false,
			                    data : { // Danh sách các thuộc tính sẽ gửi đi
			                         total_page:total_page,
			                         current_page : page,
			                         thietbi: thietbi 
			                    },
			                    success : function (result){
			                    	$('#pagination').append(result);
			                    }
				            });
				      
				            j=0;
	       					$.each(JSON.parse(result), function(key, item) {
	       						if(j!=(lengthofObject-1)){ 
		                    		datetime = item['datetime'];
									nhietdo = item['nhietdo'];
		                        	doam = item['doam'];
		                        	vido=item['vido'];
		                        	color="black";
		                        	if(nhietdo>100){
		                        		nhietdo=txt_loi;
		                        		doam=txt_loi;
		                        		color="red";
		                        	}
		                        	if(vido==0){
		                        		$('#table').append("<tr><td><center class='thongtin'>"+datetime+"</center></td>																<td><center class='thongtin' style='color:"+color+";'>"+nhietdo+"</center> </td>									<td><center class='thongtin' style='color:"+color+";'>"+doam+"</center> </td>										<td><center class='thongtin' style='color: red;'>"+txt_loi+"</center> </td></tr>");
		                        	}else{

		                        		$('#table').append("<tr><td><center class='thongtin'>"+datetime+"</center></td>																<td><center class='thongtin' style='color:"+color+";'>"+nhietdo+"</center> </td>									<td><center class='thongtin' style='color:"+color+";'>"+doam+"</center> </td>										<td><a target='_blank' class='chitiet' href='../map/thietbi.php?datetime="+ datetime+"'><center class='thongtin' >"+txt_chitiet+"</center> </a></td></tr>");
		                        	}

		                        	
		                        }
	                        	j++;
							});   
							if(lang==0){
								if(lengthofObject==1)
									$('#khonghoatdong').append("<center><h2>Thiết bị không hoạt động</h2></center>");  
								 
							}else{
								if(lengthofObject==1)
									$('#khonghoatdong').append("<center><h2>Device does not work<h2></center>");  
							}	
							
	                    }
							
	                });
	            }); 

			});
			
</script>
 
</head>

<body>	
	<div id="poptuk" >
	        <div id="poptuk_content" style='z-index:5' >
		          <div class="poptuk_body"></div>
		          <span onclick="poptuk_a('close')" class="poptuk_b" style="color:blue;border: 2px solid blue;">Đóng</span> 
	        </div>
	</div>
	<header>
    <div  class="cd-dropdown-wrapper ">
      <a class="cd-dropdown-trigger"   style="width:100px;z-index: 4;">Menu</a>
      <?php 
      	if($_SESSION['admin']==1){
          	echo "<nav class='cd-dropdown' style=' height: 350px;'>";
      	}elseif($_SESSION['mode_user']==0){
      		echo "<nav class='cd-dropdown' style=' height: 250px;'>";
      	}else{
      		echo "<nav class='cd-dropdown' style=' height: 300px;'>";
      	}
      ?>
      
        <ul class="cd-dropdown-content">
          <li><a class="menu1" style="margin-left:0px" href="../map/thongtin.php"><?php  echo $txt_trangchu; ?></a></li>
          <li><a   class='menu1' href='luachon_thietbi.php'><?php  echo $txt_lichsu; ?> </a></li>
           
          <li class='has-children'>
          	<a  class='menu1' ><?php 
          			echo $txt_quanlythietbi;
          		?></a>
          	<?php
          		if($_SESSION['admin']==1 ){
          			echo "<ul id='child_quanlythietbi' class='is-hidden' style='margin-top: 100px;'>";
          		}else{
          			echo "<ul id='child_quanlythietbi' class='is-hidden' style='margin-top: 100px;'>";
          		}
          	?>
          		<li><a class="menu2" href="caidat.php"><?php  echo $txt_caidatthietbi; ?></a></li>
          		<li><a class='menu2' href='addthietbi.php'><?php  echo $txt_themthietbi;?></a></li>
          		<li><a class="menu2" href='taothietbi.php'><?php  echo $txt_taothietbi; ?></a></li>
          		<li><a class="menu2" href='xoathietbi.php'><?php  echo $txt_xoathietbi; ?></a></li>
          	</ul>
          	
          </li>
            
           
        	<?php 
            if($_SESSION['mode_user']==1  ){
            echo "<li class='has-children'>";
              echo "<a  class='menu1'  >";
              		 
	          			echo $txt_quanlyuser;
              echo "</a>";  
              	echo "<ul id='child_quanlyuser' class='is-hidden' style='margin-top: 150px;'>";

	              		echo "<li><a class='menu2' href='../menu/caidat_user.php'>";
			          			echo $txt_caidatuser;
	              		echo "</a></li>"; 

		          		echo "<li><a class='menu2' href='../menu/signup.php'>";
			          			echo $txt_dangkyuser;
		          		echo "</a></li>"; 

		          		echo "<li><a  href='../menu/xoa_user.php' class='menu2' >";
			          			echo $txt_xoauser;
		          		echo "</a></li>  "; 

          		echo "</ul>";
            echo "</li>";
            }
          ?>
          <li><a class="menu1" href="log.php"><?php   echo $txt_log; ?></a></li>
          <?php 
          	if($_SESSION['admin']==1  ){
				 
				 echo "<li class='has-children'>";
	              echo "<a  class='menu1'  >";
	              		 
		          			echo $txt_caidathethong;
	              echo "</a>";  
	              	echo "<ul id='child_caidathethong' class='is-hidden' style='margin-top: 250px;'>";

		              		echo "<li><a class='menu2' href='../menu/caidat_ngonngu.php'>";
				          			echo $txt_caidatngonngu;
		              		echo "</a></li>"; 

			          		echo "<li><a class='menu2' href='../menu/caidat_email.php'>";
				          			echo $txt_caidatemail;
			          		echo "</a></li>"; 

			          	 
	          		echo "</ul>";
	            echo "</li>";
          	} 
          ?>
          
          <li><a class="menu1"  onclick="lancer()" ><?php  echo $txt_lienhe; ?></a></li>
          	
        </ul> <!-- .cd-dropdown-content -->
      </nav> <!-- .cd-dropdown -->
    </div> <!-- .cd-dropdown-wrapper -->

    <div id="notification" style="position:absolute;margin-left: 120px; margin-top: 0px" >
	 			<div id="dropdown" style="position: relative;margin-left:  4px; float: left; ">
			  		<button style="background-color: white;"><img id='dropbtn' <?php 
						if($_SESSION['ngonngu']==0){
							echo "src='../icon/vietnamese.png'";
						}else{
							echo "src='../icon/british.png'";
						} ?> style=" height:30px;width:30px;"></button>
				  
				  <div id="dropdown-content"  >
				    <a class='lang' ><img class='lang_icon' src="../icon/vietnamese.png" style=" height:30px;width:30px;"> Việt Nam</a>
					<a class='lang' ><img class='lang_icon' src="../icon/british.png" style=" height:30px;width:30px;"> English</a>
				  </div>
				</div>
        <i id="notify" class="material-icons" style="font-size:36px;margin-top:3px;float:left; margin-left: -5px;" >notifications</i>
          <div id="notify_drop" class="dropdown-content-notify"  style="margin-top:40px; margin-left: 50px;" >
                    <?php  
                      $user = $_SESSION['tentaikhoan'];
                      //so luong thong bao cua user hien thi tren icon thong bao
                      $result = mysqli_query($link,"SELECT * FROM `soluong_thongbao` WHERE user='$user'" );
                      if($result){
                      	while($row = mysqli_fetch_assoc($result)){
                        	$soluong_thongbao=$row['soluong_thongbao'];
                      	}
                      }
                      //user la admin
                     if($_SESSION['admin']==1  || $_SESSION['mode_user']==1){
                     	if($_SESSION['ngonngu']==0)
                        	$result = mysqli_query($link,"SELECT * FROM `thongbao` ORDER BY id DESC LIMIT $soluongthongbao" );
                        else
                        	$result = mysqli_query($link,"SELECT * FROM `thongbao_en` ORDER BY id DESC LIMIT $soluongthongbao" );
                        if($result){
                            while($row= mysqli_fetch_assoc($result)){
                                $thongbao= $row['thongbao'];
                                $tenthietbi=$row['tenthietbi'];
                                $datetime=date('Y-m-d H:i:s', strtotime($row['date_time']));
                                echo "<div><a class='thongbao' style=''>$tenthietbi: $thongbao Time: $datetime</a></div>";
                            }
                        }
                    }else{
                      //lay thong tin user quan ly thiet bi nao, roi log du lieu trong bang thong bao
                      $i=0;
                      $result = mysqli_query($link,"SELECT * FROM `user_thietbi` WHERE user='$user'" );
                      if($result){
                            while($row = mysqli_fetch_assoc($result)){
                              	$mang_tenthietbi[$i] = $row['tenthietbi'];
                                $i++;
                            }
                        }
                        $userStr = implode("', '", $mang_tenthietbi);
                        if($_SESSION['ngonngu']==0)
                        	$result = mysqli_query($link,"SELECT * FROM `thongbao` WHERE tenthietbi IN ('$userStr') ORDER BY id DESC LIMIT $soluongthongbao" );
                        else
                        	$result = mysqli_query($link,"SELECT * FROM `thongbao_en` WHERE tenthietbi IN ('$userStr') ORDER BY id DESC LIMIT $soluongthongbao" );

                        if($result){
                            while($row= mysqli_fetch_assoc($result)){
                                $thongbao= $row['thongbao'];
                                $tenthietbi=$row['tenthietbi'];
                                $datetime=date('Y-m-d H:i:s', strtotime($row['date_time']));
                                echo "<a class='thongbao'>$tenthietbi: $thongbao Time: $datetime</a>";
                            }
                        }
                    }
                    ?>
                    <div><a id='thongbao' class='thongbao' href="thongbao.php"><center><?php if($_SESSION['ngonngu']==0) echo " Xem tất cả ";else echo " View all";?></center></a></div>


            </div> 
                    <?php 
                  	if($soluong_thongbao>0){
                  		echo "<span id='sothongbao' class='button__badge' style=''>$soluong_thongbao</span>";
              		}
                ?>  
                 
    </div> 
    
    
    <div id='avatar' class="dropdown" style="float:right;position: relative;">
	  	<button id='menu_right' class="dropbtn" ><b>Hi, <?php echo $_SESSION['tentaikhoan']."  ";?></b>
	  				<div>				 
						<?php
								$sql="SELECT * FROM `avatar` WHERE user= '$user';";
								$result=mysqli_query($link,$sql) or die(mysqli_error($link));
								if($result){
									while($row=mysqli_fetch_array($result))
									{
						?>				
									<center><img id='image1' src="../upload/<?php echo $row['file'];?>"  ></center>	
								 					
					 	<?php
						 			}
						 		}
						?>	
					</div> 
	  	</button>
	  	 
	  	<div class="dropdown-content-icon" <?php if($_SESSION['mode_user']==0){ echo "style='min-width: 250px;'";} ?> >	 
				<?php
						$sql="SELECT * FROM `avatar` WHERE user= '$user';";
						$result=mysqli_query($link,$sql) or die(mysqli_error($link));
						if($result){
							while($row=mysqli_fetch_array($result))
							{
				?>				
							 	<img id='image2' src='../upload/<?php echo $row['file']; ?>'  
						 					
			 	<?php
			 					if($_SESSION['admin']==1 || $_SESSION['mode_user']==1){
			 						//echo "width='115' height='115'  ";
			 					}else{
			 						echo "style='width: 77px;height: 77px;
			 						'";
			 					}
				 			}
				 		}
				?>	></
			<div id=''  >	
	  			 	<?php 
				            if($_SESSION['admin']==1 || $_SESSION['mode_user']==1){
				            	echo "<a href='../menu/caidat_user.php'>";
				            		 
					          			echo $txt_caidatuser;
				            	echo "</a>";  
				            	echo "<a href='../menu/edit_profile.php'>";
				            		 
					          			echo $txt_chinhsuathongtin;
				            	echo "</a> ";
				    			echo "<a href='../login/logout.php'>";
				    				 
					          			echo $txt_dangxuat;
				    			echo "</a>"; 
				            }else{
				              echo "<a href='../menu/edit_profile.php' style='margin-left: 31%;'>";
                                 
                                 echo $txt_chinhsuathongtin;
                              echo "</a>"; 
                              echo "<a href='../login/logout.php' style='margin-left: 31%;'>";
                              		echo $txt_dangxuat;
                              echo "</a>"; 
				            }
	    			?>
	    		
	    	</div>
	  	</div>
	  	 
	</div>
	  </header>
     <script type="text/javascript" language="javascript">
       $(document).ready(function(){
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
	<div id="thietbi">
		<div>				 
			<?php
					$sql="SELECT * FROM `images` WHERE thietbi= '$thietbi';";
					$result=mysqli_query($link,$sql) or die(mysqli_error($link));
					if($result){
						while($row=mysqli_fetch_array($result))
						{
			?>				
						<img class = 'img' id="anh" src="../upload/<?php echo $row['file'];?>" >						
		 	<?php
			 			}
			 		}
			?>	
		</div>		
		<center><a><?php 
                  echo $txt_tenthietbi;
              ?>:</a>
		<?php 
			$query_seri =  "SELECT * FROM `seri_thietbi` WHERE thietbi='$thietbi';";
			$result_seri = mysqli_query($link, $query_seri);
			if($result){
				while($row_seri = mysqli_fetch_assoc($result_seri)){
					$seri = $row_seri['seri'];
					$tenthietbi= $row_seri['tenthietbi'];
					$_SESSION['tenthietbi']=$tenthietbi;//lay data chuyen sang thietbi.php
				}
			}

			echo "$tenthietbi";
			echo "</center>";
			echo "<center>";
			echo "<a>";
				
                
                  echo $txt_seri;
              
			echo ":</a> $seri";
			echo "</center>";
			$query =  "SELECT * FROM $thietbi ORDER BY id DESC";
			$result = mysqli_query($link, $query);
			if(mysqli_num_rows($result) > 0){
				while($row= mysqli_fetch_assoc($result)){
					$nhietdo=$row['nhietdo'];
		    		$doam=$row['doam'];
		    		if($nhietdo>100)
		    			continue;

		    		echo "<center>";
				    echo "<a>";
				    	 
		                  echo $txt_tmoinhat;
				    echo ":</a> ";
				    echo "$nhietdo";
					echo "°C</center><center>";
				    echo "<a>";
				    	 
		                  echo $txt_hmoinhat;
				    echo ":</a> ";
				    echo "$doam";
				    echo "%</center><center>";
				    echo "<a>";
				    	 
		                  echo $txt_ngay;
				    echo ":</a>"; 
				    echo date('d-m-Y', strtotime($row['date_time']));
				    echo "</center><center>";
				    echo "<a>";
				    	 
		                  echo $txt_gio;
				    echo ":</a>";
				    echo date('H:i:s', strtotime($row['date_time']));
				    echo "</center> ";
				   	break;
				}
			}
		?>	
		<div>
			<form action="" method="post" enctype="multipart/form-data">
				<center><input type="file" name="uploadfile" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple onchange="readURL(this);"/>
			<label   id='img' for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span style="font-size: 20px;"><?php
			 
			                  echo $txt_chonanh;
			              ?>&hellip;</span></label>
			<script src="../js/custom-file-input.js"></script>
				</center>
				<img id="blah"/>
			    <center><button id='btn_capnhatanh' class="button" type="submit" name="submitform"><?php
					 	 
			                  echo $txt_capnhatanh;
			              ?></button></center>
			    <center><div id="result">  </div></center>
			</form>
		</div>						
		
	</div>

	<div id="lichsu">
		<table id = "table"  width="100%">
		<tr style="">
			<th id="thoigian" class='header'><?php echo $txt_thoigian; ?></th>
			<th id="nhietdo" class='header'><?php echo $txt_nhietdo; ?> (ºC)</th>
			<th id="doam" class= 'header'><?php echo $txt_doam; ?> (%)</th>
			<th id="bando" class='header'><?php  echo $txt_bando; ?></th>	
		</tr>
		 
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
		<?php
			//$query = "SELECT * FROM $thietbi ORDER BY ID DESC LIMIT $soluongtimkiem";
			$query = "SELECT * FROM $thietbi ";
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
	        	$result = mysqli_query($link, "SELECT * FROM $thietbi ORDER BY ID DESC LIMIT $start, $limit");
	        	
		       $config = [
		  				'total' => $total_page, 
		  				'limit' => 1,
		  				'full' => false,
		  				'querystring' => 'page',
		  				'thietbi' => $thietbi,
		  				'ajax' => 0,
		  				'current_page' =>0,
		  				'thongbao' => 0,
		  				'log' => 0,
		  				'luachon_thietbi' => 0,
		        		'caidat' => 0,
		        		'xoathietbi' => 0,
		        		'xoa_user' => 0,
		        		'caidat_ngonngu' =>0,
					]; 
					$page = new Pagination($config);
					echo $page->getPagination();

		?>
		 
		<?php
	  		if($total_rows > 0){
		    	while($row= mysqli_fetch_assoc($result)){
		    		$nhietdo=$row['nhietdo'];
		    		$doam=$row['doam'];
		    		$vido=$row['vido'];
		    		$nhietdo =number_format($nhietdo,2);
    				$doam =number_format($doam,2);
    				
				    $datetime=date('d-m-Y H:i:s', strtotime($row['date_time']));
		    		echo "<tr  >";
		    		echo "<td  ><center class='thongtin'>". date('d-m-Y H:i:s', strtotime($row['date_time']))."</center></td>" ;
		    		if($nhietdo>100){
		    			echo "<td  ><center class='thongtin' style='color:red;'>".$txt_loi."</center></td>" ;
		    			echo "<td  ><center class='thongtin' style='color:red;'>".$txt_loi."</center> </td>" ;
		    		}else{
		    			echo "<td  ><center class='thongtin'>$nhietdo</center></td>" ;
		    			echo "<td  ><center class='thongtin'>$doam</center> </td>" ;
		    		}
		    		
		    		if($vido==0){
		    			 echo "<td  ><center class='thongtin' style='color:red;'>".$txt_loi."</center> </td>" ;

		    		}else{
		    			echo "<td  ><a target='_blank'  class='chitiet' href='../map/thietbi.php?datetime=".$datetime."'><center class='thongtin'>";
		    			 
		                  echo $txt_chitiet;
		    			echo "</center> </a></td>";
		    		}
		    		
		    		echo "</tr>";
		    	}
	    	}
		?>
		</table>
		<div id='khonghoatdong'></div>
	</div>

	<div id="timkiem">

		<form method="POST">
			<div id="datepicker"></div>
			<div id="ngay_gio">
				<p><?php echo $txt_ngay;?>: <input type="text" id="day" name="day" size="10" required autocomplete="off" style="margin: 3px;"></p>
 				<p><?php echo $txt_giobatdau;?>: <input type="text" id="time_start" class="time" name="time_start"  style="margin: 3px;"></p>
 				<p><?php echo $txt_gioketthuc;?>: <input type="text" id="time_end" class="time" name="time_end"  style="margin: 3px;"></p>
 				<button  id="btn_timkiem" class="page" type="button"><?php echo $txt_timkiem;?></button>
 				<button id="btn_xuatfile" class="button" name="btnExport" type="submit"><?php echo $txt_xuatfile;?></button>
 			</div>
		</form>
		<p hidden id='ngonngu'> <?php echo $_SESSION['ngonngu']; ?></p>
	</div>
			 <?php
			 	facebook();
			 ?>
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

<!--  popup  -->
	<script src="../popup/popup.js"></script>
