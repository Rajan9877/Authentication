<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    </style>
</head>

<body>
    <div class="formcontainer">
    <div class="formholder">
    <h1>Login</h1>
    <?php

        include('../config.php');
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $remember_me = isset($_POST['remember_me']);
            $check = "select * from users where email = '$email'";
            $checkresult = mysqli_query($conn, $check);
            if(mysqli_num_rows($checkresult) > 0){
                $row = mysqli_fetch_assoc($checkresult);
                if(password_verify($password, $row['password'])){
                    if($row['role'] == '1'){
                        $_SESSION["adminlogerid"] = rand();
                        $_SESSION["user_id"] = $row['id'];
                        if ($remember_me) {
                            $token = bin2hex(random_bytes(32)); // Generate a random token
                            
                            // Store the token in the database
                            $userId = $row['id']; // Replace with the actual user ID
                            $query = "UPDATE users SET remember_me_token = '$token' WHERE id = $userId";
                            $stmt = mysqli_query($conn, $query);
                    
                            // Set the token as a cookie (expires in 30 days)
                            setcookie('remember_me_admin', $token, time() + (30 * 24 * 60 * 60), '/');
                        }
                        header('Location: http://localhost/authentication/welcome_admin.php');
                    }else{
                        $_SESSION["logerid"] = rand();
                        $_SESSION["userid"] = $row['id'];
                        if ($remember_me) {
                            $token = bin2hex(random_bytes(32)); 
                            
                            // Store the token in the database
                            $userId = $row['id']; // Replace with the actual user ID
                            $query = "UPDATE users SET remember_me_token = '$token' WHERE id = $userId";
                            $stmt = mysqli_query($conn, $query);
                            // $stmt->execute(['token' => $hashedToken, 'id' => $userId]);
                    
                            // Set the token as a cookie (expires in 30 days)
                            setcookie('remember_me', $token, time() + (30 * 24 * 60 * 60), '/');
                        }
                        header('Location: http://localhost/authentication/welcome_user.php');
                    }
                }else{
                    echo "<p class='error-msg'>Password is incorrect!</p>";
                }
            }else{
                echo "<p class='error-msg'>User does not exist!</p>";
            }
        }

    ?>
            <form action="" method="post">
                <div>
                    <label for="code">Email</label><br>
                    <input type="email" name="email" required><br>
                </div>
                <div>
                    <label for="password">Password</label><br>
                    <input type="password" name="password" required><br>
                </div>
                <div>
                    <input type="checkbox" name="remember_me" id="remember_me">
                       <label for="remember_me">Remember Me</label>
                </div>
                <div class="formbtn">
                    <button type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>