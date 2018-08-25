<?php
	  require '../library/db.php';
 
	  $json = array( );
	  	if($_SESSION['admin']==1 || $_SESSION['mode_user']==1){  
           $query = "SELECT * FROM `seri_thietbi` ORDER BY thietbi DESC";
           $result = mysqli_query($link, $query);
           while($row= mysqli_fetch_array($result)){
            $thietbi =$row['thietbi'];//
            $result2 = mysqli_query($link, "SELECT * FROM `$thietbi` ORDER BY id DESC;");
            while($row2= mysqli_fetch_assoc($result2)){
              $vido=$row2['vido'];
              $kinhdo=$row2['kinhdo'];
              if($vido==0 )
                continue;
              $json[] =array('tenthietbi'=> $row['tenthietbi']); 
              break;
            }
          }
        }else{
            $user=$_SESSION['tentaikhoan'];
            $result = mysqli_query($link, "SELECT * FROM `user_thietbi` WHERE user = '$user' ORDER BY thietbi DESC");
            while($row= mysqli_fetch_array($result)){
              $thietbi = $row['thietbi'];
              $tenthietbi = $row['tenthietbi'];
              $result2 = mysqli_query($link, "SELECT * FROM `$thietbi` ORDER BY id DESC ");
              while($row2= mysqli_fetch_assoc($result2)){
                $nhietdo=$row2['nhietdo'];
                $doam=$row2['doam'];
                $vido=$row2['vido'];
                if($vido==0)
                  continue;
                if($nhietdo !=null ||  $doam != null){
                  $json[] = array('tenthietbi'=> $row['tenthietbi']); 
                  break;
                }
              }
            }
        }

	  die (json_encode($json));
?>