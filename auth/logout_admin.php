<?php

session_start();
require_once('../config.php');
if (isset($_SESSION['adminlogerid'])) {
    $userId = $_SESSION['user_id'];
    $query = "UPDATE users SET remember_me_token = NULL WHERE id = $userId";
    $stmt = mysqli_query($conn, $query);

    // Clear the "Remember Me" cookie
    setcookie('remember_me_admin', '', time() - 3600, '/');
}
unset($_SESSION['adminlogerid']);
unset($_SESSION['user_id']);
header('Location: http://localhost/authentication/auth/login.php');

?>