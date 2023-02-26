<?php
$url_str = $_SERVER['REQUEST_URI'];
$url_arr = explode('/', $url_str);
$curr_page = $url_arr[count($url_arr)-1];
$page_title = "Food Ordering Admin";
if($curr_page == "" || $curr_page =="index.php"){
  $page_title = "Dashboard | Online Food Web";
}
if($curr_page == "category.php" || $curr_page =="manage_category.php" ){
  $page_title = "Category | Online Food Web";
}
if($curr_page == "coupon_code.php" || $curr_page =="manage_coupon.php"){
  $page_title = "Coupon Code | Online Food Web";
}
if($curr_page == "delivery_boy" || $curr_page =="manage_boys.php"){
  $page_title = "Delivery Boy | Online Food Web";
}
if($curr_page == "dishes.php" || $curr_page =="manage_dish.php"){
  $page_title = "Dishes | Online Food Web";
}
if($curr_page == "users.php" || $curr_page =="manage_users.php"){
  $page_title = "Users | Online Food Web";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $page_title; ?></title>
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