<?php
session_start();
require_once '../core/database.php';
if(empty($_SESSION['username'])){
    header('Location: /');exit;
}else{
if($data['admin'] == 1){
if($_GET && $_GET['xoa']){
    $id = $_GET['xoa'];
    $check = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `users` WHERE `id` = '$id'"));
    if($check){
        mysqli_query($conn,"DELETE FROM `users` WHERE `id` = '$id'");
        header('Location: /setup-member');
    }
}   
if($_GET && $_GET['member']){
    $id = $_GET['member'];
    $check = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `users` WHERE `id` = '$id'"));
    if($check && $check['admin'] == 1 && $check['username'] != $system['username']){
        mysqli_query($conn,"UPDATE `users` SET `admin`= 0 WHERE `id` = '$id'");
        if($username == $check['username']){
            header('Location: /');
        }else{
            header('Location: /setup-member');
        }
    }
} 
if($_GET && $_GET['admin']){
    $id = $_GET['admin'];
    $check = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `users` WHERE `id` = '$id'"));
    if($check && $check['admin'] == 0){
        mysqli_query($conn,"UPDATE `users` SET `admin`= 1 WHERE `id` = '$id'");
        header('Location: /setup-member');
    }
} 
require_once 'header.php';
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        
        <!-- Small boxes (Stat box) -->
        <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Quản Lý Thành Viên</h3>
              </div>
              
           <div class="card-body">
        <div class="box-header primary">
          <h3><?= $title; ?></h3>
        </div>
        <div class="box-body">
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#m-a-a" ui-toggle-class="zoom" ui-target="#animate"><i class="fa fa-plus"></i> Thêm Thành Viên </button>
        <div class="table-responsive">
      <table ui-jp="dataTable" class="table table-striped b-t b-b">
                <thead>
            <tr>
            <th>#</th>
            <th>Email</th>
            <th>Username</th>
            <th>Password</th>
            <th>Số dư</th>
            <th>Chức vụ</th>
            <th>Thao tác</th>
           </tr>
        </thead>
            <tbody>
                     <?php
                      $query = mysqli_query($conn,"SELECT * FROM `users` ORDER BY id DESC");
                      $stt = 0;
                      while($row = mysqli_fetch_array($query)){
                      ?>
                      <tr>
                           <td><?= ++$stt; ?></td>
                           <td><?= $row['email']; ?></td>
                           <td><?= $row['username']; ?></td>
                             <td><?= $row['password']; ?></td>
                           <td><?= number_format($row['cash']); ?> VNĐ</td>
                           <td><?= $row['admin']==1?"Quản trị viên":"Thành viên"; ?></td>
                           <td>
                           <a type="button" class="btn btn-danger p-x-md" href="?xoa=<?= $row['id']; ?>">Xóa</a>
                           <a type="button" class="btn btn-success p-x-md" href="/setup-money?id=<?= $row['id']; ?>">Cộng tiền</a>
                            <?php if($row['admin'] == 1 && $row['username'] != $system['username']){?>
                            <a type="button" class="btn btn-info p-x-md" href="?member=<?= $row['id']; ?>">Thành viên</a>
                            <?php }else if($row['admin'] == 0){ ?> 
                            <a type="button" class="btn btn-info p-x-md" href="?admin=<?= $row['id']; ?>">Quản trị viên</a>
                            <?php } ?>
                           </td>

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
            <!-- /.card -->

        </div>
     <script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>

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







