let userType = "normal"; 
let userLists = 0;
const taskData = {};

function addList() {
  const maxLists = userType === "premium" ? 3 : 5;

  if (userLists >= maxLists) {
    alert(`Limit reached! Maximum ${maxLists} lists allowed.`);
    return;
  }
  const listName = prompt("Enter task name:");

  const container = document.getElementById("lists-container");
  const newListId = `list-${userLists}`;
  const newList = document.createElement("div");
  newList.className = "cont";
  newList.id = newListId;

  newList.innerHTML = `
    <h3>${listName}</h3>
    <div id="tasks-${newListId}"></div>
    <button class="add-button" onclick="addTask('${newListId}')">Create Task
    <img src="css/plus.png" alt="Icon" width="17" height="17">
    </button> 
  `;

  container.insertBefore(newList, container.firstChild)
  taskData[newListId] = [];
  userLists++;
}

function addTask(listId) {
  const taskName = prompt("Enter task name:");

  if (!taskName) {
    alert("Task name are required.");
    return;
  }

  const tasksUl = document.getElementById(`tasks-${listId}`);
  const taskId = `task-${Date.now()}`;
  const newTask = document.createElement("div");
  newTask.id = taskId;
  newTask.className = "task";

  newTask.innerHTML = `
    <input type="checkbox" onchange="(this)" style="cursor: pointer;">
    <span>${taskName}</span>
    <button onclick="editTask('${listId}', '${taskId}')">
      <img src="css/edit.png" alt="Icon" width="25" height="25">
    </button>
  `;

  tasksUl.appendChild(newTask);
  taskData[listId].push({ id: taskId, name: taskName, dateTime: taskDateTime, completed: false });
}


function removeTask(checkbox) {
  if (checkbox.checked) {
    const taskElement = checkbox.closest('.task');
    taskElement.remove();
  }
}


