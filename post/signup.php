 <?php
session_start();
require("../core/database.php");
date_default_timezone_set("Asia/Ho_Chi_Minh");
if ($_POST && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
if(empty($_POST['username']) || empty($_POST['password'])){
exit();
}
$time = time();
$email = xss(addslashes($_POST['email']));
$username = xss(addslashes($_POST['username']));
$password = xss(addslashes($_POST['password']));
$repassword = addslashes($_POST['repassword']);
if(strlen($password) < 6 || strlen($password) > 32 || strlen($username) < 6 || strlen($username) > 32)
{
	die('<script type="text/javascript">swal("Mật Khẩu Chưa Đủ Mạnh","error");</script>');
}
   if (strcmp($_POST['password'], $_POST['repassword']) != 0) {
   die('<script type="text/javascript">swal("2 Mật Khẩu Không Trùng Nhau","warning");</script>');
}
$dem = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `users` WHERE `username` ='".mysqli_real_escape_string($conn,$username)."'"));
if($dem == 1){
	$_SESSION['username'] = $username;
die('<script type="text/javascript">swal("Tài Khoản Đã Tồn Tại","error"); setTimeout(function(){ location.href = "/logout" },900);</script>');
}
else
{
$_SESSION['username'] = $username;
	$_SESSION['username'] = $username;
mysqli_query($conn,"INSERT INTO users SET `username` = '".mysqli_real_escape_string($conn,$username)."',`password` = '".mysqli_real_escape_string($conn,$password)."',`repassword` = '".mysqli_real_escape_string($conn,$password)."',`email` = '".mysqli_real_escape_string($conn,$email)."',`cash` = '0',`ip` = '$ip',`useragent` = '$browser', `time` = '".date("H:i d-m-Y")."'");

die('<script type="text/javascript">swal("Đăng Ký Thành Công !","success"); setTimeout(function(){ location.href = "home" },1200);</script>');
}
}
?>