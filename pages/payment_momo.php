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
if($_POST['momo'] == true){
    // echo "<script>swal('cc','cc','success'); </script>";
    $tranid = $_POST['code'];

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $_SERVER['HTTP_HOST']."/post/momo.php?code=$tranid",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($response, true);
    $momo_noidung = "naptien ".$_SESSION['username']."";

    if ($data['status'] == 'success') {
  
        
        $check_tranID = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `momo` WHERE `tranId` = '".$tranid."' "));
        if($check_tranID) {
            die('<script>swal("Mã Giao Dịch Đã Tồn Tại","error"); setTimeout(function(){ location.href = "" },1200);</script>');
        } else {
        
            $money_check = str_replace('.', '', $data['data']['money']);
            
            $create = $conn->query("INSERT INTO `momo` (`tranId`, `amount`, `username`, `partnerId`, `partnerName`, `comment`, `time`, `status`) VALUES ('".$data['data']['code']."','".$data['data']['money']."','".$_SESSION['username']."','".$data['data']['phone']."','".$data['data']['name']."','".$_SESSION['username']."','".$data['data']['time']."','success')");

            $create = $conn->query("UPDATE `users` SET `cash` = `cash` + '".$money_check."' WHERE `username` = '".$_SESSION['username']."' ");

            if($create)
            {
                die('<script>swal("Nạp tiền thành công","success");setTimeout(function(){ location.href = "" },1200);  </script>');
            }
            else
            {
                die('<script>swal("Thất Bại, Vui Lòng Thao Tác Lại","error"); setTimeout(function(){ location.href = "" },1200);</script>');
            }
        }

    } else {
        die('<script>swal("Mã Giao Dịch Không Đúng","error");setTimeout(function(){ location.href = "" },1200);  </script>');
    }
    
}

?>
<div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing">
                 
                        <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12  layout-spacing">
                            <div class="statbox widget">
                                <div class="widget-header">                                
                               
                                            <h5 class="">Nạp Tiền MoMo Tự Động</h5>
                                        
                                </div>
                                <div class="widget-content">
                                    <form>
                                        
                                            <div class="form-group text-center pt-5">
                                            <font class="text-danger">Chú ý :</font> Vui Lòng Chuyển Đúng Nội Dung
                                        </div>
                                      
            
        <div class="form-group">
		  <label for="">Nội Dung</label>
		  <input type="text" class="form-control bs-tooltip" id="result" title="Nội Dung" value="<?=$_SESSION['username'];?>" readonly>
		  <p></p>
		  <div class="input-group-append">
    <button class="btn btn-danger" onclick="coppy('result');" type="button">Sao chép</button>
  </div>
			</div>
		       <div class="form-group">
		  <label for="">Nhập Mã Giao Dịch</label>
		  <input type="text" class="form-control bs-tooltip" id="code" title="Mã Giao Dịch" placeholder="Mã Giao Dịch">
		</div> 
		
		<div class="form-group text-center">
		    <button type="button" id="submit" class="btn btn-dark"><i class="fa fa-shopping-cart"></i> Nạp Tiền </button>
        </div>
        <div class="form-group" id="list_buy"></div>
                                    
                                    </form>

                                    
                                </div>
                                
                            </div>
                </div>        
                 
                 <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="widget-content widget-content-area br-6">
                            <div class="table-responsive mb-4 mt-4">
                                <table id="zero-config" class="table table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Mã GD</th>
                                            <th>Tài Khoản</th>
                                            <th>Số Tiền</th>
                                            <th>Số Điện Thoại</th>
                                            <th>Tên Người Gửi</th>
                                            <th>Nội Dung</th>
                                            <th>Thời Gian</th> 
                                            <th>Trạng Thái</th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                 
                                                                          <?php
                      $query = mysqli_query($conn,"SELECT * FROM `momo` WHERE `username` = '$username' ORDER BY id DESC");
                      $stt = 0;
                      while($row = mysqli_fetch_array($query)){
						
                      ?>
                      <tr>
                           <td><?= ++$stt; ?></td>
						   <td><?= $row['tranId']; ?></td>
						   <td><?= $row['username'] ;?></td>
                           <td><?= $row['amount']; ?></td>
                           <td><?= $row['partnerId'] ;?> </td>
                           <td><?= $row['partnerName'] ;?></td>
                           <td><?= $row['comment'] ;?></td>
                           <td><?= $row['time'] ;?></td>
                           <td><? if($row['status'] == "success") { echo "Thành Công"; } ?></td>
                      </tr>
                      <?php
                      }
                      ?>             
                                    </tbody>
                                     
                                </table>
                            </div>
                        </div>
                  
            
            
        </div>    
                 </div>
                 
                 </div>
                 </div>
                 
                 </div>
                 
                 </div>
                 </div>
                 <script type="text/javascript">
    $('#submit').click(function(){
        var code = $('#code').val();
        var momo = true;
            if (!code) {
                // toarst("error","Vui Lòng Nhập Đầy Đủ Thông Tin","Thông Báo");
                swal("Vui Lòng Nhập Mã Giao Dịch","error");
                return false;
            }
            $('#submit').prop('disabled', true).html('<i class="fa fa-refresh fa-spin"></i> Đang Xử Lý')
            $.post('../pages/payment_momo.php', {
                code: code,
                momo: momo
            }, function(data, status) {
                $("#momo").html(data);
                $('#submit').prop('disabled', false).html('<i class="fa fa-refresh"></i> Nạp Tiền') ;
            });
        });
</script>
<div id="momo" style="display: none;"></div>
<?php
require_once '../layout/script.php';
?>