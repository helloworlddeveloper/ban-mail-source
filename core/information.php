<?php
define("HACKER","Aduk Hacker Kìa !");
define("DATABASE", "namjsc");
define("USERNAME", "namjsc");
define("PASSWORD", "namjsc");
define("LOCALHOST", "localhost");
$system = array( // cấu hình thông tin hệ thống
    'title' => 'Hệ thông bán clone giá rẻ - uy tín - chất lượng', // tiêu đề hệ thống
    'domain' => '', // tên miền hệ thống
    'admin' => '', // tên của quản trị viên
    'idfb' => '4', // id facebook của quản trị viên
    'phone' => '', // số điện thoại quản trị viên
    'username' => 'Hoangskeam', // tên đăng nhập mặc định sẽ là quản trị viên
    'napthengay' => array( // cấu hình thông tin nạp thẻ qua api napthengay.com
        'api_email' => 'duyhoangoffical@gmail.com', // email của tài khoản nạp thẻ ngay checkpass110506
        'merchant_id' => '5119', // mã merchant_id của api 
        'secure_code' => 'e09919335daa0c19a59fc6c747bc6985' // mã secure của api
    )
);
$day = date('d',time());
$month = date('m',time());
$year = date('Y',time()); 

?>