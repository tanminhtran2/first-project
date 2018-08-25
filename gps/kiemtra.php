<?php 
    require 'library/db.php';
    mysqli_set_charset($link, 'UTF8');
    date_default_timezone_set('Asia/Ho_Chi_Minh');
   
    
    $i=0;
    $dem=0;
    $result = mysqli_query($link,"SELECT * FROM `users` WHERE id=1" );
    while($row= mysqli_fetch_assoc($result)){
       // $timeout_confirm=$row['timeout_confirm'];
        $time_check=$row['time_check'];//lay thoi gian kiem tra hoat dong tbi
    }



    //chon dc tat ca cac bang lay du lieu moi nhat so sanh thoi gian, bao loi, cap nhat so loi của user va admin
    $result = mysqli_query($link,"SELECT * FROM `seri_thietbi`" );
    while($row= mysqli_fetch_assoc($result)){
        $thietbi = $row['thietbi'];         //lay ten bang
        $tenthietbi=$row['tenthietbi'];     //lay ten thiet bi
        $theodoi=$row['theodoi'];

        $result2 = mysqli_query($link,"SELECT * FROM $thietbi ORDER BY ID DESC LIMIT 1" );
        if(mysqli_num_rows($result2) > 0){
            while($row2= mysqli_fetch_assoc($result2)){
                $datetime=date('Y-m-d H:i:s', strtotime($row2['date_time']));//lay du lieu moi nhat
                $datetime_add=date('Y-m-d H:i:s', strtotime('+'.$time_check.' minutes',strtotime($datetime)));//lay 
                $date = new DateTime('now');//lay du lieu hien tai
                $date_now=date_format($date,'Y-m-d H:i:s');
                if(strcmp($date_now,$datetime_add)>0){ 
                    mysqli_query($link, "UPDATE hoatdong_thietbi  SET hoatdong = 0  WHERE tenthietbi='$tenthietbi'");
                }
            }
        }

        if($theodoi==1){    //co theo doi thiet bi
            $result2 = mysqli_query($link,"SELECT * FROM $thietbi ORDER BY ID DESC LIMIT 1" );
            if(mysqli_num_rows($result2) > 0){
                while($row2= mysqli_fetch_assoc($result2)){
                    $datetime=date('Y-m-d H:i:s', strtotime($row2['date_time']));//lay du lieu moi nhat
                    $datetime_add=date('Y-m-d H:i:s', strtotime('+'.$time_check.' minutes',strtotime($datetime)));//lay dulieu moi nhat +2
                    $date = new DateTime('now');//lay du lieu hien tai
                    $date_now=date_format($date,'Y-m-d H:i:s');
                    //if($date_now<=$datetime_add){   // true tb co hdong
                    if(strcmp($date_now,$datetime_add)<=0){  //so sanh t hien tai voi t du lieu moi nhat +2
                        mysqli_query($link,"UPDATE `seri_thietbi`  SET theodoi_ndda = 1 WHERE thietbi='$thietbi'");//bat theo doi ndda vi tbi co hdong
                    }else{// xuat loi tb khong hdong
                        mysqli_query($link,"INSERT INTO `thongbao`(thongbao,tenthietbi,date_time) values('Thiết bị $tenthietbi không hoạt động','$tenthietbi',now()) " );
                        mysqli_query($link,"INSERT INTO `thongbao_en`(thongbao,tenthietbi,date_time) values('Device $tenthietbi inactive','$tenthietbi',now()) " );
                        $dem++;
                        mysqli_query($link,"UPDATE `seri_thietbi`  SET theodoi_ndda = 0 WHERE thietbi='$thietbi'");
                         
                        $mesg= "Thiết bị $tenthietbi không hoạt động";
                        $request_url = 'http://api.telegram.org/bot'. $token .'/sendMessage?chat_id='.$user_id.'&text='.$mesg;
                        file_get_contents($request_url);
                    }
                }
            }
        }else{  //khong theo doi ndda  vi khong theo doi thiet bi
            mysqli_query($link,"UPDATE `seri_thietbi`  SET theodoi_ndda = 0 WHERE thietbi='$thietbi'");
        }
    }
/*
    $result = mysqli_query($link,"SELECT * FROM `seri_thietbi`" );
    while($row= mysqli_fetch_assoc($result)){
        $tenthietbi=$row['tenthietbi'];
        $t_moinhat=$row['nhietdo_moinhat'];
        $h_moinhat=$row['doam_moinhat'];
        $t_duoi=$row['nhietdo_duoi']; 
        $t_tren=$row['nhietdo_tren'];
        $h_duoi=$row['doam_duoi'];
        $h_tren=$row['doam_tren'];
        $theodoi_ndda=$row['theodoi_ndda'];
        if($theodoi_ndda==1){
            if($h_duoi>$h_moinhat){
                mysqli_query($link,"INSERT INTO `thongbao`(thongbao,tenthietbi,date_time) values('Độ ẩm $h_moinhat thấp hơn ngưỡng cài đặt $h_duoi','$tenthietbi',now()) " );
                $dem++;
                $mesg= "$tenthietbi: độ ẩm $h_moinhat thấp hơn ngưỡng cài đặt $h_duoi";
                $request_url = 'http://api.telegram.org/bot'. $token .'/sendMessage?chat_id='.$user_id.'&text='.$mesg;
                file_get_contents($request_url);
            }elseif($h_tren<$h_moinhat){
                mysqli_query($link,"INSERT INTO `thongbao`(thongbao,tenthietbi,date_time) values('Độ ẩm $h_moinhat cao hơn ngưỡng cài đặt $h_tren','$tenthietbi',now()) " );
                $dem++;
                $mesg= "$tenthietbi: độ ẩm $h_moinhat cao hơn ngưỡng cài đặt $h_tren";
                $request_url = 'http://api.telegram.org/bot'. $token .'/sendMessage?chat_id='.$user_id.'&text='.$mesg;
                file_get_contents($request_url);
            }
            if($t_duoi>$t_moinhat){
                mysqli_query($link,"INSERT INTO `thongbao`(thongbao,tenthietbi,date_time) values('Nhiệt độ $t_moinhat thấp hơn ngưỡng cài đặt $t_duoi','$tenthietbi',now()) " );
                $dem++;
                $mesg= "$tenthietbi: nhiệt độ $t_moinhat thấp hơn ngưỡng cài đặt $t_duoi";
                $request_url = 'http://api.telegram.org/bot'. $token .'/sendMessage?chat_id='.$user_id.'&text='.$mesg;
                file_get_contents($request_url);
            }elseif($t_tren<$t_moinhat){
                mysqli_query($link,"INSERT INTO `thongbao`(thongbao,tenthietbi,date_time) values('Nhiệt độ $t_moinhat cao hơn ngưỡng cài đặt $t_tren','$tenthietbi',now()) " );
                $dem++;
                $mesg= "$tenthietbi: nhiệt độ $t_moinhat cao hơn ngưỡng cài đặt $t_tren";
                $request_url = 'http://api.telegram.org/bot'. $token .'/sendMessage?chat_id='.$user_id.'&text='.$mesg;
                file_get_contents($request_url);
            }
        }

    }
*/    
    
    if($dem>0){
        //cap nhat thong bao cua admin
        $result = mysqli_query($link,"SELECT * FROM `users` WHERE mode = 1" );
        while($row= mysqli_fetch_assoc($result)){
            $username=$row['username'];

            $result2 = mysqli_query($link,"SELECT * FROM `soluong_thongbao` WHERE user = '$username'" );
            while($row2= mysqli_fetch_assoc($result2)){
                $soluong_thongbao=$row2['soluong_thongbao'];
            }
            $soluong_thongbao=$soluong_thongbao+$dem;
            mysqli_query($link, "UPDATE soluong_thongbao  SET soluong_thongbao = $soluong_thongbao  WHERE user='$username'");
        }
            

        //cap nhat thong bao cua user
        $result = mysqli_query($link,"SELECT * FROM `thongbao` ORDER BY ID DESC  LIMIT $dem" );//loc những thong bao moi I 
        while($row= mysqli_fetch_assoc($result)){
            $tenthietbi=$row['tenthietbi'];
            $result2 = mysqli_query($link,"SELECT user FROM `user_thietbi` WHERE tenthietbi='$tenthietbi'" );
            while($row2= mysqli_fetch_array($result2)){
                $user=$row2['user']; //tim ten user dang quan lý thiet bi co loi
                mysqli_query($link, "UPDATE soluong_thongbao  SET soluong_thongbao = soluong_thongbao+1 WHERE user='$user'");
            }
            
        }  
    }
?>