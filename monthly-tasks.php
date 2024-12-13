<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>Monthly Tasks</title>
  <style>

  </style>
</head>
<body class="body">
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
  </div>

  <script>
    const calendarGrid = document.getElementById('calendarGrid');
    const monthYear = document.getElementById('monthYear');

    let currentDate = new Date();

    async function fetchTasks(year, month) {
      const response = await fetch(`get_tasks.php?year=${year}&month=${month}`);
      if (!response.ok) {
        console.error('Failed to fetch tasks');
        return {};
      }
      return await response.json();
    }

    async function renderCalendar() {
      const year = currentDate.getFullYear();
      const month = currentDate.getMonth() + 1;

      monthYear.textContent = currentDate.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long'
      });

      const firstDay = new Date(year, month - 1, 1).getDay();
      const daysInMonth = new Date(year, month, 0).getDate();
      const tasks = await fetchTasks(year, month);

      calendarGrid.innerHTML = '';

      // Fill blank cells for days before the first of the month
      for (let i = 0; i < firstDay; i++) {
        const cell = document.createElement('div');
        cell.className = 'calendar-cell';
        calendarGrid.appendChild(cell);
      }

      // Fill cells with days and tasks
      for (let day = 1; day <= daysInMonth; day++) {
        const cell = document.createElement('div');
        cell.className = 'calendar-cell';

        const date = document.createElement('div');
        date.className = 'date';
        date.textContent = day;

        const tasksContainer = document.createElement('div');
        tasksContainer.className = 'tasks';

        const dayTasks = tasks[day] || [];
        dayTasks.forEach(task => {
          const taskItem = document.createElement('div');
          taskItem.textContent = `- ${task}`;
          tasksContainer.appendChild(taskItem);
        });

        cell.appendChild(date);
        cell.appendChild(tasksContainer);
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