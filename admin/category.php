<?php
include('top.php');
if(isset($_GET['type']) && $_GET['type'] !== "" && isset($_GET['id']) && $_GET['id'] > 0){
    $type = $_GET['type'];
    $id = $_GET['id'];
    if($type == 'delete'){
        mysqli_query($conn, "DELETE from category where id = '$id'");
        redirect('category.php');
    }
    if($type == 'active' || $type == 'deactive'){
        $status = 1;
        if($type == "deactive"){
            $status = 0;
        }
        mysqli_query($conn , "UPDATE category set status = '$status'  where id = '$id'" );
        redirect('category.php');
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
              <div class="d-flex justify-content-between">
                <h4 class="mb-3">Category Master</h4>
                <a href="add_category.php" class="btn btn-primary">Add Category</a>
              </div>
              <div class="row mt-3">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="10%">Order #</th>
                            <th>Category</th>
                            <th>Order_number</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                         $sql = "SELECT * FROM category order by order_number";
                         $result= mysqli_query($conn, $sql) or die('category query failed');

                        if(mysqli_num_rows($result) > 0){
                            $sr = 1;
                            foreach($result as $row){?>

                            <tr>
                            <td><?php echo $sr;?></td>
                            <td><?php echo $row['category'];?></td>
                            <td><?php echo $row['order_number']; ?></td>
                            <td>
                                <?php
                                if($row['status'] == 1){?>
                                   <a href="?id=<?php echo $row['id']?>&type=deactive" class="badge badge-success">Active</a>
                               <?php }else{?>
                                <a href="?id=<?php echo $row['id']?>&type=active" class="badge badge-warning">Deactive</a>
                               <?php ;}
                                ?>
                            </td>
                            <td>
                              <a href="" class="btn btn-primary">Edit</a>
                              <a href="?id=<?php echo $row['id'];?>&type=delete" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                         <?php $sr++; } 
                        }else{?>
                            <tr>
                            <td colspan="5" class="text-center">No data found</td>
                            
                        </tr>

                       <?php } ?>
                       
                      </tbody>
                    </table>
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