<?php
  if (!isset($_COOKIE["session_id"])) {
    header('Location: login.php');
    die();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to Taskatk</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    /* General Page Styling */
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #f9f9fa;
      text-align: center;
    }

    /* Container */
    .welcome-container {
      background-color: #fff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      max-width: 600px;
      width: 90%;
    }

    /* Heading */
    .welcome-container h1 {
      color: rgb(53, 50, 149);
      font-size: 2.5rem;
      margin-bottom: 10px;
    }

    /* Motivational Message */
    .welcome-container p {
      font-size: 1.1rem;
      color: #555;
      margin-bottom: 20px;
      line-height: 1.6;
    }

    /* Call-to-Action Button */
    .start-button {
      display: inline-block;
      padding: 12px 20px;
      font-size: 1rem;
      font-weight: bold;
      color: #fff;
      background-color: rgb(76, 73, 151); /* Button color in harmony with your app */
      border: none;
      border-radius: 6px;
      text-decoration: none;
      transition: 0.3s ease, transform 0.2s ease;
    }

    .start-button:hover {
      background-color: rgb(53, 50, 149);
      transform: scale(1.05);
    }

    /* Footer */
    .footer {
      margin-top: 20px;
      font-size: 0.9rem;
      color: #777;
    }
  </style>
</head>
<body>
    <div class="nav">
        <h1>
            <img src="css/to-do-list.png" alt="Icon" width="29" height="29">
            Taskatk
        </h1>
        <div>
            <a href="index.php" class="link">Home</a>
            <a href="monthly-tasks.php" class="link">Monthly Tasks</a>
            <a href="About.php" class="link">About Us</a>
            <a href="contact.php" class="link">Contact Us</a>
        </div>
  </div>
  <!-- Welcome Container -->
  <div class="welcome-container">
    <h1>Welcome to Taskatk ✨</h1>
    <p>
      Take control of your time, organize your tasks, and achieve your goals.  
      Start building your daily lists and make every moment count!
    </p>
    <p>
      Whether it's planning assignments, projects, or simple tasks, Taskatk is here to help you stay organized.
    </p>
    <a href="index.php" class="start-button">Start Creating Tasks 🚀</a>
    <div class="footer">
      &copy; 2024 Taskatk Team | Make Today Productive 💻🧠
    </div>
  </div>
</body>
</html>
