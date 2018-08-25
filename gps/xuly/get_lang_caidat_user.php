<?php
	require '../library/db.php';
	require '../library/function.php';
	getlang();
      $json = array();
  if($_SESSION['ngonngu']==0){
    $chuathaydoigiatri= $array_vn[190];
    $xacnhan_timedangxuat = $array_vn[191];
    $error_timedangxuat = $array_vn[192];
    $xacnhan_timeactive = $array_vn[193];
    $error_timeactive = $array_vn[194];
    $at_least_one = $array_vn[195];
 	}else{
 		 $chuathaydoigiatri= $array_en[190];
    $xacnhan_timedangxuat = $array_en[191];
    $error_timedangxuat = $array_en[192];
    $xacnhan_timeactive = $array_en[193];
    $error_timeactive = $array_en[194];
    $at_least_one = $array_en[195];
 	}
  $json[] = array('chuathaydoigiatri' => $chuathaydoigiatri,'xacnhan_timedangxuat' => $xacnhan_timedangxuat ,'error_timedangxuat' => $error_timedangxuat, 'xacnhan_timeactive' => $xacnhan_timeactive ,'error_timeactive' => $error_timeactive ,'at_least_one' => $at_least_one);
  die (json_encode($json));
?>