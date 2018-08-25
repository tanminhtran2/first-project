<?php
/* Displays user information and some useful messages */
require '../library/db.php';
require '../library/function.php';

check_timeout();
mysqli_set_charset($link, 'UTF8');
 date_default_timezone_set('Asia/Ho_Chi_Minh');
// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "Bạn cần phải đăng nhập!";
  header("location: ../login/error.php");    
}
 
getlang();
  if($_SESSION['ngonngu']==0){
    $txt_nhapthongtinthietbi=$array_vn[78];
    $txt_tenthietbi= $array_vn[79];
    $txt_nhaptenthietbi= $array_vn[80];
    $txt_seri=  $array_vn[81];
    $txt_nhapseri=$array_vn[82];
    $txt_chonanh= $array_vn[83];
    $txt_taothietbi= $array_vn[84];
    $txt_moinhaptenthietbi= $array_vn[85];
    $txt_moinhapseri= $array_vn[86];
    $txt_tenthietbiphaicokytu= $array_vn[87];
    $txt_seriphaicokytu= $array_vn[88];
    $txt_tenthietbidatontai= $array_vn[89];
    $txt_seridatontai= $array_vn[90];
    $txt_taothietbithanhcong= $array_vn[91];
  }else{
    $txt_nhapthongtinthietbi=$array_en[78];
    $txt_tenthietbi= $array_en[79];
    $txt_nhaptenthietbi= $array_en[80];
    $txt_seri=  $array_en[81];
    $txt_nhapseri=$array_en[82];
    $txt_chonanh= $array_en[83];
    $txt_taothietbi= $array_en[84];
    $txt_moinhaptenthietbi= $array_en[85];
    $txt_moinhapseri= $array_en[86];
    $txt_tenthietbiphaicokytu= $array_en[87];
    $txt_seriphaicokytu= $array_en[88];
    $txt_tenthietbidatontai= $array_en[89];
    $txt_seridatontai= $array_en[90];
    $txt_taothietbithanhcong= $array_en[91];
  }

$kiemtra=0;
if (isset($_POST['submit'])){ //neu bam nut them thiet bi
   
    $name = $_POST['name'];
    $seri=  $_POST['seri'];

    $query="SELECT * FROM `seri_thietbi`;";
    $result=mysqli_query($link,$query) or die(mysqli_error($link));
    $kiemtra=1;
    if($result){
        while($row=mysqli_fetch_array($result))
        {
             

            if(empty($_POST["name"])){
                $kiemtra=2;
                break;
            }
            elseif(trim($name) == ''){
                $kiemtra=8;
            }
            elseif(!strcmp($row['tenthietbi'] ,$name)  ){       
                $kiemtra=3;
                break;
            }
            /*
            elseif(preg_match("/^[0-9]*$/",$name[0]) ){       
                $kiemtra=0;
                echo "Chữ cái đầu phải khác số";
                break;
            }
            elseif(!preg_match("/^[a-z0-9]*$/",$name) ){       
                $kiemtra=0;
                echo "Đặt tên từ a-z, 0-9";
                break;
            }
            */
            elseif(empty($_POST["seri"])){
                $kiemtra=4;
                break;
            }
            elseif(trim($seri) == ''){
                $kiemtra=9;
            }
            elseif(!strcmp($row['seri'] ,$seri)  ){       
                $kiemtra=5;
                break;
            }
            elseif( !empty($_POST["name"]) && !empty($_POST["seri"]) && strcmp($row['tenthietbi'] ,$name) && strcmp($row['seri'] ,$seri)){
                $kiemtra=1;                           //them thiet bi hop le
            }
            else{
                $kiemtra=6;
                break;
            }
        }
    }
    

    if($kiemtra==1){
        $query ="SELECT * FROM `seri_thietbi` ORDER BY id DESC LIMIT 1"; //lua chon ten bang cuoi cung de cong them 1 (tb12)
        $result=mysqli_query($link,$query) or die(mysqli_error($link));
        $select = $result->fetch_assoc();
        if($select){
            $ma = str2int($select['thietbi']); 
            $ma++;
            $tb="tb".$ma;//ket qua ten bang
        }else{
            $tb="tb1";
        }
        
        $user = $_SESSION['user'];
        $query = "INSERT INTO `seri_thietbi`(`tenthietbi`,`seri`,`thietbi`) values ('$name','$seri','$tb')";//name la ten nhap vao
        mysqli_query($link, $query);
        if($user!='$admin'){
            mysqli_query($link, "INSERT INTO user_thietbi(`user`,`thietbi`,`tenthietbi`) values ('$user','$tb','$name')");
        }
       
        $query = "CREATE TABLE `$tb` (ID int(255) NOT NULL AUTO_INCREMENT, PRIMARY KEY (id), nhietdo float(16),doam float(16), vido double ,kinhdo double ,nhietdo_duoi float(16),nhietdo_tren float(16),doam_duoi float(16),doam_tren float(16), date_time datetime)";
        mysqli_query($link, $query);  
        //THEM VAO BANG hoatdong_thietbi
        $query = "INSERT INTO `hoatdong_thietbi`(`tenthietbi`,`hoatdong`) values ('$name',0)";
        mysqli_query($link, $query);
        //log
        mysqli_query($link, "INSERT INTO `log`(user,thongbao,`tenthietbi`,`date_time`) values ('$user','Tạo thiết bị mới','$name',now())" );
         
        //upload anh
        $dir="../upload/";
        if($_FILES['uploadfile']['name']==null)
        {
            
        }
        else{
            $image=$_FILES['uploadfile']['name'];
            $temp_name=$_FILES['uploadfile']['tmp_name'];
            if($image!="")
            {
                //if(file_exists($dir.$image))
                //{
                //  $image= time().'_'.$image;
                //}
                $fdir= $dir.$image;
                move_uploaded_file($temp_name, $fdir);
            }
             
            $query="DELETE FROM `images` WHERE  thietbi= '$tb';";
            mysqli_query($link,$query) or die(mysqli_error($link));     
            $query="INSERT IGNORE INTO `images` (`id`,`thietbi`,`file`) values ('','$tb','$image')";
            mysqli_query($link,$query) or die(mysqli_error($link));     
        }  

    }

    
}
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tạo thiết bị</title>
    <link rel="stylesheet" type="text/css" href="../css/lichsu.css" />
    <link rel="shortcut icon" href="../icon/icon.ico">
    <link rel="stylesheet" type="text/css" href="../css/uploadfile.css" />
    <link rel="stylesheet" href="../css/bootstrap.min.css-3.3.1.css">  <!-- menu css -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 
    <script src="../js/jquery.min.js-3.3.1.js"></script>  <!-- menu click -->
    <script src="../js/function.js"></script>

    <script src="../js/jquery.menu-aim.js"></script> <!-- menu aim -->
    <script src="../js/main.js"></script> <!-- Resource jQuery --> 
    <script src="../js/modernizr.js"></script>
 
    <link rel="stylesheet" type="text/css" href="../css/reset.css" />
    <link rel="stylesheet" type="text/css" href="../css/style_menu.css" />
    <script src="../js/jquery-2.1.1.js"></script>
    <!--  timeout confirm  -->
    <link rel="stylesheet" type="text/css"  href="../lib_timeout_confirm/css/jquery-confirm.css"/>
    <script type="text/javascript"  src="../lib_timeout_confirm/js/jquery-confirm.js"></script>
    <link rel="stylesheet" href="../popup/popup.css" />
    <?php 
        style_menu();
    ?>
    <style type="text/css">
        legend{
             width: 50%;
        }
        .form-control{
            width: 50%;
            color: blue;
            border: 1px solid #abadb2;
        }
        li a,  .dropbtn {
            
          
            text-decoration: none;
        }
        #image{
            padding-top:5%;
            padding-left:15%;
            float:left;
         
          }
          #info{
            color:blue; padding-top: 10px; ;
           padding-left:0%;
            float:left;
            width: 60%;
          }
        @media only screen and (max-width: 700px) {
            .cd-dropdown{
              <?php

                if($_SESSION['admin']==1){    /* administrator */
                    echo "height: 210px !important;";
                  }elseif($_SESSION['mode_user']==1)  {
                    echo "height: 180px !important;";
                  }else{
                    echo "height: 150px !important;";
                  }
 
              ?>
          }
       <?php
            if($_SESSION['admin']==1){}else{
                echo "#image2{";
                    echo "width: 66px !important;"; 
                    echo "height: 66px !important;"; 
                echo "}";
                echo ".dropdown-content-icon{";             
                    echo "min-width: 220px !important;";    
                echo "}";  
                if($_SESSION['mode_user'] ==1){
                    echo "#xoathietbi{";
                        echo "margin-top: 150px !important ;";
                    echo "}";
                }else{
                    echo "#xoathietbi{";
                        echo "margin-top: 120px !important ;";
                    echo "}";
                } 
            }
        ?>
    </style>
   
     <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(400)
                        .height(300);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</head>
<body>
    <?php bar_menu($link,$admin,$soluongthongbao); ?>
    
    <script type="text/javascript" language="javascript">
       $(document).ready(function() {
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
        if($kiemtra==1){
    ?>
    <div id='image'>
        <div style="color :blue;">Tên thiết bị vừa tạo:</div>
        <div><?php if(!empty($name)) echo "$name"; ?></div>
        <div style="margin-top:5%;color :blue;">Mã seri vừa tạo:</div>
        <span><?php if(!empty($seri)) echo "$seri"; ?></span>
    
        <div>                
            <?php
                if(isset($image)){

                    $sql="SELECT * FROM `images`   where thietbi='$tb';";
                    $result=mysqli_query($link,$sql) or die(mysqli_error($link));
                    if($result){
                        while($row=mysqli_fetch_array($result))
                        {
            ?>              
                        <img class = 'img' style="width:100%;" id="anh" src="../upload/<?php echo $row['file'];?>" >                        
            <?php
                        }
                    }
                }
            ?>  
        </div>  
    </div> 
    <?php }?>
    <div class="container" style="color:blue; padding-top: 10px;padding-left: 30%;">
       
        <form action="taothietbi.php" method="POST" role="form" enctype="multipart/form-data">
            <legend style="color:red;"><?php 
                 
                    echo $txt_nhapthongtinthietbi;
                ?> </legend>
            
            <div class="form-group">
                <label for=""><?php 
                 
                    echo $txt_tenthietbi;
                ?> </label>
                <input type="text" class="form-control" id="" placeholder="<?php
                        
                                echo $txt_nhaptenthietbi; ?> " name="name"
                 value="<?php 
                            if(isset($name)) echo $name;
                        ?>"><div style="color:red"> <?php 
                                    if($kiemtra==2){
                                            echo $txt_moinhaptenthietbi; 
                                    }elseif($kiemtra==8){
                                        
                                            echo $txt_tenthietbiphaicokytu;
                                         
                                    }
                            ?></div>
            </div>
            
            <div class="form-group">
                <label for=""><?php 
                 
                    echo $txt_seri;
                ?> </label>
                <input type="text" class="form-control" id="" placeholder="<?php 
                    
                        echo $txt_nhapseri;
                 ?> " name="seri" 
                 value="<?php 
                            if(isset($seri)) echo $seri;
                        ?>"><div style="color:red"> <?php 
                                    if($kiemtra==4){
                                         
                                            echo $txt_moinhapseri;
                                         
                                    }elseif($kiemtra==9){
                                       
                                            echo $txt_seriphaicokytu;
                                         
                                    }
                            ?></div>
            </div>  
                    <input type="file" name="uploadfile" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" onchange="readURL(this);" />  <!-- them multiple de chon nhieu anh-->
                    <label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span><?php 
                 
                    echo $txt_chonanh;
                ?> &hellip;</span></label><br>
                    <script src="../js/custom-file-input.js"></script>
                    <img id="blah"  />
                   <br><br>
            <button type="submit" class="btn btn-primary" name="submit"><?php 
                 
                    echo $txt_taothietbi;
                ?> </button><br><div style="color:red">
            <?php
                //echo "<br><br>";
                if (isset($_POST['submit'])){
                    if($kiemtra==1){
                        
                            echo $txt_taothietbithanhcong;
                
                       
                    }
                    
                    elseif($kiemtra==3){
                        
                            echo $txt_tenthietbidatontai;
                         
                    }
                     
                    elseif($kiemtra==5){
                       
                            echo $txt_seridatontai;
                         
                    }
                     
                    elseif($kiemtra==6){
                        echo "error";
                    }
                }
           ?>     </div>
        </form>

    </div>
        <?php  facebook(); ?>
</body>
</html>
    <script src="../popup/popup.js"></script>