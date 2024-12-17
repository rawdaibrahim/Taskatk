<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Login</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="css/style.css">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Playwrite+HR+Lijeva:wght@100..400&family=Playwrite+HU:wght@100..400&display=swap" rel="stylesheet">
	</head>
	<body class="body">
		<div class="container">
			<form id="login-form" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
				<h1>Login</h1>
				<div class="input-box">
					<label for="username">Username</label>
					<input type="text" id="username" name="username" required>
				</div>
				<div class="input-box">
					<label for="password">Password</label>
					<input type="password" id="password" name="password" required>
				</div>
				<p style="font-size: 14px; padding-left: 10px; color: #5f5f5f;">
					Don't have an account? 
					<a href="signup.php" style="color: rgb(49, 49, 219); text-decoration: none;">Sign Up</a>
				</p>        
				<div class="button-container">
					<button type="submit" class="submit">Login</button>
				</div>
				<?php
					include('utils/db_conn.php');
					include('utils/user_management.php');

					if($_SERVER["REQUEST_METHOD"] == "POST"){
						$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
						$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
						if (empty($username)) {
							echo "Please enter a username";
						}
						elseif (empty($password)) {
							echo "Please enter a password";
						}
						else{
							$success = login($conn, $username, $password);
							if ($success) {
								echo <<<EOD
									<p style='font-size: 16px; padding-left: 10px; color: #228B22;'>
										You have successfully logged in!
									</p>
								EOD;
								
								header('refresh:1;url=index.php');
								die();
							} else {
								echo <<<EOD
									<p style='font-size: 16px; padding-left: 10px; color: #DC143C;'>
										Username or password is incorrect
									</p>
								EOD;

							}
						}
					}
					ob_end_flush();
					disconnect($conn);
				?>
			</form>

		</div>
	</body>
</html>