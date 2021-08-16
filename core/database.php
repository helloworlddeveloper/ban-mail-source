<?php

error_reporting(0);
session_start();
date_default_timezone_set("Asia/Ho_Chi_Minh");
require_once 'information.php';
$conn = mysqli_connect(LOCALHOST,USERNAME,PASSWORD,DATABASE);
mysqli_set_charset($conn,"utf8");

if(isset($_SESSION['username'])){
  $username = $_SESSION['username'];
  $data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `users` WHERE `username` = '$username'"));

}
  $setup = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `setting` WHERE id='1'"));

$ip = $_SERVER['REMOTE_ADDR'];
if (!empty($_SERVER['WWW_HTTP_CLIENT_IP']))
{
    $ip = $SERVER['WWW_HTTP_CLIENT_IP'];
} else if
(!empty($_SERVER['WWW_HTTP_X_FORWARDED_FOR'])){
    $ip =
    $_SERVER['WWW_HTTP_X-FORWARDED_FOR'];
}
$browser = $_SERVER['HTTP_USER_AGENT'];


require_once 'func.php';

?>