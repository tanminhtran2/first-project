<?php   
	require '../library/db.php';
	require '../library/Pagination.php';
	$total_page = $_GET['total_page'];	//nam-thang-ngay
	 
	$thietbi='';
	if(isset($_GET['thietbi']) ){//neu ton tai bien nay
		$thietbi=$_GET['thietbi'];
	}
	
	$current_page = $_GET['current_page'];
	$config = [
		'total' => $total_page, 
		'limit' => 1,
		'full' => false,
		'querystring' => 'page',
		'thietbi' => $thietbi,//cho lich su
		'ajax' => 1,
		'current_page' => $current_page,
		'thongbao' => 0
		];
		$page = new Pagination($config);
		echo $page->getPagination();
	 
?>