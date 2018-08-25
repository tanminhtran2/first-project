<?php 
	require '../library/db.php';
	$tenthietbi=$_POST['tenthietbi'];
 
        //vn
        $txt_capnhatnhietdoduoi= $array_vn[170];
        $txt_capnhatnhietdotren= $array_vn[171];
        $txt_capnhatdoamduoi= $array_vn[172];
        $txt_capnhatdoamtren= $array_vn[173];
        //en
        $txt_capnhatnhietdoduoi_en= $array_en[170];
        $txt_capnhatnhietdotren_en= $array_en[171];
        $txt_capnhatdoamduoi_en= $array_en[172];
        $txt_capnhatdoamtren_en= $array_en[173];

	$user = $_SESSION['tentaikhoan'];
	$query = "SELECT * FROM `seri_thietbi` where tenthietbi='$tenthietbi'";//chon du lieu tu database
        $result=mysqli_query($link,$query) or die(mysqli_error($link));
        while($row= mysqli_fetch_assoc($result)){  //lay du lieu tu bang
          $nhietdo_duoi=$row['nhietdo_duoi'];
          $nhietdo_tren=$row['nhietdo_tren'];
          $doam_duoi=$row['doam_duoi'];
          $doam_tren=$row['doam_tren'];
        }
        
       if(!empty($_POST['nhietdo_duoi']) ){
           $nhietdo_duoi_post=  $_POST['nhietdo_duoi'];
            //preg_match_all('!\d+!', $nhietdo_duoi_post1, $nhietdo_duoi_post);
            if($nhietdo_duoi_post>$nhietdo_duoi){
              mysqli_query($link, "INSERT INTO log(user, thongbao,tenthietbi,date_time) VALUES ('$user', '$txt_capnhatnhietdoduoi $nhietdo_duoi lên $nhietdo_duoi_post','$tenthietbi',now())");
              mysqli_query($link, "INSERT INTO log_en(user, thongbao,tenthietbi,date_time) VALUES ('$user', '$txt_capnhatnhietdoduoi_en $nhietdo_duoi to $nhietdo_duoi_post','$tenthietbi',now())");
           }else if($nhietdo_duoi_post<$nhietdo_duoi){
              mysqli_query($link, "INSERT INTO log(user, thongbao,tenthietbi,date_time) VALUES ('$user', '$txt_capnhatnhietdoduoi $nhietdo_duoi xuống $nhietdo_duoi_post','$tenthietbi',now())");
              mysqli_query($link, "INSERT INTO log_en(user, thongbao,tenthietbi,date_time) VALUES ('$user', '$txt_capnhatnhietdoduoi_en $nhietdo_duoi to $nhietdo_duoi_post','$tenthietbi',now())");
           }
           
        }else{
           $nhietdo_duoi_post=$nhietdo_duoi;
        }
        if(!empty($_POST['nhietdo_tren'])){
           $nhietdo_tren_post=  $_POST['nhietdo_tren'];
           if($nhietdo_tren_post>$nhietdo_tren){
              mysqli_query($link, "INSERT INTO log(user, thongbao,tenthietbi,date_time) VALUES ('$user', '$txt_capnhatnhietdotren $nhietdo_tren lên $nhietdo_tren_post','$tenthietbi',now())");
              mysqli_query($link, "INSERT INTO log_en(user, thongbao,tenthietbi,date_time) VALUES ('$user', '$txt_capnhatnhietdotren_en $nhietdo_tren to $nhietdo_tren_post','$tenthietbi',now())");
           }else if($nhietdo_tren_post<$nhietdo_tren){
              mysqli_query($link, "INSERT INTO log(user, thongbao,tenthietbi,date_time) VALUES ('$user', '$txt_capnhatnhietdotren $nhietdo_tren xuống $nhietdo_tren_post','$tenthietbi',now())");
              mysqli_query($link, "INSERT INTO log_en(user, thongbao,tenthietbi,date_time) VALUES ('$user', '$txt_capnhatnhietdotren_en $nhietdo_tren to $nhietdo_tren_post','$tenthietbi',now())");

           }
        }else{
          $nhietdo_tren_post=$nhietdo_tren;
        }
        if(!empty($_POST['doam_duoi'])){
           $doam_duoi_post=  $_POST['doam_duoi'];
           if($doam_duoi_post>$doam_duoi){
              mysqli_query($link, "INSERT INTO log(user, thongbao,tenthietbi,date_time) VALUES ('$user', '$txt_capnhatdoamduoi $doam_duoi lên $doam_duoi_post','$tenthietbi',now())");
              mysqli_query($link, "INSERT INTO log_en(user, thongbao,tenthietbi,date_time) VALUES ('$user', '$txt_capnhatdoamduoi_en $doam_duoi to $doam_duoi_post','$tenthietbi',now())");
           }else if($doam_duoi_post<$doam_duoi){
              mysqli_query($link, "INSERT INTO log(user, thongbao,tenthietbi,date_time) VALUES ('$user', '$txt_capnhatdoamduoi $doam_duoi xuống $doam_duoi_post','$tenthietbi',now())");
              mysqli_query($link, "INSERT INTO log_en(user, thongbao,tenthietbi,date_time) VALUES ('$user', '$txt_capnhatdoamduoi_en $doam_duoi to $doam_duoi_post','$tenthietbi',now())");
           }
        }else{
          $doam_duoi_post=$doam_duoi;
        }
        if(!empty($_POST['doam_tren'])){
           $doam_tren_post=  $_POST['doam_tren'];
           if($doam_tren_post>$doam_tren){
              mysqli_query($link, "INSERT INTO log(user, thongbao,tenthietbi,date_time) VALUES ('$user', '$txt_capnhatdoamtren $doam_tren lên $doam_tren_post','$tenthietbi',now())");
              mysqli_query($link, "INSERT INTO log_en(user, thongbao,tenthietbi,date_time) VALUES ('$user', '$txt_capnhatdoamtren_en $doam_tren to $doam_tren_post','$tenthietbi',now())");
           }else if($doam_tren_post<$doam_tren){
              mysqli_query($link, "INSERT INTO log(user, thongbao,tenthietbi,date_time) VALUES ('$user', '$txt_capnhatdoamtren $doam_tren xuống $doam_tren_post','$tenthietbi',now())");
              mysqli_query($link, "INSERT INTO log_en(user, thongbao,tenthietbi,date_time) VALUES ('$user', '$txt_capnhatdoamtren_en $doam_tren to $doam_tren_post','$tenthietbi',now())");
           }
        }else{
          $doam_tren_post= $doam_tren;
        }
      
        $query = "UPDATE `seri_thietbi` SET nhietdo_duoi = '$nhietdo_duoi_post', nhietdo_tren = '$nhietdo_tren_post',doam_duoi = '$doam_duoi_post', doam_tren = '$doam_tren_post' WHERE tenthietbi='$tenthietbi'";
        mysqli_query($link, $query);
      echo "thanh cong";
?>