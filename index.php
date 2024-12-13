<?php
    if (!isset($_COOKIE["session_id"])) {
        header('Location: login.php');
        die();
    }
?>

<?php
    include('utils/db_conn.php');
    include('utils/user_management.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="script.js" defer></script>
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

  <section id="lists-section">
    <div class="center">
      <button onclick="addList()" class="add-button">Add List <img src="css/plus.png" alt="Icon" width="20" height="20"></button>
    </div>
    <div id="lists-container">
    </div>
  </section>
  <script>
  