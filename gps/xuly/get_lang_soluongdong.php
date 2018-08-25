<?php
	require '../library/db.php';
	require '../library/function.php';
	getlang();
      $json = array();
    if(  $_SESSION['ngonngu']==0){
      $chuanhapgiatri= $array_vn[181];
      $error_nhohonko= $array_vn[182];
     
 	}else{
 		 $chuanhapgiatri= $array_en[181];
      $error_nhohonko= $array_en[182];
      
 	}
      $json[] = array('error_nhohonko' => $error_nhohonko ,'chuanhapgiatri' => $chuanhapgiatri);
      die (json_encode($json));
?>