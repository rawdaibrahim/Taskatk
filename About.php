<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    /* General Page Styling */
   /* General Page Styling */
/* General Page Styling */
body {
  line-height: 1.6;
  margin: 0;
  padding: 0;
  background-color: #f9f9fa; /* Slightly off-white */
  color: #333;
  padding-top: 70px; /* Adjust for fixed navbar */
}

/* Header Styling */
header {
  color: rgb(53, 50, 149); /* Dark blue text */
  text-align: center;
  padding-top: 5px ;
  
}

header h1 {
  margin: 0;
  font-size: 2.5rem;
  font-weight: bold;
  letter-spacing: 1px;
  text-align: center;
  display: block;
}

header p {
  font-size: 1rem;
  color: #555;
  margin-top: 5px;
}

/* Main Content Styling */
main {
  max-width: 800px;
  margin: 20px auto;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  padding: 20px;
}

/* Section Titles */
h2 {
  color: rgb(53, 50, 149); /* Matching nav blue */
  font-size: 1.5rem;
  margin-bottom: 10px;
  border-left: 4px solid rgb(129, 123, 181);
  padding-left: 10px;
}

/* Paragraph Styling */
p {
  font-size: 1rem;
  color: #555;
  margin: 10px 0;
}

/* Team Section Styling */
.team-section {
  margin-top: 20px;
}

.team-member {
  background-color: #f1f1f1; /* Light gray for contrast */
  border: 1px solid #ddd;
  border-radius: 6px;
  padding: 10px 15px;
  margin: 10px 200px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s ease-in-out, box-shadow 0.2s;
}

.team-member:hover {
  transform: scale(1.03);
  box-shadow: 0 4px 8px rgba(53, 50, 149, 0.2);
}

.team-member span {
  color: rgb(53, 50, 149); /* Blue accent */
  font-weight: bold;
}

/* Story Highlight */
.story {
  background-color: #fdfcff; /* Soft white with blue tint */
  border-left: 4px solid rgb(53, 50, 149);
  padding: 15px;
  border-radius: 5px;
  margin-top: 20px;
  font-style: italic;
  color: #444;
}

/* Footer Styling */
footer {
  text-align: center;
  background-color: rgb(76, 73, 151); /* Dark blue footer */
  
  padding: 15px 0;
  font-size: 0.9rem;
  box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.1);
}

footer p{
  color: #000000;
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
  <!-- Header -->
  

  <!-- Main Content -->
  <main>
    <header>
      <h1>About Us</h1>
    </header>
    <section>
      <h2>Who Are We?</h2>
      <p>
        We are a humble software development team working with a tech stack that is 
        different from what we are used to. (Yes, it's our first time writing PHP code 🥲)
      </p>
    </section>

    <section>
      <h2>Why Did We Choose This Project?</h2>
      <p>
        This is where we tell you why we embarked on this journey. A mix of courage, curiosity, 
        and perhaps a touch of overconfidence led us to face the tech stack monster. 
        It all started with an idea, and here we are now, building this project.
      </p>
    </section>

    <section>
      <h2>How Did We Survive 4 Years in College?</h2>
      <p>
        Honestly, only Allah knows. Between countless assignments, long nights, caffeine, and last-minute submissions, 
        we somehow made it through. But those struggles made us stronger. 
      </p>
    </section>

    <!-- Team Section -->
    <section class="team-section">
      <h2>Meet Our Team</h2>
      <div class="team-member">
        The one and only <strong>Mohamed Moataz</strong> 😎
      </div>
      <div class="team-member">
        The code adventurer <strong>Ahmed Hussein</strong> 🧳🧭
      </div>
      <div class="team-member">
        The speedy test runner <strong>Ahmed Mahmoud</strong> 🏃‍♂🚄
      </div>
      <div class="team-member">
        The artistic color master <strong>Rawda Ibrahim</strong> 🖌🖼
      </div>
      <div class="team-member">
        The marvellous designer <strong>Alaa Zahran</strong> 🍦🍨
      </div>
    </section>

    <section>
      <h2>The Epic Story</h2>
      <p>
        Those were 5 courageous developers, fearless of what the college monster had for them. 
        But little did they know... it was on that fateful day, the day they decided to slay the monster, 
        when everything began. Armed with their swords (keyboards), helmets (coffee mugs), and laptops, 
        they ventured into a place <strong>of no return</strong>—the world of PHP and software development!
      </p>
    </section>
  </main>

  <!-- Footer -->
  <footer>
    <p>&copy; 2024 Taskatk Team | Crafted with 💻 and 🧠</p>
  </footer>
</body>
</html>
