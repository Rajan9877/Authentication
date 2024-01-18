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
    <title>Apply Coupon</title>
    <style>
        .container{
            text-align: center;
        }
        .formcontainer{
            display: flex;
            flex-direction: column;
        }
        .formcontainer input{
            padding: 5px 15px;
            border-radius: 50px;
        }
        .applycouponcontainer{
            margin: 5px;
        }
        .applycouponcontainer button{
            padding: 5px 15px;
            margin: 5px;
            background-color: greenyellow;
            border: 2px solid greenyellow;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }
        .applycouponcontainer button:hover{
            background-color: rgb(201, 255, 120);
        }
        .successmsg{
            background-color: greenyellow;
            position: absolute;
            right: 10px;
            padding: 10px 20px;
            border-radius: 50px;
            display: none;
        }
        .errormsg{
            background-color: red;
            position: absolute;
            right: 10px;
            padding: 10px 20px;
            border-radius: 50px;
            color: white;
            display: none;
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
    <div class="successmsg">
    </div>
    <div class="errormsg">
    </div>
    <div class="container">
    <?php

    include('navbar.php');

    ?>
        <h3>Your Total Amount</h3>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET"){
                $total_amount = $_GET["total_amount"];
                echo "<p id='total_amount'>".$total_amount."</p>";
            }
        ?>
        <div class="formcontainer">
            <form id="form">
                <label for="coupon_code">Enter Coupon Code</label><br>
                <input type="text" id="coupon_code" required><br>
                <div class="applycouponcontainer">
                    <button type="submit">Apply Coupon</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $("#form").submit(function (event) {
                var formData = {
                    coupon_code: $("#coupon_code").val(),
                };
                $.ajax({
                type: "POST",
                url: "apply_coupon.php",
                data: formData,
                }).done(function (data) {
                    var jsonResponse = JSON.parse(data);
                    if (jsonResponse.hasOwnProperty('success')) {
                        if (jsonResponse.success) {
                    var totalamount = parseInt($('#total_amount').text());
                    var totaldiscount = jsonResponse.discountAmount;
                    var payprice = totalamount - (totalamount*totaldiscount)/100;
                    $('#total_amount').html(payprice);
                    $('.successmsg').text("Applied Discount " + totaldiscount + "%");
                    $('.successmsg').fadeIn();
                    setTimeout(()=>{
                        $('.successmsg').fadeOut();
                    }, 5000);
                        }
                        else{
                            $('.errormsg').text(jsonResponse.message);
                            $('.errormsg').fadeIn();
                            setTimeout(()=>{
                                $('.errormsg').fadeOut();
                            }, 5000);
                        }
                    }
                });

                event.preventDefault();
            });
        });
    </script>
</body>
</html>