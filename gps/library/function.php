<?php 
    require 'db.php';
     
    if(isset($_POST['button_timeout'])){      //co bam nut xac nhan
      if(isset($_POST['timeout'])&& $_POST['timeout']!=null ){
          $_SESSION['set_timeout']=$_POST['timeout'];
          $_SESSION['timeout'] = time();
      }
    }
  function getlang(){
    if(isset($_GET['lang'])){
      if($_GET['lang']==0){
         $_SESSION['ngonngu']=0;
       }else{
         $_SESSION['ngonngu']=1;
       }
    }
  }
   
	function str2int($string, $concat = true) {
        $length = strlen($string);    
        for ($i = 0, $int = '', $concat_flag = true; $i < $length; $i++) {
            if (is_numeric($string[$i]) && $concat_flag) {
                $int .= $string[$i];
            } elseif(!$concat && $concat_flag && strlen($int) > 0) {
                $concat_flag = false;
            }        
        }  
        return (int) $int;
    }

     

    
    function bar_menu($link,$admin,$soluongthongbao){
      echo "<div id='poptuk' style='z-index:5'>";
                          echo "<div id='poptuk_content'>";
                            echo "<div class='poptuk_body'></div>";
                            echo "<span onclick=\"poptuk_a('close')\" class='poptuk_b' style='color:blue;border: 2px solid blue;'>Đóng</span> ";
                          echo "</div>";
                  echo "</div>";
        echo "<header>";
          echo "<div style='float: left;";
          if($_SESSION['admin']==1){
            echo "height:500px;";
           }else if($_SESSION['mode_user']==1){
            echo "height:400px;";
           }else{
            echo "height:350px;";
           }

          echo "' class='cd-dropdown-wrapper'>"; 
            echo "<a class='cd-dropdown-trigger' style='width:100px;' >Menu</a>";
            if($_SESSION['admin']==1){
              echo "<nav class='cd-dropdown' style= 'height: 350px;'>";
            }elseif($_SESSION['mode_user']==0){

              echo "<nav class='cd-dropdown' style=' height: 250px;'>";
            }else{
              echo "<nav class='cd-dropdown' style= 'height: 300px;'>";
            }
              echo "<ul class='cd-dropdown-content' style=' margin:0px;'>";
                echo "<li><a class='menu1' href='../map/thongtin.php'>";
                      $result = mysqli_query($link,"SELECT * FROM `languages` WHERE id = 146" );
                      $lang = $result->fetch_assoc();
                      if($_SESSION['ngonngu']==0) 
                        echo $lang['vn'];
                      else 
                        echo $lang['en'];
                echo "</a></li>";  
                 echo "<li><a class='menu1' href='luachon_thietbi.php'>";
                    $result = mysqli_query($link,"SELECT * FROM `languages` WHERE id = 147" );
                    $lang = $result->fetch_assoc();
                    if($_SESSION['ngonngu']==0) 
                      echo $lang['vn'];
                    else 
                      echo $lang['en'];
                 echo "</a></li>";  
                    
            echo "<li class='has-children'>";
            echo "<a  class='menu1'  >";
                      $result = mysqli_query($link,"SELECT * FROM `languages` WHERE id = 148" );
                      $lang = $result->fetch_assoc();
                      if($_SESSION['ngonngu']==0) 
                        echo $lang['vn'];
                      else 
                        echo $lang['en'];
            echo "</a> ";
             
             
              echo "<ul id='child_quanlythietbi' class='is-hidden' style='margin-top: 100px;'>";
              
               echo "<li><a class='menu2' href='caidat.php'>";
                      $result = mysqli_query($link,"SELECT * FROM `languages` WHERE id = 149" );
                      $lang = $result->fetch_assoc();
                      if($_SESSION['ngonngu']==0) 
                        echo $lang['vn'];
                      else 
                        echo $lang['en'];
                
              echo "</a></li>"; 
             
             echo " <li><a class='menu2' href='addthietbi.php'>";
                      $result = mysqli_query($link,"SELECT * FROM `languages` WHERE id = 150" );
                      $lang = $result->fetch_assoc();
                      if($_SESSION['ngonngu']==0) 
                        echo $lang['vn'];
                      else 
                        echo $lang['en'];
             echo"</a></li>"; 
              if($_SESSION['mode_user']==1){
                echo "<li><a class='menu2' href='taothietbi.php'>";
                      $result = mysqli_query($link,"SELECT * FROM `languages` WHERE id = 151" );
                      $lang = $result->fetch_assoc();
                      if($_SESSION['ngonngu']==0) 
                        echo $lang['vn'];
                      else 
                        echo $lang['en'];
                echo "</a></li>"; 
              }
              echo "<li ><a href='xoathietbi.php' class='menu2'>";
                      $result = mysqli_query($link,"SELECT * FROM `languages` WHERE id = 152" );
                      $lang = $result->fetch_assoc();
                      if($_SESSION['ngonngu']==0) 
                        echo $lang['vn'];
                      else 
                        echo $lang['en'];
              echo"</a>"; 
              echo "</li>";
            echo "</ul>";
            
          echo "</li>";
            
         
         if($_SESSION['admin']==1||$_SESSION['mode_user']==1 ){
            echo "<li class='has-children'>";
              echo "<a  class='menu1'  >";
               $result = mysqli_query($link,"SELECT * FROM `languages` WHERE id = 153" );
                      $lang = $result->fetch_assoc();
                      if($_SESSION['ngonngu']==0) 
                        echo $lang['vn'];
                      else 
                        echo $lang['en'];
              echo "</a>"; 
                echo "<ul id='child_quanlyuser' class='is-hidden' style='margin-top: 150px;'>";
                  echo "<li><a class='menu2' href='../menu/caidat_user.php'>";
                    $result = mysqli_query($link,"SELECT * FROM `languages` WHERE id = 154" );
                      $lang = $result->fetch_assoc();
                      if($_SESSION['ngonngu']==0) 
                        echo $lang['vn'];
                      else 
                        echo $lang['en'];
                  echo "</a></li>";  
                echo "<li><a class='menu2' href='../menu/signup.php'>";
                    $result = mysqli_query($link,"SELECT * FROM `languages` WHERE id = 155" );
                      $lang = $result->fetch_assoc();
                      if($_SESSION['ngonngu']==0) 
                        echo $lang['vn'];
                      else 
                        echo $lang['en'];
                echo "</a></li>";
                    
                echo "<li><a  href='../menu/xoa_user.php'  class='menu2' >";
                 $result = mysqli_query($link,"SELECT * FROM `languages` WHERE id = 156" );
                      $lang = $result->fetch_assoc();
                      if($_SESSION['ngonngu']==0) 
                        echo $lang['vn'];
                      else 
                        echo $lang['en'];
                echo "</a>";  
                   
                echo "</li>";
              echo "</ul>";
            echo "</li>";
            }
        
                echo "<li><a class='menu1' href='log.php'>";
                  $result = mysqli_query($link,"SELECT * FROM `languages` WHERE id = 157" );
                      $lang = $result->fetch_assoc();
                      if($_SESSION['ngonngu']==0) 
                        echo $lang['vn'];
                      else 
                        echo $lang['en'];
                echo "</a></li>";
                if($_SESSION['admin']==1){
                         echo "<li class='has-children'>";
                          echo "<a  class='menu1'  >";
                              $result = mysqli_query($link,"SELECT * FROM `languages` WHERE id = 158" );
                                  $lang = $result->fetch_assoc();
                                  if($_SESSION['ngonngu']==0) 
                                    echo $lang['vn'];
                                  else 
                                    echo $lang['en'];
                          echo "</a>";  
                            echo "<ul id='child_caidathethong' class='is-hidden' style='margin-top: 250px;'>";

                                echo "<li><a class='menu2' href='../menu/caidat_ngonngu.php'>";
                                  $result = mysqli_query($link,"SELECT * FROM `languages` WHERE id = 196" );
                                  $lang = $result->fetch_assoc();
                                  if($_SESSION['ngonngu']==0) 
                                    echo $lang['vn'];
                                  else 
                                    echo $lang['en'];
                                echo "</a></li>"; 

                              echo "<li><a class='menu2' href='../menu/caidat_email.php'>";
                                 $result = mysqli_query($link,"SELECT * FROM `languages` WHERE id = 197" );
                                  $lang = $result->fetch_assoc();
                                  if($_SESSION['ngonngu']==0) 
                                    echo $lang['vn'];
                                  else 
                                    echo $lang['en'];
                              echo "</a></li>"; 

                             
                          echo "</ul>";
                        echo "</li>";
                }
                     
                echo "<li><a class='menu1'  onclick='lancer()' >";
                  $result = mysqli_query($link,"SELECT * FROM `languages` WHERE id = 159" );
                    $lang = $result->fetch_assoc();
                    if($_SESSION['ngonngu']==0) 
                      echo $lang['vn'];
                    else 
                      echo $lang['en'];
                echo "</a></li>";
                   
              echo "</ul> "; 
            echo "</nav>   ";
          echo "</div>   ";

          echo "<div id='notification' style='position:absolute;margin-left: 110px; margin-top: 0px'> ";
                echo "<div id='dropdown' style='position: absolute;margin-top: 0px;'>"; 
                      echo "<button style='background-color: white;'><img id='dropbtn' ";
                         if($_SESSION['ngonngu']==0)
                            echo "src='../icon/vietnamese.png' ";
                          else
                            echo "src='../icon/british.png' ";
                      echo "style='float:left;height:30px;width:30px;'></button>";
                    
                    echo "<div id='dropdown-content'>";
                      echo "<a class='lang' ><img class='lang_icon' src='../icon/vietnamese.png' style=' height:30px;width:30px;'> Việt Nam</a>";
                      echo "<a class='lang' ><img class='lang_icon' src='../icon/british.png' style=' height:30px;width:30px;'> English</a>";
                    echo "</div>";
                echo "</div>";
              echo " <i id='notify' class='material-icons' style='font-size:36px;margin-top:3px;float:left;margin-left: 60px;' >notifications</i>";
                echo " <div id='notify_drop' class='dropdown-content-notify' style='margin-top:40px;margin-left: 60px;'  >";
                           
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
                          
                          echo " <div><a id='thongbao' class='thongbao' href='thongbao.php'><center>";
                              if($_SESSION['ngonngu']==0)
                                echo " Xem tất cả";
                              else
                                echo "View all ";
                          echo "</center></a></div> ";
                      echo " </div>"; 
                        
                      if($soluong_thongbao>0){
                        echo "<span id='sothongbao' class='button__badge'>$soluong_thongbao</span>";
                      }  
          echo "</div>  ";

          echo "<div class='dropdown' style='float:right;'>";
            echo "<button class='dropbtn' ><b>Hi, "; echo $_SESSION['tentaikhoan'].'  </b>'; 
                  echo "<div> ";       
                      $sql="SELECT * FROM `avatar` WHERE user= '$user';";
                      $result=mysqli_query($link,$sql) or die(mysqli_error($link));
                      if($result){
                        while($row=mysqli_fetch_array($result))
                        {
                          echo "<center><img id='image1' src='../upload/";
                          echo $row['file'];
                          echo "' width='45' height='45'></center> ";
                        }
                      }  
                  echo "</div> ";
            echo "</button>";
             
            echo "<div class='dropdown-content-icon' ";
            if($_SESSION['mode_user']==0){ echo "style='min-width: 250px;'";}
            echo ">";   
            
                  $sql="SELECT * FROM `avatar` WHERE user= '$user';";
                  $result=mysqli_query($link,$sql) or die(mysqli_error($link));
                  if($result){
                    while($row=mysqli_fetch_array($result))
                    {
                     
                      echo "<img id='image2' src='../upload/";  echo $row['file'];  echo "'";
                            
              
                      if($_SESSION['admin']==1 || $_SESSION['mode_user']==1){
                        //echo "width='115' height='115'  ";
                      }else{
                        echo "style='width: 77px;height: 77px;'";
                      }
                    }
                  }
              echo "></";  
            echo "<div id='a'>";  
                   
                          if($_SESSION['admin']==1 || $_SESSION['mode_user']==1){
                            echo "<a href='../menu/caidat_user.php'>";
                                $result = mysqli_query($link,"SELECT * FROM `languages` WHERE id = 154" );
                                $lang = $result->fetch_assoc();
                                if($_SESSION['ngonngu']==0) 
                                  echo $lang['vn'];
                                else 
                                  echo $lang['en'];
                            echo "</a> ";
                            echo "<a href='../menu/edit_profile.php'>";
                                $result = mysqli_query($link,"SELECT * FROM `languages` WHERE id = 160" );
                                $lang = $result->fetch_assoc();
                                if($_SESSION['ngonngu']==0) 
                                  echo $lang['vn'];
                                else 
                                  echo $lang['en'];
                            echo "</a>";
                            echo "<a href='../login/logout.php'>";
                                $result = mysqli_query($link,"SELECT * FROM `languages` WHERE id = 161" );
                                $lang = $result->fetch_assoc();
                                if($_SESSION['ngonngu']==0) 
                                  echo $lang['vn'];
                                else 
                                  echo $lang['en'];
                            echo "</a> ";
                          }else{
                             echo "<a href='../menu/edit_profile.php' style='margin-left: 31%;'>";
                                $result = mysqli_query($link,"SELECT * FROM `languages` WHERE id = 160" );
                                $lang = $result->fetch_assoc();
                                if($_SESSION['ngonngu']==0) 
                                  echo $lang['vn'];
                                else 
                                  echo $lang['en'];
                             echo "</a>"; 
                            echo "<a href='../login/logout.php' style='margin-left: 31%;'>";
                                $result = mysqli_query($link,"SELECT * FROM `languages` WHERE id = 161" );
                                $lang = $result->fetch_assoc();
                                if($_SESSION['ngonngu']==0) 
                                  echo $lang['vn'];
                                else 
                                  echo $lang['en'];
                            echo "</a>"; 
                          }
                   
                echo "</div>";
                
              echo "</div>";
                
          echo "</div>";
        echo " </header>";
    }
   
    function facebook(){
      ?>
        <style>.fb-livechat,.fb-widget{display:none}.ctrlq.fb-button,.ctrlq.fb-close{position:fixed;right:24px;cursor:pointer}.ctrlq.fb-button{z-index:1;background:url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDEyOCAxMjgiIGhlaWdodD0iMTI4cHgiIGlkPSJMYXllcl8xIiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCAxMjggMTI4IiB3aWR0aD0iMTI4cHgiIHhtbDpzcGFjZT0icHJlc2VydmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxnPjxyZWN0IGZpbGw9IiMwMDg0RkYiIGhlaWdodD0iMTI4IiB3aWR0aD0iMTI4Ii8+PC9nPjxwYXRoIGQ9Ik02NCwxNy41MzFjLTI1LjQwNSwwLTQ2LDE5LjI1OS00Niw0My4wMTVjMCwxMy41MTUsNi42NjUsMjUuNTc0LDE3LjA4OSwzMy40NnYxNi40NjIgIGwxNS42OTgtOC43MDdjNC4xODYsMS4xNzEsOC42MjEsMS44LDEzLjIxMywxLjhjMjUuNDA1LDAsNDYtMTkuMjU4LDQ2LTQzLjAxNUMxMTAsMzYuNzksODkuNDA1LDE3LjUzMSw2NCwxNy41MzF6IE02OC44NDUsNzUuMjE0ICBMNTYuOTQ3LDYyLjg1NUwzNC4wMzUsNzUuNTI0bDI1LjEyLTI2LjY1N2wxMS44OTgsMTIuMzU5bDIyLjkxLTEyLjY3TDY4Ljg0NSw3NS4yMTR6IiBmaWxsPSIjRkZGRkZGIiBpZD0iQnViYmxlX1NoYXBlIi8+PC9zdmc+) center no-repeat #0084ff;width:60px;height:60px;text-align:center;bottom:24px;border:0;outline:0;border-radius:60px;-webkit-border-radius:60px;-moz-border-radius:60px;-ms-border-radius:60px;-o-border-radius:60px;box-shadow:0 1px 6px rgba(0,0,0,.06),0 2px 32px rgba(0,0,0,.16);-webkit-transition:box-shadow .2s ease;background-size:80%;transition:all .2s ease-in-out}.ctrlq.fb-button:focus,.ctrlq.fb-button:hover{transform:scale(1.1);box-shadow:0 2px 8px rgba(0,0,0,.09),0 4px 40px rgba(0,0,0,.24)}.fb-widget{background:#fff;z-index:2;position:fixed;width:360px;height:435px;overflow:hidden;opacity:0;bottom:0;right:24px;border-radius:6px;-o-border-radius:6px;-webkit-border-radius:6px;box-shadow:0 5px 40px rgba(0,0,0,.16);-webkit-box-shadow:0 5px 40px rgba(0,0,0,.16);-moz-box-shadow:0 5px 40px rgba(0,0,0,.16);-o-box-shadow:0 5px 40px rgba(0,0,0,.16)}.fb-credit{text-align:center;margin-top:8px}.fb-credit a{transition:none;color:#bec2c9;font-family:Helvetica,Arial,sans-serif;font-size:12px;text-decoration:none;border:0;font-weight:400}.ctrlq.fb-overlay{z-index:0;position:fixed;height:100vh;width:100vw;-webkit-transition:opacity .4s,visibility .4s;transition:opacity .4s,visibility .4s;top:0;left:0;background:rgba(0,0,0,.05);display:none}.ctrlq.fb-close{z-index:4;padding:0 6px;background:#365899;font-weight:700;font-size:11px;color:#fff;margin:8px;border-radius:3px}.ctrlq.fb-close::after{content:'x';font-family:sans-serif}</style>
 
            <div class="fb-livechat">
            <div class="ctrlq fb-overlay"></div>
            <div class="fb-widget">
            <div class="ctrlq fb-close"></div>
            <div class="fb-page" data-href="https://www.facebook.com/TanThanhTech1102/" data-tabs="messages" data-width="360" data-height="400" data-small-header="true" data-hide-cover="true" data-show-facepile="false">
            <blockquote cite="https://www.facebook.com/TanThanhTech1102/" class="fb-xfbml-parse-ignore"> </blockquote>
            </div>
         
            <div id="fb-root"></div>
            </div>
            <a href="https://m.me/TanThanhTech1102/" title="Send us a message on Facebook" class="ctrlq fb-button"></a>
            </div>

            <script src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9"></script>
   
            <script>$(document).ready(function(){var t={delay:125,overlay:$(".fb-overlay"),widget:$(".fb-widget"),button:$(".fb-button")};setTimeout(function(){$("div.fb-livechat").fadeIn()},8*t.delay),$(".ctrlq").on("click",function(e){e.preventDefault(),t.overlay.is(":visible")?(t.overlay.fadeOut(t.delay),t.widget.stop().animate({bottom:0,opacity:0},2*t.delay,function(){$(this).hide("slow"),t.button.show()})):t.button.fadeOut("medium",function(){t.widget.stop().show().animate({bottom:"30px",opacity:1},2*t.delay),t.overlay.fadeIn(t.delay)})})});</script>
      <?php
    }
    
    function style_menu(){

      if($_SESSION['mode_user']==1)
        echo "<link rel='stylesheet' type='text/css' media='screen' href='../css/style_menu_admin.css'>";
      else
        echo "<link rel='stylesheet' type='text/css' media='screen' href='../css/style_menu_user.css'>";
    
    }
    function style_menu_map(){

      if($_SESSION['mode_user']==1)
        echo "<link rel='stylesheet' type='text/css' media='screen' href='../css/style_menu_map_admin.css'>";
      else
        echo "<link rel='stylesheet' type='text/css' media='screen' href='../css/style_menu_map_user.css'>";
    
    }
?>
