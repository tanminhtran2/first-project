<?php 
	require '../library/db.php';
	$id=$_POST['id'];
	$query = "SELECT * FROM `seri_thietbi`  WHERE id = $id";
	$result = mysqli_query($link, $query);
	if($result){
   		while($row= mysqli_fetch_assoc($result)){
   			$theodoi=$row['theodoi'];        //lay du lieu theo doi htai
            $flag_theodoi= $row['flag_theodoi'];
            $tenthietbi=$row['tenthietbi'];
   			if($flag_theodoi==1)
   				mysqli_query($link, "UPDATE `seri_thietbi`  SET theodoi = 0,flag_theodoi=0  WHERE id=$id");// cap nhat lai du lieu theo doi
   			else
   				mysqli_query($link, "UPDATE `seri_thietbi`  SET flag_theodoi = 1,date_time_theodoi = now()  WHERE id=$id");
   		}
   }

   $user = $_SESSION['tentaikhoan'];
   if($theodoi==1){
      $thongbao = 'Tắt theo dõi ' ;
      $thongbao_en = 'Turn off tracking' ;
   }else{
      $thongbao = 'Bật theo dõi ' ;
      $thongbao_en = 'Turn on tracking' ;
   }
   mysqli_query($link, "INSERT INTO log(user, thongbao,tenthietbi,date_time) VALUES ('$user', '$thongbao','$tenthietbi',now())");
   mysqli_query($link, "INSERT INTO log_en(user, thongbao,tenthietbi,date_time) VALUES ('$user', '$thongbao_en','$tenthietbi',now())");
?>