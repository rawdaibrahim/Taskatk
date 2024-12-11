<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Date Picker</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: #f9f9f9;
    }

    .date-picker {
      background: #fff;
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 1rem;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    input[type="date"] {
      padding: 0.5rem;
      font-size: 1rem;
      border: 1px solid #ddd;
      border-radius: 5px;
    }

    button {
      margin-top: 1rem;
      padding: 0.5rem 1rem;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <div class="date-picker">
    <h2>Select a Date</h2>
    <input type="date" id="date" />
    <button onclick="getSelectedDate()">Submit</button>
    <p id="selected-date"></p>
  </div>

  <script>
    function getSelectedDate() {
      const dateInput = document.getElementById("date").value;
      const display = document.getElementById("selected-date");
      if (dateInput) {
        display.innerText = `Selected Date: ${dateInput}`;
      } else {
        display.innerText = "No date selected.";
      }
    }
  </script>
</body>
</html>
