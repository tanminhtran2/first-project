<?php  
	require '../library/db.php';
	$time_check=$_POST['time_check'];
 	$txt_capnhat=$array_vn[176];
 	$txt_capnhat_en=$array_en[176];
 	$user=$_SESSION['tentaikhoan'];
    mysqli_query($link,  "UPDATE `users` SET time_check = $time_check WHERE id=1");
    mysqli_query($link,  "INSERT INTO log(user, thongbao,date_time) VALUES ('$user', '$txt_capnhat: $time_check phút',now())");
    mysqli_query($link,  "INSERT INTO log_en(user, thongbao,date_time) VALUES ('$user', '$txt_capnhat_en: $time_check minute',now())");
    echo "success";

?>