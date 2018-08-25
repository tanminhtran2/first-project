<?php
	require '../library/db.php';
	require '../library/function.php';
	check_timeout();   
	 
	if ( $_SESSION['logged_in'] != 1 ) {
	    $_SESSION['message'] =  "Bạn cần phải đăng nhập!";
	    header("location: ../login/error.php");    
	  }

	getlang();
	  if($_SESSION['ngonngu']==0){
	    $txt_tenuser= $array_vn[98];
	    $txt_xacnhan= $array_vn[99];
	    $txt_xacnhanemail= $array_vn[100];
	    $txt_xacnhansdt= $array_vn[101];
	    $txt_timeoutxacnhan= $array_vn[102];
	    $txt_timeout= $array_vn[103];
	  }else{
	    $txt_tenuser= $array_en[98];
	    $txt_xacnhan= $array_en[99];
	    $txt_xacnhanemail= $array_en[100];
	    $txt_xacnhansdt= $array_en[101];
	    $txt_timeoutxacnhan= $array_en[102];
	    $txt_timeout= $array_en[103];
	  }
?> 

<!DOCTYPE html>
<html>
<head>
	<title>Cài đặt user</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="../icon/icon.ico">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script src="../js/jquery.min.js-3.3.1.js"></script>
  	<link rel="stylesheet" href="../css/bootstrap.min.css-3.3.1.css">  <!-- menu css -->
   
  <!-- Latest compiled and minified JavaScript -->
	<link rel="stylesheet" type="text/css" href="../css/lichsu.css" />
	<script src="../js/jquery.menu-aim.js"></script> <!-- menu aim -->
	<script src="../js/function.js"></script>
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
		*{
			margin: 0px;
	 
		}
		div{
			position: relative;
		}
		#quanlyuser{
			float: left;
			padding-left: 15%;
	 		position: relative;
	 		z-index: 3;
		}
		#xacnhan{
			float: left ;
			padding-left: 55%;
			position: absolute;
			width: 100%;
			 
		}
		 
		table{
			table-layout: fixed;
			border-left: 1px solid gray;
			border-right:  1px solid gray;
		}
		.btn_xacnhan{
		    color:white ;
		    background-color:#5cb85c;  
		    border: 2px  ;
		    padding: 3px;
		    font-size: 14px;
		    -webkit-transition: .5s ease;
		    transition: .5s ease;
		}
		.btn_xacnhan:hover{
		     background-color: orange;  
		}
		#parent {
 
		}

		#childWrapper {
		    list-style: none;
		    margin: 0;
		    padding: 0;
		 
		}

		#childWrapper > li {
		    float: left;
 
		}

		#childWrapper > li:nth-child(even) {
 
		}
		.cd-dropdown{
			z-index: 4;
		}
	 	input{
	 		width: 80%;
	 		text-align: center;
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
	    @media only screen and (max-width: 500px) {
	    	#table{
		      margin-top:100px !important;
		   }
		}
	</style>
	 
</head>
<body>
	<?php bar_menu($link,$admin,$soluongthongbao); ?>
	<script type="text/javascript" language="javascript">
       $(document).ready(function() {
          $("#notify").click(function () {
          	$('#sothongbao').fadeOut('slow');
            document.getElementById("notify_drop").classList.toggle("show");
             $.ajax({
              	url: "../xuly/reset_thongbao.php",
              		success: function(result){

          			}
            });
          });
       });
    </script>
<div>
    <div id="quanlyuser" >
	    <table id = "table"  width="400" >
			<tr>
				<th id='ten_user' class='header'><?php echo $txt_tenuser; ?> </th>
				<th id='timeout'  class='header'><?php  echo $txt_timeout; ?></th>
				<th id='confirm'  class='header'><?php  echo $txt_xacnhan; ?></th>
			</tr>
			<?php
				$query = "SELECT * FROM `users` ";
				$result = mysqli_query($link, $query);

				if($result){
		        	while($row= mysqli_fetch_assoc($result)){
		        		$username=$row['username'];
		        		$check_admin=0;
		        		if($_SESSION['admin']==0 && $username=="$admin"){
		        			$check_admin=1;
		        		}else{
		        			$check_admin=0;
		        		}
		        		if($username!="" && $check_admin==0 ){

		        			$xacnhan=$row['xacnhan'];
		   					$timeout=$row['timeout'];
		   					$id=$row['id'];
				    		echo "<tr>";
				    		echo "<td><center class=''> ".$username." </center></td>" ;
			 
				    		echo "<td><center class=''><input id='".$id."' style='number' placeholder='".$timeout."'> </center></td>";
				    		echo "<input type='hidden' name='id' />";
				    		echo "<td><center><button class='btn_xacnhan' style='padding:5px;'  value='".$id."'>";
				    			 
				          			echo $txt_xacnhan;
				    		echo "</button></center></td> ";
				    	//	echo "</form>";
				    		echo "</td>";
		        		}
		        		
			    	}
			    }
			?>
		</table>
		
	</div>
	<div id="xacnhan">
		<?php  
			$query = "SELECT * FROM `users` WHERE username='$admin' ";
			$result = mysqli_query($link, $query);
			if($result){
				while($row= mysqli_fetch_assoc($result)){
					$xacnhan = $row['xacnhan'];
					if($xacnhan[0]==1){
						$send_email="checked";
					}else{
						$send_email='';
					}
					if($xacnhan[1]==1){
						$send_sdt="checked";
					}else{
						$send_sdt='';
					}
				}
			}
			 
		?>
		 
		 <div style=" ">
		    <ul id="childWrapper">
		        <li style="color:blue"> <?php  echo $txt_xacnhanemail; ?>: </li>
		        <li style="width:40px;"><?php echo "<input id='email' style='float:left'  class='checkbox'   type='checkbox' value='email' ".$send_email."> ";  ?> </li>
	 
		    </ul>
 		</div>
		 <br> <br> 
		<div style=" ">
			<ul id="childWrapper">
		        <li style="color:blue"><?php  echo $txt_xacnhansdt; ?>:  </li>
		        <li style="width:50px;"><?php echo "<input id='sdt' style='float:left' class='checkbox'   type='checkbox' value='sdt' ".$send_sdt."> ";  ?> </li>
	 
		    </ul>
		</div> 
	 
		 <br> <br> 
 		<?php  $result=mysqli_query($link,"SELECT * FROM `users` where id=1");
             while($row= mysqli_fetch_assoc($result)){
                $timeout_confirm=$row['timeout_confirm'];
             }
        ?>
      	<p class="" style="color:blue;float:left;margin-right: 5%; "><?php 
          			echo $txt_timeoutxacnhan;
          		?> : <input id="input_timeout_confirm" type="number" name="" placeholder="<?php echo $timeout_confirm;?>" style='margin-right: 5px;width:40px;'>
          		<span><?php   if(  $_SESSION['ngonngu']==0) echo "phút"; else echo "minute"; ?></span>
          		<button id="btn_timeout_confirm" class="btn_capnhat" style="" ><?php echo $txt_xacnhan;	?> </button>
         </p>
	</div>
</div>

			 <?php  facebook(); ?>
</body>
</html>
<script type="text/javascript">
	 $.ajax({
           url : "../xuly/get_lang_caidat_user.php",              
           type : "post",          // chọn phương thức gửi là post
           dataType:"json",           // dữ liệu trả về dạng text
           success : function (result){
                  $.each (result, function (key, item){
                    chuathaydoigiatri =  item['chuathaydoigiatri'];
					xacnhan_timedangxuat =  item['xacnhan_timedangxuat'];
					error_timedangxuat =  item['error_timedangxuat'];
					xacnhan_timeactive =  item['xacnhan_timeactive'];
					error_timeactive =  item['error_timeactive'];
					at_least_one = item['at_least_one'];
                  });
           }
      });
		$(document).ready(function(){
	      	$('.checkbox').on('click', function() {
	      		var n;
	      		var countChecked = function() {
				   n = $( "input:checked" ).length;
				};
				countChecked();
				if(n!=0){
					val = $(this).val();
					var checkbox = document.getElementById(val); 
				 
					$.ajax({
			                 url : "../xuly/get_lang.php",              
			                 type : "post",          // chọn phương thức gửi là post
			                 dataType:"json",           // dữ liệu trả về dạng text
			                 success : function (result){
			                        $.each (result, function (key, item){
			                              lang =  item['lang'];
			                              if(lang==0){
			                              	if(val=="email")
			                              		text="email";
			                              	else
			                              		text= "số điện thoại";
			                              	if (checkbox.checked) 
			                              		txt="bật";
			                              	else
			                              		txt="tắt";
			                              	$.confirm({
													            title: 'Cập nhật?',
													            content: 'Xác nhận '+txt+' gửi mã xác nhận về '+text+'.',
													            autoClose: 'Hủy|10000',
													            buttons: {
													                deleteUser: {
													                  text: 'Xác nhận',
													                  action: function () {
													                  	 
																			$.ajax({
														                     url:'../xuly/checkbox_xacnhan.php',
																             	method:'GET',
																             	data:{
																              		val:val
																            	},
														                       success : function (result){
														                              location.reload();
														                      }
														                    });
						                                             
													                    
													                  }
													                },
													                Hủy: function () {
													     				if (checkbox.checked) {
						                                                  //alert("checked");
						                                                  document.getElementById(val).checked = false;
						                                                }else{
						                                                  //alert("unchecked");
						                                                  document.getElementById(val).checked = true;
						                                                }
													                }
													            }
													        });
			                              }else{
			                              	if(val=="email")
			                              		text="email";
			                              	else
			                              		text= "phone number";
			                              	if (checkbox.checked) 
			                              		txt="turn on";
			                              	else
			                              		txt="turn off";
			                              	$.confirm({
												            title: 'Update?',
												            content: 'Confirm '+txt+' send validation code to '+text+'.',
												            autoClose: 'Cancel|10000',
												            buttons: {
												                deleteUser: {
												                  text: 'Confirm',
												                  action: function () {
												                  	 
						                                            	$.ajax({
													                      url:'../xuly/checkbox_xacnhan.php',
															             	method:'GET',
															             	data:{
															              		val:val
															            	},
													                       success : function (result){
													                              location.reload();
													                      }
													                    });
						                                          
												                  }
												                },
												                Cancel: function () {
												     				if (checkbox.checked) {
					                                                  //alert("checked");
					                                                  document.getElementById(val).checked = false;
					                                                }else{
					                                                  //alert("unchecked");
					                                                  document.getElementById(val).checked = true;
					                                                }
												                }
												            }
												        });
			                              }
			                               });
			                }
			        });

		           
		        }else{ //so luong check ==0
					$.alert(at_least_one);
		        	return false;
		        }
	      	});
		});
 
	 
    $('.btn_xacnhan').on('click', function () {
    	var id = $(this).val();
    	var timeout = $("#"+id).val();

    	 $.ajax({
                 url : "../xuly/get_lang.php",              
                 type : "post",          // chọn phương thức gửi là post
                 dataType:"json",           // dữ liệu trả về dạng text
                 success : function (result){
                        $.each (result, function (key, item){
                              lang =  item['lang'];
                              if(lang==0){
                              	$.confirm({
										            title: 'Cập nhật?',
										            content: xacnhan_timedangxuat,
										            autoClose: 'Hủy|10000',
										            buttons: {
										                deleteUser: {
										                  text: 'Xác nhận',
										                  action: function () {
										                  	if(!timeout){
										                  		$.alert(chuathaydoigiatri);
										                  	}else	if(timeout<=0){
			                                            		$.alert(error_timedangxuat);
			                                            	}else{
																$.ajax({
											                      url : "../xuly/capnhat_timeout.php",              // gửi ajax đến file result.php
											                      type : "post",          // chọn phương thức gửi là post
											                      dataType:"text",           // dữ liệu trả về dạng text
											                      //async:false,
											                      data : {               // Danh sách các thuộc tính sẽ gửi đi
											                        id:id,
											                        timeout:timeout
											                      },
											                       success : function (result){
											                              location.reload();
											                      }
											                    });
			                                            	}
										                    
										                  }
										                },
										                Hủy: function () {
										     
										                }
										            }
										        });
                              }else{
                              	$.confirm({
									            title: 'Update?',
									            content: xacnhan_timedangxuat,
									            autoClose: 'Cancel|10000',
									            buttons: {
									                deleteUser: {
									                  text: 'Confirm',
									                  action: function () {
									                  	if(!timeout){
										                  		$.alert(chuathaydoigiatri);
									                  	}else if(timeout<=0){
			                                            		$.alert(error_timedangxuat)
			                                            }else{
			                                            	$.ajax({
										                      url : "../xuly/capnhat_timeout.php",              // gửi ajax đến file result.php
										                      type : "post",          // chọn phương thức gửi là post
										                      dataType:"text",           // dữ liệu trả về dạng text
										                      //async:false,
										                      data : {               // Danh sách các thuộc tính sẽ gửi đi
										                        id:id,
										                        timeout:timeout
										                      },
										                       success : function (result){
										                              location.reload();
										                      }
										                    });
			                                            }
										                    
									                  }
									                },
									                Cancel: function () {
									     
									                }
									            }
									        });
                              }
                               });
                }
        });
    });
         

    	$('#btn_timeout_confirm').on('click', function () {
            $.ajax({
                 url : "../xuly/get_lang.php",              
                 type : "post",          // chọn phương thức gửi là post
                 dataType:"json",           // dữ liệu trả về dạng text
                 success : function (result){
                        $.each (result, function (key, item){
                              lang =  item['lang'];
                              if(lang==0){
                                  $.confirm({
                                      title: 'Cập nhật?',
                                      content: xacnhan_timeactive,
                                      autoClose: 'Hủy|10000',
                                      buttons: {
                                            xacnhan: {
                                            text: 'Xác nhận',
                                            action: function () {
                                              var timeout_confirm=$('#input_timeout_confirm').val();
                                                if(!timeout_confirm){
                                                	$.alert(chuathaydoigiatri)
                                                }else if(timeout_confirm<=0){
                                            		$.alert(error_timeactive)
                                            	}else{
                                            		$.ajax({
		                                                url : "../xuly/timeout_confirm.php",               
		                                                type : "post",          // chọn phương thức gửi là post
		                                                dataType:"text",           // dữ liệu trả về dạng text
		                                                data : {               // Danh sách các thuộc tính sẽ gửi đi
		                                                  timeout_confirm : timeout_confirm
		                                                },
		                                                success : function (result){
		                                                  location.reload();
		                                                }
		                                            });
                                            	}
                                              
                                            }
                                          },
                                          Hủy: function () {
                                             
                                          }
                                      }
                                  });
                              }else{
                                $.confirm({
                                            title: 'Update?',
                                            content: xacnhan_timeactive,
                                            autoClose: 'Cancel|10000',
                                            buttons: {
                                                  xacnhan: {
                                                  text: 'Confirm',
                                                  action: function () {
                                                    var timeout_confirm=$('#input_timeout_confirm').val();
                                                     if(!timeout_confirm){
                                                		$.alert(chuathaydoigiatri)
                                                	}else if(timeout_confirm<=0){
                                            			$.alert(error_timeactive)
                                            		}else{
                                            			$.ajax({
	                                                      url : "../xuly/timeout_confirm.php",               
	                                                      type : "post",          // chọn phương thức gửi là post
	                                                      dataType:"text",           // dữ liệu trả về dạng text
	                                                      data : {               // Danh sách các thuộc tính sẽ gửi đi
	                                                        timeout_confirm : timeout_confirm
	                                                      },
	                                                      success : function (result){
	                                                        location.reload();
	                                                      }
	                                                    });
                                            		}
                                                    
                                                  }
                                                },
                                                Cancel: function () {
                                                   
                                                }
                                            }
                                        });
                               }
                        });
                }
            });
        });
     
  </script>
  	<script src="../popup/popup.js"></script>