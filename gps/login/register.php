<?php
    require '../library/db.php';
     date_default_timezone_set('Asia/Ho_Chi_Minh');
$_SESSION['username'] = $_POST['username'];
if(isset($_POST['checkbox']) && $_POST['checkbox'] == 'Yes')
{
 $mode_user = 1;
}
else
{
  $mode_user = 0;
}   


$username = $mysqli->escape_string($_POST['username']);
$password = $mysqli->escape_string($_POST['password']);
$confirm_password = $mysqli->escape_string($_POST['confirm_password']);
$email = $mysqli->escape_string($_POST['email']);
$sodt = $_POST['sodt'];
$user = $_SESSION['user'];
$result = $mysqli->query("SELECT * FROM users WHERE username='$username'") or die($mysqli->error());

if ( $result->num_rows > 0 ) {
    
    $_SESSION['message'] = 'User đã tồn tại!';
    header("location: error_admin.php");
     
}else if($password != $confirm_password){
	$_SESSION['message'] = 'Mật khẩu không trùng khớp!';
    header("location: error_admin.php");
}
else { 

    $sql = "INSERT INTO users( username,email, password,sodt,mode,timeout,soluongdong)  VALUES ('$username','$email','".md5($password)."','$sodt',$mode_user,30,15)";
    $mysqli->query($sql);
    $sql = "INSERT INTO soluong_thongbao(soluong_thongbao, user)  VALUES (0,'$username')";
    $mysqli->query($sql);

    //log
    mysqli_query($link, "INSERT INTO `log`(user,thongbao ,`date_time`) values ('$user','Tạo user $username' ,now())" );
    $_SESSION['message'] = 'Đăng ký thành công';
    header("location: success.php");

}