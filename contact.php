<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us</title>
  <link rel="stylesheet" href="css/style.css">
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
  <div class="form-div">
    <form id="contact-form">
      <p>where learning knows no bounds! <br> Access high-quality courses offered by educators spanning every corner of Egypt</p>
      <div style="display: flex;">
        <input type="text" id="name" placeholder="Your Name" required>
        <input type="email" id="email" placeholder="Your Email" required>
      </div>
      <textarea id="message" placeholder="Your Message" required></textarea>
      <div class="center">
        <button type="submit"  class="submit" >Send</button>
      </div>
      
    </form>
  </section>

</body>
</html>