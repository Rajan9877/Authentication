<?php

session_start();
unset($_SESSION['adminlogerid']);
unset($_SESSION['user_id']);
header('Location: http://localhost/applycoupon/auth/login.php');

?>