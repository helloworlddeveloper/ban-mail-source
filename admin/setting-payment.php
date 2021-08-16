<?php
session_start();
require_once '../core/database.php';
if(empty($_SESSION['username'])){
    header('Location: /');exit;
}else{
require_once 'header.php';
if($data['admin'] == 1){
if(isset($_POST['momoupdate'])) {
$gmailmomo = $_POST['emailmomo'];
$namemomo = $_POST['namemomo'];
$phonemomo = $_POST['phonemomo'];
$passmomo = $_POST['passmomo'];

$update = mysqli_query($conn, "UPDATE setting SET 
        `gmail-momo-api` = '".mysqli_real_escape_string($conn, $gmailmomo).
     "',`name-momo` = '".mysqli_real_escape_string($conn, $namemomo).
     "',`phone-momo` = '".mysqli_real_escape_string($conn, $phonemomo).
     "',`pass-momo-api` = '".mysqli_real_escape_string($conn, $passmomo).
     "' WHERE `id`='1'");
if($update) {
echo '<script> swal("Cập Nhật Thông Tin Thành Công","success"); setTimeout(function(){ location.href = "" },1300);</script>'; 
}
}
if(isset($_POST['ntnupdate'])) {
$emailntn = $_POST['emailntn'];
$merchantid = $_POST['merchantid'];
$securecode = $_POST['securecode'];
$update = mysqli_query($conn, "UPDATE setting SET 
        `napthengay-email` = '".mysqli_real_escape_string($conn, $emailntn).
     "',`napthengay-id` = '".mysqli_real_escape_string($conn, $merchantid).
     "',`napthengay-code` = '".mysqli_real_escape_string($conn, $securecode).
     "' WHERE `id`='1'");

if($update) {
echo '<script> swal("Cập Nhật Thông Tin Thành Công","success"); setTimeout(function(){ location.href = "" },1300);</script>'; 
}
}
if(isset($_POST['infoupdate'])) {
$tsr = $_POST['tsr'];
$nametsr = $_POST['nametsr'];
$tcsr = $_POST['tcsr'];
$nametcsr = $_POST['nametcsr'];

$info = mysqli_query($conn, "UPDATE setting SET 
        `phone-tsr` = '".mysqli_real_escape_string($conn, $tsr).
     "',`name-tsr` = '".mysqli_real_escape_string($conn, $nametsr).
     "',`phone-tcsr` = '".mysqli_real_escape_string($conn, $tcsr).
     "',`name-tcsr` = '".mysqli_real_escape_string($conn, $nametcsr).
     "'  WHERE `id`='1'");
if($info) {
echo '<script> swal("Cập Nhật Thông Tin Thành Công","success"); setTimeout(function(){ location.href = "" },1300);</script>'; 
}
}


?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      

        <!-- Small boxes (Stat box) -->
        <div class="row">
        <div class="col-md-4">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Cấu Hình Nạp Auto MoMo</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="" method="POST">
                <div class="card-body">
                
                  <div class="form-group">
                    <label for="emailmomo">Gmail MoMo</label>
                    <input type="email" class="form-control" name="emailmomo" id="emailmomo" value="<?= $setup['gmail-momo-api']; ?>" placeholder="Email Tài Khoản MoMo" required>
                  </div>
           
                  <div class="form-group">
                    <label for="namemomo">Tên Tài Khoản MoMo</label>
                    <input type="text" class="form-control" name="namemomo" id="namemomo" value="<?= $setup['name-momo']; ?>" placeholder="Tên Tài Khoản MoMo" required>
                  </div>
                  <div class="form-group">
                    <label for="phonemomo">Số Điện Thoại MoMo</label>
                    <input type="number" class="form-control" name="phonemomo" id="phonemomo" value="<?= $setup['phone-momo']; ?>" placeholder="Số Điện Thoại MoMo" required>
                  </div>
                  <div class="form-group">
                    <label for="passmomo">Mật Khẩu Ứng Dụng </label>
                    <input type="password" class="form-control" name="passmomo" id="passmomo" value="<?= $setup['pass-momo-api']; ?>" placeholder="Mật Khẩu Ứng Dụng Email">
                  </div>
                      
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="momoupdate" class="btn btn-dark">Cập Nhật</button>
                </div>
              </form>
            </div>
            </div>
            <!-- /.card -->
            <div class="col-md-4">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Nạp Thẻ Tự Động Napthengay.com</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="" method="POST">
                <div class="card-body">
                
                  
                  <div class="form-group">
                    <label for="emailntn">Email Napthengay</label>
                    <input type="email" class="form-control" name="emailntn" id="emailntn" value="<?=$setup['napthengay-email']; ?>" placeholder="Email Napthengay" required>
                  </div>
                  <div class="form-group">
                    <label for="merchantid">Merchant ID Tích Hợp</label>
                    <input type="number" class="form-control" name="merchantid" id="merchantid" value="<?=$setup['napthengay-id']; ?>" placeholder="Merchant ID Napthengay">
                  </div>
                  <div class="form-group">
                    <label for="securecode">Mật Khẩu Kết Nối</label>
                    <input type="text" class="form-control" name="securecode" id="securecode" value="<?=$setup['napthengay-code']; ?>" placeholder="Secure Code Napthengay">
                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="ntnupdate" class="btn btn-dark">Cập Nhật</button>
                </div>
              </form>
            </div>
            </div>
            <!-- /.card -->
            
                      <div class="col-md-4">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Thông Tin Chuyển Khoản</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="" method="POST">
                <div class="card-body">
                
                  
                  <div class="form-group">
                    <label for="tsr">Thẻ Siêu Rẻ</label>
                    <input type="text" class="form-control" name="tsr" id="tsr" value="<?=$setup['phone-tsr']; ?>" placeholder="Số Điện Thoại Hoặc Email Thẻ Siêu Rẻ" required>
                  </div>
                  <div class="form-group">
                    <label for="nametsr">Tên Tài Khoản Thẻ Siêu Rẻ</label>
                    <input type="text" class="form-control" name="nametsr" id="nametsr" value="<?=$setup['name-tsr']; ?>" placeholder="Tên Tài Khoản Thẻ Siêu Rẻ">
                  </div>
               <div class="form-group">
                    <label for="tcsr">Thẻ Cào Siêu Rẻ</label>
                    <input type="text" class="form-control" name="tcsr" id="tcsr" value="<?=$setup['phone-tcsr']; ?>" placeholder="Số Điện Thoại Hoặc Email Thẻ Cào Siêu Rẻ" required>
                  </div>
                  <div class="form-group">
                    <label for="nametsr">Tên Tài Khoản Thẻ Cào Siêu Rẻ</label>
                    <input type="text" class="form-control" name="nametcsr" id="nametcsr" value="<?=$setup['name-tcsr']; ?>" placeholder="Tên Tài Khoản Thẻ Cào Siêu Rẻ">
                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="infoupdate" class="btn btn-dark">Cập Nhật</button>
                </div>
              </form>
            </div>
        </div>
        <!-- /.row -->
     

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2020 <a href="#"><?= $setup['name-footer']; ?></a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0-rc
    </div>
  </footer>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
</body></html>
<?php
require_once 'script.php';
}
else{
    require_once '../pages/404.php';
    
}
}

?>







