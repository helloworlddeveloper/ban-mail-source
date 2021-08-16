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

?>
<div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing">
                 
                        
                
               <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="widget-content widget-content-area br-6">
                        <div class="widget-content">
                        <h4> Lịch Sử Đăng Nhập</h4>
                        </div>
                       
                            <div class="table-responsive mb-4 mt-4">
                                <table id="zero-config" class="table table-hover" style="width:100%">
                                    <thead>
                                        <tr>
        <th>UID</th>
       	<th>Tài Khoản</th>
       	<th>User Agent</th>	
       	<th>Địa Chỉ IP</th>
       	<th>Thời Gian</th> 	
       	
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php
				$result = mysqli_query($conn,"SELECT * FROM `history-log` WHERE `username` = '".$_SESSION['username']."' ORDER BY id DESC LIMIT 0,5 ");
				if($result)
				{
				while($row = mysqli_fetch_assoc($result))
				{
				?>
               <tr>
                <td><?php echo $row['id']; ?></td>
                 <td><?php echo $row['username']; ?></td>
                 <td><?php echo $row['useragent']; ?></td>
                 <td><?php echo $row['ip']; ?></td>
                 <td><?php echo $row['time']; ?></td>
              
                 
                
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