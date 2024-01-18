<?php 
    session_start();
    if(!isset($_SESSION['adminlogerid'])){
        header('Location: http://localhost/applycoupon/auth/login.php');
    }
    if(!isset($_GET['id'])){
        echo "<p style='color: red;'>Id is not set.</p>";
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Coupon</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        h1 {
            text-align: center;
            margin-bottom: 15px;
        }

        .formcontainer {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100%;
        }

        .formcontainer form {
            text-align: center;
        }

        .formcontainer form div {
            margin-bottom: 5px;
        }

        .formcontainer form div input {
            padding: 5px 15px;
            border-radius: 50px;
        }

        .formbtn {
            text-align: center;
        }

        .formbtn button {
            padding: 5px 15px;
            margin: 5px;
            background-color: greenyellow;
            border: 2px solid greenyellow;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .formbtn button:hover {
            background-color: rgb(201, 255, 120);
        }

        .error-msg{
            color: rgb(230, 0, 0);
            text-align: center;
        }
        .formholder{
            padding: 50px;
            border-radius: 50px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        }
        .logoutbtn{
            padding: 5px 15px;
            margin: 5px;
            background-color: red;
            border: 2px solid red;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            color: white;
        }
        .logoutbtn:hover{
            background-color: rgb(255, 72, 72);
        }
    </style>
</head>

<body>
    <div class="formcontainer">
        <?php

        include('navbar.php');

        ?>
        <div class="formholder">
        <h1>Update Coupon</h1>
        <?php
            include('../config.php');
            $id = $_GET['id'];
            $sql = "select * from coupons_data where coupon_id = $id";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
        ?>
        <?php
         if ($_SERVER["REQUEST_METHOD"] == "POST") {
           
                $updateid = $_POST["updateid"];
                $code = $_POST["code"];
                $discount_amount = $_POST["discount_amount"];
                $expiration_date = $_POST["expiration_date"];
                $max_usage = $_POST["max_usage"];
                $current_usage = $_POST["current_usage"];
                
                $check = "select * from coupons_data where code = '$code' AND coupon_id != $updateid";
                $result = mysqli_query($conn, $check);
                if(mysqli_num_rows($result) > 0){
                    echo "<p class='error-msg'>Coupon already exist!</p>";
                }else{
                $sql = "UPDATE coupons_data
                SET code = '$code', discount_amount = $discount_amount, expiration_date = '$expiration_date', max_usage = $max_usage, current_usage = $current_usage
                WHERE coupon_id = $updateid";

                if ($conn->query($sql) === TRUE) {
                    header("Location: http://localhost/applycoupon/createcoupon/coupons.php");
                } else {
                    echo "<p class='error-msg'>Error updating coupon: " . $conn->error . "</p>";
                }
                }
            }
        ?>
        <form action="" method="post">
            <div>
                <input type="hidden" name="updateid" value="<?php echo $row['coupon_id'] ?>">
            </div>
            <div>
                <label for="code">Coupon Code</label><br>
                <input type="text" name="code" value="<?php echo $row['code'] ?>" required><br>
            </div>
            <div>
                <label for="discount_amount">Discount Amount</label><br>
                <input type="text" name="discount_amount" value="<?php echo $row['discount_amount'] ?>" required><br>
            </div>
            <div>
                <label for="expiration_date">Expiration Date</label><br>
                <input type="date" name="expiration_date" value="<?php echo $row['expiration_date'] ?>" required><br>
            </div>
            <div>
                <label for="max_usage">Max Usage</label><br>
                <input type="text" name="max_usage" value="<?php echo $row['max_usage'] ?>" required><br>
            </div>
            <div>
                <label for="current_usage">Current Usage</label><br>
                <input type="text" name="current_usage" value="<?php echo $row['current_usage'] ?>" required><br>
            </div>
            <div class="formbtn">
                <button type="submit">Update Coupon</button>
            </div>
        </form>
        </div>
    </div>
</body>

</html>