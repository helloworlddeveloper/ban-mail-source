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
if($_GET && $_GET['xoa']){
    $id = $_GET['xoa'];
    $check = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `ticket` WHERE `id` = '$id'"));
    if($check){
        mysqli_query($conn,"DELETE FROM `ticket` WHERE `id` = '$id'");
        header('Location: /ticket');
    }
}  
?>
<div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing">
                 
                        <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12  layout-spacing">
                            <div class="statbox widget">
                                <div class="widget-header">                                
                               
                                            <h5 class="">Gửi Hỗ Trợ </h5>
                                        
                                </div>
                                <div class="widget-content">
                                    <form><p></p>
<div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>Warning - </strong> Alert Notification Ticket !
</div>

 <div class="form-group">
                    <label>Tiêu Đề</label>
                    <input type="text" placeholder="Vấn Đề Gặp Phải" id="title" name="title" class="form-control">
                </div>
                <div class="table table-striped">
    <label>Nội Dung </label>
    <textarea class="form-control" name="manager" id="manager" rows="4"></textarea>
  </div>
 <div class="form-group text-center">
<button onclick="submit();" id="submit" type="submit" class="btn btn-success btn-rounded"><i class="fa fa-send"></i> Gửi Hỗ Trợ</button>
                                 </div>
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
        <th>UID</th>
       	<th>Tài Khoản</th>
       	<th>Tiêu Đề</th>	
       	<th>Nội Dung</th>
       	<th>Thời Gian</th> 	
       	<th>Trạng thái</th>
        <th>Trả Lời Của Admin</th> 
        <th> User Agent</th>
       	<th>Hành Động</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php
				$result = mysqli_query($conn,"SELECT * FROM `ticket` WHERE `username` = '".$_SESSION['username']."' ORDER BY id DESC LIMIT 0,5 ");
				if($result)
				{
				while($row = mysqli_fetch_assoc($result))
				{
				?>
               <tr>
                <td><?php echo $row['id']; ?></td>
                 <td><?php echo $row['username']; ?></td>
                 <td><?php echo $row['title']; ?></td>
                 <td><?php echo $row['manager']; ?></td>
                 <td><?php echo $row['time']; ?></td>
              
                 
                 <td><?php 
                 if($row['status'] == '1'){
                    echo '<p style="color:#00ff00";><b>Đã Duyệt </b></p>';
                 }elseif($row['status'] == '0')
                  echo '<p style="color:#FF0000";><b>Chưa Duyệt</b></p>';
                 ?></td>
                 <td><?php echo $row['reply']; ?></td>
                 <td><?php echo $row['useragent']; ?></td>
                 <td><a href="?xoa=<?= $row['id']; ?>"> <button type="submit" class="btn btn-warning">Xóa</button></a>
                 
                 </td>
                 <?php
				}
				}
				?>
                                                                         

            </tr>             
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
<script type="text/javascript">
        $('#submit').click(function(){
            var title = $('#title').val();
            var manager = $('#manager').val();
                if (!title) {
                    swal("Vui Lòng Nhập Tiêu Đề Cần Hỗ Trợ","info");
                    return false;
                }
                else if (!manager) {
                swal("Vui Lòng Nhập Nội Dung Cần Hỗ Trợ","info");
                return false;
                }
                $('#submit').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Đang Xử Lý')
                $.post('../post/ticket.php', {
                    title: title,
                    manager: manager
                }, function(data, status) {
                    $("#trave").html(data);
                    $('#submit').prop('disabled', false).html('<i class="fa fa-spinner fa-spin"></i> Gửi Thêm');
                });
            });
         
</script>

<div id="trave" style="display: none;">
<?php
require_once '../layout/script.php';
?>