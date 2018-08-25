function DeleteUser(delUrl,user,ngonngu) {
  //if (confirm("Bạn có muốn xóa User này không?")) {
    //document.location = delUrl;
  //}
  if(ngonngu==0){
    $.confirm({
        title: 'Xóa user?',
        content: 'Bạn có muốn xóa user '+ user +' không?',
        autoClose: 'Hủy|10000',
        buttons: {
            logoutUser: {
                text: 'Xác nhận',
                action: function (){
                    document.location = delUrl;
                }
            },
            Hủy: function () {
                
            }
        }
    });
  }else{
    $.confirm({
        title: 'Delete user?',
        content: 'Do you want to delete user '+ user +'?',
        autoClose: 'Cancel|10000',
        buttons: {
            logoutUser: {
                text: 'Confirm',
                action: function (){
                    document.location = delUrl;
                }
            },
            Cancel: function () {
                
            }
        }
    });
  }
          
}
function DeleteThietbi(delUrl,tenthietbi,ngonngu) {
  if(ngonngu==0){
    $.confirm({
        title: 'Xóa thiết bị?',
        content: 'Bạn có muốn xóa thiết bị '+tenthietbi+' không?',
        autoClose: 'Hủy|10000',
        buttons: {
            logoutUser: {
                text: 'Xác nhận',
                action: function () {
                     document.location = delUrl;
                }
            },
            Hủy: function () {
                
            }
        }
    });
  }else{
    $.confirm({
        title: 'Delete device?',
        content: 'Do you want to delete device '+tenthietbi+'?',
        autoClose: 'Cancel|10000',
        buttons: {
            logoutUser: {
                text: 'Confirm',
                action: function () {
                     document.location = delUrl;
                }
            },
            Cancel: function () {
                
            }
        }
    });
  }
     
}
 $(function(){
          $(".lang").click(function () {
              var text = $(this).text();  //lay  thiet bi
              if(text==" English"){
                check=1;
              }else{
                check=0;
              }
             // alert(text);
              //var id = this.id;
              //alert(check);
              $.ajax({
                   url : "../xuly/lang.php",              
                   type : "get",          // chọn phương thức gửi là post
                   dataType:"text",           
                   //async:false, // bat dong bo = false
                   data : {               // Danh sách các thuộc tính sẽ gửi đi
                       check : check
                    },
                    success : function (result){
                       location.reload();
                     }
             });
      });
    });
 


 
 
    function plusDivs(n) {
      showDivs(slideIndex += n);
    }

    function currentDiv(n) {
      showDivs(slideIndex = n);
    }

    function showDivs(n) {
      var i;
      var x = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("demo");
      if (n > x.length) {slideIndex = 1}    
      if (n < 1) {slideIndex = x.length}
      for (i = 0; i < x.length; i++) {
         x[i].style.display = "none";  
      }
      for (i = 0; i < dots.length; i++) {
         dots[i].className = dots[i].className.replace(" w3-teal", "");
      }
      x[slideIndex-1].style.display = "block";  
      dots[slideIndex-1].className += " w3-teal";
    }
 
    function carousel() {

        var i;
        var x = document.getElementsByClassName("mySlides");
        for (i = 0; i < x.length; i++) {
           x[i].style.display = "none";  

        } 
        myIndex++;
        if (myIndex > x.length) {myIndex = 1}    
        x[myIndex-1].style.display = "block";  
         currentDiv(myIndex);
        setTimeout(carousel, 5000);    
    }
 function lancer() {
  poptuk('<center ><img  src="../icon/logo.png"><div>Công ty TNHH Kỹ Thuật Công Nghệ Tấn Thành</div><div>269/40 Phan Huy Ích, Phường 14, Quận Gò Vấp, Tp. Hồ Chí Minh.</div><div>Tel: 028 66.732.777 - HOTLINE: 0909.948.079</div><div>Email: info@tanthanh-tech.vn</div><div>Website: www.tanthanh-tech.vn</div></center>');
}