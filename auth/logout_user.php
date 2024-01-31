<?php

session_start();
require_once('../config.php');
if (isset($_SESSION['logerid'])) {
    $userId = $_SESSION['userid'];
    $query = "UPDATE users SET remember_me_token = NULL WHERE id = $userId";
    $stmt = mysqli_query($conn, $query);

    // Clear the "Remember Me" cookie
    setcookie('remember_me', '', time() - 3600, '/');
}
unset($_SESSION['logerid']);
unset($_SESSION['userid']);
header('Location: http://localhost/authentication/auth/login.php');

?>