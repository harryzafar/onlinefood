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
      $added_on = date('Y-m-i h:i:s');

        if($id == ''){
          $check_cateogry_query = "SELECT * FROM delivery_boy where mobile = '$mobile'";
        }else{
          $check_cateogry_query = "SELECT * FROM delivery_boy where mobile = '$mobile' AND id != '$id'";
        }
        
        if(mysqli_num_rows(mysqli_query($conn, $check_cateogry_query)) > 0 ){
            $error = "This Boy's number is already Exist";
        }
        else{
          if($id == ''){
            $sql = "INSERT INTO delivery_boy (name, mobile, password, status, added_on) values ('$name', '$mobile', $password, 1, '$added_on')";
          }else{
            $sql = "UPDATE delivery_boy set name = '$name', mobile = '$mobile', password = '$password' where id = '$id'";
          }
            
            $query = mysqli_query($conn , $sql) or die("add/edit query failed");
            if($query){
                redirect('delivery_boy.php');
            }
            else{
                $error = "Something went Wrong in inserting";
            } 
        }
        
        

    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Food Ordering Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="assets/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="assets/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="assets/css/bootstrap-datepicker.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>
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
                      <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" name="name" value="<?php echo $name;?>">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword4">Mobile</label>
                      <input type="text" class="form-control" id="exampleInputPassword4" placeholder="Mobile" name="mobile" value="<?php echo $mobile;?>">
                      <p class="text-danger mt-2"><?php echo $error ;?></p>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword2">Password</label>
                      <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password" name="password" value="<?php echo $password;?>">
                    </div>
                    
                    <button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
                    <a href="delivery_boy.php" class="btn btn-light">Cancel</a>
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