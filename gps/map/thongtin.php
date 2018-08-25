<?php
  /* Displays user information and some useful messages */
  require '../library/db.php';
  require '../library/function.php';
  getlang();
  if(  $_SESSION['ngonngu']==0){
    $txt_hoatdong= $array_vn[16];
    $txt_kohoatdong= $array_vn[17];
    $txt_search= $array_vn[18];

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
      $txt_thietbi=$array_vn[162];
  }else{
    $txt_hoatdong=$array_en[16];
    $txt_kohoatdong=$array_en[17];
    $txt_search=$array_en[18];

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
      $txt_thietbi=$array_en[162];
  }
  // Check if user is logged in using the session variable
  if ( $_SESSION['logged_in'] != 1 ) {
    $_SESSION['message'] = "Bạn cần phải đăng nhập!";
    header("location: ../login/error.php");    
  }
  check_timeout();
 
?>
<html> 
  <head> 
    <title>Map</title>
    
    <link rel="stylesheet" href="../css/thongtin.css">
 
    <link rel="shortcut icon" href="../icon/icon.ico">
    <meta name="viewport" content="initial-scale=1.0">

    <meta charset="utf-8">
     
    <script src="../js/jquery.min.js-3.3.1.js"></script>
    <script src="../js/function.js"></script>
  

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="../js/jquery.min.js-3.3.1.js"></script>  <!-- menu click -->
    <link rel="stylesheet" href="../css/bootstrap.min.css-3.3.1.css">  <!-- menu css -->
        
    <script src="../js/jquery.menu-aim.js"></script> <!-- menu aim -->
    <script src="../js/main.js"></script> <!-- Resource jQuery --> 
    <script src="../js/modernizr.js"></script>
   
    <link rel="stylesheet" type="text/css" href="../css/style_menu.css" />
    <link rel="stylesheet" type="text/css" href="../css/reset.css" />
    <link rel="stylesheet" type="text/css" href="../css/lichsu.css" />
    <script src="../js/jquery.confirm.js"></script>
    <link rel="stylesheet" href="../popup/popup.css" />
    <link rel="stylesheet" href="../css/thongtin2.css">
    <script src="../js/function.js"></script>
    <?php 
        style_menu_map();
    ?>
    <style type="text/css">
     
        .autocomplete-items {
          position: relative;
          border: 1px solid #d4d4d4;
          border-bottom: none;
          border-top: none;
          z-index: auto !important;
          /*position the autocomplete items to be the same width as the container:*/
          top: 100%;
          left: 0%;
          right: 0%;
          width: 150px;
          height: 500px;
          overflow: auto;
        }
        .autocomplete-items div {
          position: relative;z-index: auto;
          padding: 10px;
          line-height: 20px;
          cursor: pointer;
          background-color: #fff; 
          border-bottom: 1px solid #d4d4d4; 
          
        }
        .autocomplete-items div:hover { position: relative;z-index: auto;
          /*when hovering an item:*/
          background-color: #e9e9e9; 
        }
        .autocomplete-active {position: relative;z-index: auto; 
          /*when navigating through the items using the arrow keys:*/
          background-color: DodgerBlue !important; 
          color: #ffffff; 
        }
        
        .dropdown-content {
            display: none;
            
        }
        .show {display: block;}
        #hoatdong, #kohoatdong{
          font-size: 18;
          overflow: auto;

        }
        #hoatdong li, #kohoatdong li{
          padding:  6px;
          border-top:  1px solid white;
          box-shadow: 3px 3px 3px #ddd; 
        }
        .ctrlq.fb-button,.ctrlq.fb-close{
          right: 50px !important;
        }
        @media only screen and (max-width: 700px) {
            .cd-dropdown{
              <?php

                if($_SESSION['admin']==1){    /* administrator */
                  echo "height: 270px !important;";
                }elseif($_SESSION['mode_user']==1)  {
                  echo "height: 240px !important;";
                }else{
                  echo "height: 210px !important;";
                }
 
              ?>
            }
        }
    </style>
  
  
  </head>
  <body onload="javascript:setTimeout('location.reload(true);',120000);">
              <div id="poptuk" style="z-index:5">
                    <div id="poptuk_content" >
                      <div class="poptuk_body"></div>
                      <span onclick="poptuk_a('close')" class="poptuk_b" style="color:blue;border: 2px solid blue;">Đóng</span> 
                    </div>
                  </div>
    <div   class="search_box ">
       
      <div class="also search-link" id="searchclick" style="margin:0px;padding:0px;" ><img class='lang_icon' src="../icon/search.png" style=" height:30px;width:30px;margin-top: 8px;"></div>
     
          <input id="search" placeholder="<?php echo $txt_search; ?>..." type="text" >
      <script>
            function search_box(inp, arr) {
              /*the autocomplete function takes two arguments,
              the text field element and an array of possible autocompleted values:*/
              var currentFocus;
              var tt=1;
              /*execute a function when someone writes in the text field:*/
              inp.addEventListener("input", function(e) {
                  var a, b, i, val = this.value;
                  /*close any already open lists of autocompleted values*/
                  closeAllLists();
                  if (!val){ return false;}
                  currentFocus = -1;
                  /*create a DIV element that will contain the items (values):*/
                  a = document.createElement("DIV");
                  a.setAttribute("id", this.id + "autocomplete-list");
                  a.setAttribute("class", "autocomplete-items");
                  /*append the DIV element as a child of the autocomplete container:*/
                  this.parentNode.appendChild(a);
                  /*for each item in the array...*/
                  for (i = 0; i < arr.length; i++) {
                    /*check if the item starts with the same letters as the text field value:*/
                   
                    //if ( strpos(arr[i], val) !== 0) {
                   if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase() || arr[i].indexOf(val)>0  ) {
                      /*create a DIV element for each matching element:*/
                      b = document.createElement("DIV");
                      /*make the matching letters bold:*/
                     // b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                      //b.innerHTML += arr[i].substr(val.length);
                      b.innerHTML += arr[i];
                      /*insert a input field that will hold the current array item's value:*/
                      b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                      /*execute a function when someone clicks on the item value (DIV element):*/
                      b.addEventListener("click", function(e) {
                          /*insert the value for the autocomplete text field:*/
                          inp.value = this.getElementsByTagName("input")[0].value;
                          /*close the list of autocompleted values,
                          (or any other open lists of autocompleted values:*/
                          closeAllLists();
                      });
                      a.appendChild(b);
                    }
                  }
              });
              /*execute a function presses a key on the keyboard:*/
              inp.addEventListener("keydown", function(e) {
                  var x = document.getElementById(this.id + "autocomplete-list");
                  if (x) x = x.getElementsByTagName("div");
                  if (e.keyCode == 40) {
                    /*If the arrow DOWN key is pressed,
                    increase the currentFocus variable:*/
                    currentFocus++;
                    /*and and make the current item more visible:*/
                    addActive(x);
                  } else if (e.keyCode == 38) { //up
                    /*If the arrow UP key is pressed,
                    decrease the currentFocus variable:*/
                    currentFocus--;
                    /*and and make the current item more visible:*/
                    addActive(x);
                  } else if (e.keyCode == 13) {
                    /*If the ENTER key is pressed, prevent the form from being submitted,*/
                    e.preventDefault();
                    if (currentFocus > -1) {
                      /*and simulate a click on the "active" item:*/
                      if (x) x[currentFocus].click();
                    }
                  }
              });
              function addActive(x) {
                /*a function to classify an item as "active":*/
                if (!x) return false;
                /*start by removing the "active" class on all items:*/
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                /*add class "autocomplete-active":*/
                x[currentFocus].classList.add("autocomplete-active");
              }
              function removeActive(x) {
                /*a function to remove the "active" class from all autocomplete items:*/
                for (var i = 0; i < x.length; i++) {
                  x[i].classList.remove("autocomplete-active");
                }
              }
              function closeAllLists(elmnt) {
                /*close all autocomplete lists in the document,
                except the one passed as an argument:*/
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                  if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                  }
                }
              }
              /*execute a function when someone clicks in the document:*/
              document.addEventListener("click", function (e) {
                  closeAllLists(e.target);
                  });
            }

            /*An array containing all the country names in the world:*/
            var tb = [];
            i=0;
            $.ajax({
                   url : "../xuly/get_tenthietbi.php",              
                   type : "post",          // chọn phương thức gửi là post
                   dataType:"json",           // dữ liệu trả về dạng text
                   async:false, // bat dong bo = false
                    //data : {               // Danh sách các thuộc tính sẽ gửi đi
                    //number : $('#number').val()
                    //},
                   success : function (result){
                          $.each (result, function (key, item){
                                tenthietbi =  item['tenthietbi'];
                                tb[i]=tenthietbi;
                                i++;
                               // alert(vido);
                                 //$('#demo').append(vido);
                          }); 
                    }
              });
            /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
            search_box(document.getElementById("search"), tb);
      </script>
    </div>
     
  <header id="container"  style="z-index: 2;" >
    <div   class="cd-dropdown-wrapper">
      <a class="cd-dropdown-trigger" style="width:100px;">Menu</a>
      <?php 
        if($_SESSION['admin']==1){
          echo "<nav class='cd-dropdown' style=' height: 450px;'>";
        }elseif($_SESSION['mode_user']==0){
          echo "<nav class='cd-dropdown' style=' height: 350px;'>";
        }else{//admin==0 và mode user == 1
          echo "<nav class='cd-dropdown' style=' height: 400px;'>";
        }
      ?>
      
        <ul class="cd-dropdown-content">
          <li><a class="menu1" href="../map/thongtin.php"><?php 
                   
                    echo $txt_trangchu;
              ?></a></li>
          <li class='has-children'>
            <a  class='menu1' ><?php 
                
                  echo $txt_thietbi;
              ?></a>
             
            <ul id='thietbi_map' class='is-hidden' >
             
              <?php
                  if($_SESSION['admin']==1 || $_SESSION['mode_user']==1){
                      $query = "SELECT * FROM `seri_thietbi` ORDER BY thietbi DESC";
                  }else{
                      $user = $_SESSION['tentaikhoan'];
                      $query = "SELECT * FROM `user_thietbi` WHERE user = '$user' ORDER BY thietbi DESC";
                  }
                   
                  $result = mysqli_query($link, $query);
                  $i=0;
                  while($row= mysqli_fetch_array($result)){     //duyet bang seri_thietbi
                     $tenthietbi=$row['tenthietbi'];
                     $thietbi =$row['thietbi'];
                      $result2 = mysqli_query($link, "SELECT * FROM `$thietbi`");
                     if(mysqli_num_rows($result2)==0)
                      continue;
                     echo "<a id='".$i."' class='thietbi'  ><li  >$tenthietbi</li></a>";
                     $i++;
                  }
                ?>
            
            </ul>
          </li>

        

          <li><a class='menu1' href='../menu/luachon_thietbi.php'><?php echo $txt_lichsu;?></a></li>
          <li class='has-children'>
            <a  class='menu1' ><?php echo $txt_quanlythietbi;?></a>
            <?php
              
              echo "<ul id='child_quanlythietbi_map' class='is-hidden' style=' '>";
             
            ?>
              <li><a class="menu2" href="../menu/caidat.php"><?php echo $txt_caidatthietbi;?></a></li>
              <li><a class='menu2' href='../menu/addthietbi.php'><?php echo $txt_themthietbi;?></a></li>
            <?php
              if($_SESSION['mode_user']==1){
                echo "<li><a class='menu2' href='../menu/taothietbi.php'>";
                echo $txt_taothietbi;
                echo "</a></li>";
              }
            ?>
              <li ><a class="menu2" href='../menu/xoathietbi.php'><?php echo $txt_xoathietbi; ?></a></li>
            </ul>
          </li>
            
          
          <?php 
            if($_SESSION['admin']==1||$_SESSION['mode_user']==1){
              echo "<li class='has-children'>";
                echo "<a  class='menu1'>";
                     
                      echo $txt_quanlyuser;
                echo "</a>";  
                  echo "<ul id='child_quanlyuser_map' class='is-hidden' style=''>";
                    echo "<li><a class='menu2' href='../menu/caidat_user.php'>";
                       
                      echo $txt_caidatuser;
                    echo "</a></li>"; 
                  echo "<li><a class='menu2' href='../menu/signup.php'>";
                     
                      echo $txt_dangkyuser;
                  echo "</a></li>"; 
                  echo "<li><a  href='../menu/xoa_user.php' class='menu2'>";
                    
                      echo $txt_xoauser;
                  echo "</a>"; 
                     
                  echo "</li>";
                echo "</ul>";
              echo "</li>";
            }
          ?>
          <li><a class="menu1" href="../menu/log.php"><?php  echo $txt_log; ?></a></li>
          <?php 
              if($_SESSION['admin']==1)
              {
                 echo "<li class='has-children'>";
                  echo "<a  class='menu1'  >";
                     
                    echo $txt_caidathethong;
                  echo "</a>";  
                    echo "<ul id='child_caidathethong' class='is-hidden' style='margin-top: 300px;'>";

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
 
          <li><a class="menu1" onclick="lancer()"><?php  echo $txt_lienhe; ?></a></li>
          <li><a class="menu1" href="../login/logout.php"><?php echo $txt_dangxuat; ?></a></li>
        </ul> <!-- .cd-dropdown-content -->
      </nav> <!-- .cd-dropdown -->
    </div> <!-- .cd-dropdown-wrapper -->

        <div id="dropdown" style="position: fixed;  float: left;margin-left: 115px  ;margin-top:2px; " >
          <p style="background-color:  ; "><img id='dropbtn' <?php 
              if($_SESSION['ngonngu']==0){
                echo "src='../icon/vietnamese.png'";
              }else{
                echo "src='../icon/british.png'";
              } ?> style=" height:30px;width:30px;">
          </p>
          
          <div id="dropdown-content"   >
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
                      echo "<span id='sothongbao' class='button__badge' style='margin-left:90px !important;'>$soluong_thongbao</span>";
                  }
                ?>  
        </div>
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
      <?php
        $sothietbi_hoatdong=0;
        $sothietbi_khonghoatdong=0;
        $i=0;
        $mang_tenthietbi = array();
        if($_SESSION['admin']==1 || $_SESSION['mode_user']==1){
          $query="SELECT * FROM hoatdong_thietbi";
        }else{
          $user = $_SESSION['tentaikhoan'];
          $result2=mysqli_query($link,"SELECT * FROM `user_thietbi` WHERE user = '$user' ORDER BY thietbi DESC");
          while($row2= mysqli_fetch_array($result2)){
            $mang_tenthietbi[$i] = $row2['tenthietbi'];
            $i++;
          }
          $userStr = implode("', '", $mang_tenthietbi);
          $query = "SELECT * FROM `hoatdong_thietbi` WHERE tenthietbi IN ('$userStr')";
        }
        $result=mysqli_query($link,$query);
        if($result){
          while ($row=mysqli_fetch_array($result)) {
            $hoatdong=$row['hoatdong'];
            $tenthietbi=$row['tenthietbi'];
            $result2 = mysqli_query($link, "SELECT * FROM `seri_thietbi` where tenthietbi='$tenthietbi'");
                while ($row2=mysqli_fetch_array($result2)) {
                    $thietbi=$row2['thietbi'];
                }
                $result3 = mysqli_query($link, "SELECT * FROM `$thietbi`");
                 if(mysqli_num_rows($result3)==0)
                  continue;
                else{
                  if($hoatdong==1){
                    $sothietbi_hoatdong++;
                  }else{
                    $sothietbi_khonghoatdong++;
                  }
                }
            

          }
        }
      ?>
    <div id='note'>
      <div id='dropdown_hoatdong'>
          <div id='div_hoatdong' ><?php 
                  echo $txt_hoatdong;
              ?>: <?php echo "$sothietbi_hoatdong"; ?></div>
          <div id='hoatdong' style=" " >
            <?php  
              if($_SESSION['admin']==1 || $_SESSION['mode_user']==1){
                $query="SELECT * FROM hoatdong_thietbi WHERE hoatdong=1";
              }else{
                $user = $_SESSION['tentaikhoan'];
                $result2=mysqli_query($link,"SELECT * FROM `user_thietbi` WHERE user = '$user' ORDER BY thietbi DESC");
                while($row2= mysqli_fetch_array($result2)){
                  $mang_tenthietbi[$i] = $row2['tenthietbi'];
                  $i++;
                }
                $userStr = implode("', '", $mang_tenthietbi);
                $query = "SELECT * FROM `hoatdong_thietbi` WHERE tenthietbi IN ('$userStr') AND hoatdong=1";
              }

              $result=mysqli_query($link,$query);
              while ($row=mysqli_fetch_array($result)) {
                $tenthietbi=$row['tenthietbi'];
                $result2 = mysqli_query($link, "SELECT * FROM `seri_thietbi` where tenthietbi='$tenthietbi'");
                while ($row2=mysqli_fetch_array($result2)) {
                    $thietbi=$row2['thietbi'];
                }
                $result3 = mysqli_query($link, "SELECT * FROM `$thietbi`");
                     if(mysqli_num_rows($result3)==0)
                      continue;
                echo "<li class='hoatdong_thietbi'>$tenthietbi</li>";
              }
            ?>
             
          </div>
      </div>
      <div id='dropdown_kohoatdong'>
        <div id='div_kohoatdong' style="   "><?php 
                   echo $txt_kohoatdong;
              ?>: <?php echo "$sothietbi_khonghoatdong"; ?></div>
        <div id='kohoatdong' style="  ">
           <?php  
              //$query="SELECT * FROM hoatdong_thietbi WHERE hoatdong=0"; 
              if($_SESSION['admin']==1 || $_SESSION['mode_user']==1){
                $query="SELECT * FROM hoatdong_thietbi WHERE hoatdong=0";
              }else{
                $user = $_SESSION['tentaikhoan'];
                $result2=mysqli_query($link,"SELECT * FROM `user_thietbi` WHERE user = '$user' ORDER BY thietbi DESC");
                while($row2= mysqli_fetch_array($result2)){
                  $mang_tenthietbi[$i] = $row2['tenthietbi'];
                  $i++;
                }
                $userStr = implode("', '", $mang_tenthietbi);
                $query = "SELECT * FROM `hoatdong_thietbi` WHERE tenthietbi IN ('$userStr') AND hoatdong=0";
              }
              $result=mysqli_query($link,$query);
              while ($row=mysqli_fetch_array($result)) {
                $tenthietbi=$row['tenthietbi'];
                $result2 = mysqli_query($link, "SELECT * FROM `seri_thietbi` where tenthietbi='$tenthietbi'");
                while ($row2=mysqli_fetch_array($result2)) {
                    $thietbi=$row2['thietbi'];
                }
                $result3 = mysqli_query($link, "SELECT * FROM `$thietbi`");
                     if(mysqli_num_rows($result3)==0)
                      continue;
                echo  "<li class='hoatdong_thietbi'>$tenthietbi</li>";
              }
            ?>
             
        </div>
      </div>
    </div> 
    <div id="map" ></div>
      
      <?php
        facebook();
       ?>
  </body>
 
</html>

  <script>
  var a=1;
    var markers = [],gmarkers=[];
    function initMap() {
      var tenthietbi;
      var vido,kinhdo;
      var nhietdo,doam;
      var map;
      var bounds = new google.maps.LatLngBounds();
      var labels = ' ';
      var labelIndex = 0;
      var mapOptions = {
          //mapTypeId: 'roadmap'
          mapTypeControl: false,
          fullscreenControl: false
      };
      var i = 1;
      var id;
      // Display a map on the page
      map = new google.maps.Map(document.getElementById("map"), mapOptions);
      map.setTilt(45);
          
                    

      // Multiple Markers
        $.ajax({
             url : "../xuly/get_toado.php",              
             type : "post",          // chọn phương thức gửi là post
             dataType:"json",           // dữ liệu trả về dạng text
             async:false, // bat dong bo = false
              //data : {               // Danh sách các thuộc tính sẽ gửi đi
              //number : $('#number').val()
              //},
             success : function (result){
                    $.each (result, function (key, item){
                          vido =  item['vido'];
                          kinhdo = item['kinhdo'];
                          markers[i-1]=[vido,kinhdo];
                       
                          i++;
                         // alert(vido);
                           //$('#demo').append(vido);
                    }); 
              }
        });
     
      // Info Window Content
      var infoWindowContent = new Array,mar=[];
      i=1;
      var array_tenthietbi=[];
      var j=0;
        $.ajax({
             url : "../xuly/get_ndda.php",            
             type : "post",          // chọn phương thức gửi là post
             dataType:"json",           // dữ liệu trả về dạng text
             async:false, // bat dong bo = false
            // data : {               // Danh sách các thuộc tính sẽ gửi đi
            //    id : id,
            // },
             success : function(result){
                   
                   $.each(result, function (key, item){
                          nhietdo =  item['nhietdo'];
                          doam = item['doam'];
                       
                          tenthietbi = item['tenthietbi'];
                          gio= item['gio'];
                          ngay= item['ngay'];
                          theodoi = item['theodoi'];
                          lang = item['lang'];
                          if(lang==0){
                            txt_theodoi="Theo dõi";
                          }else{
                            txt_theodoi="Tracking";
                          }
                          
                          if(nhietdo>100){
                            if(theodoi==1)
                            infoWindowContent[i-1]=['<h4>'+tenthietbi+'</h4><p>'+txt_theodoi+': ON</p>' +'<p>'+ "<img src='../icon/nhietdo.png' alt='t' width='20' height='30' style='margin-bottom:2px;'> Error &nbsp&nbsp&nbsp&nbsp <img src='../icon/doam.png' alt='h' width='20' height='22' style='margin-bottom:4px;'> Error"+'</p>'+"<p><img src='../icon/gio.png' alt='t' width='25' height='25' style='margin-bottom:2px;'>&nbsp"+gio+"&nbsp<img src='../icon/ngay.png' alt='t' width='25' height='25' style='margin-bottom:2px;'>&nbsp"+ngay+"</p>"];
                            else
                              infoWindowContent[i-1]=['<h4>'+tenthietbi+'</h4><p>'+txt_theodoi+': OFF</p>' +'<p>'+ "<img src='../icon/nhietdo.png' alt='t' width='20' height='30' style='margin-bottom:2px;'> Error &nbsp&nbsp&nbsp&nbsp <img src='../icon/doam.png' alt='h' width='20' height='22' style='margin-bottom:4px;'> Error"+'</p>'+"<p><img src='../icon/gio.png' alt='t' width='25' height='25' style='margin-bottom:2px;'>&nbsp"+gio+"&nbsp<img src='../icon/ngay.png' alt='t' width='25' height='25' style='margin-bottom:2px;'>&nbsp"+ngay+"</p>"];
                          }else{
                            if(theodoi==1)
                            infoWindowContent[i-1]=['<h4>'+tenthietbi+'</h4><p>'+txt_theodoi+': ON</p>' +'<p>'+ "<img src='../icon/nhietdo.png' alt='t' width='20' height='30' style='margin-bottom:2px;'> "+ nhietdo +"ºC &nbsp&nbsp&nbsp<img src='../icon/doam.png' alt='h' width='20' height='22' style='margin-bottom:4px;'> " + doam+"%</p><p><img src='../icon/gio.png' alt='t' width='25' height='25' style='margin-bottom:2px;'>&nbsp"+gio+"&nbsp<img src='../icon/ngay.png' alt='t' width='25' height='25' style='margin-bottom:2px;'>&nbsp"+ngay+"</p>"]; 
                            else
                              infoWindowContent[i-1]=['<h4>'+tenthietbi+'</h4><p>'+txt_theodoi+': OFF</p>' +'<p>'+ "<img src='../icon/nhietdo.png' alt='t' width='20' height='30' style='margin-bottom:2px;'> "+ nhietdo +"ºC &nbsp&nbsp&nbsp<img src='../icon/doam.png' alt='h' width='20' height='22' style='margin-bottom:4px;'> " + doam+"%</p><p><img src='../icon/gio.png' alt='t' width='25' height='25' style='margin-bottom:2px;'>&nbsp"+gio+"&nbsp<img src='../icon/ngay.png' alt='t' width='25' height='25' style='margin-bottom:2px;'>&nbsp"+ngay+"</p>"]; 
                          } 
                          i++;
                          array_tenthietbi[j]=tenthietbi;
                          j++;
                    });
              }
        });
        var jsonString = JSON.stringify(array_tenthietbi);
        var check=[];
        i=0;
         $.ajax({
             url : "../xuly/get_hoatdong.php",              
             type : "post",          // chọn phương thức gửi là post
             dataType:"json",           // dữ liệu trả về dạng text
             async:false, // bat dong bo = false
              data : {               // Danh sách các thuộc tính sẽ gửi đi
                data :jsonString
              },
             success : function (result){
                    $.each (result, function (key, item){
                          check[i] =  item['check'];
                          i++;
                         // alert(vido);
                           //$('#demo').append(vido);
                    }); 
              }
        });
      // Display multiple markers on a map
      var infoWindow = new google.maps.InfoWindow(), marker, i;
      var icon_hd = {
          url: "../icon/marker_hd.png", // url
          scaledSize: new google.maps.Size(30, 35), // scaled size
      };
      var icon_khd = {
          url: "../icon/marker_khd.png", // url
          scaledSize: new google.maps.Size(30, 35), // scaled size
      };
    
      // Loop through our array of markers & place each one on the map
      for( i = 0; i < markers.length; i++ ) {
          var position = new google.maps.LatLng(markers[i][0], markers[i][1]);
          bounds.extend(position);
          if(check[i]==1)
            marker = new google.maps.Marker({
                position: position,
                animation: google.maps.Animation.DROP,
                label: labels[labelIndex++ % labels.length],
                map: map,
                icon:icon_hd,
            });

          else
            marker = new google.maps.Marker({
                position: position,
                animation: google.maps.Animation.DROP,
                label: labels[labelIndex++ % labels.length],
                map: map,
                icon:icon_khd,
            });
          gmarkers.push(marker);
          // Allow each marker to have an info window
          google.maps.event.addListener(marker, 'click', (function(marker, i) {
              return function() {
                  //map.setZoom(14);
                 // map.setCenter(marker.getPosition());
                 
                  infoWindow.setContent(infoWindowContent[i][0]);
                  infoWindow.open(map, marker);
                  if (marker.getAnimation() !== null) {
                    marker.setAnimation(null);
                  } else {
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                  }
              }           
          })(marker, i));
          
          // Automatically center the map fitting all markers on the screen
          map.fitBounds(bounds);
      }
       $(function(){
          $(".thietbi").click(function () {
              var kinhdo,vido;
              var text = $(this).text();  //lay thiet bi
              var id = this.id;
              //alert(id);
              $.ajax({
                   url : "../xuly/dinhvidiem.php",              
                   type : "get",          // chọn phương thức gửi là post
                   dataType:"json",           
                   //async:false, // bat dong bo = false
                   data : {               // Danh sách các thuộc tính sẽ gửi đi
                       tenthietbi : text
                    },
                    success : function (result){
                     $.each (result, function (key, item){
                        kinhdo = item['kinhdo'];
                        vido = item['vido'];
                        nhietdo =  item['nhietdo'];
                        doam = item['doam'];
                        tenthietbi = item['tenthietbi'];
                        gio= item['gio'];
                        ngay= item['ngay'];  
                      });
                     //toado ="{lat:"+ vido +", lng:" + kinhdo + "}";
                     if(kinhdo==null || vido==null){
                      return;
                     }
                      var latLng = new google.maps.LatLng(vido,kinhdo);
                      $("#search").val(text);
                      map.panTo(latLng);
                      map.setZoom(18);
                      
                     google.maps.event.trigger(gmarkers[id],'click');
                    }
              });
          });
      });
       $(function(){
          $(".hoatdong_thietbi").click(function () {
              var kinhdo,vido;
              var text = $(this).text();  //lay  thiet bi
            
              //alert(id);
              $.ajax({
                   url : "../xuly/dinhvidiem2.php",              
                   type : "get",          // chọn phương thức gửi là post
                   dataType:"json",           
                   //async:false, // bat dong bo = false
                   data : {               // Danh sách các thuộc tính sẽ gửi đi
                       tenthietbi : text
                    },
                    success : function (result){
                     $.each (result, function (key, item){
                        kinhdo =  item['kinhdo'];
                        vido = item['vido'];
                        nhietdo =  item['nhietdo'];
                        doam = item['doam'];
                        tenthietbi = item['tenthietbi'];
                        gio= item['gio'];
                        ngay= item['ngay']; 
                        id= item['id'];   
                      });
                     //toado ="{lat:"+ vido +", lng:" + kinhdo + "}";
                     if(kinhdo==null || vido==null){
                      return;
                     }
                      var latLng = new google.maps.LatLng(vido,kinhdo);
                      $("#search").val(text);
                      map.panTo(latLng);
                      map.setZoom(18);
                      
                     google.maps.event.trigger(gmarkers[id],'click');
                    }
              });
          });
      });
     $(function(){
          $("#searchclick").click(function () {
              var text = $('#search').val();
              // alert(text);
              $.ajax({
                   url : "../xuly/dinhvidiem2.php",              
                   type : "get",        
                   dataType:"json",           
                   //async:false, // bat dong bo = false
                   data : {               // Danh sách các thuộc tính sẽ gửi đi
                       tenthietbi : text
                    },
                   success : function (result){
                      $.each (result, function (key, item){
                        kinhdo =  item['kinhdo'];
                        vido = item['vido'];
                        nhietdo =  item['nhietdo'];
                        doam = item['doam'];
                        tenthietbi = item['tenthietbi'];
                        gio= item['gio'];
                        ngay= item['ngay']; 
                        id= item['id'];   
                      });
                     //toado ="{lat:"+ vido +", lng:" + kinhdo + "}";

                      if(kinhdo==null || vido==null){
                      return;
                     }
                      var latLng = new google.maps.LatLng(vido,kinhdo);
                      $("#search").val(text);
                      map.panTo(latLng);
                      map.setZoom(18);
                      
                     google.maps.event.trigger(gmarkers[id],'click');
                    }
              });
          });
      });  
    }
    
    </script>
     <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
      <script src="../popup/popup.js"></script>
    <script async defer
     src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmErrTfzEX8API4OqE0U_i5xEU1pd2Sdc&callback=initMap">
    </script>
