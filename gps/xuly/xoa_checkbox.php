<?php
	require '../library/db.php';
	
	if(isset($_POST["id"]))
	{
	 foreach($_POST["id"] as $id)
	 {
	  $query = "DELETE FROM thongbao WHERE id = '".$id."'";
	  mysqli_query($link, $query);
	  $query = "DELETE FROM thongbao_en WHERE id = '".$id."'";
	  mysqli_query($link, $query);
	 }
	}
?>