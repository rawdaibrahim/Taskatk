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
      <pre style="text-align: center; font-size: 18px;">We are here to help. Ready to get in touch?
        Please fill out the form below and we will get back to you as soon as possible</pre>
      <div style="display: flex;">
        <input type="text" id="name" placeholder="Your Name" required>
        <!-- <input type="email" id="email" placeholder="Your Email" required> -->
      </div>
      <textarea id="message" placeholder="Your Message" required></textarea>
      <div class="center">
        <a href="#" onclick="mailFn()" id="contact"  class="submit" >Send</a>
      </div>
      
    </form>
  </section>

  <script>
    function mailFn() {
      let contact = document.getElementById('contact').value;
      let name = document.getElementById('name').value;
      let message = document.getElementById('message').value;
      let link =
        "mailto:admin@taskatk.com?subject=Asking for help&body="
        + encodeURIComponent(message + "\n\n" + "With regards,\n" + name);
      window.location.href = link;
    }
  </script>

</body>
</html>