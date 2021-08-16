<?php
/*
|---------------------------------------------------------|
|                   CODER HOÀNG VĂN LĨNH                  |
|                    ZALO : 0353257530                    |
|---------------------------------------------------------|
*/
session_start();
require_once '../core/database.php';
if(empty($_SESSION['username'])){
    header('Location: /');exit;
}else{
$title = "Lịch sử mua";
require_once '../layout/head.php';
$code = $_GET['code'];
$total = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `lich-su-mua` WHERE `time` = '$code' AND `username` = '$username'"));
?>
       

        <!--  END SIDEBAR  -->

                <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing">



                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12  layout-spacing">
                            <div class="statbox widget">
                                <div class="widget-header">                                
                               
                                            <h5 class=""><?= $title ?></h5>
                                        
                                </div>
                                <div class="widget-content">
                                    <form>
                                        
                                            
                                    <div class="box-body">
          <?php 
           if(!$total){
               ?>
               <div class="form-group text-center">
                 <h3 class="text-danger">Lịch sử mua không tồn tại!</h3>
               </div>
               <?php
           }else{
           ?>
           <div class="form-group">
             <label for="">Danh sách sản phẩm:</label>
             <textarea class="form-control" rows="15"><?php 
                  $query =  mysqli_query($conn,"SELECT * FROM `san-pham-da-ban` WHERE `time` = '$code' AND `username` = '$username'");
                  while($row = mysqli_fetch_array($query)){
                         echo $row['text']."\n";
                  }
                 ?>
             </textarea>
           </div>
           <?php } ?>
        </div>
      </div>
                                    </form>

                                    
                                </div>
                            </div>
                        </div>


            <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                    <p class="">Copyright © 2020 <a target="_blank" href="https://designreset.com">DesignReset</a>, All rights reserved.</p>
                </div>
                <div class="footer-section f-section-2">
                    <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p>
                </div>
            </div>
        </div>

        <!-- End -->
        </div>
<?php
require_once '../layout/script.php';
}
?>
                            