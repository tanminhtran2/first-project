<?php
	require '../library/db.php';
	$timeout_confirm=$_POST['timeout_confirm'];
 	$user= $_SESSION['tentaikhoan'];
    mysqli_query($link,  "UPDATE `users` SET timeout_confirm = $timeout_confirm WHERE id=1");
    mysqli_query($link,  "INSERT INTO log(user, thongbao,date_time) VALUES ('$user', 'Cập nhật thời gian timeout mã xác nhận: $timeout_confirm phút',now())");
    echo "success";
  ?>