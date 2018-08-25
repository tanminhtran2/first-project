<?php
	require '../library/db.php';
	if($_SESSION['admin']==1){
	 	mysqli_query($link,"UPDATE soluong_thongbao  SET soluong_thongbao = 0 WHERE id=1;" );
	}else{
		$user = $_SESSION['user'];
		mysqli_query($link,"UPDATE soluong_thongbao  SET soluong_thongbao = 0 WHERE user='$user'" );
	}
?>