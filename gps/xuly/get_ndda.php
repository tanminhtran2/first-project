<?php
    //  $i = $_POST['number'];
   //   $thietbi = "Thietbi"."$i";
  require '../library/db.php';
  $user=$_SESSION['tentaikhoan'];
      $json = array();
          if($_SESSION['admin']==1 || $_SESSION['mode_user']==1){  
            $result = mysqli_query($link, "SELECT * FROM `seri_thietbi` ORDER BY thietbi DESC");
            while($row= mysqli_fetch_array($result)){
              $thietbi = $row['thietbi'];
              $tenthietbi = $row['tenthietbi'];
              $result3 = mysqli_query($link, "SELECT * FROM `seri_thietbi` where thietbi='$thietbi '");
              while($row3= mysqli_fetch_assoc($result3)){
                $theodoi=$row3['flag_theodoi'];
              }
              $result4 = mysqli_query($link, "SELECT * FROM `users` where username='$user'");
              while($row4= mysqli_fetch_assoc($result4)){
                $lang=$row4['ngonngu'];
              }
              $result2 = mysqli_query($link, "SELECT * FROM `$thietbi` ORDER BY id DESC ");
              while($row2= mysqli_fetch_assoc($result2)){
                $nhietdo=$row2['nhietdo'];
                $doam=$row2['doam'];
                $nhietdo =number_format($nhietdo,2);
                $doam =number_format($doam,2);
                $vido=$row2['vido'];
                $gio=date('H:i:s', strtotime($row2['date_time']));  
                $ngay=date('d-m-Y', strtotime($row2['date_time']));
                if($vido==0)
                  continue;
                if($nhietdo !=null ||  $doam != null){
                  $json[] = array('nhietdo' => $nhietdo,  'doam' =>$doam, 'tenthietbi'=> $row['tenthietbi'],  'gio' =>$gio,  'ngay' =>$ngay, 'theodoi' => $theodoi, 'lang' => $lang ); 
                  break;
                }
              }
            }
          }else{
           
            $result = mysqli_query($link, "SELECT * FROM `user_thietbi` WHERE user = '$user' ORDER BY thietbi DESC");
            while($row= mysqli_fetch_array($result)){
              $thietbi = $row['thietbi'];
              $tenthietbi = $row['tenthietbi'];
              $result3 = mysqli_query($link, "SELECT * FROM `seri_thietbi` where thietbi='$thietbi '");
              while($row3= mysqli_fetch_assoc($result3)){
                $theodoi=$row3['theodoi'];
              }
              $result4 = mysqli_query($link, "SELECT * FROM `users` where username='$user'");
              while($row4= mysqli_fetch_assoc($result4)){
                $lang=$row4['ngonngu'];
              }
              $result2 = mysqli_query($link, "SELECT * FROM `$thietbi` ORDER BY id DESC ");
              while($row2= mysqli_fetch_assoc($result2)){
                $nhietdo=$row2['nhietdo'];
                $doam=$row2['doam'];
                $nhietdo =number_format($nhietdo,2);
                $doam =number_format($doam,2);
                $vido=$row2['vido'];

                $gio=date('H:i:s', strtotime($row2['date_time']));  
                $ngay=date('d-m-Y', strtotime($row2['date_time']));
                if($vido==0)
                  continue;
                if($nhietdo !=null ||  $doam != null){
                  $json[] = array('nhietdo' => $nhietdo,  'doam' =>$doam, 'tenthietbi'=> $row['tenthietbi'],  'gio' =>$gio,  'ngay' =>$ngay,'theodoi' => $theodoi, 'lang' => $lang); 
                  break;
                }
              }
            }
          }

      die (json_encode($json));
      //echo ",";

?>
