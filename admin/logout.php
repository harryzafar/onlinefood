<?php
session_start();
include('function.inc.php');
session_destroy();
redirect('login.php');

?>