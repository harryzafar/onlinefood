<?php
include('top.php');

$id = "";
$coupon_code = "";
$coupon_type = "";
$coupon_value = "";
$cart_min_value = "";
$expired_on= "";
$error = "";

if(isset($_GET['id']) && $_GET['id'] > 0){
  $id = get_safe_value($_GET['id']);
  $result = mysqli_query($conn, "SELECT * from coupon_code where id = '$id'") or die('search query failed');
  $row = mysqli_fetch_assoc($result);
  $coupon_code = $row['coupon_code'];
  $coupon_type = $row['coupon_type'];;
  $coupon_value = $row['coupon_value'];
  $cart_min_value = $row['cart_min_value'];
  $expired_on= $row['expired_on'];
}



if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['submit'])){
      $coupon_code = get_safe_value($_POST['coupon_code']);
      $coupon_type = get_safe_value($_POST['coupon_type']);
      $coupon_value = get_safe_value($_POST['coupon_value']) ;
      $cart_min_value = get_safe_value($_POST['cart_min_value']);
      $expired_on= get_safe_value($_POST['expired_on']);
      $added_on = date('Y-m-d h:i:s');

        if($id == ''){
      
          $check_cateogry_query = "SELECT * FROM coupon_code where coupon_code = '$coupon_code'";
        }else{
          $check_cateogry_query = "SELECT * FROM coupon_code where coupon_code = '$coupon_code' AND id != '$id'";
        }
        
        if(mysqli_num_rows(mysqli_query($conn, $check_cateogry_query)) > 0 ){
            $error = "This Coupon Code number is already Exist";
        }
        else{
          if($id == ''){
            $sql = "INSERT INTO coupon_code (coupon_code, coupon_type, coupon_value, cart_min_value, expired_on, status, added_on) values ('$coupon_code', '$coupon_type', '$coupon_value', '$cart_min_value','$expired_on', 1 , '$added_on')";
          }else{
            $sql = "UPDATE coupon_code set coupon_code = '$coupon_code', coupon_type = '$coupon_type', coupon_value = '$coupon_value', cart_min_value= '$cart_min_value',expired_on='$expired_on', added_on='$added_on'  where id = '$id'";
          }
            
            $query = mysqli_query($conn , $sql) or die("add/edit query failed");
            if($query){
                redirect('coupon_code.php');
            }
            else{
                $error = "Something went Wrong in inserting";
            } 
        }
        
        

    }
}

?>
<?php
include('head.php');
?>
<body class="sidebar-light">
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php include('topbar.php');?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      <?php include('sidebar.php');?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
           <div class="card">
            <div class="card-body">
            <h4 class="mb-3">Manage Coupon</h4>
              <div class="row">
                <div class="col-12">
                <div class="card">
                <div class="card-body">
                  <form class="forms-sample" method="post">
                    <div class="form-group">
                      <label for="exampleInputName1">Coupon Code</label>
                      <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" name="coupon_code" value="<?php echo $coupon_code;?>">
                      <p class="text-danger mt-2"><?php echo $error ;?></p>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword4">Coupon Type</label>
                      
                      <select class="form-control" name="coupon_type" id="exampleInputPassword4">
                        <option value="">Select Type</option>
                        <?php
                        $tpye_arr = ['P'=>'Percentage', 'F'=>'Fixed'];
                        foreach($tpye_arr as $key=>$value ){
                          if($key == $coupon_type){
                            echo '<option value="'.$key.'" selected >'.$value.'</option>';
                          }else{
                            echo '<option value="'.$key.'">'.$value.'</option>';
                          }
                     
                         }
                        ?>
                      </select>
                      
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword2">Coupon Value</label>
                      <input type="text" class="form-control" id="exampleInputPassword2" placeholder="Coupon Value" name="coupon_value" value="<?php echo $coupon_value;?>">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword3">Cart MIn Value</label>
                      <input type="text" class="form-control" id="exampleInputPassword3" placeholder="Coupon Value" name="cart_min_value" value="<?php echo $cart_min_value;?>">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword6">Expired On</label>
                      <input type="date" class="form-control" id="exampleInputPassword6" placeholder="Coupon Value" name="expired_on" value="<?php echo $expired_on;?>">
                    </div>
                    
                    <button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
                    <a href="coupon_code.php" class="btn btn-light">Cancel</a>
                  </form>
                </div>
              </div>
				</div>
              </div>
            </div>
          </div>
          
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2018 <a href="https://www.urbanui.com/" target="_blank">Urbanui</a>. All rights reserved.</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <?php include('footer.php'); ?>
</body>
</html>