<?php
session_start();
include('database.inc.php');
include('function.inc.php');
include('constant.inc.php');

if($_SESSION['is_login'] != true){
    redirect('login.php');
}

?>
