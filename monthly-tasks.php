
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Monthly Tasks</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f4f4f9;
    }
    .nav{
      width:100%;
      position: fixed; 
      display: flex;
      backdrop-filter:blur(20px);
      align-items: center;
      justify-content: space-between;
      margin-bottom: 20px;
      background-image:linear-gradient(to right,rgb(129, 123, 181), rgb(53, 50, 149));
      top: 0;
      left: 0;
      box-shadow: 0 4px 10px rgba(22, 22, 67, 0.253);
    }

    .nav .link{
      text-decoration: none;
      color:#f1f1fa;
      margin: 10px;
      padding-right: 1em;
      position: relative;
      font-size: 15px;
      font-weight: 500;
    }

    .nav .link::after{
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 90%;
      height: 3px;
      background-color: #f1f1fa;
      border-radius: 3px;
      transition: .5s ease-in-out;
      transform:scalex(0);
      
    }

    .nav .link:hover:after{
      transform: scaleX(1);
    }

    a.active .link{
      color: #033ccd;
    }

    a.active .link::after{
      transform: scaleX(1);
      background-color:#f1f1fa;
      height: 4px;
    }
    .calendar {
      width: 90%;
      max-width: 1000px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      margin-top:100px;
    }
    .calendar-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px;
      background: #3f51b5;
      color: white;
    }
    .calendar-header h2 {
      margin: 0;
      font-size: 1.5em;
    }
    .calendar-header button {
      background: white;
      color: #3f51b5;
      border: none;
      padding: 10px 15px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 1em;
    }
    .calendar-header button:hover {
      background: #e0e0e0;
    }
    .calendar-grid {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      gap: 1px;
      background: #ddd;
    }
    .calendar-cell {
      background: white;
      min-height: 100px;
      display: flex;
      flex-direction: column;
      padding: 5px;
    }
    .calendar-cell .date {
      font-weight: bold;
      margin-bottom: 5px;
    }
    .calendar-cell textarea {
      flex-grow: 1;
      border: none;
      outline: none;
      resize: none;
      font-family: inherit;
      padding: 5px;
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
  <div class="calendar">
    <div class="calendar-header">
      <button onclick="prevMonth()">&#8249;</button>
      <h2 id="monthYear">December 2024</h2>
      <button onclick="nextMonth()">&#8250;</button>
    </div>
    <div class="calendar-grid" id="calendarGrid"></div>
  </div>

  <script>
    const calendarGrid = document.getElementById('calendarGrid');
    const monthYear = document.getElementById('monthYear');

    let currentDate = new Date();

    function renderCalendar() {
      const year = currentDate.getFullYear();
      const month = currentDate.getMonth();

      monthYear.textContent = currentDate.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long'
      });

      const firstDay = new Date(year, month, 1).getDay();
      const daysInMonth = new Date(year, month + 1, 0).getDate();

      calendarGrid.innerHTML = '';

      // Fill blank cells for days before the first of the month
      for (let i = 0; i < firstDay; i++) {
        const cell = document.createElement('div');
        cell.className = 'calendar-cell';
        calendarGrid.appendChild(cell);
      }

      // Fill cells with days and task inputs
      for (let day = 1; day <= daysInMonth; day++) {
        const cell = document.createElement('div');
        cell.className = 'calendar-cell';

        const date = document.createElement('div');
        date.className = 'date';
        date.textContent = day;

        const textarea = document.createElement('textarea');
        textarea.placeholder = 'Add tasks...';

        cell.appendChild(date);
        cell.appendChild(textarea);
        calendarGrid.appendChild(cell);
      }
    }

    function prevMonth() {
      currentDate.setMonth(currentDate.getMonth() - 1);
      renderCalendar();
    }

    function nextMonth() {
      currentDate.setMonth(currentDate.getMonth() + 1);
      renderCalendar();
    }

    renderCalendar();
  </script>
</body>
</html>