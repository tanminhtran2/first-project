<?php
	require '../library/db.php';

	$i=0;
	$day = $_GET['day'];	//nam-thang-ngay
	$time_start = $_GET['time_start'];
	$time_end = $_GET['time_end'];
	$current_page = $_GET['current_page'];
	$daytime_end =$day." ".$time_end;
	$daytime_start =$day." ".$time_start;
	$thietbi = $_SESSION["thietbi"];

	//$thietbi=$_GET['thietbi'];
	$json = array();

	//$query =  "SELECT * FROM $thietbi WHERE DATE(date_time) = '$day'  "; //date tra ve ngay
	// $query =  "SELECT COUNT(*) FROM $thietbi WHERE date_time <= '$daytime' ;"; 
	//$result2 = mysqli_query($link,$query);
	//$_SESSION['num_rows'] = $num_rows;
	$user=$_SESSION['tentaikhoan'];
	$result = mysqli_query($link, "SELECT * FROM users WHERE username='$user' "); 
	while($row= mysqli_fetch_array($result)){
		$soluongtimkiem=$row['soluongdong'];
	}
    $limit = $soluongtimkiem;
	$start = ($current_page - 1) * $limit;
	//$result = mysqli_query($link, "SELECT * FROM $thietbi WHERE date_time <= '$daytime' ORDER BY date_time DESC LIMIT $start, $limit"); 
	$result = mysqli_query($link, "SELECT * FROM $thietbi WHERE date_time BETWEEN '$daytime_start' AND '$daytime_end' ORDER BY date_time DESC "); //thoi gian ket thuc 
	while($row= mysqli_fetch_assoc($result)){
		//if(strcmp (date('H:i:s', strtotime($row['date_time'])), $time_start) >= 0 && !strcmp(date('Y-m-d', strtotime($row['date_time'])), $day) ){			// thoi gian bat dau
			//if( !strcmp(date('Y-m-d', strtotime($row['date_time'])), $day) ){
			if($i>= $start && $i <($start + $limit)){
				$json[] = array( 'nhietdo' =>$row['nhietdo'],'doam' => $row['doam'] ,'vido' =>$row['vido'],'datetime' => date('d-m-Y H:i:s', strtotime($row['date_time'])));
			} 	
        	$i++; 
    }
    
    $num_rows = mysqli_num_rows($result); 
  
    $json[] = array('num_rows' =>$num_rows  );
    die (json_encode($json));
?>
