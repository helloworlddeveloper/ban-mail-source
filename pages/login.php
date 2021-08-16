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
                                    <h4 class="mt-0 mb-3 mt-5">Đăng nhập </h4>
                                    <p class="text-muted mb-0">Điền thông tin tài khoản của bạn vào bên dưới.</p>  
                                </div> <!--end auth-logo-text-->  

                                
                               <div class="form-horizontal auth-form my-4">
        
                                    <div class="form-group">
                                        <label for="username">Tài khoản</label>
                                        <div class="input-group mb-3">
                                            <span class="auth-form-icon">
                                                <i class="dripicons-user"></i> 
                                            </span>                                                                                                              
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tài khoản">
                                        </div>                                    
                                    </div><!--end form-group--> 
        
                                    <div class="form-group">
                                        <label for="pass">Mật khẩu</label>                                            
                                        <div class="input-group mb-3"> 
                                            <span class="auth-form-icon">
                                                <i class="dripicons-lock"></i> 
                                            </span>                                                       
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu">
                                        </div>                               
                                    </div><!--end form-group--> 
        
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-6">
                                            <div class="custom-control custom-switch switch-success">
                                                <input type="checkbox" class="custom-control-input" id="customSwitchSuccess">
                                                <label class="custom-control-label text-muted" for="customSwitchSuccess">Ghi nhớ </label>
                                            </div>
                                        </div><!--end col--> 
                                        <div class="col-sm-6 text-right">
                                            <a href="#" class="text-muted font-13"><i class="dripicons-lock"></i> Quên mật khẩu?</a>                                    
                                        </div><!--end col--> 
                                    </div><!--end form-group--> 
        
                                    <div class="form-group mb-0 row">
                                        <div class="col-12 mt-2">
                                            <button id="submit" type="submit" name="submit" class="btn btn-primary btn-round btn-block waves-effect waves-light " type="button">Đăng Nhập <i class="fas fa-sign-in-alt ml-1"></i></button>
                                        </div><!--end col--> 
                                    </div> <!--end form-group-->                           
                                </div><!--end form-->
                            </div><!--end /div-->
                            
                            <div class="m-3 text-center text-muted">
                                <p class="">Chưa có tài khoản ?  <a href="/signup" class="text-primary ml-2">Đăng Ký Ngay</a></p>
                            </div>
                        </div><!--end card-body-->
                    </div><!--end card-->
                    <div class="account-social text-center mt-4">
                        <h6 class="my-4">Login With</h6>
                        <ul class="list-inline mb-4">
                            <li class="list-inline-item">
                                <a href="" class="">
                                    <i class="fab fa-facebook-f facebook"></i>
                                </a>                                    
                            </li>
                            <li class="list-inline-item">
                                <a href="" class="">
                                    <i class="fab fa-twitter twitter"></i>
                                </a>                                    
                            </li>
                            <li class="list-inline-item">
                                <a href="" class="">
                                    <i class="fab fa-google google"></i>
                                </a>                                    
                            </li>
                        </ul>
                    </div><!--end account-social-->
                </div><!--end auth-page-->
            </div><!--end col-->           
        </div><!--end row-->
        <!-- End Log In page -->
        <script type="text/javascript">
        $('#submit').click(function(){
            var username = $('#username').val();
            var password = $('#password').val();
                if (!username) {
                    swal("Vui Lòng Nhập Tài Khoản","error");
                    return false;
                }
                else if (!password) {
                swal("Vui Lòng Nhập Mật Khẩu","error");
                return false;
                }
                $('#submit').prop('disabled', true)
                $.post('../post/login.php', {
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
        <!-- jQuery  -->
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