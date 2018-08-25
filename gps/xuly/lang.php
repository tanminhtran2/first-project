<?php
	require '../library/db.php';
	$check = $_GET['check'];
	 $user =$_SESSION['tentaikhoan'];
	if($check==1){
		 $query = "UPDATE `users` SET ngonngu =1 WHERE username='$user'";
        mysqli_query($link, $query);
		$_SESSION['ngonngu']=1;
	}else{
		 $query = "UPDATE `users` SET ngonngu =0 WHERE username='$user'";
        mysqli_query($link, $query);
		$_SESSION['ngonngu']=0;
	}
	echo "thanh cong";
?>