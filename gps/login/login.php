<?php
/* User login process, checks if user exists and password is correct */
require 'library/db.php';
// Escape email to protect against SQL injections
$username = $_POST['username'];
$query = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($link, $query);

if ( $result->num_rows == 0 ){ // User doesn't exist
    $_SESSION['message'] = "User không tồn tại!";
    header("location: login/error.php");
}
else { // User exists
    
    $user = $result->fetch_assoc();
    //echo "User exists";
    if($user['username'] == "$admin"){
        $_SESSION['admin'] = 1;
    }
    else{
        $_SESSION['admin'] = 0;
    }
    
    
   //if ($user['password'] == md5( $_POST['password'])  ) {
    if ($user['password'] == md5($_POST['password'])  ) { 
        $_SESSION['tentaikhoan']=$username; //de xuat ten tai khoan trong cac trang khac
        $_SESSION['mode_user'] = $user['mode'];
        $_SESSION['email'] = $user['email'];
         $_SESSION['user'] = $user['username'];
        
        header("Location: login/confirm.php");
    }
    else {
        $_SESSION['message'] = "Mật khẩu không đúng!";
        header("location: login/error.php");
    }
}

