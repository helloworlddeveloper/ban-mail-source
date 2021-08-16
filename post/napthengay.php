<?php
session_start();
include('../core/database.php');
date_default_timezone_set('Asia/Ho_Chi_Minh');
set_time_limit(0);
$seri = isset($_POST['dSeri']) ? xss(addslashes($_POST['dSeri'])) : '';
$sopin = isset($_POST['dPin']) ? xss(addslashes($_POST['dPin'])) : '';
$card_value = isset($_POST['dCount']) ? xss(addslashes($_POST['dCount'])) : '';
//Loai the cao (VINA, MOBI, VIETEL, VTC, GATE)
$mang = isset($_POST['dCategory']) ? xss(addslashes($_POST['dCategory'])) : '';
$user = $_SESSION['username'];

if($user){
if($mang==2){
        $ten = "Mobifone";
    }
else if($mang==1){
        $ten = "Vietel";
    }
else $ten ="Vinaphone"; //id = 3 la mang VINA
$api_email = $setup['napthengay-email'];
    $merchant_id = $setup['napthengay-id'];
    $secure_code = $setup['napthengay-code'];
$trans_id = time();  //mã giao dịch do bạn gửi lên, Napthengay.com sẽ trả về 
$api_url = 'http://api.napthengay.com/v2/';


$arrayPost = array(
    'merchant_id'=>intval($merchant_id),
    'api_email'=>trim($api_email),
    'trans_id'=>trim($trans_id),
    'card_id'=>trim($mang),
    'card_value'=> intval($card_value),
    'pin_field'=>trim($sopin),
    'seri_field'=>trim($seri),
    'algo_mode'=>'hmac'
);


$data_sign = hash_hmac('SHA1',implode('',$arrayPost),$secure_code);

$arrayPost['data_sign'] = $data_sign;

$curl = curl_init($api_url);

curl_setopt_array($curl, array(
    CURLOPT_POST=>true,
    CURLOPT_HEADER=>false,
    CURLINFO_HEADER_OUT=>true,
    CURLOPT_TIMEOUT=>120,
    CURLOPT_RETURNTRANSFER=>true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_POSTFIELDS=>http_build_query($arrayPost)
));

$data = curl_exec($curl);

$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

$result = json_decode($data,true);

$time = time();

if($status==200){
    $amount = $result['amount'];
    switch($amount) {
        case 10000: $xu = 7500; break;
        case 20000: $xu = 15000; break;
        case 50000: $xu = 37500; break;
        case 100000: $xu = 75000; break;
        case 200000: $xu = 150000; break;
        case 500000: $xu = 375000; break;
    }
    
    if($result['code'] == 100){
        mysqli_query($conn, "UPDATE users SET cash = `cash` + '$xu' WHERE username='$user'");
        mysqli_query($conn, "INSERT INTO napthe (username, count_card, status_card, pin_card, seri_card, time) VALUES ('$user', '$card_value', '1', '$sopin', '$seri', $time)");
         $success = $result['msg'];
        echo json_encode(array("status" => "success","code"=>$result['code'],"msg"=>"Nạp Thẻ Thành Công ! Chúc Bạn 1 Ngày Vui Vẻ"));
    }else{
        $error = $result['msg'];
        if($result['code']=="108"){
            $error = "Nạp Thẻ Thất Bại, Thẻ Sai Hoặc Đã Sử Dụng";
        }
        mysqli_query($conn, "INSERT INTO napthe (username, count_card, status_card, pin_card, seri_card, time) VALUES ('$user', '$card_value', '0', '$sopin', '$seri', $time)");
        echo json_encode(array("status" => "error","code"=>$result['code'],"msg"=>$error));
    }
}
else{ 
    echo json_encode(array("status" => "waring","code"=>$status,"msg"=>"Máy Chủ Gặp Sự Cố"));
}
}else{ echo json_encode(array("status" => "waring","code"=>null,"msg"=>"Vui Lòng Đăng Nhập Lại")); }

?>
