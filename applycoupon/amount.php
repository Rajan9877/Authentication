<?php

session_start();
if(!isset($_SESSION['logerid'])){
    header('Location: http://localhost/applycoupon/auth/login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amount Form</title>
    <style>
        h1{
            text-align: center;
        }
        .inputcontainer, .btncontainer{
            text-align: center;
        }
        .inputcontainer input{
            padding: 5px 15px;
            border-radius: 50px;
        }
        .btncontainer button{
            padding: 5px 15px;
            margin: 5px;
            background-color: greenyellow;
            border: 2px solid greenyellow;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }
        .btncontainer button:hover {
            background-color: rgb(201, 255, 120);
        }
        nav{
            text-align: center;
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
    <?php

        include('navbar.php');

    ?>
    <h1>Total Amount</h1>
    <div class="inputcontainer">
        <input type="text" id="total_amount" placeholder="Enter Total Amount">
    </div>
    <div class="btncontainer">
        <button onclick="redirectFunc()">Submit</button>
    </div>
    <script>
        function redirectFunc(){
            var total_amount = document.getElementById("total_amount").value;
            window.location.href = "http://localhost/applycoupon/applycoupon/applycoupon.php?total_amount="+total_amount;
        }
    </script>
</body>
</html>