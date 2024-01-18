<?php

session_start();
unset($_SESSION['logerid']);
unset($_SESSION['userid']);
header('Location: http://localhost/applycoupon/auth/login.php');

?>