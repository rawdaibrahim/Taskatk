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

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const calendarGrid = document.getElementById("calendarGrid");
      const monthYearLabel = document.getElementById("monthYear");
      
      let currentMonth = new Date().getMonth();
      let currentYear = new Date().getFullYear();

      function fetchAndRenderTasks(month, year) {
        const url = `/Taskatk/api/tasks.php/monthly_tasks?month=${month+1}&year=${year}`;
        fetch(url)
          .then(response => {
            if (!response.ok) throw new Error("Failed to fetch tasks");
            return response.json();
          })
          .then(tasks => {
            renderCalendar(month, year, tasks);
          })
          .catch(error => {
            console.error("Error fetching tasks:", error);
          });
      }

      function renderCalendar(month, year, tasks) {
        calendarGrid.innerHTML = ""; 

        const today = new Date(); 
        const firstDay = new Date(year, month, 1).getDay(); 
        const daysInMonth = new Date(year, month + 1, 0).getDate(); 

        for (let i = 0; i < firstDay; i++) {
          const emptyCell = document.createElement("div");
          emptyCell.className = "calendar-cell empty";
          calendarGrid.appendChild(emptyCell);
        }

        for (let day = 1; day <= daysInMonth; day++) {
          const dayCell = document.createElement("div");
          dayCell.className = "calendar-cell";
          dayCell.innerHTML = `<span class="date">${day}</span>`;
          
          const tasksForDay = tasks.filter(task => new Date(task.due_date).getDate() === day);
          if (tasksForDay.length > 0) {
            const taskList = document.createElement("ul");
            taskList.className = "task-list";
            tasksForDay.forEach(task => {
              const taskItem = document.createElement("li");
              if(task.flg_completed == "1"){
                taskItem.className = "green tooltip-green";
                taskItem.setAttribute("data-title", "Completed");
              }else{
                const dueDate = new Date(task.due_date);
                if (dueDate < today && task.flg_completed != "1") {
                  taskItem.className = "overdue tooltip-red";
                  taskItem.setAttribute("data-title", "Overdue");
                } else {
                  taskItem.className = "blue tooltip-blue";
                  taskItem.setAttribute("data-title", "Inprogress");
                }
              }
                
              taskItem.textContent = task.name; 
              taskList.appendChild(taskItem);
              
            });
            dayCell.appendChild(taskList);
          }

          calendarGrid.appendChild(dayCell);
        }

        const monthNames = [
          "January", "February", "March", "April", "May", "June",
          "July", "August", "September", "October", "November", "December"
        ];
        monthYearLabel.textContent = `${monthNames[month]} ${year}`;
      }

      window.prevMonth = function () {
        currentMonth--;
        if (currentMonth < 0) {
          currentMonth = 11;
          currentYear--;
        }
        fetchAndRenderTasks(currentMonth, currentYear);
      };

      window.nextMonth = function () {
        currentMonth++;
        if (currentMonth > 11) {
          currentMonth = 0;
          currentYear++;
        }
        fetchAndRenderTasks(currentMonth, currentYear);
      };

      fetchAndRenderTasks(currentMonth, currentYear);
    });
  </script>
</body>
</html>
