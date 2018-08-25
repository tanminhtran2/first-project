<?php
	require '../library/db.php';
	require '../library/function.php';
	getlang();
      $json = array();
    if($_SESSION['ngonngu']==0){
      $xoaodachon= $array_vn[183];
      $xacnhan_xoaodachon= $array_vn[184];
      $vuilongchonitnhatmoto=$array_vn[185];
   
 	}else{
 		 $xoaodachon= $array_en[183];
      $xacnhan_xoaodachon= $array_en[184];
      $vuilongchonitnhatmoto=$array_en[185];
    
 	}
      $json[] = array('xoaodachon' => $xoaodachon ,'xacnhan_xoaodachon' => $xacnhan_xoaodachon,'vuilongchonitnhatmoto' => $vuilongchonitnhatmoto);
      die (json_encode($json));
?>