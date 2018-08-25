<?php
  require '../library/db.php';
  require '../library/function.php';
  check_timeout();
  if ( $_SESSION['logged_in'] != 1 ) {
    $_SESSION['message'] =  "Bạn cần phải đăng nhập!";
    header("location: ../login/error.php");    
  }
  
   getlang();
   if(  $_SESSION['ngonngu']==0){

      $txt_trangchu=$array_vn[146];
      $txt_lichsu=$array_vn[147];
      $txt_quanlythietbi=$array_vn[148];
      $txt_caidatthietbi=$array_vn[149];
      $txt_themthietbi=$array_vn[150];
      $txt_taothietbi=$array_vn[151];
      $txt_xoathietbi=$array_vn[152];
      $txt_quanlyuser=$array_vn[153];
      $txt_caidatuser=$array_vn[154];
      $txt_dangkyuser=$array_vn[155];
      $txt_xoauser=$array_vn[156];
      $txt_log=$array_vn[157];
      $txt_caidathethong=$array_vn[158];
      $txt_caidatngonngu=$array_vn[196];
      $txt_caidatemail=$array_vn[197];

      $txt_lienhe=$array_vn[159];
      $txt_chinhsuathongtin=$array_vn[160];
      $txt_dangxuat=$array_vn[161];

    }else{
     
      $txt_trangchu=$array_en[146];
      $txt_lichsu=$array_en[147];
      $txt_quanlythietbi=$array_en[148];
      $txt_caidatthietbi=$array_en[149];
      $txt_themthietbi=$array_en[150];
      $txt_taothietbi=$array_en[151];
      $txt_xoathietbi=$array_en[152];
      $txt_quanlyuser=$array_en[153];
      $txt_caidatuser=$array_en[154];
      $txt_dangkyuser=$array_en[155];
      $txt_xoauser=$array_en[156];
      $txt_log=$array_en[157];
      $txt_caidathethong=$array_en[158];
      $txt_caidatngonngu=$array_en[196];
      $txt_caidatemail=$array_en[197];
      $txt_lienhe=$array_en[159];
      $txt_chinhsuathongtin=$array_en[160];
      $txt_dangxuat=$array_en[161];
    }
  $thietbi=$_SESSION["thietbi"];
  $tenthietbi = $_SESSION["tenthietbi"];
  $datetime=$_GET["datetime"];
  $gio=date('H:i:s', strtotime($datetime));    
  $ngay=date('d-m-Y', strtotime($datetime));
  $vido=0;  
  $kinhdo=0;
  $query = "SELECT * FROM $thietbi";
    $result = mysqli_query($link, $query);
    if(mysqli_num_rows($result) > 0){
          while($row= mysqli_fetch_assoc($result)){
            if($datetime==date('d-m-Y H:i:s', strtotime($row['date_time'])))
            {
              $doam=$row['doam'];
              $nhietdo=$row['nhietdo'];
              $nhietdo =number_format($nhietdo,2);
              $doam =number_format($doam,2);
              $doam=$doam.'%';
              $nhietdo=$nhietdo.'ºC';

              if($nhietdo>100){
                if($_SESSION['ngonngu']==0){
                    $doam="Lỗi";
                    $nhietdo="Lỗi";
                  }else{
                    $doam="Error";
                    $nhietdo="Error";
                    
                  }
              } 
              $vido=$row['vido'];
              $kinhdo=$row['kinhdo'];
            }
          }
    }
?>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Vị trí chi tiết</title>
    <link rel="shortcut icon" href="../icon/icon.ico">
    <script src="../js/jquery.min.js-3.3.1.js"></script>
    <link rel="stylesheet" href="../css/thongtin.css">
 
    <script src="../js/function.js"></script>
    <!--  timeout confirm  -->
    <link rel="stylesheet" type="text/css"  href="../lib_timeout_confirm/css/jquery-confirm.css"/>
    <script type="text/javascript"  src="../lib_timeout_confirm/js/jquery-confirm.js"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="../js/jquery.min.js-3.3.1.js"></script>  <!-- menu click -->
    <link rel="stylesheet" href="../css/bootstrap.min.css-3.3.1.css">  <!-- menu css -->
        
    <script src="../js/jquery.menu-aim.js"></script> <!-- menu aim -->
    <script src="../js/main.js"></script> <!-- Resource jQuery --> 
    <script src="../js/modernizr.js"></script>
   
    <link rel="stylesheet" type="text/css" href="../css/lichsu.css" />
    <link rel="stylesheet" type="text/css" href="../css/style_menu.css" />
    <link rel="stylesheet" type="text/css" href="../css/reset.css" />

    <script src="../js/jquery.confirm.js"></script>
    <script src="../js/function.js"></script>

    <link rel="stylesheet" href="../popup/popup.css" />
     <?php 
        style_menu_map();
    ?>
    <style>
      
      .dropdown-content {
            display: none;
           
      }
      .show {display: block;}
      .ctrlq.fb-button,.ctrlq.fb-close{
          right: 50px !important;
      }

      @media only screen and (max-width: 700px) {
          #dropdown{
            margin-left:  105px !important;
            margin-top:8px !important;
          }
          #notification{
            margin-left: 135px !important;
          }
          .cd-dropdown{
              <?php

                if($_SESSION['admin']==1){    /* administrator */
                  echo "height: 240px !important;";
                }elseif($_SESSION['mode_user']==1)  {
                  echo "height: 210px !important;";
                }else{
                  echo "height: 180px !important;";
                }
 
              ?>
          }
          #child_caidathethong{
            margin-top:150px !important;
          }
      }
    </style>
     
  </head>
  <body>
                  <div id="poptuk" style="z-index:5">
                    <div id="poptuk_content" >
                      <div class="poptuk_body"></div>
                      <span onclick="poptuk_a('close')" class="poptuk_b" style="color:blue;border: 2px solid blue;">Đóng</span> 
                    </div>
                  </div>
    <header id="container"   >
    <div style="<?php 
         if($_SESSION['admin']==1){
          echo "height:500px;";
         }else if($_SESSION['mode_user']==1){
          echo "height:400px;";
         }else{
          echo "height:350px;";
         }
      ?>" class="cd-dropdown-wrapper">
      <a class="cd-dropdown-trigger"   style="width:100px; ">Menu</a>
      <?php 
        if($_SESSION['admin']==1){
          echo "<nav class='cd-dropdown' style='height:400px;'>";
        }elseif($_SESSION['mode_user']==0){
          echo "<nav class='cd-dropdown' style='height:300px;'>";
        }else{
          echo "<nav class='cd-dropdown' style='height:350px;'>";
        }
       ?>
      
        <ul class="cd-dropdown-content">
          <li><a class="menu1" href="../map/thongtin.php"><?php  echo $txt_trangchu; ?></a></li>
         
          <li><a class='menu1' href='../menu/luachon_thietbi.php'><?php echo $txt_lichsu; ?></a></li>

           
          <li class='has-children'>
            <a  class='menu1' ><?php echo $txt_quanlythietbi; ?></a>
            <?php
              echo "<ul id='child_quanlythietbi' class='is-hidden' style='margin-top: 100px;'>";
            ?>
               <li><a class="menu2" href="../menu/caidat.php"><?php  echo $txt_caidatthietbi; ?></a></li>
              <li><a class='menu2' href='../menu/addthietbi.php'><?php echo $txt_themthietbi; ?></a></li>
            <?php
              if($_SESSION['mode_user']==1){
                echo "<li><a class='menu2' href='../menu/taothietbi.php'>";
                 echo $txt_taothietbi;
                echo "</a></li>";
               }
              
            ?>
              <li ><a class="menu2" href='../menu/xoathietbi.php'><?php  echo $txt_xoathietbi; ?></a>
              </li>
            </ul>
          </li>
            
          
          <?php 
            if($_SESSION['admin']==1||$_SESSION['mode_user']==1){
            echo "<li class='has-children'>";
              echo "<a  class='menu1'  >";
                    echo $txt_quanlyuser;
              echo "</a>";  
                echo "<ul id='child_quanlyuser' class='is-hidden' style='margin-top: 150px;'>";
                  echo "<li><a class='menu2' href='../menu/caidat_user.php'>";
                     
                      echo $txt_caidatuser;
                  echo "</a></li>"; 
                echo "<li><a class='menu2' href='../menu/signup.php'>";
                  
                    echo $txt_dangkyuser;
                echo "</a></li>"; 
                echo "<li><a  href='../menu/xoa_user.php' class='menu2' >";
                  
                    echo $txt_xoauser;
                echo "</a>  "; 
                   
                echo "</li>";
              echo "</ul>";
            echo "</li>";
            }
          ?>
          <li><a class="menu1" href="../menu/log.php"><?php  echo $txt_log;?></a></li>
          <?php 
            if($_SESSION['admin']==1) {
               echo "<li class='has-children'>";
                  echo "<a  class='menu1'  >";
                     
                    echo $txt_caidathethong;
                  echo "</a>";  
                    echo "<ul id='child_caidathethong' class='is-hidden' style='margin-top: 250px;'>";

                        echo "<li><a class='menu2' href='../menu/caidat_ngonngu.php'>";
                          echo $txt_caidatngonngu;
                        echo "</a></li>"; 

                      echo "<li><a class='menu2' href='../menu/caidat_email.php'>";
                          echo $txt_caidatemail;
                      echo "</a></li>"; 

                     
                  echo "</ul>";
                echo "</li>";
            }
          ?>
          
          <li><a class="menu1" onclick="lancer()"><?php echo $txt_lienhe; ?></a></li>
          <li><a class="menu1" href="../login/logout.php"><?php echo $txt_dangxuat; ?></a></li>
        </ul> <!-- .cd-dropdown-content -->
      </nav> <!-- .cd-dropdown -->
    </div> <!-- .cd-dropdown-wrapper -->

        <div id="dropdown" style="position: fixed;margin-left:  115px; float: left; margin-top:2px;" >
            <p style="width: 30px ;"><img id='dropbtn' <?php 
              if($_SESSION['ngonngu']==0){
                echo "src='../icon/vietnamese.png'";
              }else{
                echo "src='../icon/british.png'";
              } ?> style=" height:30px;width:30px;">
            </p>
          
            <div id="dropdown-content"  >
                <a class='lang' ><img class='lang_icon' src="../icon/vietnamese.png" style=" height:30px;width:30px;"> Việt Nam</a>
                <a class='lang' ><img class='lang_icon' src="../icon/british.png" style=" height:30px;width:30px;"> English</a>
            </div>
        </div>

        <div id="notification" style="position:fixed;margin-left: 150px; margin-top: 0px" >
          <i id="notify" class="material-icons" style="font-size:36px;margin-top:3px;float:left; margin-left: 0px;" >notifications</i>
          <div id="notify_drop" class="dropdown-content-notify"  style="margin-top:40px; margin-left: 0px;" >
                    <?php  
                      $user = $_SESSION['tentaikhoan'];
                      //so luong thong bao cua user hien thi tren icon thong bao
                      $result = mysqli_query($link,"SELECT * FROM `soluong_thongbao` WHERE user='$user'" );
                      if($result){
                        while($row = mysqli_fetch_assoc($result)){
                          $soluong_thongbao=$row['soluong_thongbao'];
                        }
                      }
                      //user la admin
                    if($_SESSION['admin']==1 || $_SESSION['mode_user']==1){
                        if($_SESSION['ngonngu']==0)
                          $result = mysqli_query($link,"SELECT * FROM `thongbao` ORDER BY id DESC LIMIT $soluongthongbao" );
                        else
                          $result = mysqli_query($link,"SELECT * FROM `thongbao_en` ORDER BY id DESC LIMIT $soluongthongbao" );
                        if($result){
                            while($row= mysqli_fetch_assoc($result)){
                                $thongbao= $row['thongbao'];
                                $tenthietbi=$row['tenthietbi'];
                                $datetime=date('Y-m-d H:i:s', strtotime($row['date_time']));
                                echo "<div><a class='thongbao' style=''>$tenthietbi: $thongbao Time: $datetime</a></div>";
                            }
                        }
                    }else{
                      //lay thong tin user quan ly thiet bi nao, roi log du lieu trong bang thong bao
                      $i=0;
                      $result = mysqli_query($link,"SELECT * FROM `user_thietbi` WHERE user='$user'" );
                      if($result){
                            while($row = mysqli_fetch_assoc($result)){
                                $mang_tenthietbi[$i] = $row['tenthietbi'];
                                $i++;
                            }
                        }
                        $userStr = implode("', '", $mang_tenthietbi);
                        if($_SESSION['ngonngu']==0)
                          $result = mysqli_query($link,"SELECT * FROM `thongbao` WHERE tenthietbi IN ('$userStr') ORDER BY id DESC LIMIT $soluongthongbao" );
                        else
                          $result = mysqli_query($link,"SELECT * FROM `thongbao_en` WHERE tenthietbi IN ('$userStr') ORDER BY id DESC LIMIT $soluongthongbao" );

                        if($result){
                            while($row= mysqli_fetch_assoc($result)){
                                $thongbao= $row['thongbao'];
                                $tenthietbi=$row['tenthietbi'];
                                $datetime=date('Y-m-d H:i:s', strtotime($row['date_time']));
                                echo "<a class='thongbao'>$tenthietbi: $thongbao Time: $datetime</a>";
                            }
                        }
                    }
                    ?>
                    <div><a id='thongbao' class='thongbao' href="../menu/thongbao.php"><center><?php if($_SESSION['ngonngu']==0) echo " Xem tất cả ";else echo " View all";?></center></a></div>


            </div> 
                    <?php 
                    if($soluong_thongbao>0){
                      echo "<span id='sothongbao' class='button__badge' style='margin-left:1000px;'>$soluong_thongbao</span>";
                  }
                ?>  
          </div>

            <?php
              facebook();
            ?>
    </header>      
    <script type="text/javascript" language="javascript">
       $(document).ready(function(){
          $("#notify").click(function () {
            $('#sothongbao' ).fadeOut('slow');
            document.getElementById("notify_drop").classList.toggle("show");
             $.ajax({
                  url: "../xuly/reset_thongbao.php",
                  success: function(result){
              }
            });
          });
       });
    </script>


    <div id="map"></div>

  </body>
</html>

<script>
      function initMap() {
        var uluru = {lat: <?php echo "$vido"; ?>, lng: <?php echo "$kinhdo"; ?>};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 17,
          center: uluru ,
          mapTypeControl: false,
        });

        var contentString ="<?php echo '<h4>'.$tenthietbi.'</h4><div>'
        ."&nbsp<img src='../icon/nhietdo.png' alt='t' width='20' height='30' style='margin-bottom:10px;'>". $nhietdo.' &nbsp&nbsp&nbsp'."<img src='../icon/doam.png' alt='h' width='20' height='22' style='margin-bottom:4px;'>".$doam. '</div> '
        .'<div>'."<img src='../icon/gio.png' alt='t' width='25' height='25' style='margin-bottom:2px;'>&nbsp".$gio.'&nbsp '."<img src='../icon/ngay.png' alt='t' width='25' height='25' style='margin-bottom:2px;'>&nbsp".$ngay.'</div>'
        ;?>";
       
        var infowindow = new google.maps.InfoWindow({
          content:contentString
        });

        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        }); 
     
        infowindow.open(map, marker);
        marker.addListener('click', function() {
          infowindow.open(map, marker);
        });
      }
</script>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3KcjPk4eUjJwfmB_q5MIw1YG4hvG8qOA&callback=initMap">
</script>
<script src="../popup/popup.js"></script>