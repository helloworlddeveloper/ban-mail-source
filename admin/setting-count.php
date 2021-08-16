<?php
session_start();
require_once '../core/database.php';
if(empty($_SESSION['username'])){
    header('Location: /');exit;
}else{
require_once 'header.php';
if($data['admin'] == 1){
$id = $_GET['id'];
$checkk = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `users` WHERE `id` = '$id'"));

if(isset($_POST['submit'])){
   $user = xss($_POST['username']);
   $type = xss($_POST['type']);
   $cash = xss(addslashes($_POST['cash']));
   $acc = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `users` WHERE `username` = '$user'"));
   if(!$user || !$cash || !is_numeric($cash)){
        $status = false;
        $msg = "Thông tin cộng/trừ tiền không hợp lệ";
   }else if(!$acc){
        $status = false;
        $msg = "Tên đăng nhập không tồn tại";
   }else{
   if($type == 1) {
        $status = true;
        $msg = "Cộng tiền thành công";
        mysqli_query($conn,"UPDATE `users` SET `cash`= `cash` + $cash WHERE `username` = '$user'");
        } else if($type == 2) {
          $status = true;
        $msg = "Trừ tiền thành công";
        mysqli_query($conn,"UPDATE `users` SET `cash`= `cash` - $cash WHERE `username` = '$user'");
     }   
   }
}

if($msg){
?>
<script>
        <?php if($status === true){?>
            swal('<?= $msg ?>',"success");
            setTimeout(() => {
                window.location.href = '/setup-member';
            }, 2000);
        <?php }else{ ?>
            swal('<?= $msg ?>',"error");
        <?php } ?>
</script>
<?php
}
?>  <!-- Content Wrapper. Contains page content -->
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
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Cộng/Trừ Tiền Thành Viên</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
                <div class="card-body">
                
                  <form ui-jp="parsley" novalidate action="#" method="POST">
                    <div class="form-group">
                        <label for="">Tên đăng nhập:</label>
                        <input type="text" name="username" value="<?= $checkk['username']; ?>" class="form-control" placeholder="Nhập tên đăng nhập cần cộng/trừ tiền" required>
                    </div>
                    <div class="form-group">
            <label for="">Thao Tác</label>
            <select class="form-control" name="type">
                
                        <option value="1">Cộng Tiền</option>
                        <option value="2">Trừ Tiền</option>
                     
            </select>
          </div>
                    <div class="form-group">
                        <label for="">Số tiền:</label>
                        <input type="number" name="cash" value="0" class="form-control" placeholder="Nhập số tiền cần cộng" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block p-x-md" name="submit">Cập Nhật </button>
                </form>
                </div>
                <!-- /.card-body -->

                
              
            </div>
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







