<?php
	require '../library/db.php';
      $json = array();
      $lang=$_SESSION['ngonngu'];
 
      $json[] = array('lang' => $lang );
      die (json_encode($json));
?>