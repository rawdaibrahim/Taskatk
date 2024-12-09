<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Playwrite+HR+Lijeva:wght@100..400&family=Playwrite+HU:wght@100..400&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <form id="signup-form" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <h1>Sign Up</h1>
            <div class="input-box">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-box">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-box">
                <label for="signup-user-type">Subscription</label>
                <select id="signup-user-type" name="subscription">
                    <option value=1>Basic</option>
                    <option value=2>Premium</option>
                </select>
            </div>
            <p style="font-size: 15px; padding-left: 10px; color: #5f5f5f;">
                Already have an account?
                <a href="login.php" style="color: blue; text-decoration: none;">Login</a>
            </p>

            <div class="button-container">
                <button type="submit">Sign Up</button>
            </div>

            <?php
                include('utils/db_conn.php');
                include('utils/user_management.php');

                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    $username = filter_input (INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
                    $password = filter_input (INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
                    $subscription = filter_input (INPUT_POST, "subscription", FILTER_SANITIZE_SPECIAL_CHARS);
                    if (empty($username)) {
                        echo "Please enter a username";
                    }
                    elseif (empty($password)) {
                        echo "Please enter a password";
                    }
                    elseif (empty($subscription)) {
                        echo "Please choose a subscription";
                    }
                    else{
                        $success = signup($conn, $username, $password, $subscription);
                        if ($success) {
                            echo <<<EOD
                                <pre style='font-size: 16px; padding-left: 10px; color: #228B22;'>
                                    You have successfully created an account!
                                    You will be redirected to the login page now.
                                </pre>
                            EOD;
                            
                            header('refresh:4;url=login.php');
                            die();
                        } else {
                            echo <<<EOD
                                <p style='font-size: 16px; padding-left: 10px; color: #DC143C;'>
                                    Please check the entered data and try again.
                                </p>
                            EOD;

                        }
                    }
                }

                disconnect($conn);
            ?>
        </form>
    </div>
</body>
</html>
