<?php

session_start();
require_once '../core/database.php';
if(empty($_SESSION['username'])){
    header('Location: /');exit;
}else{
function tinhtien($key_id,$amount,$conn){
	$check = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `danh-sach-san-pham` WHERE `key_id` = '$key_id'"));
	$total = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `san-pham-chua-ban` WHERE `key_id` = '$key_id'"));
	if(!$check || $amount < 0){
      $arr = array('error' => HACKER, 'tongthanhtoan' => 0);
	}else if($amount < 1){
	  $arr = array('error' => 'Số lượng mua ít nhất là 1', 'tongthanhtoan' => 0);
	}else if(!$total || $total < $amount){
	  $arr = array('error' => 'Số lượng '.$check['value'].' hiện còn '.$total.'.', 'tongthanhtoan' => 0);
	}else{
	  $tongthanhtoan = $amount * $check['rate'];
	  $arr = array('success' => true, 'value' => $check['value'], 'rate' => $check['rate'], 'tongthanhtoan' => $tongthanhtoan, 'tongthanhtoanfmt' => number_format($tongthanhtoan));
	}
	return $arr;
}
if($_POST && $_POST['type'] == 'tinh-tien' && isset($_POST['key_id']) && is_numeric($_POST['amount'])){
	$key_id = xss(addslashes($_POST['key_id']));
	$amount = xss(addslashes($_POST['amount']));	
	echo json_encode(tinhtien($key_id,$amount,$conn)); exit;
}  	
if($_POST && $_POST['type'] == 'thanh-toan' && isset($_POST['key_id']) && is_numeric($_POST['amount'])){
	$key_id = xss(addslashes($_POST['key_id']));
	$amount = xss(addslashes($_POST['amount']));	
	$tinhtien = tinhtien($key_id,$amount,$conn);
	$tongthanhtoan = $tinhtien['tongthanhtoan'];
	if($tinhtien['error']){
     $arr = array('error' => $tinhtien['error']);
	}else if($tongthanhtoan > $data['cash']){
	 $arr = array('error' => 'Bạn không đủ tiền để thanh toán');
	}else{
     mysqli_query($conn,"UPDATE `users` SET `cash` = `cash` - ".$tongthanhtoan." WHERE `username` = '".$username."'");
	 $time = time();
	 $query = mysqli_query($conn,"SELECT * FROM `san-pham-chua-ban` WHERE `key_id` = '$key_id' ORDER BY RAND() LIMIT 0, {$amount}");
	 if($query){
			$fail = 0;
			while($row = mysqli_fetch_array($query)){
				$text = $row['text'];
				mysqli_query($conn,"DELETE FROM `san-pham-chua-ban` WHERE `text` ='".$text."' AND `key_id` = '$key_id'");
				if($text != NULL){
					mysqli_query($conn,"INSERT INTO `san-pham-da-ban`(`key_id`, `text`, `time`, `username`) VALUES ('$key_id','$text','$time','$username')");
				}else{
					$fail = $fail + 1;
				}
		   }
		   $hoantien  = $tinhtien['rate'] * $fail;
		   mysqli_query($conn,"UPDATE `users` SET `cash` = `cash` + ".$hoantien." WHERE `username` = '".$username."'");
		   $success = $amount - $fail;
		   mysqli_query($conn,"INSERT INTO `lich-su-mua`(`key_id`, `amount`, `time`, `username`) VALUES ('$key_id','$amount','$time','$username')");
		   $tienmua = $tinhtien['rate'] * $success;
	}
    	$arr = array('success' => 'Thanh toán thành công','code' => $time);
	}
	echo json_encode($arr); exit;
}  
$title = "Trang chủ";
require_once '../layout/head.php';
?>
        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing">
<div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">

                        <div class="widget widget-chart-two">
                            <div class="widget-heading">
                                <h5 class="">Tài Khoản</h5>
                            </div>
                
                        
                            <center><img src="https://graph.fb.me/4/picture?type=large" alt="" style="border-radius:100px;height:70px">
                            </center>
                        
                        <div class="list-group-item">
                            <p> Tài khoản : <span class="btn btn-danger btn-rounded btn-sm float-right"><i class="mdi mdi-account-edit"></i> <?= $_SESSION['username']; ?></span>
                            </p>
                        </div>
                        <div class="list-group-item">
                            <p> Số dư : <span title="Số tiền hiện có" class="btn btn-success btn-rounded btn-sm float-right bs-tooltip"><i class="fa fa-dollar-sign"></i>  <?= $data['cash']; ?> VND </span>
                            </p>
                        </div>
                        <div class="list-group-item">
                            <p> Loại tài khoản : <span title="Chức vụ" class="btn btn-primary btn-rounded btn-sm float-right bs-tooltip"><i class="mdi mdi-account"></i> <?php if($data['admin'] == '1'){
                    echo 'Quản Trị Viên';
                 }else if($data['admin'] == '0') {
                  echo 'Thành Viên';	
				}else if($data['admin'] == '2') {
                  echo 'Cộng Tác Viên';	}
				
                 ?>  </span>
                            </p>
                        </div>
                        <div class="list-group-item">
                            <p> IP Address : <span class="btn btn-warning btn-rounded btn-sm float-right"><i class="fa fa-link"></i> <?= $data['ip']; ?> </span>
                            </p>
                        </div>
                        <div class="list-group-item">
                            <p> Trạng Thái : <span class="btn btn-dark btn-rounded btn-sm float-right"><i class="fa fa-link"></i> Kích Hoạt </span>
                            </p>
                        </div>
                    </div>
                
               
                            
</div>

<!-- Mua Bằng Form Card --->
                       <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12  layout-spacing">
                            <div class="statbox widget" style="box-shadow: 0px 0px 0px rgba(0, 0, 0, 0.25);">
                                <div class="widget-header">                                
                               
                                            <h5 class="">Mua Sản Phẩm</h5>
                                        
                                </div>
                                <div class="widget-content">
                                    <form>
                                        
                                            <div class="form-group text-center pt-5">
                                            <font class="text-danger">Chú ý :</font> khi đang thanh toán vui lòng không tải lại trang hoặc đóng tab để tránh mất trắng sản phẩm .
                                        </div>
                                        <div class="form-group">
            <label for="">Loại clone:</label>
            <select class="form-control bs-tooltip" title="Lựa chọn sản phẩm" id="key_id" onchange="tinhtien();">
                     				<?php
                      $query = mysqli_query($conn,"SELECT * FROM `danh-sach-san-pham`");
                      while($row = mysqli_fetch_array($query)){
						  $key_id = $row['key_id'];
                      ?>
						<option value="<?= $key_id; ?>">
						<?= $row['value']; ?> 
						(<?= number_format($row['rate']); ?> VNĐ / 1,
							 hiện còn
							 <?= mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `san-pham-chua-ban` WHERE `key_id` = '".$key_id."'")) ?>)
						</option>
                      <?php
                      }
                      ?>
                                  </select>
        </div>
        <div class="form-group">
		  <label for="">Số lượng :</label>
		  <input type="text" id="amount" class="form-control bs-tooltip" title="Nhập số lượng sản phẩm" placeholder="Nhập số lượng cần mua" onkeyup="tinhtien();">
		</div>
		<div class="form-group"><label class="active">Tổng thanh toán: <font color="red"><b id="tongthanhtoan">0</b></font> VNĐ</label></div>
		<div class="form-group text-center">
		    <button type="button" class="btn btn-dark" id="thanh-toan"><i class="fa fa-shopping-cart"></i> Thanh toán</button>
        </div>
        <div class="form-group" id="list_buy"></div>
                                    
                                    </form>

                                    
                                </div>
                                
                            </div>
                </div>        <!-- Đóng Form Card --->
               <?php
                      $query = mysqli_query($conn,"SELECT * FROM `danh-sach-san-pham`");
                      while($row = mysqli_fetch_array($query)){
						  $key_id = $row['key_id'];
                      ?>
                <!--        <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12  layout-spacing">
                            <div class="statbox widget box-service-panel">
                                
                                <div class="widget-content">
                                   <img class="img-fluid" src="//shopacfb.site/img/facebook.png" width="70px">
<b><?= $row['value']; ?> </b><br>
<span class="badge badge-info" style="font-size:0.8rem!important;">Giá: <?= number_format($row['rate']); ?>
VNĐ</span>
<span class="badge badge-success" style="font-size:0.8rem!important;">Hiện còn: <?= mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `san-pham-chua-ban` WHERE `key_id` = '".$key_id."'")) ?></span>
<hr>
<p></p>
		    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#buy_<?= $key_id; ?>"><i class="fa fa-shopping-cart"></i> Mua Ngay</button>
       

                                    
                                </div>
                                
                            </div>
                </div>     
              
                <div id="buy_<?= $key_id; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">


        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 class="text-center"><?= $row['value']; ?></h4>
                    <hr>
                    <div class="alert alert-info" style="display: none;" id="show-productNote">
                        <p> Product Note</p>
                    </div>
                    <div class="form-group">
                        <label for="">Số lượng:</label>
               <input type="text" id="amount" class="form-control bs-tooltip" title="Nhập số lượng sản phẩm" placeholder="Nhập số lượng cần mua" onkeyup="tinhtien();">
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-outline-success waves-effect waves-light">Tổng thanh toán: <b class="text-danger" id="tongthanhtoan">0</b> VNĐ</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" id="thanh-toan"><i class="fa fa-shopping-cart"></i> Thanh toán</button>
                </div>
                <div class="form-group" id="list_buy"></div>
            </div>
        </div>
    </div> -->
  <?php
                      }
                      ?> 
           <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="widget-content widget-content-area br-6">
                            <div class="table-responsive mb-4 mt-4">
                                <table id="zero-config" class="table table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Thời gian</th>
                                            <th>Loại</th>
                                            <th>Số lượng</th>
                                            <th>Thao tác</th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                 
                                                                          <?php
                      $query = mysqli_query($conn,"SELECT * FROM `lich-su-mua` WHERE `username` = '$username' ORDER BY id DESC");
                      $stt = 0;
                      while($row = mysqli_fetch_array($query)){
						$key_id = $row['key_id'];
                      ?>
                      <tr>
                           <td><?= ++$stt; ?></td>
						   <td><?= date('d-m-Y - H:i:s',$row['time']); ?></td>
						   <td><?= mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `danh-sach-san-pham` WHERE `key_id` = '$key_id'"))['value'];?></td>
                           <td><?= number_format($row['amount']); ?></td>
                           <td><a class="btn btn-warning" href="/lich-su-mua.html?code=<?= $row['time']; ?>" class="btn primary">Xem</a></td>
                      </tr>
                      <?php
                      }
                      ?>             
                                    </tbody>
                                     
                                </table>
                            </div>
                        </div>
                  
            
            
        </div>           </div>
        </div> 
<?php 
require_once '../layout/footer.php';?>
        <!-- End -->                </div>
            
        </div>

<script>
  $(()=>{
	  $('#thanh-toan').click(()=>{
		var key_id = $('#key_id').val();
		var amount = $('#amount').val().trim();
		if (!amount) {
			swal("Vui Lòng Nhập Số Lượng","info");
            return;
        }else{
			tinhtien();
			$('#thanh-toan').prop('disabled',false).html("<i class=\"fa fa-spinner fa-spin\"></i> Đang Xử Lý");
			$.post('#',{type:'thanh-toan',key_id,amount},'json')
			.done((res)=>{
				var data = JSON.parse(res);
				if(data.success){
					swal(data.success,"success"); 
					setTimeout(() => {
						window.location.href = '/lich-su-mua.html?code='+data.code;
					}, 2000);
				}else{
				swal(data.error,"error"); 	
				}
				$('#thanh-toan').prop('disabled',true).html("<i class=\"fa fa-shopping-cart\"></i> Thanh toán");  
			})
			.fail((err)=>{
				console.log(err);     
			});
		}
	  });
  });
  function tinhtien(){
	  var key_id = $('#key_id').val();
	  var amount = $('#amount').val().trim();
	    if (parseInt(amount) != amount || amount < 0) {
		swal("Nhập Số Lượng Sản Phẩm","info");
            return;
        }else if (amount < 1) {
			swal("Mua Ít Nhất 1 Sản Phẩm","info");
            return;
		}else{
			$.post('#',{type:'tinh-tien',key_id,amount},'json')
			.done((res)=>{
				var data = JSON.parse(res);
				$('#tongthanhtoan').html(data.tongthanhtoan);
				if(data.success){
					  $('#thanh-toan').prop('disabled',false);
                      return true;
				}else{
					swal(data.error,"error"); 
					return;
				}
			})
			.fail((err)=>{
				console.log(err);     
			});
		}
  }
</script>
 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <br>
				<h5 class="modal-title"><center><font style="background: transparent url(https://cdn.raidforums.com/s/rain.gif);
    color: #028e6b;
    font-weight: bold;"><b><i class="fa fa-bullhorn" aria-hidden="true"></i> Thông Báo <i class="fa fa-star fa-spin"></i></b></font></center></h5><p></p>
    <div class="modal-footer">
    </div>
<center>    
<h8> &nbsp; <?= $setup['notification']; ?>  &nbsp;
</h8>
</center>
<p></p>
<div class="modal-footer">
					<center><button type="button" data-dismiss="modal" class="btn btn-dark btn-round waves-effect waves-light m-1" style="color:#ffffff;"><b><i class="fa fa-times"></i> Đóng</b></button></center>
			</div>
</div>
</div>
        </div>
<script>
    $(window).on('load', function() {
        $('#myModal').modal('show');
    });
</script>
<?php
require_once '../layout/script.php';
}
?>
                            