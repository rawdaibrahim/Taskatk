let userType = "normal"; 
let taskData = [];
let currentEditTask = null;
let currentListId = null;

const modalOverlay = document.getElementById('modal-overlay');
const modal = document.getElementById('modal');
const taskForm = document.getElementById('task-form');
const completedContainer = document.getElementById('completed-container');
const flip = document.getElementById("flip");

document.addEventListener("DOMContentLoaded", () => {
  fetchLists();
});

function fetchLists() {
  fetch('/Taskatk/api/lists.php/')
    .then(response => response.json())
    .then(data => {
      taskData = Object.values(data);
      renderLists();
    })
    .catch(err => console.error("Error fetching lists:", err));
}

function renderLists() {
  const container = document.getElementById("lists-container");
  container.innerHTML = "";
  console.log(taskData)
  taskData.forEach(list => {
    const listElement = document.createElement("div");
    listElement.className = "cont";
    listElement.id = list.id;

    listElement.innerHTML = `
      <div class="grid">
        <div class="list-name">
          <h3>${list.name}</h3>
        </div>
        <button class="trash" onclick="removeList('${list.id}')">
          <img src="css/trash.png" alt="Trash Icon" width="17" height="17" title="Remove List">
        </button>
      </div>
      <div id="tasks-${list.id}"></div>
      <button class="add-button" onclick="openCreateTaskModal('${list.id}')">
        Create Task
        <img src="css/plus.png" alt="Icon" width="17" height="17">
      </button>
    `;

    const tasksContainer = listElement.querySelector(`#tasks-${list.id}`);
    list.tasks.forEach(task => {
      if (task.flg_completed == 0) {
        const taskElement = document.createElement("div");
        taskElement.className = "task";
        taskElement.id = task.id;

        taskElement.innerHTML = `
          <input type="checkbox" ${task.flg_completed == 1 ? "checked" : ""} 
            onchange="toggleTaskCompletion('${task.id}', '${list.id}')">
          <span>${task.name}</span>
          <button onclick="openTaskInfo('${list.id}', '${task.id}')">
            <img src="css/information.png" alt="Icon" width="20" height="20" title="Task Info.">
          </button>
        `;


        tasksContainer.appendChild(taskElement);
      }
    });

    container.appendChild(listElement);
  });

  renderCompletedTasks();
}

function renderCompletedTasks() {
  completedContainer.innerHTML = "";

  taskData.forEach(list => {
    console.log(list);
    list.tasks
      .filter(task => task.flg_completed == 1)
      .forEach(task => {
        const taskElement = document.createElement("div");
        taskElement.className = "completed-task";
        taskElement.id = task.id;

        taskElement.innerHTML = `
          <span>${task.name}</span>
          <button onclick="removeCompletedTask('${list.id}', '${task.id}')" class="trash">
            <img src="css/trash.png" alt="Trash Icon" width="17" height="17" title="Delete Task">
          </button>
        `;

        completedContainer.appendChild(taskElement);
      });
  });
}

function addList() {
  const listName = prompt("Enter list name:");
  if (!listName) return;

  const formData = new URLSearchParams();
  formData.append('list_name', listName);

  fetch('/Taskatk/api/lists.php/create', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: formData.toString()
  })
  .then(response => response.json())
  .then(data => {
    if (data.list_id) {
      taskData.push({ id: data.list_id, name: listName, tasks: [] });
      renderLists();
    } else {
      alert("Error creating list: " + data.message);
    }
  })
  .catch(err => console.error("Error adding list:", err));
}


function openCreateTaskModal(listId) {
  currentListId = listId;
  currentEditTask = null;
  document.getElementById('modal-title').innerText = "Create Task";
  taskForm.reset();
  showModal();
}

function showModal() {
  modalOverlay.classList.remove('hidden');
  modal.classList.remove('hidden');
}

function closeModal() {
  modalOverlay.classList.add('hidden');
  modal.classList.add('hidden');
}

function handleTaskFormSubmit(event) {
  event.preventDefault();
  const taskName = document.getElementById('task-name').value;
  const dueDate = document.getElementById('task-due-date').value;
  const description = document.getElementById('task-description').value;

  if (currentEditTask) {
    updateTask(currentEditTask, taskName, dueDate, description);
  } else {
    createTask(currentListId, taskName, dueDate, description);
  }
  closeModal();
}

function createTask(listId, name, dueDate, description) {
  const formData = new URLSearchParams();
  formData.append('list_id', listId);
  formData.append('name', name);
  formData.append('due_date', dueDate);
  formData.append('description', description);

  fetch('/Taskatk/api/tasks.php/create', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: formData.toString()
  })
  .then(response => response.json())
  .then(data => {
    if (data.task_id) {
      const list = taskData.find(l => l.id === listId);
      if (list) {
        list.tasks.push({ 
          id: data.task_id, 
          name: name, 
          due_date: dueDate, 
          description: description, 
          flg_completed: 0
        });
        renderLists(); 
      } else {
        console.warn(`List with ID ${listId} not found.`);
      }
    } else {
      alert("Error creating task: " + (data.message || "Unknown error."));
    }
  })
  .catch(err => console.error("Error creating task:", err));
}


function toggleTaskCompletion(taskId, listId) {
  const list = taskData.find(l => l.id === listId);
  const task = list.tasks.find(t => t.id === taskId);


  const formData = new URLSearchParams();
  formData.append('task_id', taskId);
  formData.append('flg_completed', "1");

  fetch('/Taskatk/api/tasks.php/edit', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: formData.toString()
  })
    .then(response => response.json())
    .then(data => {
      if (data.message === 'Task updated successfully') {
        task.flg_completed = "1";
        renderLists();
      } else {
        alert("Error toggling task completion: " + (data.message || "Unknown error."));
      }
    })
    .catch(err => console.error("Error toggling task completion:", err));
}


function removeCompletedTask(listId, taskId) {
  fetch(`/Taskatk/api/tasks.php/?id=${taskId}`, {
    method: 'DELETE',
  })
    .then(response => response.json())
    .then(data => {
      if (data.message === 'Task deleted successfully') {
        const list = taskData.find(l => l.id === listId);
        list.tasks = list.tasks.filter(task => task.id !== taskId);
        renderLists();
      } else {
        alert("Error removing completed task: " + (data.message || "Unknown error."));
      }
    })
    .catch(err => console.error("Error removing completed task:", err));
}


function openTaskInfo(listId, taskId) {
  fetch(`/Taskatk/api/tasks.php/?id=${taskId}`)
    .then(response => {
      if (!response.ok) {
        throw new Error("Failed to fetch task details.");
      }
      return response.json();
    })
    .then(data => {
      if (Array.isArray(data) && data.length > 0) {
        const task = data[0]; 
        document.getElementById('modal-title').innerText = "Task Info";
        document.getElementById('task-name').value = task.name || "";
        document.getElementById('task-due-date').value = task.due_date || "";
        document.getElementById('task-description').value = task.description || "";

        currentListId = listId;
        currentEditTask = {
          id: taskId,
          name: task.name,
          due_date: task.due_date,
          description: task.description,
          flg_completed: task.flg_completed
        };

        showModal();
      } else {
        alert("Task not found or permission denied.");
      }
    })
    .catch(err => {
      console.error("Error fetching task details:", err);
      alert("Could not load task details. Please try again.");
    });
}



function updateTask(task, name, dueDate, description) {
  const formData = new URLSearchParams();
  formData.append('task_id', task.id);
  formData.append('name', name);
  formData.append('due_date', dueDate);
  formData.append('description', description);
  formData.append('flg_completed', 0);

  fetch('/Taskatk/api/tasks.php/edit', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: formData.toString()
  })
  .then(response => {
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }
    return response.json();
  })
  .then(data => {
    if (data.message === 'Task updated successfully') {
      task.name = name;
      task.due_date = dueDate;
      task.description = description;
      renderLists(); 
    } else {
      alert("Error updating task: " + (data.message || "Unknown error."));
    }
  })
  .catch(err => console.error("Error updating task:", err));
}


function removeList(listId) {
  if (confirm('Are you sure you want to remove this list?')) {
    fetch(`/Taskatk/api/lists.php/?id=${listId}/`, {
      method: 'DELETE',
    })
    .then(response => response.json())
    .then(data => {
      if (data.message === 'List deleted successfully') {
        taskData = taskData.filter(list => list.id !== listId);
        renderLists();
      } else {
        alert("Error removing list: " + (data.message || "Unknown error."));
      }
    })
    .catch(err => alert("List must be empty"));
  }
}



function showCompleted() {
  if (completedContainer.className === "show") {
    completedContainer.className = "hidden";
    flip.className = "not-flipped";
  } else {
    completedContainer.className = "show";
    flip.className = "flip";
  }
}
