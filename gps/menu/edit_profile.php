<?php
/* Displays all successful messages */
	require '../library/db.php';
 	require '../library/function.php';
	check_timeout();  
  	// Check if user is logged in using the session variable
  	if( $_SESSION['logged_in'] != 1 ){
   		$_SESSION['message'] = "Bạn cần phải đăng nhập!";
    	header("location: ../login/error.php");    
  	}
  getlang();
  if($_SESSION['ngonngu']==0){
    $txt_thongtinuser= $array_vn[139];
    $txt_dangnhaplancuoi= $array_vn[145];
    $txt_sodienthoai= $array_vn[140];
    $txt_matkhaucu= $array_vn[141];
    $txt_matkhaumoi= $array_vn[142];
    $txt_nhaplaimkmoi= $array_vn[143];
    $txt_luuthaydoi= $array_vn[144];
    $txt_chonanh= $array_vn[33];
    $txt_capnhatanh= $array_vn[34];
    
    $txt_nhapmkcu=$array_vn[206];
    $txt_matkhaucukodung=$array_vn[207];
    $txt_nhapmkmoi=$array_vn[208];
    $txt_nhaplaimkmoi=$array_vn[209];
    $txt_matkhaukotrungkhop=$array_vn[210];
    $txt_capnhatmkthanhcong=$array_vn[211];
    $txt_khongthaydoi=$array_vn[212];

    $txt_capnhatemailthanhcong=$array_vn[213];
    $txt_emailkothaydoi=$array_vn[214];
    $txt_capnhatsdtthanhcong=$array_vn[215];
    $txt_sdtkothaydoi=$array_vn[216];
    $txt_sdtkonhapkytu=$array_vn[217];
  }else{
    $txt_thongtinuser= $array_en[139];
    $txt_dangnhaplancuoi= $array_en[145];
    $txt_sodienthoai= $array_en[140];
    $txt_matkhaucu= $array_en[141];
    $txt_matkhaumoi= $array_en[142];
    $txt_nhaplaimkmoi= $array_en[143];
    $txt_luuthaydoi= $array_en[144];
    $txt_chonanh= $array_en[33];
    $txt_capnhatanh= $array_en[34];

    $txt_nhapmkcu=$array_en[206];
    $txt_matkhaucukodung=$array_en[207];
    $txt_nhapmkmoi=$array_en[208];
    $txt_nhaplaimkmoi=$array_en[209];
    $txt_matkhaukotrungkhop=$array_en[210];
    $txt_capnhatmkthanhcong=$array_en[211];
    $txt_khongthaydoi=$array_en[212];

    $txt_capnhatemailthanhcong=$array_en[213];
    $txt_emailkothaydoi=$array_en[214];
    $txt_capnhatsdtthanhcong=$array_en[215];
    $txt_sdtkothaydoi=$array_en[216];
    $txt_sdtkonhapkytu=$array_en[217];
  }

  $user = $_SESSION['tentaikhoan'];
	//upload file
	if(isset($_POST['submitform'])) 
	{
		$dir="../upload/";
		//if(isset($_FILES['uploadfile']))
		//{
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
					//	$image= time().'_'.$image;
					//}
					$fdir= $dir.$image;
					move_uploaded_file($temp_name, $fdir);
				}
				 
				$query="DELETE FROM `avatar` WHERE  user= '$user';";
				mysqli_query($link,$query) or die(mysqli_error($link));		
				$query="INSERT IGNORE INTO `avatar` (`id`,`user`,`file`) values ('','$user','$image')";
				mysqli_query($link,$query) or die(mysqli_error($link));		
			}
		//}
	}

	//luu thay doi
	$kiemtra=0;
  $check_email=0;
  $check_sdt=0;
	if(isset($_POST['save'])) 
	{
		 if(!empty($_POST['user'])){ 
		 	//$user_post=  $_POST['user'];
        	//mysqli_query($link, "UPDATE `users` SET username = '$user_post' WHERE username='$user'");
		 }
		 if(!empty($_POST['email'])){ 
		 	$email=  $_POST['email'];
      $result=mysqli_query($link, "SELECT * FROM `users` WHERE username='$user'");
        while($row= mysqli_fetch_assoc($result)){
          $email_sql=$row['email'];
        }
      if($email_sql==$email)  {
        $check_email=2;
      }else{
        mysqli_query($link, "UPDATE `users` SET email = '$email' WHERE username='$user'");
       $check_email=1;
      }
		 	
		 }
		 if(!empty($_POST['sdt'])){ 
		 	$sdt=  $_POST['sdt'];
      $result=mysqli_query($link, "SELECT * FROM `users` WHERE username='$user'");
        while($row= mysqli_fetch_assoc($result)){
          $sdt_sql=$row['sodt'];
        }
      if($sdt_sql==$sdt)  {
        $check_sdt=2;
      }elseif(!is_numeric($sdt)){
        $check_sdt=3;
      }else{
		  	mysqli_query($link, "UPDATE `users` SET sodt = '$sdt' WHERE username='$user'");
       $check_sdt=1;
      } 
		 }
		 if(empty($_POST['sdt'])&&empty($_POST['password_old'])&&empty($_POST['password_new'])&&empty($_POST['confirm_password'])&&$check_email==0&&$check_sdt==0) { 
		 	$kiemtra=7;
		 }elseif(!empty($_POST['password_new'])&&!empty($_POST['confirm_password'])&&!empty($_POST['password_old'])){ 
  		 	$result=mysqli_query($link, "SELECT * FROM `users` WHERE username='$user'");
  		 	while($row= mysqli_fetch_assoc($result)){
  		 		$password=$row['password'];
  		 	}
  		 	if($password!=md5($_POST['password_old'])){
  				$kiemtra=2;
  		 	}elseif($_POST['password_new']!=$_POST['confirm_password']){
  		 		$kiemtra=1;
  		 	}else{
  		 		$password_new =  $_POST['password_new'];
  		 		mysqli_query($link, "UPDATE `users` SET password = '".md5($password_new)."' WHERE username='$user'");
  		 		$kiemtra=6;
  		 	}
		 }else if(empty($_POST['password_old'])){
		 	$kiemtra=3;
		 }else if(empty($_POST['password_new'])){
		 	$kiemtra=4;
		 }else if(empty($_POST['confirm_password'])){
		 	$kiemtra=5;
		 }else {

     }
	}
	 
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Chỉnh sửa thông tin</title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../icon/icon.ico">
  <link rel="stylesheet" type="text/css" href="../css/lichsu.css" />
 	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script src="../js/jquery.min.js-3.3.1.js"></script>
  <script src="../js/function.js"></script>
    

   <link rel="stylesheet" type="text/css" href="../css/uploadfile.css" />

  <script src="../js/jquery.menu-aim.js"></script> <!-- menu aim -->
  <script src="../js/main.js"></script> <!-- Resource jQuery --> 
  <script src="../js/modernizr.js"></script>
 
  <link rel="stylesheet" type="text/css" href="../css/reset.css" />
  <link rel="stylesheet" type="text/css" href="../css/style_menu.css" />
  <script src="../js/jquery-2.1.1.js"></script>
  <link rel="stylesheet" type="text/css"  href="../lib_timeout_confirm/demo/libs/bundled.css"><!--confirm timeout fix center-->
  <link rel="stylesheet" type="text/css"  href="../lib_timeout_confirm/css/jquery-confirm.css"/>
  <script type="text/javascript"  src="../lib_timeout_confirm/js/jquery-confirm.js"></script>

  <link rel="stylesheet" href="../popup/popup.css" />
  <?php 
    style_menu();
  ?>
  <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blah')
                      .attr('src', e.target.result)
                      .width(150)
                      .height(150);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <style type="text/css">
    	label {
    		color: blue;
    	}
    	#image{
    		padding-top:2%;
    		padding-left:25%;
    		float:left;
    		max-width: 40%;
    	}
    	#info{

    		padding-left:5%;
			  float:left;
    	}
    	.form-control {
    		display:inline;
    	}
      a{
        font-size: 16px;
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
        if($_SESSION['admin']==1 || $_SESSION['mode_user'] ==1 ){}else{
          echo "#image2{";
              echo "width: 66px !important;"; 
              echo "height: 66px !important;"; 
          echo "}";
          echo ".dropdown-content-icon{";         
              echo "min-width: 220px !important;";    
          echo "}"; 
           
        }
      ?>
    </style>
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
  
    <div id='image'>
	    <div>				 
				<?php
						$sql="SELECT * FROM `avatar` WHERE user= '$user';";
						$result=mysqli_query($link,$sql) or die(mysqli_error($link));
						if($result){
							while($row=mysqli_fetch_array($result))
							{
				?>				
							<center><img id="anh" src="../upload/<?php echo $row['file'];?>" width="150" height="150"></center>	
							<br>					
			 	<?php
				 			}
				 		}
				?>	
		</div>	
	    <div>
			<form action="" method="post" enctype="multipart/form-data">
				<center><input type="file" name="uploadfile" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple onchange="readURL(this);"/>
			<label id='img_profile' for="file-1" style="width:210px;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span style="font-size: 17px; "><?php   echo $txt_chonanh;?>&hellip;</span></label>
			<script src="../js/custom-file-input.js"></script>
				</center>
				<center><img id="blah"/></center>
			    <center><button   id='capnhat_anh_profile' class="button" type="submit" name="submitform"><?php  echo $txt_capnhatanh;?> </button></center>
			    <center><div id="result">  </div></center>
			</form>
		</div>
	</div>
	<div id='info'>
		<?php
			 
			$result = mysqli_query($link,"SELECT * FROM `users` WHERE username='$user'");
			while($row=mysqli_fetch_array($result)){
				$user=$row['username'];
				$email=$row['email'];
				$sdt=$row['sodt'];
			}
		?>
		<form action="" method="POST" role="form" enctype="multipart/form-data"> 
			<h2 style="color:red;"><?php  echo $txt_thongtinuser;?> </h2>
			<!--
            <div class="form-group">
                <label >Tên user</label>
                <input type="text" class="form-control" id="" placeholder="<?php //echo $user; ?>" name="user">
            </div>
        	-->
        	<div class="form-group">
                <label ><?php   echo $txt_dangnhaplancuoi;?>:</label>
                <label style="color:black;"><?php  
                			$query = "SELECT * FROM `users` where username='$user'";//chon du lieu tu database
        					$result= mysqli_query($link,$query) or die(mysqli_error($link));
        					while($row= mysqli_fetch_assoc($result)){
        						$last_login=$row['last_login'];
        						echo "$last_login";
        					}
                		?>
                </label>
            </div>
            <div class="form-group">
                <label >Email</label>
                <input minlength="8" type="email" class="form-control" id="" placeholder="<?php echo $email; ?>" name="email">
            </div>
            <div class="form-group">
                <label ><?php  echo $txt_sodienthoai;?></label>
                <input minlength="10" type="text" class="form-control" id="" placeholder="<?php echo $sdt; ?>" name="sdt">
            </div>
            <div class="form-group">
                <label ><?php   echo $txt_matkhaucu;?></label>
                <input minlength="8" type="password" class="form-control" id="" placeholder="" name="password_old" 
                  value="<?php 
                            if(isset($_POST['password_old'])) echo $_POST['password_old'];
                        ?>">  
                        <div style="color:red;"><?php
                            if($kiemtra==3){
                              echo $txt_nhapmkcu;
                               
                            }elseif($kiemtra==2){
                               echo $txt_matkhaucukodung;
                            }
                        ?></div>
            </div>
            <div class="form-group">
                <label ><?php echo $txt_matkhaumoi;?></label>
                <input minlength="8" type="password" class="form-control" id="" placeholder="" name="password_new"
                value="<?php 
                            if(isset($_POST['password_new'])) echo $_POST['password_new'];
                        ?>"><div style="color:red;"><?php
                          if($kiemtra==4){
                            echo $txt_nhapmkmoi;
                          }
                        ?></div>
            </div>
            <div class="form-group">
                <label ><?php echo $txt_nhaplaimkmoi;?></label>
                <input minlength="8" type="password" class="form-control" id="" placeholder="" name="confirm_password"
                value="<?php 
                            if(isset($_POST['confirm_password'])) echo $_POST['confirm_password'];
                        ?>"><div style="color:red;"><?php
                          if($kiemtra==5){
                            echo $txt_nhaplaimkmoi;
                             
                          }
                        ?></div>
            </div>
            <button type="submit" class="btn btn-primary" name="save"><?php   echo $txt_luuthaydoi;?></button>
            <br>
            <div style="color:red;"> 
            <?php 
            	if($kiemtra==1){
                echo $txt_matkhaukotrungkhop;
            	} elseif($kiemtra==6){
                echo "<div style='color:blue;'>".$txt_capnhatmkthanhcong."</div>";
              }elseif($kiemtra==7){
                echo "<div style='color:blue;'>".$txt_khongthaydoi."</div>";  
              }

              if($check_email==1){
                echo "<div style='color:blue;'>".$txt_capnhatemailthanhcong."</div>";  
                
              }elseif($check_email==2){
                echo "<div style='color:blue;'>".$txt_emailkothaydoi."</div>";  
               
              }
              if($check_sdt==1){
                echo "<div style='color:blue;'>".$txt_capnhatsdtthanhcong."</div>";  
              }elseif($check_sdt==2){
                echo "<div style='color:blue;'>".$txt_sdtkothaydoi."</div>";  
              }elseif($check_sdt==3){
                echo "<div style='color:blue;'>".$txt_sdtkonhapkytu."</div>";  
              }
             ?>
             </div>
        </form> 
	</div>
             <?php  facebook(); ?>    
</body>
</html>
  <script src="../popup/popup.js"></script>