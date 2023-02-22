<?php
include('top.php');

$error = "";
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['submit'])){
        $category = get_safe_value($_POST['category']);
        $order_number = get_safe_value($_POST['order_number']);
        $status = get_safe_value($_POST['status']);
        $added_on = date('Y-m-i h:i:s');

        $check_cateogry = mysqli_query($conn, "SELECT * FROM category where category = '$category'");
        if( mysqli_num_rows($check_cateogry) > 0 ){
            $error = "This category is already Exist";
        }
        else{
            $sql = "INSERT INTO category (category, order_number , status , added_on) values ('$category', '$order_number', '$status', '$added_on')";
            $insert = mysqli_query($conn , $sql) or die("add query failed");
            if($insert){
                redirect('category.php');
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
            <h4 class="mb-3">Add Category</h4>
              <div class="row">
                <div class="col-12">
                <div class="card">
                <div class="card-body">
                  <form class="forms-sample" method="post">
                    <div class="form-group">
                      <label for="exampleInputName1">Category Name</label>
                      <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" name="category">
                      <p class="text-danger mt-2"><?php echo $error ;?></p>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword4">Order Number</label>
                      <input type="text" class="form-control" id="exampleInputPassword4" placeholder="Order Number" name="order_number">
                    </div>
                    <div class="form-group">
                      <label for="status">Status:</label><br>
                      <label for="active">Active</label>
                      <input type="radio" id="active" checked  name="status" value="1">
                      <label for="deactive">Deactive</label>
                      <input type="radio" id="deactive" name="status" value="0">
                    </div>
                    
                    <button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
                    <a href="category.php" class="btn btn-light">Cancel</a>
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