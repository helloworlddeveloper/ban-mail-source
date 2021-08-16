<?php
session_start();
include("../core/database.php");
if ($_POST && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
if(empty($_POST['username']) || empty($_POST['password'])){
exit();
}
$username = addslashes($_POST['username']);
$password = addslashes($_POST['password']);
if(strlen($password) < 6 || strlen($password) > 32 || strlen($username) < 6 || strlen($username) > 32)
{
	die('<script type="text/javascript">swal("Bạn Nhập Không Đủ Ký Tự","error");</script>');
}
$dem = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `users` WHERE `username` ='".mysqli_real_escape_string($conn,$username)."'"));
if($dem == 1){
	$dem = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `users` WHERE `username` ='".mysqli_real_escape_string($conn,$username)."' AND `password` = '".mysqli_real_escape_string($conn,$password)."'"));
	if($dem == 1){
	$_SESSION['username'] = $username;
	mysqli_query($conn, "INSERT INTO `history-log` (username, useragent, ip, time) VALUES ('$username', '$browser', '$ip','".date("H:i d-m-Y")."')"); 
	die('<script type="text/javascript">swal("Đăng Nhập Thành Công","success"); setTimeout(function(){ location.href = "/home" },1450);</script>');
	}else{
	die('<script type="text/javascript">swal("Tài Khoản Hoặc Mật Khẩu Của Bạn Chưa Chính Xác","error");</script>');
	}
}
else
{
die('<script type="text/javascript">swal("Xin Lỗi! Tài Khoản Này Không Tồn Tại","error");</script>');
}
}
?>