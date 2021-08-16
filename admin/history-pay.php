<?php

session_start();
require_once '../core/database.php';
if(empty($_SESSION['username'])){
    header('Location: /');exit;
}else{
if($data['admin'] == 1){

if($_GET && $_GET['delete'] == "all"){

    $check = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `napthe`"));
    if($check){
        mysqli_query($conn,"DELETE FROM `napthe`");
        header('Location: /history-pay');
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
                <h3 class="card-title">Danh Sách Thẻ Nạp</h3>
              </div>
              
           <div class="card-body">
        <div class="box-header primary">
          <h3></h3>
        </div>
        <div class="box-body">
        
        <div class="form-group">
    <a href="?delete=all"><button type="submit" name="submit" class="btn btn-info"><i class="fa fa-remove"></i> Xóa Tất Cả </button></a>
        </div>
        <div class="table-responsive">
      <table ui-jp="dataTable" class="table table-striped b-t b-b">
                    <thead>
    <tr>
       <th>UID</th>
       <th>Tên Tài Khoản</th>
       	<th>Mệnh giá</th>
       	<th>Số seri</th>	
       	<th>Mã thẻ</th>	
       	<th>Trạng thái</th>
    </tr>
    </thead>
    <tbody>
        <?php
				$result = mysqli_query($conn,"SELECT * FROM `napthe` ORDER BY id DESC LIMIT 10000 ");
				if($result)
				{
				while($row = mysqli_fetch_assoc($result))
				{
				?>
               <tr>
               <td><?php echo $row['id']; ?></td>
               <td><?php echo $row['username']; ?></td>
                 <td><?php echo $row['count_card']; ?></td>
                 <td><?php echo $row['seri_card']; ?></td>
                 <td><?php echo $row['pin_card']; ?></td>
                 <td><?php 
                 if($row['status_card'] == '1'){
                    echo '<p style="color:#00ff00";><b>Thành Công</b></p>';
                 }elseif($row['status_card'] == '0')
                  echo '<p style="color:#FF0000";><b>Thất Bại</b></p>';
                 ?></td>
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
            <!-- /.card -->
            <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Danh Sách Momo Nạp</h3>
              </div>
              
           <div class="card-body">
        <div class="box-header primary">
          <h3></h3>
        </div>
        <div class="box-body">
        
        <div class="form-group">
    <a href=""><button type="submit" name="submit" class="btn btn-info"><i class="fa fa-remove"></i> Xóa Tất Cả </button></a>
        </div>
        <div class="table-responsive">
      <table ui-jp="dataTable" class="table table-striped b-t b-b">
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
                      $query = mysqli_query($conn,"SELECT * FROM `momo` ORDER BY id DESC");
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







