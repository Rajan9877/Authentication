<?php
session_start();
if(!isset($_SESSION['logerid'])){
    header('Location: http://localhost/applycoupon/auth/login.php');
}
include('../config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $coupon_code = $_POST["coupon_code"];
    $userid = $_SESSION['userid'];
    $check_usage_sql = "SELECT * FROM coupon_usage WHERE user_id = $userid AND coupon_id = (SELECT coupon_id FROM coupons_data WHERE code = '$coupon_code')";
    $usage_result = $conn->query($check_usage_sql);
    if ($usage_result->num_rows > 0){
        echo json_encode(array('success' => false, 'message' => 'You have already used this coupon.'));
        exit;
    }else{   
    $sql = "SELECT * FROM coupons_data WHERE code = '$coupon_code'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    
        if ($row["current_usage"] < $row["max_usage"]) {
            $expiration_date_obj = new DateTime($row["expiration_date"]);
            $current_date = new DateTime();
            if ($current_date > $expiration_date_obj) {
                echo json_encode(array('success' => false, 'message' => 'Coupon has expired!'));
                exit;
            }
            if(isset($_SESSION['coupon_used'])){
                echo json_encode(array('success' => false, 'message' => 'You have already used one coupon code on this.'));
                exit;
            }
            $discount_amount = $row["discount_amount"];
            $current_usage = $row["current_usage"] + 1;
    
            $update_sql = "UPDATE coupons_data SET current_usage = $current_usage WHERE coupon_id = " . $row["coupon_id"];
            $conn->query($update_sql);
            
            $record_usage_sql = "INSERT INTO coupon_usage (user_id, coupon_id) VALUES ($userid,". $row["coupon_id"] .")";
            $conn->query($record_usage_sql);
            // Return JSON response with success and discount amount
            $_SESSION['coupon_used'] = true;
            echo json_encode(array('success' => true, 'discountAmount' => (int)$discount_amount));
            exit;
        } else {
            // Return JSON response with failure message
            echo json_encode(array('success' => false, 'message' => 'Coupon has reached its maximum usage limit.'));
            exit;
        }
    } else {
        // Return JSON response with failure message
        echo json_encode(array('success' => false, 'message' => 'Invalid coupon code.'));
        exit;
    }
    } 

}
