<?php
	require '../library/db.php';
	$data = json_decode(stripslashes($_POST['data']));
	 $json = array();
	 
	 	foreach($data as $d){
	     	$query = "SELECT * FROM `hoatdong_thietbi` WHERE tenthietbi='$d'";
		  	$result = mysqli_query($link, $query);
		  	while($row= mysqli_fetch_array($result)){
		  		$json[] = array('check' => $row['hoatdong'] );
		  	}
  		}
		
	die (json_encode($json));
?>