<?php
	require '../library/db.php';

	$i=0;
	$day = $_GET['day'];	//nam-thang-ngay
	$time_start = $_GET['time_start'];
	$time_end = $_GET['time_end'];
	$current_page = $_GET['current_page'];
	$daytime_end =$day." ".$time_end;
	$daytime_start =$day." ".$time_start;

	$json = array();
 	$user=$_SESSION['tentaikhoan'];
	$result = mysqli_query($link, "SELECT * FROM users WHERE username='$user' "); 
	while($row= mysqli_fetch_array($result)){
		$soluongtimkiem=$row['soluongdong'];
	}
    $limit = $soluongtimkiem;
	$start = ($current_page - 1) * $limit;

	$lang=$_SESSION['ngonngu'];

 	if($_SESSION['admin']==1 || $_SESSION['mode_user']==1){
 		if($lang==0){
			$result = mysqli_query($link, "SELECT * FROM thongbao WHERE date_time BETWEEN '$daytime_start' AND '$daytime_end' ORDER BY date_time DESC "); //thoi gian ket thuc 
		}else{
			$result = mysqli_query($link, "SELECT * FROM thongbao_en WHERE date_time BETWEEN '$daytime_start' AND '$daytime_end' ORDER BY date_time DESC "); //thoi gian ket thuc 
		}
		while($row= mysqli_fetch_assoc($result)){
				if($i>= $start && $i <($start + $limit)){
					$json[] = array('id'=>$row['id'], 'tenthietbi' =>$row['tenthietbi'],'thongbao' => $row['thongbao'] ,'date_time' => date('Y-m-d H:i:s', strtotime($row['date_time'])));
				} 	
	        	$i++; 
	    }
	}else{
		$i=0;
		$user = $_SESSION['user'];
    	$result = mysqli_query($link,"SELECT * FROM `user_thietbi` WHERE user='$user'" );
    	if($result){
            while($row = mysqli_fetch_assoc($result)){
            	$mang_tenthietbi[$i] = $row['tenthietbi'];
            	$i++;
            }
        }
        $userStr = implode("', '", $mang_tenthietbi);
        if($lang==0){
			$result = mysqli_query($link, "SELECT * FROM thongbao WHERE tenthietbi IN ('$userStr') AND date_time BETWEEN '$daytime_start' AND '$daytime_end' ORDER BY date_time");
		}else{
			$result = mysqli_query($link, "SELECT * FROM thongbao_en WHERE tenthietbi IN ('$userStr') AND date_time BETWEEN '$daytime_start' AND '$daytime_end' ORDER BY date_time");
		}
		while($row= mysqli_fetch_assoc($result)){
				if($i>= $start && $i <($start + $limit)){
					$json[] = array('id'=>$row['id'], 'tenthietbi' =>$row['tenthietbi'],'thongbao' => $row['thongbao'] ,'date_time' => date('Y-m-d H:i:s', strtotime($row['date_time'])));
				} 	
	        	$i++; 
	    }
	}


 	$num_rows = mysqli_num_rows($result); 
    $json[] = array('num_rows' =>$num_rows  );
    die (json_encode($json));
?>
