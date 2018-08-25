<?php  
	header("Content-type: text/html; charset=utf-8");
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$host = 'localhost';
	$user = 'root';
	$pass = '';
	$db = 'gps';
	$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);
	$link = mysqli_connect($host,$user,$pass,$db) or die ('Không thể kết nối tới database');
	$link->set_charset('utf8');
	$mysqli->set_charset('utf8');
	 
	$admin="administrator";

	$soluongthongbao=7;
	
	$token ="614016914:AAFOqAUKurE5vu7Gp9C8EGbqKhnO26q4Esg";
    $user_id = -266626652;
    
	if(!isset($_SESSION)){ 
		session_start();
	}
	if (!function_exists('check_timeout'))   {
		function check_timeout(){
			if(isset($_SESSION['set_timeout'])){
		  		if ($_SESSION['timeout'] + 60*$_SESSION['set_timeout'] < time()) {
		        	session_unset();
		       		session_destroy();
		    	}
		  	}
		}
	}
	  $result_l=mysqli_query($link,"SELECT * FROM `languages` ");
	  $i=1;
	  while($row_l=mysqli_fetch_array($result_l))
	  {
	    $array_vn[$i] = $row_l['vn'];
	    $array_en[$i] = $row_l['en'];
	    $i++;
	  }
	  $i=0;

	 
?>