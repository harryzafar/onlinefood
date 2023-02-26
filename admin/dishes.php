<?php
include('top.php');

if(isset($_GET['type']) && $_GET['type'] !== "" && isset($_GET['id']) && $_GET['id'] > 0){
    $type = $_GET['type'];
    $id = $_GET['id'];
    if($type == 'delete'){
        mysqli_query($conn, "DELETE from dish where id = '$id'");
        redirect('dishes.php');
    }
    if($type == 'active' || $type == 'deactive'){
        $status = 1;
        if($type == "deactive"){
            $status = 0;
        }
        mysqli_query($conn , "UPDATE dish set status = '$status'  where id = '$id'" );
        redirect('dishes.php');
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
            <div class="d-flex justify-content-between">
                <h4 class="mb-3">Dish Master</h4>
                <a href="manage_dish.php" class="btn btn-primary">Add Dish</a>
              </div>
              
              <div class="row mt-3">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="10%">Order #</th>
                            <th>Dish</th>
                            <th>Category</th>
                            <th>Image</th>
                            <th>Added On</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                         $sql = "SELECT dish.*, category.id as cat_id, category.category as cat_name FROM dish INNER JOIN category on dish.category_id = category.id ";
                         $result= mysqli_query($conn, $sql) or die('dish query failed');

                        if(mysqli_num_rows($result) > 0){
                            $sr = 1;
                            foreach($result as $row){?>

                            <tr>
                            <td><?php echo $sr;?></td>
                            <td><?php echo $row['dish'];?></td>
                            
                            <td><?php echo $row['cat_name'];?></td>
                            <td>
                                <img src="<?php echo DISH_IMG_PATH.$row['image'];?>" alt=""></td>
                            <td><?php
                                 $dateStr = strtotime($row['added_on']);
                                 echo date('d-m-Y', $dateStr);
                                ?>
                            </td>
                            <td>
                                <?php
                                if($row['status'] == 1){?>
                                   <a href="?id=<?php echo $row['id']?>&type=deactive" class="badge badge-success">Active</a>
                               <?php }else{?>
                                <a href="?id=<?php echo $row['id']?>&type=active" class="badge badge-warning">Deactive</a>
                               <?php ;}
                                ?>
                                <a href="manage_dish.php?id=<?php echo $row['id'];?>" class="badge badge-primary">Edit</a>
                                <a href="?id=<?php echo $row['id'];?>&type=delete" class="badge badge-danger">Delete</a>
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