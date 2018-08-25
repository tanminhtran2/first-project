<?php
	require '../library/db.php';
	require '../library/function.php';
	getlang();
      $json = array();
  if($_SESSION['ngonngu']==0){
      $chuathaydoigiatri= $array_vn[186];
      $time_kiemtra= $array_vn[187];
      $time_active= $array_vn[188];
      $txt_trangthai= $array_vn[189];
 	}else{
      $chuathaydoigiatri= $array_en[186];
      $time_kiemtra= $array_en[187];
      $time_active= $array_en[188];
 	    $txt_trangthai= $array_en[189];
 	}
  $json[] = array('chuathaydoigiatri' => $chuathaydoigiatri ,'time_kiemtra' => $time_kiemtra  ,'time_active' => $time_active, 'txt_trangthai' => $txt_trangthai );
  die (json_encode($json));
?>