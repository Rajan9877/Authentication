<?php
session_start();
if(!isset($_SESSION['adminlogerid'])){
    header('Location: http://localhost/applycoupon/auth/login.php');
}
include('../config.php');
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "delete from coupons_data where coupon_id = $id";
    $result = mysqli_query($conn, $sql);
    header("Location: http://localhost/applycoupon/createcoupon/coupons.php");
}else{
echo "<p style='color: red;'>Id is not set.</p>";
}

?>