<?php
  /* User login process, checks if user exists and password is correct */
  require '../library/db.php';
  // Escape email to protect against SQL injections
  $user =$_SESSION['tentaikhoan'];
  $code = $_POST['code'];
  $query = "SELECT * FROM users WHERE username = '$user'";
  $result = mysqli_query($link, $query);
  while($row = mysqli_fetch_array($result)){
    $code_db=$row['code'];
    $flag_code=$row['flag_code'];
   
  }
  if($code==$code_db && $flag_code==1){
    $_SESSION['logged_in'] = true;
    $_SESSION['timeout'] = time();
    $result = "UPDATE users  SET flag_code=0 WHERE username='$user'";
    $mysqli->query($result);
    
    //set time out cho user
    if($user!='$admin'){
      $query = "SELECT * FROM users WHERE username = '$user'";
      $result = mysqli_query($link, $query);
      while($row = mysqli_fetch_array($result)){
          $timeout=$row['timeout'];
      }
      $_SESSION['set_timeout'] = $timeout;
    }

    //cap nhat last login
    $query = "SELECT * FROM `users` where username='$user'";//chon du lieu tu database
    $result= mysqli_query($link,$query) or die(mysqli_error($link));
    while($row= mysqli_fetch_assoc($result)){
      $last_activity=$row['last_activity'];
      $_SESSION['ngonngu']=$row['ngonngu'];
    }

    $query = "UPDATE `users` SET last_login = '$last_activity',last_activity=now() WHERE username='$user'";
    mysqli_query($link, $query);
      mysqli_query($link, "INSERT INTO log(user, thongbao,date_time) VALUES ('$user', 'Đăng nhập',now())");
      mysqli_query($link, "INSERT INTO log_en(user, thongbao,date_time) VALUES ('$user', 'Login',now())");
    header("Location: ../map/thongtin.php");
  }else{
    $_SESSION['message'] = "Mã xác nhận không đúng";
    header("location:  error.php");
  }
?>

