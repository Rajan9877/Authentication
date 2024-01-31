<?php

session_start();
require_once('config.php');
if (isset($_COOKIE['remember_me']) && !isset($_SESSION["logerid"])) {
    // Retrieve the token from the cookie
    $token = $_COOKIE['remember_me'];

    // Look for the token in the database
    $query = "SELECT * FROM users WHERE remember_me_token = '$token'";
    $stmt = mysqli_query($conn, $query);
    if(mysqli_num_rows($stmt) > 0){
        while($user = mysqli_fetch_assoc($stmt)) {
            // Log in the user
            $_SESSION["logerid"] = rand();
            $_SESSION["userid"] = $user['id'];
        }
    }
}
if(!isset($_SESSION["logerid"])){
    header('Location: http://localhost/authentication/auth/login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome To User Page</title>
    <style>
        h1{
            text-align: center;
        }
        .btncontainer{
            text-align: center;
        }
        .btncontainer a button {
            padding: 5px 15px;
            margin: 5px;
            background-color: red;
            border: 2px solid red;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            color: white;
        }

        .btncontainer a button:hover {
            background-color: rgb(255, 95, 95);
        }
    </style>
</head>
<body>
    <h1>Welcome User</h1>
    <div class="btncontainer">
        <a href="auth/logout_user.php"><button>Logout</button></a>
    </div>
</body>
</html>