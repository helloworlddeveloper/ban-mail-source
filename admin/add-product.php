<?php
/*
* @author: Vũ Đình Nam Khánh - Nguyễn Lê Hoàng Anh
* @contact: vudinhnamkhanh.clone@gmail.com
* @copyright: copyright © 2021
**/
session_start();
require_once '../core/database.php';
if(empty($_SESSION['username'])){
    header('Location: /');exit;
}else{
if($data['admin'] == 1){
if($_POST && $_POST['type'] == 'them-san-pham' && isset($_POST['text']) && isset($_POST['key_id'])){
    $text = xss(addslashes($_POST['text']));
    $key_id = xss(addslashes($_POST['key_id']));
    $check = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `san-pham-chua-ban` WHERE `text` = '$text' AND `key_id` = '$key_id'"));
    if($check){
        $arr = array('error' => false);
    }else{
        $arr = array('success' => true);
        mysqli_query($conn,"INSERT INTO `san-pham-chua-ban`(`key_id`, `text`) VALUES ('$key_id','$text')");
    }
    echo json_encode($arr); exit;
}    
require_once 'header.php';
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
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Thêm Sản Phẩm</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div class="card-body">
                
                  <div class="form-group">
            <label for="">Dữ liệu sản phẩm</label>
            <textarea class="form-control" id="list" rows="5"></textarea>
          </div>
          <div class="form-group">
            <label for="">Loại sản phẩm</label>
            <select class="form-control" id="key_id">
                     <?php
                      $query = mysqli_query($conn,"SELECT * FROM `danh-sach-san-pham`");
                      while($row = mysqli_fetch_array($query)){
                      ?>
                        <option value="<?= $row['key_id']; ?>"><?= $row['value']; ?></option>
                      <?php
                      }
                      ?>
            </select>
          </div>
          <div class="form-group text-center">
            <button type="button" class="btn btn-primary" id="them-san-pham">Thêm ngay</button>
          </div>
          <hr>
          <div class="form-group text-center">
            <button type="button" class="btn btn-info">Tổng: <span class="label rounded" id="total">0</span></button>
            <button type="button" class="btn btn-success">Thành công: <span class="label rounded" id="success">0</span></button>
            <button type="button" class="btn btn-danger">Thất bại: <span class="label rounded" id="error">0</span></button>
          </div>
                </div>
                <!-- /.card-body -->

                
              </form>
            </div>
            </div>
            
        </div>
        <!-- /.row -->
     

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <script>
var split;
var key_id;
var total = 0;
var success;
var error;
$(()=>{
    $('#them-san-pham').click(()=>{
            var list = $('#list').val(); 
            key_id = $('#key_id').val(); 
            if(!list){
                swal("Vui Lòng Nhập Danh Sách Sản Phẩm","error");
                return;
            }else{
                split = list.trim().split("\n");
                total = split.length;
                $('#total').html(total);
                success = 0;
                error = 0;
                $('#them-san-pham').prop('disabled',true);
                add(0);
            }
    });
});
function add(i){
       if(i >= total){
            $('#them-san-pham').prop('disabled',false);
            return;
        }
        var text = split[i];
        $.post('#',{type:'them-san-pham',text,key_id},'json')
        .done((res)=>{
            if(JSON.parse(res).success){
                ++success;
                $('#success').html(success);
            }else{
                ++error;
                $('#error').html(error);
            }
            add(i+1);
        })
        .fail((err)=>{
            console.log(err);     
        });
}
</script>
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







