<?php
    require 'library/db.php';
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $ND = $_GET['nd'];
    $DA = $_GET['da'];
    $seri = $_GET['seri'];
    $vido =$_GET['vido'];
    $kinhdo =$_GET['kinhdo'];
    $dem=0;
 
        //vn
        $txt_nondda= $array_vn[164];
        $txt_nogps= $array_vn[165];
        $txt_dahientai= $array_vn[166];
        $txt_ndhientai= $array_vn[168];
        $txt_thaphon= $array_vn[167];
        $txt_caohon= $array_vn[169];
        //en
        $txt_nondda_en= $array_en[164];
        $txt_nogps_en= $array_en[165];
        $txt_dahientai_en= $array_en[166];
        $txt_ndhientai_en= $array_en[168];
        $txt_thaphon_en= $array_en[167];
        $txt_caohon_en= $array_en[169];
 

    $query="SELECT * FROM `seri_thietbi` WHERE seri = '$seri';";
    $result=mysqli_query($link,$query) or die(mysqli_error($link));
    while($row=mysqli_fetch_array($result))
    {
        $theodoi=$row['theodoi'];
        $thietbi = $row['thietbi'];         
        $tenthietbi = $row['tenthietbi'];  
        $nhietdo_tren = $row['nhietdo_tren'];
        $nhietdo_duoi = $row['nhietdo_duoi'];
        $doam_tren = $row['doam_tren'];
        $doam_duoi = $row['doam_duoi'];
    } 
    
   
    $query = "INSERT INTO $thietbi(nhietdo,doam,vido,kinhdo,nhietdo_duoi,nhietdo_tren,doam_duoi,doam_tren,date_time) VALUES('$ND','$DA',$vido,$kinhdo,$nhietdo_duoi,$nhietdo_tren,$doam_duoi,$doam_tren,now())";
    mysqli_query($link, $query);
    //echo "cap nhat thanh cong";
    mysqli_query($link, "UPDATE hoatdong_thietbi  SET hoatdong = 1  WHERE tenthietbi='$tenthietbi'");
    if(isset($seri) && $theodoi==1){
        //nhiet do eror
        if($ND>100){
            $dem++;
            $query = "INSERT INTO thongbao(thongbao,tenthietbi, date_time) VALUES('$txt_nondda','$tenthietbi', now())";
            mysqli_query($link, $query);
            $query = "INSERT INTO thongbao_en(thongbao,tenthietbi, date_time) VALUES('$txt_nondda_en, humidity data','$tenthietbi', now())";
            mysqli_query($link, $query);
            //telegram
            $mesg= "$tenthietbi: $txt_nondda";
            $request_url = 'http://api.telegram.org/bot'. $token .'/sendMessage?chat_id='.$user_id.'&text='.$mesg;
            file_get_contents($request_url);
        }else{
            $query = "UPDATE `seri_thietbi` SET nhietdo_moinhat = '$ND', doam_moinhat = '$DA', date_time=now() WHERE thietbi = '$thietbi'";
            mysqli_query($link, $query);
        }

        //error gps
        if($vido==0){
            $dem++;
            $query = "INSERT INTO thongbao(thongbao,tenthietbi, date_time) VALUES('$txt_nogps','$tenthietbi', now())";
            mysqli_query($link, $query);
            $query = "INSERT INTO thongbao_en(thongbao,tenthietbi, date_time) VALUES('$txt_nogps_en','$tenthietbi', now())";
            mysqli_query($link, $query);
            $mesg= "$tenthietbi: $txt_nogps";
            $request_url = 'http://api.telegram.org/bot'. $token .'/sendMessage?chat_id='.$user_id.'&text='.$mesg;
            file_get_contents($request_url);
        }
        
        //loi vuot nguong cai dat nhiet do do am
        $result = mysqli_query($link,"SELECT * FROM `seri_thietbi` WHERE seri = '$seri'" );
        while($row= mysqli_fetch_assoc($result)){
            $tenthietbi=$row['tenthietbi'];
            $t_moinhat=$row['nhietdo_moinhat'];
            $h_moinhat=$row['doam_moinhat'];
            $t_duoi=$row['nhietdo_duoi']; 
            $t_tren=$row['nhietdo_tren'];
            $h_duoi=$row['doam_duoi'];
            $h_tren=$row['doam_tren'];
           //$theodoi_ndda=$row['theodoi_ndda'];
           // if($theodoi_ndda==1){
                if($h_duoi>$h_moinhat){
                    $ketqua=round($h_duoi-$h_moinhat, 2);
                    mysqli_query($link,"INSERT INTO `thongbao`(thongbao,tenthietbi,date_time) values('$txt_dahientai $h_moinhat $txt_thaphon $ketqua%','$tenthietbi',now()) " );
                    mysqli_query($link,"INSERT INTO `thongbao_en`(thongbao,tenthietbi,date_time) values('$txt_dahientai_en $h_moinhat $txt_thaphon_en $ketqua%','$tenthietbi',now()) " );
                    $dem++;
                    $mesg= "$tenthietbi: độ ẩm hiện tại là $h_moinhat thấp hơn ngưỡng cài đặt $ketqua%";
                    $request_url = 'http://api.telegram.org/bot'. $token .'/sendMessage?chat_id='.$user_id.'&text='.$mesg;
                    file_get_contents($request_url);
                }elseif($h_tren<$h_moinhat){
                    $ketqua=round($h_moinhat-$h_tren,2);
                    mysqli_query($link,"INSERT INTO `thongbao`(thongbao,tenthietbi,date_time) values('$txt_dahientai $h_moinhat $txt_caohon $ketqua%','$tenthietbi',now()) " );
                    mysqli_query($link,"INSERT INTO `thongbao_en`(thongbao,tenthietbi,date_time) values('$txt_dahientai_en $h_moinhat $txt_caohon_en $ketqua%','$tenthietbi',now()) " );
                    $dem++;
                    $mesg= "$tenthietbi: độ ẩm hiện tại là $h_moinhat cao hơn ngưỡng cài đặt $ketqua%";
                    $request_url = 'http://api.telegram.org/bot'. $token .'/sendMessage?chat_id='.$user_id.'&text='.$mesg;
                    file_get_contents($request_url);
                }
                if($t_duoi>$t_moinhat){
                    $ketqua=round($t_duoi-$t_moinhat,2);
                    mysqli_query($link,"INSERT INTO `thongbao`(thongbao,tenthietbi,date_time) values('$txt_ndhientai $t_moinhat $txt_thaphon $ketqua độ' ,'$tenthietbi',now()) " );
                     mysqli_query($link,"INSERT INTO `thongbao_en`(thongbao,tenthietbi,date_time) values('$txt_ndhientai_en $t_moinhat $txt_thaphon_en $ketqua degrees' ,'$tenthietbi',now()) " );
                    $dem++;
                    $mesg= "$tenthietbi: nhiệt độ hiện tại là $t_moinhat thấp hơn ngưỡng cài đặt $ketqua độ";
                    $request_url = 'http://api.telegram.org/bot'. $token .'/sendMessage?chat_id='.$user_id.'&text='.$mesg;
                    file_get_contents($request_url);
                }elseif($t_tren<$t_moinhat){
                    $ketqua=round($t_moinhat-$t_tren,2);
                    mysqli_query($link,"INSERT INTO `thongbao`(thongbao,tenthietbi,date_time) values('$txt_ndhientai $t_moinhat $txt_caohon $ketqua độ','$tenthietbi',now()) " );
                    mysqli_query($link,"INSERT INTO `thongbao_en`(thongbao,tenthietbi,date_time) values('$txt_ndhientai_en $t_moinhat $txt_caohon_en $ketqua degrees','$tenthietbi',now()) " );
                    $dem++;
                    $mesg= "$tenthietbi: nhiệt độ hiện tại là $t_moinhat cao hơn ngưỡng cài đặt $ketqua độ";
                    $request_url = 'http://api.telegram.org/bot'. $token .'/sendMessage?chat_id='.$user_id.'&text='.$mesg;
                    file_get_contents($request_url);
                }
            //}

        }

        if($dem>0){
            //cap nhat thong bao admin
         $result = mysqli_query($link,"SELECT * FROM `users` WHERE mode =1" );//loc cac user admin
            while($row= mysqli_fetch_assoc($result)){
                $user=$row['username'];
                $result2 = mysqli_query($link,"SELECT * FROM `soluong_thongbao` WHERE user = '$user'" );
                while($row2= mysqli_fetch_assoc($result2)){
                    $soluong_thongbao=$row2['soluong_thongbao'];
                }
                $soluong_thongbao=$soluong_thongbao+$dem;
                mysqli_query($link, "UPDATE soluong_thongbao  SET soluong_thongbao = $soluong_thongbao  WHERE user='$user'");
            }   

            
            
            //cap nhat thong bao user
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
        

    }

?>
