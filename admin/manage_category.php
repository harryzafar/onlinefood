<?php
include('top.php');

$id = "";
$category = "";
$order_number = "";
$error = "";

if(isset($_GET['id']) && $_GET['id'] > 0){
  $id = get_safe_value($_GET['id']);
  $result = mysqli_query($conn, "SELECT * from category where id = '$id'") or die('search query failed');
  $row = mysqli_fetch_assoc($result);
  $category = $row['category'];
  $order_number = $row['order_number'];
}



if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['submit'])){
        $category = get_safe_value($_POST['category']);
        $order_number = get_safe_value($_POST['order_number']);
        $added_on = date('Y-m-d h:i:s');

        if($id == ''){
          $check_cateogry_query = "SELECT * FROM category where category = '$category'";
        }else{
          $check_cateogry_query = "SELECT * FROM category where category = '$category' AND id != '$id'";
        }
        
        if(mysqli_num_rows(mysqli_query($conn, $check_cateogry_query)) > 0 ){
            $error = "This category is already Exist";
        }
        else{
          if($id == ''){
            $sql = "INSERT INTO category (category, order_number, status, added_on) values ('$category', '$order_number', 1, '$added_on')";
          }else{
            $sql = "UPDATE category set category = '$category', order_number = '$order_number' where id = '$id'";
          }
            
            $query = mysqli_query($conn , $sql) or die("add/edit query failed");
            if($query){
                redirect('category.php');
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
            <h4 class="mb-3">Manage Category</h4>
              <div class="row">
                <div class="col-12">
                <div class="card">
                <div class="card-body">
                  <form class="forms-sample" method="post">
                    <div class="form-group">
                      <label for="exampleInputName1">Category Name</label>
                      <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" name="category" value="<?php echo $category;?>">
                      <p class="text-danger mt-2"><?php echo $error ;?></p>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword4">Order Number</label>
                      <input type="text" class="form-control" id="exampleInputPassword4" placeholder="Order Number" name="order_number" value="<?php echo $order_number;?>">
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