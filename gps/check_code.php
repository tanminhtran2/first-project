<?php 
    require 'library/db.php';
    mysqli_set_charset($link, 'UTF8');
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $result = mysqli_query($link,"SELECT * FROM `users` WHERE id=1" );
    while($row= mysqli_fetch_assoc($result)){
       $timeout_confirm=$row['timeout_confirm'];//hieu luc ma xac nhan
       // $time_check=$row['time_check'];
    }
     $result = mysqli_query($link,"SELECT * FROM users  " );
        if(mysqli_num_rows($result) > 0){
            while($row= mysqli_fetch_assoc($result)){
                $datetime=date('d-m-Y H:i:s', strtotime($row['date_time']));//lay du lieu moi nhat
                $datetime_add=date('d-m-Y H:i:s', strtotime('+'.$timeout_confirm.' minutes',strtotime($datetime)));
                $date = new DateTime('now');
                $date_now=date_format($date,'d-m-Y H:i:s');
                $id =$row['id'];
                if($date_now<=$datetime_add){

                }else if($date_now>$datetime_add){  
                    
                    $result2 = "UPDATE users  SET flag_code=0  WHERE id='$id'";
                    $mysqli->query($result2);

                }       
            }
        }
    

    
?>