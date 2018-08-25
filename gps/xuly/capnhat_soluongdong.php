<?php 
	require '../library/db.php';
	$soluongdong=$_POST['soluongdong'];
	$user=$_SESSION["tentaikhoan"];

	mysqli_query($link, "UPDATE users  SET soluongdong = $soluongdong WHERE username='$user'");
	echo "thanhcong";
 ?>