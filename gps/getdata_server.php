<?php 
	require 'library/db.php';
	$query = "SELECT * FROM `users` Where id = 1";
	$result = mysqli_query($link, $query);
	while($row= mysqli_fetch_assoc($result)){
	  $code=$row['code'];
	  $flag_code_tinnhan=$row['flag_code_tinnhan'];
	  $sodienthoai= $row['sodt'];
	}
	if($flag_code_tinnhan==1)
	{
		echo $code. " ";
		echo $sodienthoai;
		$result = "UPDATE users SET flag_code_tinnhan=0  WHERE id=1";
    	$mysqli->query($result);
	}
?>