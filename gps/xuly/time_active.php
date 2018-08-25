<?php  
	require '../library/db.php';
	$time_active=$_POST['time_active'];
 	$user=$_SESSION['tentaikhoan'];
 	$txt_capnhat=$array_vn[175];
 	$txt_capnhat_en=$array_en[175];
    mysqli_query($link,  "UPDATE `users` SET time_active = $time_active WHERE id=1");
    mysqli_query($link,  "INSERT INTO log(user, thongbao,date_time) VALUES ('$user', '$txt_capnhat: $time_active phút',now())");
     mysqli_query($link,  "INSERT INTO log_en(user, thongbao,date_time) VALUES ('$user', '$txt_capnhat_en: $time_active minute',now())");
    echo "success";

?>