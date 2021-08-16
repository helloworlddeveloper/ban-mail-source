<?php
session_start();
if(empty($_SESSION['username'])){
	session_destroy();
	header('location: /');
	die();
}
include('../core/database.php');
include('../layout/head.php');
date_default_timezone_set("Asia/Ho_Chi_Minh");
?>
<div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing">
                        <div class="col-lg-12 col-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                         <center>   <h4>Cập nhật thông tin</h4></center>
                                        
                                    </div>
                                </div>
                                <div class="widget-content animated-underline-content">
                                  
                                    <ul class="nav nav-tabs mb-2" id="animateLine" role="tablist">
                                   
                                        <li class="nav-item">
                                            <a class="nav-link active" id="animated-underline-profile-tab" data-toggle="tab" href="#animated-underline-profile" role="tab" aria-controls="animated-underline-profile" aria-selected="true"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> Thông Tin</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="animated-underline-contact-tab" data-toggle="tab" href="#animated-underline-contact" role="tab" aria-controls="animated-underline-contact" aria-selected="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg> Đổi Mật Khẩu</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="animateLineContent-4">
                               
                                        <div class="tab-pane fader show active" id="animated-underline-profile" role="tabpanel" aria-labelledby="animated-underline-profile-tab">
                                        <form>
                                        <div class="form-group">
                  <label for="">Tên tài khoản</label>
                  <input type="text" title="Tên Tài Khoản" class="form-control bs-tooltip" value="<?= $data['username']; ?>" readonly>
                </div> 
                   <div class="form-group">
                  <label for="">Số dư</label>
                  <input type="text" title="Số Dư Hiện Có" class="form-control bs-tooltip" value="<?= $data['cash']; ?> VNĐ" readonly>
                </div>
                                          <div class="form-group">
		  <label for="">Email</label>
		  <input type="email" id="email" class="form-control bs-tooltip" title="Email" placeholder="Email" value="<?= $data['email']; ?>">
		</div>
		                                          <div class="form-group">
		  <laai bel for="">Họ và tên</label>
		  <input type="text" id="fullname" class="form-control bs-tooltip" title="Họ và tên" placeholder="Họ và tên" value="<?= $data['fullname']; ?>">
		</div>
		
		<div class="form-group">
                  <label for="">Thời gian tham gia:</label>
                  <input type="text" title="Thời Gian Tham Gia" class="form-control bs-tooltip" value="<?= $data['time']; ?>" readonly>
                </div> 
                <div class="form-group">
                  <label for="">User Agent</label>
                  <input type="text" title="User Agent" class="form-control bs-tooltip" value="<?= $data['useragent']; ?>" readonly>
                </div>
		<div class="form-group text-center">
		    <button type="button" class="btn btn-dark" id="update"><i class="fa fa-save"></i> Cập nhật</button>
        </div>  
        </form>
                                        </div>
                                        <div class="tab-pane fade" id="animated-underline-contact" role="tabpanel" aria-labelledby="animated-underline-contact-tab">
                                              <form>
                                          <div class="form-group">
		  <label for="">Mật khẩu cũ</label>
		  <input type="password" id="passold" class="form-control bs-tooltip" title="Mật Khẩu Cũ" placeholder="Mật Khẩu Cũ">
		</div>
		                                          <div class="form-group">
		  <label for="">Mật khẩu mới</label>
		  <input type="password" id="password" class="form-control bs-tooltip" title="Mật Khẩu Mới" placeholder="Mật Khẩu Mới">
		         </div> 
		           <div class="form-group">
	  <label for="">Nhập lại mật khẩu mới</label>
		   <input type="password" id="repassword" class="form-control bs-tooltip" title="Nhập lại mật Khẩu Mới" placeholder="Nhập lại mật Khẩu Mới" >
	
	</div> 
		<div class="form-group text-center">
		    <button type="button" class="btn btn-dark" id="change"><i class="fa fa-save"></i> Cập nhật</button>
        </div>  
        </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        </div>
                            </div>
                        </div>
                        
<script type="text/javascript">

            $('#change').click(function(){
            	var password = $('#password').val();	
            		var passold = $('#passold').val();
			var repassword = $('#repassword').val();
				if (!passold) {
					swal("Vui Lòng Nhập Mật Khẩu Cũ","error");
					return false;
				} 
				else if (!password) {
					swal("Vui Lòng Nhập Mật Khẩu Mới","error");
					return false;
				} 
				else if (!repassword){
				swal("Vui Lòng Nhập Lại Mật Khẩu Mới","error");
					return false; 
				}
				
				$('#change').prop('disabled', true).html('<i class="fa fa-refresh fa-spin"></i> Đang Xử Lý')
				$.post('../post/password.php', {
					password: password,
					passold: passold,
					repassword: repassword
				}, function(data, status) {
					$("#trave").html(data);
					$('#change').prop('disabled', false).html('<i class="fa fa-save"></i> Cập nhật');
				});
			});
			
            $('#update').click(function(){
            	var email = $('#email').val();	
            		var fullname = $('#fullname').val();
			var phone = $('#phone').val();
				if (!email) {
					swal("Vui Lòng Nhập Email","error");
					return false;
				} 
				else if (!fullname) {
					swal("Vui Lòng Nhập Họ Và Tên","error");
					return false;
				} 
				else if (!phone){
				swal("Vui Lòng Nhập Số Điện Thoại","error");
					return false; 
				}
				
				$('#update').prop('disabled', true).html('<i class="fa fa-refresh fa-spin"></i> Đang Xử Lý')
				$.post('../post/info.php', {
					email: email,
					passold: passold,
					repassword: repassword
				}, function(data, status) {
					$("#trave").html(data);
					$('#update').prop('disabled', false).html('<i class="fa fa-save"></i> Cập nhật');
				});
			}); 
</script>
<div id="trave" style="display: none;">
	</div>
		<script type="text/javascript">
            function toarst(status, msg, title) {
         Command: toastr[status](msg, title)
            toastr.options = {
            "closeButton": true,
            "debug": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "onclick": null,
            "showDuration": "400",
            "hideDuration": "1000",
            "timeOut": "4000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "slideDown",
            "hideMethod": "slideUp"
        }
    }
</script>
<?php
require_once '../layout/script.php';
?>