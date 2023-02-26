
<?php
include('top.php');

$id = "";
$dish = "";
$category_id = "";
$dish_detail = "";
$image = "";
$error = "";
$img_error = "";
if(isset($_GET['id']) && $_GET['id'] > 0){
  $id = get_safe_value($_GET['id']);
  $result = mysqli_query($conn, "SELECT * from dish where id = '$id'") or die('search query failed');
  $row = mysqli_fetch_assoc($result);
  $dish = $row['dish'];
  $category_id = $row['category_id'];
  $dish_detail = $row['dish_detail'];
}



if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['submit'])){
      $dish = get_safe_value($_POST['dish']);
      $category_id = get_safe_value($_POST['category_id']);
      $dish_detail = get_safe_value($_POST['dish_detail']);
      $image = $_FILES['image']['name'];
      $added_on = date('Y-m-d h:i:s');

        if($id == ''){
          $check_query = "SELECT * FROM dish where dish = '$dish'";
        }else{
          $check_query = "SELECT * FROM dish where dish = '$dish' AND id != '$id'";
        }
        
        if(mysqli_num_rows(mysqli_query($conn, $check_query)) > 0 ){
            $error = "This Dish name is already Exist";
        }
        else{
          if($id == ''){
            if(! file_exists($_FILES['image']['tmp_name'])){
              $img_error = "Image must be required";
            }else{
              $type = $_FILES['image']['type'];
              if($type != 'image/jpg' && 'image/jpeg' && 'image/png'){
                $img_error = "file format not valid";
              }else{
              move_uploaded_file($_FILES['image']['tmp_name'], DISH_UPLOAD_PATH.$image);
              $sql = "INSERT INTO dish (category_id, dish, dish_detail, image, status, added_on ) values('$category_id', '$dish', '$dish_detail', '$image', 1 , '$added_on')";
              $query = mysqli_query($conn , $sql) or die("add query failed");
              if($query){
                redirect('dishes.php');
              }
              else{
                $error = "Something went Wrong in inserting";
              }
             } 
            }  
          }else{
            if(file_exists($_FILES['image']['tmp_name'])){
              $type = $_FILES['image']['type'];
              if($type != 'image/jpg' && 'image/jpeg' && 'image/png'){
                $img_error = "file format not valid";
              }else{
              move_uploaded_file($_FILES['image']['tmp_name'], DISH_UPLOAD_PATH.$image);
              $sql = "UPDATE dish set category_id = '$category_id', dish = '$dish', dish_detail = '$dish_detail', image= '$image' where id = '$id'";
              $query = mysqli_query($conn , $sql) or die("add query failed");
              if($query){
                redirect('dishes.php');
              }
              else{
                $error = "Something went Wrong in inserting";
              }
             }
            }else{
              $sql = "UPDATE dish set category_id = '$category_id', dish = '$dish', dish_detail = '$dish_detail' where id = '$id'";
              $query = mysqli_query($conn , $sql) or die("add query failed");
              if($query){
                redirect('dishes.php');
              }
              else{
                $error = "Something went Wrong in inserting";
              }
            }
            
          }
            
            
        }
        
        

    }
}

$category_row = mysqli_query($conn, "SELECT * from category where status = '1' order by category") or die("category query failed");


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
            <h4 class="mb-3">Manage Dish</h4>
              <div class="row">
                <div class="col-12">
                <div class="card">
                <div class="card-body">
                  <form class="forms-sample" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="exampleInputName1">Dish</label>
                      <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" name="dish" value="<?php echo $dish;?>">
                      <p class="text-danger mt-2"><?php echo $error ;?></p>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword4">Category</label>
                      <select class="form-control" name="category_id" id="exampleInputPassword4">
                        <option value="">Select Type</option>
                        <?php
                        
                        foreach($category_row as $row ){
                          if($row['id'] == $category_id){
                            echo '<option value="'.$row['id'].'" selected >'.$row['category'].'</option>';
                          }else{
                            echo '<option value="'.$row['id'].'">'.$row['category'].'</option>';
                          }
                            
                          
                     
                         }
                        ?>
                      </select>
                      
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword2">Dish Detail</label>
                      <textarea name="dish_detail" id="exampleInputPassword2" class="form-control" cols="30" rows="10" placeholder="Dish Details"><?php echo $dish_detail;?></textarea>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword7">Dish Image</label>
                      <input type="file" class="form-control" id="exampleInputName7"  name="image">
                      <p class="text-danger mt-2"><?php echo $img_error ;?></p>
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