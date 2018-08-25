<?php 
	require '../library/db.php';
 
	    $txt_batemail= $array_vn[177];
	    $txt_tatemail= $array_vn[178];
	    $txt_batsdt= $array_vn[179];
	    $txt_tatsdt= $array_vn[180];
 
  		$txt_batemail_en= $array_en[177];
	    $txt_tatemail_en= $array_en[178];
	    $txt_batsdt_en= $array_en[179];
	    $txt_tatsdt_en= $array_en[180];
 
	$val=$_GET['val'];
	$user=$_SESSION['tentaikhoan'];
	$result = mysqli_query($link,"SELECT * FROM `users` WHERE username='administrator'");
	while($row= mysqli_fetch_assoc($result)){
		$xacnhan= $row['xacnhan'];
	}
	if($val=="email"){
		if($xacnhan[0]=='0'){
			$xacnhan[0]='1';
			mysqli_query($link,"INSERT INTO log(user,thongbao,date_time)  VALUES('$user','$txt_batemail',now())  ");
			mysqli_query($link,"INSERT INTO log_en(user,thongbao,date_time)  VALUES('$user','$txt_batemail_en',now())  ");
		}else{
			$xacnhan[0]='0';
			mysqli_query($link,"INSERT INTO log(user,thongbao,date_time)  VALUES('$user','$txt_tatemail',now())  ");
			mysqli_query($link,"INSERT INTO log_en(user,thongbao,date_time)  VALUES('$user','$txt_tatemail_en',now())  ");
		}
	}else if($val=="sdt"){ 
		if($xacnhan[1]=='0'){
			$xacnhan[1]='1';
			mysqli_query($link,"INSERT INTO log(user,thongbao,date_time)  VALUES('$user','$txt_batsdt',now())  ");
			mysqli_query($link,"INSERT INTO log_en(user,thongbao,date_time)  VALUES('$user','$txt_batsdt_en',now())  ");
		}else{
			$xacnhan[1]='0';
			mysqli_query($link,"INSERT INTO log(user,thongbao,date_time)  VALUES('$user','$txt_tatsdt',now())  ");
			mysqli_query($link,"INSERT INTO log_en(user,thongbao,date_time)  VALUES('$user','$txt_tatsdt_en',now())  ");
		}
	}
 	
	mysqli_query($link,"UPDATE `users`  SET xacnhan = '$xacnhan' WHERE username='administrator'");
 ?>