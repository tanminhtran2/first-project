<?php 
	require '../library/db.php';
	$id=$_POST['id'];
	$timeout=$_POST['timeout'];
	$user=$_SESSION["tentaikhoan"];

	$txt_capnhattimeout=$array_vn[174];
	$txt_capnhattimeout_en=$array_en[174];

	mysqli_query($link, "UPDATE `users` SET timeout=$timeout WHERE id=$id ");
	if(is_numeric($timeout)){
		$query = "SELECT * FROM `users` WHERE id=$id ";
		$result = mysqli_query($link, $query);
		while($row= mysqli_fetch_assoc($result)){
			$user=$row['username'];
		}
		 mysqli_query($link, "INSERT INTO log(user, thongbao,date_time) VALUES ('$user', '$txt_capnhattimeout $user: $timeout phút',now())");
		  mysqli_query($link, "INSERT INTO log_en(user, thongbao,date_time) VALUES ('$user', '$txt_capnhattimeout_en $user: $timeout minute',now())");
	}
	
	
 
?>