<?php

session_start();
if(!isset($_SESSION['adminlogerid'])){
    header('Location: http://localhost/applycoupon/auth/login.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Coupon</title>
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

        .success-msg{
            color: rgb(0, 230, 0);
            text-align: center;
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
        <h1>Create Coupon</h1>
        <?php
            include('../config.php');
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $code = $_POST["code"];
                $discount_amount = $_POST["discount_amount"];
                $expiration_date = $_POST["expiration_date"];
                $max_usage = $_POST["max_usage"];

                $check = "select * from coupons_data where code = '$code'";
                $result = mysqli_query($conn, $check);
                if(mysqli_num_rows($result) > 0){
                    echo "<p class='error-msg'>Coupon already exist!</p>";
                }else{
                    $sql = "INSERT INTO coupons_data (code, discount_amount, expiration_date, max_usage)
                            VALUES ('$code', $discount_amount, '$expiration_date', $max_usage)";
                
                    if ($conn->query($sql) === TRUE) {
                        echo "<p class='success-msg'>Coupon created successfully!</p>";
                    } else {
                        echo "<p class='error-msg'>Error creating coupon: " . $conn->error . "</p>";
                    }
                }
            }
        ?>
            <form action="" method="post">
                <div>
                    <label for="code">Coupon Code</label><br>
                    <input type="text" name="code" required><br>
                </div>
                <div>
                    <label for="discount_amount">Discount Amount</label><br>
                    <input type="text" name="discount_amount" required><br>
                </div>
                <div>
                    <label for="expiration_date">Expiration Date</label><br>
                    <input type="date" name="expiration_date" required><br>
                </div>
                <div>
                    <label for="max_usage">Max Usage</label><br>
                    <input type="text" name="max_usage" required><br>
                </div>
                <div class="formbtn">
                    <button type="submit">Create Coupon</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>