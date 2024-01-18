<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
        
        .formcontainer form div select {
            padding: 5px 15px;
            border-radius: 50px;
            border: 2px solid rgb(66, 66, 66);
            width: 100%;
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
    <h1>Sign Up</h1>
        <?php
              include('../config.php');
              if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $confirmpassword = $_POST['confirmpassword'];
                $role = $_POST['role'];

                $isValid = true;
                $errorMessages = array();

                if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errorMessages[] = "Invalid email address!";
                    $isValid = false;
                }
                if (empty($password)) {
                    $errorMessages[] = "Password cannot be empty";
                    $isValid = false;
                }
                if (strlen($password) < 6 || strlen($password) > 15) {
                    $errorMessages[] = "Password must be between 6 and 15 characters";
                    $isValid = false;
                } 
                if (!preg_match('/^[a-zA-Z0-9!@#$%^&*()_+]+$/', $password)) {
                    $errorMessages[] = "Password should only contain alphanumeric and special symbols";
                    $isValid = false;
                }
                if ($password !== $confirmpassword) {
                    $errorMessages[] = "Passwords didn't match!";
                    $isValid = false;
                }
                foreach ($errorMessages as $errorMessage) {
                    echo "<p class='error-msg'>$errorMessage</p>";
                }
                if($isValid){
                    $table_exist = "SELECT COUNT(*) as count FROM users";
                    $table_exist_result = mysqli_query($conn, $table_exist);
                    if(mysqli_num_rows($table_exist_result) > 0){
                        $check = "select * from users where email = '$email'";
                        $checkresult = mysqli_query($conn, $check);
                        if(mysqli_num_rows($checkresult) > 0){
                            echo "<p class='error-msg'>User already exist!</p>";
                        }else{
                            $sql = "INSERT INTO users (email, password, role)
                            VALUES ('$email', '$password', '$role')";
                            $result = mysqli_query($conn, $sql);
                            if($result){
                                echo "<p class='success-msg'>User created successfully!</p>";
                            }
                    }
                   
                    }else{
                        $sql = "INSERT INTO users (email, password)
                            VALUES ('$email', '$password')";
                            $result = mysqli_query($conn, $sql);
                            if($result){
                                echo "<p class='success-msg'>User created successfully!</p>";
                            }
                    }
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
                    <label for="confirmpassword">Confirm Password</label><br>
                    <input type="password" name="confirmpassword" required><br>
                </div>
                <div>
                    <label for="role">Sign Up As</label><br>
                    <select name="role">
                        <option value="0">User</option>
                        <option value="1">Admin</option>
                    </select>
                </div>
                <div class="formbtn">
                    <button type="submit">Sign Up</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>