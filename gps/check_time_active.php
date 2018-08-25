<?php 
    require 'library/db.php';
    mysqli_set_charset($link, 'UTF8');
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $result = mysqli_query($link,"SELECT * FROM `users` WHERE id=1" );
    while($row= mysqli_fetch_assoc($result)){
       $time_active=$row['time_active'];
       // $time_check=$row['time_check'];
    }
     $result = mysqli_query($link,"SELECT * FROM seri_thietbi  " );
        if(mysqli_num_rows($result) > 0){
            while($row= mysqli_fetch_assoc($result)){
                $datetime_theodoi=date('d-m-Y H:i:s', strtotime($row['date_time_theodoi']));//lay du lieu moi nhat
                $datetime_add=date('d-m-Y H:i:s', strtotime('+'.$time_active.' minutes',strtotime($datetime_theodoi)));
                $date = new DateTime('now');
                $date_now=date_format($date,'d-m-Y H:i:s');
                $id =$row['id'];
                $theodoi=$row['theodoi'];
                $flag_theodoi= $row['flag_theodoi'];
                if($date_now<=$datetime_add){

                }else if($date_now>$datetime_add && $flag_theodoi==1){  
                    if($theodoi==0){
                        $result2 = "UPDATE seri_thietbi  SET theodoi=1  WHERE id='$id'";

                    }
                    $mysqli->query($result2);
                }       
            }
        }
?>