<?php

include('./core/database.php');
session_start();
if(empty($_SESSION['username'])){
	header('location: /login');
	die();
}
else{
header('location: /home');
die();
}

?>