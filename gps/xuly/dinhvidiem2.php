<?php 
	require '../library/db.php';
	$tenthietbi = $_GET['tenthietbi'];
	
	$json = array();
		//if($_SESSION['admin']==1){  
			$query =  "SELECT * FROM `seri_thietbi` WHERE tenthietbi='$tenthietbi' ";
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
            if($_SESSION['admin']==1 || $_SESSION['mode_user']==1){  
           	 	$query = "SELECT * FROM `seri_thietbi` ORDER BY thietbi DESC";
           	}else{
           		$user=$_SESSION['tentaikhoan'];
				//$query =  "SELECT * FROM `user_thietbi` WHERE tenthietbi='$tenthietbi' AND user = '$user'";
				$query = "SELECT * FROM `user_thietbi` WHERE user = '$user'  ORDER BY thietbi DESC";
           	}
            $result2 = mysqli_query($link, $query);
            $i=0;
            while($row2= mysqli_fetch_array($result2)){ 
            	$tenthietbi2=$row2['tenthietbi'];
            	$thietbi =$row2['thietbi'];
            	 	$result3 = mysqli_query($link, "SELECT * FROM `$thietbi`");
                    if(mysqli_num_rows($result3)==0)
                    	continue;
            	if($tenthietbi== $tenthietbi2) 
            		break;
            	$i++;
            }
	        $json[] = array('vido' => $row['vido'],'kinhdo' => $row['kinhdo'],'nhietdo' => $row['nhietdo'],  'doam' =>$row['doam'], 'tenthietbi'=> $tenthietbi,  'gio' =>$gio,  'ngay' =>$ngay,  'id' =>$i);
	        break;
	    }
	die (json_encode($json));
?> 