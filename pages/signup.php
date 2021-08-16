<?php
session_start();
if(isset($_SESSION['username'])){
	header('location: /home');
	die();
}
include('../core/database.php');
include('../layout/header.php');

?>
  <body class="account-body accountbg">
        <!-- Log In page -->
        <div class="row vh-100 ">
            <div class="col-12 align-self-center">
                <div class="auth-page">
                    <div class="card auth-card shadow-lg">
                        <div class="card-body">
                            <div class="px-3">
                                <div class="auth-logo-box">
                                    <a href=" " class="logo logo-admin"><img src="https://i.imgur.com/Lb7Tt1O.png" height="55" alt="logo" class="auth-logo"></a>
                                </div><!--end auth-logo-box-->
                                
                                <div class="text-center auth-logo-text">
                                    <h4 class="mt-0 mb-3 mt-5">Đăng Ký </h4>
                                    <p class="text-muted mb-0">Điền thông tin tài khoản của bạn vào bên dưới.</p>  
                                </div> <!--end auth-logo-text-->  

                                
                               <div class="form-horizontal auth-form my-4">
        
                                 

                                    <div class="form-group">
                                        <label for="username">Tài Khoản</label>
                                        <div class="input-group mb-3">
                                            <span class="auth-form-icon">
                                                <i class="dripicons-user"></i> 
                                            </span>                                                                                                              
                                            <input type="text" class="form-control"name="username" id="username" placeholder="Nhập tài khoản">
                                        </div>                                    
                                    </div><!--end form-group-->

                                    <div class="form-group">
                                        <label for="useremail">Email</label>
                                        <div class="input-group mb-3">
                                            <span class="auth-form-icon">
                                                <i class="dripicons-mail"></i> 
                                            </span>                                                                                                              
                                            <input type="text" class="form-control" type="email"  name="email" id="email" placeholder="Nhập email">
                                        </div>                                    
                                    </div> <!--end form-group-->
                                    
                                    <div class="form-group">
                                        <label for="userpassword">Mật khẩu</label>                                            
                                        <div class="input-group mb-3"> 
                                            <span class="auth-form-icon">
                                                <i class="dripicons-lock"></i> 
                                            </span>                                                       
                                            <input type="password" class="form-control" name="password"  id="password" placeholder="Nhập mật khẩu">
                                        </div>                               
                                    </div><!--end form-group--> 
                                      <div class="form-group">
                                        <label for="userpassword">Nhập lại mật khẩu</label>                                            
                                        <div class="input-group mb-3"> 
                                            <span class="auth-form-icon">
                                                <i class="dripicons-lock"></i> 
                                            </span>                                                       
                                            <input class="form-control" name="repassword" type="password"  id="repassword" placeholder="Nhập mật khẩu">
                                        </div>                               
                                    </div><!--end form-group--> 

                                  
        
                                    <!-- <div class="form-group row mt-4">
                                        <div class="col-sm-12">
                                            <div class="custom-control custom-switch switch-success">
                                                <input type="checkbox" class="custom-control-input" id="customSwitchSuccess">
                                                <label class="custom-control-label text-muted" for="customSwitchSuccess">Tôi đồng ý với <a href="#" class="text-primary">Terms of Use</a></label>
                                            </div>
                                        </div>                                             
                                    </div> -->
        
                                    <div class="form-group mb-0 row">
                                        <div class="col-12 mt-2">
                                            <button id="submit" onclick="submit();" class="btn btn-primary btn-round btn-block waves-effect waves-light btnRegister" type="button">Đăng Ký <i class="fas fa-sign-in-alt ml-1"></i></button>
                                        </div><!--end col--> 
                                    </div> <!--end form-group-->                           
                                </form><!--end form-->
                            </div><!--end /div-->
                            
                            <div class="m-3 text-center text-muted">
                                <p class="">Đã có tài khoản ? <a href="/" class="text-primary ml-2">Đăng Nhập Ngay </a></p>
                            </div>
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div><!--end auth-card-->
            </div><!--end col-->           
        </div><!--end row-->
        <!-- End Log In page -->
    <script type="text/javascript">

         $('#submit').click(function(){
            	var email = $('#email').val();
			var username = $('#username').val();
			var password = $('#password').val();
			var repassword = $('#repassword').val();
				if (  !email || !username || !password || !repassword) {
					swal("Vui Lòng Điền Thông Tin Yêu Cầu","error");
					return false;
				}
				$('#submit').prop('disabled', true)
				$.post('../post/signup.php', {			
				repassword: repassword,
				email: email,
			        username: username,
				password: password
				}, function(data, status) {
			        $("#trave").html(data);
				$('#submit').prop('disabled', false);
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

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        <script src="../assets/auth/js/jquery.min.js"></script>
        <script src="../assets/auth/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/auth/js/metisMenu.min.js"></script>
        <script src="../assets/auth/js/waves.min.js"></script>
        <script src="../assets/auth/js/jquery.slimscroll.min.js"></script>
        <!-- Sweet-Alert  -->
        <!-- App js -->
        <script src="../assets/auth/js/app.js"></script>
   

       
    </body>
</html>