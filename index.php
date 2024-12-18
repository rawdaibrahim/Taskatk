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

  <div id="modal-overlay" class="hidden">
    <div id="modal" class="modal hidden">
      <form id="task-form" onsubmit="handleTaskFormSubmit(event)">
        <h3 id="modal-title">Create Task</h3>
        <label for="task-name">Task Name*</label>
        <input type="text" id="task-name" required>
        
        <label for="task-due-date">Due Date*</label>
        <input type="date" id="task-due-date" required>

        <label for="task-description">Description</label>
        <textarea id="task-description"></textarea>

        <div class="modal-actions">
          <button type="button" onclick="closeModal()" class="cancel">Cancel</button>
          <button type="submit" class="save">Save</button>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
