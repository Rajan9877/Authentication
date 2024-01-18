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
    <title>All Created Coupons</title>
    <style>
        .container{
            text-align: center;
        }
        table{
            margin: auto;
        }
        table{
            border-collapse: collapse;
            border-radius: 50px;
            overflow: hidden; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); 
        }

        th, td {
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th:first-child, td:first-child {
            border-left: 1px solid #ddd;
        }

        th:last-child, td:last-child {
            border-right: 1px solid #ddd;
        }
        .editbtn{
            padding: 5px 15px;
            margin: 5px;
            background-color: greenyellow;
            border: 2px solid greenyellow;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }
        .editbtn:hover{
            background-color: rgb(201, 255, 120);
        }
        .deletebtn{
            padding: 5px 15px;
            margin: 5px;
            background-color: red;
            border: 2px solid red;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            color: white;
        }
        .deletebtn:hover{
            background-color: rgb(255, 72, 72);
        }
        .createcouponbtn{
            padding: 5px 15px;
            margin: 5px;
            background-color: greenyellow;
            border: 2px solid greenyellow;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }
        .createcouponbtn:hover{
            background-color: rgb(201, 255, 120);
        }
        .createcouponcontainer{
            margin-bottom: 20px;
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
    <div class="container">
        <?php

        include('navbar.php');

        ?>
        <h1>Manage Your Coupons</h1>
        <div class="createcouponcontainer">
            <a href="create.php"><button class="createcouponbtn">Create Coupon</button></a>
        </div>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">Code</th>
                <th scope="col">Discount Amount</th>
                <th scope="col">Expiration Date</th>
                <th scope="col">Max Usage</th>
                <th scope="col">Current Usage</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
            <?php 
                include('../config.php');
                $sql = "select * from coupons_data";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
            ?>
              <tr>
                <td><?php echo $row['code']; ?></td>
                <td><?php echo $row['discount_amount']; ?></td>
                <td><?php echo $row['expiration_date']; ?></td>
                <td><?php echo $row['max_usage']; ?></td>
                <td><?php echo $row['current_usage']; ?></td>
                <td>
                    <a href="couponupdate.php?id=<?php echo $row['coupon_id']; ?>"><button class="editbtn">Edit</button></a>
                    <a href="coupondelete.php?id=<?php echo $row['coupon_id']; ?>"><button class="deletebtn">Delete</button></a>
                </td>
              </tr>
            <?php
                    }
                }
            ?>
            </tbody>
          </table>
    </div>
</body>
</html>