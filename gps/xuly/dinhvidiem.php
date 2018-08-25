<?php 
	require '../library/db.php';
	$tenthietbi = $_GET['tenthietbi'];
	
	$json = array();
		//if($_SESSION['admin']==1){  
			$query =  "SELECT * FROM `seri_thietbi` WHERE tenthietbi='$tenthietbi'";
		//}else{
		//	$user=$_SESSION['tentaikhoan'];
		//	$query =  "SELECT * FROM `user_thietbi` WHERE tenthietbi='$tenthietbi' AND user = '$user'";
		//}

		$result = mysqli_query($link, $query);
		while($row= mysqli_fetch_assoc($result)){
	        $thietbi=$row['thietbi'];
	    }
		//$data = $result->fetch_assoc();
		//$thietbi = $data['thietbi'];

		$query =  "SELECT * FROM $thietbi ORDER BY ID DESC ";
		$result = mysqli_query($link, $query);
		while($row= mysqli_fetch_assoc($result)){
            $vido=$row['vido'];
             $gio=date('H:i:s', strtotime($row['date_time']));  
             $ngay=date('d-m-Y', strtotime($row['date_time']));
            if($vido==0)
                continue;
	        $json[] = array('vido' => $row['vido'],'kinhdo' => $row['kinhdo'],'nhietdo' => $row['nhietdo'],  'doam' =>$row['doam'], 'tenthietbi'=> $tenthietbi,  'gio' =>$gio,  'ngay' =>$ngay);
	        break;
	    }
	die (json_encode($json));
?> 