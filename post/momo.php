<?php
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
    header('Content-Type: application/json');
    include('../core/database.php');
    //ddang loi noi dung momo

    if(!isset($_GET['code'])){
        echo json_encode([
            'code'   => 400,
            'status' => 'error',
            'msg'    => 'Bad Request',
        ],JSON_PRETTY_PRINT);
        die();
    }
    $tran_code = $_GET['code'];
    $user = $setup['gmail-momo-api']; //điền gmail vô
    $pass = $setup['pass-momo-api']; //pas ứng dụng 
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $d = date('d', strtotime("-1 days"));
    $m = date('m', strtotime("-1 days"));
    $y = date('Y', strtotime("-1 days"));
    $m = date('F', mktime(0, 0, 0, $m, 10));
    $date = $d. ' ' . $m . ' ' . $y;

    $server = "{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX";
    if (! function_exists('imap_open')) {
        echo "IMAP is not configured.";

        echo json_encode([
                'code'   => 200,
                'status' => '',
                'msg'    => 'IMAP is not configured',
            ]);

        die();
    } else {
        $connection = imap_open($server, $user, $pass) or die('Cannot connect to Gmail: ' . imap_last_error());

        $emailData = imap_search($connection, 'FROM "no-reply@momo.vn" SINCE "'.$date.'"');
        if (! empty($emailData)) {
            foreach ($emailData as $emailIdent) {
                $overview = imap_fetch_overview($connection, $emailIdent, 0);
                if(preg_match("/Giao dịch thành công/",imap_utf8($overview[0]->subject))) continue;
                $message = ((imap_fetchbody($connection, $emailIdent,1)));
                $message = preg_replace( "/\s+/", " ", $message);
                preg_match('/(?<=li= ne-height: 1.2em; font-weight: 500;"> )(.*?)(?= <\/td>)/', $message, $matches);
                $money =  ($matches[0]);
                preg_match('/(?<=height: 1.55em;" width=3D"50%"> <div style=3D"color:#3C4043;margin:0px;font-size:12px;li= ne-height:22px; font-weight: normal; font-size: 15px; padding-right: 10px;= "> M=C3=A3 giao d=E1=BB=8Bch<\/div> <\/td> <td class=3D"" style=3D"padding-top: 5px; padding-bottom: 5px; font-si= ze: 14px; font-family: Helvetica Neue, Arial, sans-serif; color: #3C4043; t= ext-align: left; line-height: 1.55em;" width=3D"50%"> <div style=3D"color:#3C4043;margin:0px;font-size:12px;li= ne-height:22px; font-weight: normal; font-size: 15px;"> )(.*?)(?=<\/div>)/', $message, $matches);
                $code =  ($matches[0]);

                preg_match('/(?<=ADi<\/div> <\/td> <td class=3D"" style=3D"padding-top: 5px; padding-bottom: 5px; font-si= ze: 14px; font-family: Helvetica Neue, Arial, sans-serif; color: #3C4043; t= ext-align: left; line-height: 1.55em;" width=3D"50%"> <div style=3D"color:#3C4043;margin:0px;font-size:12px;li= ne-height:22px; font-weight: normal; font-size: 15px;"> )(.*?)(?=<\/div>)/', $message, $matches);
                $name =  str_replace("=",'%',$matches[0]);
                $name =  str_replace("%\s",'',$name);
                $name =  urldecode($name);
                preg_match('/(?<=tho=E1=BA=A1i ng=C6=B0= =E1=BB=9Di g=E1=BB=ADi<\/div> <\/td> <td class=3D"" style=3D"padding-top: 5px; padding-bottom: 5px; font-si= ze: 14px; font-family: Helvetica Neue, Arial, sans-serif; color: #3C4043; t= ext-align: left; line-height: 1.55em;" width=3D"50%"> <div style=3D"color:#3C4043;margin:0px;font-size:12px;li= ne-height:22px; font-weight: normal; font-size: 15px;"> )(.*?)(?=<\/div>)/', $message, $matches);
                $phone =  str_replace("=",'%',$matches[1]);
                preg_match('/(?<=gian<\/div> <\/td> <td class=3D"" style=3D"padding-top: 5px; padding-bottom: 5px; font-si= ze: 14px; font-family: Helvetica Neue, Arial, sans-serif; color: #3C4043; t= ext-align: left; line-height: 1.55em;" width=3D"50%"> <div style=3D"color:#3C4043;margin:0px;font-size:12px;li= ne-height:22px; font-weight: normal; font-size: 15px;"> )(.*?)(?=<\/div>)/', $message, $matches);
                $time =  str_replace("=",'%',$matches[1]);
                preg_match('/(?<=ch=C3=BAc<\/div> <\/td> <td class=3D"" style=3D"padding-top: 5px; padding-bottom: 5px; font-si= ze: 14px; font-family: Helvetica Neue, Arial, sans-serif; color: #3C4043; t= ext-align: left; line-height: 1.55em;" width=3D"50%"> )(.*?)(?=<\/div>)/', $message, $matches);
             $content =  str_replace('<div style="color:#3C4043;margin:0px;font-size:12px;li% ne-height:22px; font-weight: normal; font-size: 15px;"> ','',urldecode(str_replace("=",'%',$matches[1])));
                if($tran_code == $code){
                    echo json_encode([
                        'code'   => 200,
                        'status' => 'success',
                        'msg'    => 'Nạp '.$money.' VND thành công',
                        'data'   => [
                            'money' => $money,
                            'code' => $code,
                            'name' => $name,
                            'phone' => $phone,
                            'time' => $time,
                            'content' => $content,
                        ],
                    ],JSON_PRETTY_PRINT );
                    die();
                }
            }
            echo json_encode([
                'code'   => 200,
                'status' => 'not_found',
                'msg'    => 'Không tìm thấy mã giao dịch này. Vui lòng thử lại sau ít phút',
            ],JSON_PRETTY_PRINT );
        }

        imap_close($connection);

    }
?>
