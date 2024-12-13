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
    fetch('/api/lists.php')
        .then(response => response.json())
        .then(data => {
            taskData = data;
            renderLists();
        })
        .catch(err => console.error("Error fetching lists:", err));
}

function renderLists() {
    const container = document.getElementById("lists-container");
    container.innerHTML = "";

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
                    <img src="css/trash.png" alt="Trash Icon" width="17" height="17">
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
            if (!task.completed) {
                const taskElement = document.createElement("div");
                taskElement.className = "task";
                taskElement.id = task.id;

                taskElement.innerHTML = `
                    <input type="checkbox" ${task.completed ? "checked" : ""} onchange="toggleTaskCompletion('${list.id}', '${task.id}', this.checked)">
                    <span>${task.name}</span>
                    <button onclick="openTaskInfo('${list.id}', '${task.id}')">info</button>
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
        list.tasks
            .filter(task => task.completed)
            .forEach(task => {
                const taskElement = document.createElement("div");
                taskElement.className = "completed-task";
                taskElement.id = task.id;

                taskElement.innerHTML = `
                    <span>${task.name}</span>
                    <button onclick="removeCompletedTask('${list.id}', '${task.id}')" class="trash">
                        <img src="css/trash.png" alt="Trash Icon" width="17" height="17">
                    </button>
                `;

                completedContainer.appendChild(taskElement);
            });
    });
}

function addList() {
    const listName = prompt("Enter list name:");
    if (!listName) return;

    fetch('/api/lists.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ list_name: listName })
    })
        .then(response => response.json())
        .then(data => {
            taskData.push(data);
            renderLists();
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
    fetch('/api/tasks.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ list_id: listId, name, due_date: dueDate, description })
    })
        .then(response => response.json())
        .then(task => {
            const list = taskData.find(l => l.id === listId);
            list.tasks.push(task);
            renderLists();
        })
        .catch(err => console.error("Error creating task:", err));
}

function toggleTaskCompletion(listId, taskId, isCompleted) {
    fetch('/api/tasks.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ list_id: listId, task_id: taskId, completed: isCompleted })
    })
        .then(() => renderLists())
        .catch(err => console.error("Error toggling task completion:", err));
}

function removeCompletedTask(listId, taskId) {
    fetch('/api/tasks.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ list_id: listId, task_id: taskId })
    })
        .then(() => {
            const list = taskData.find(l => l.id === listId);
            list.tasks = list.tasks.filter(task => task.id !== taskId);
            renderLists();
        })
        .catch(err => console.error("Error removing completed task:", err));
}

function openTaskInfo(listId, taskId) {
    const list = taskData.find(l => l.id === listId);
    const task = list.tasks.find(t => t.id === taskId);
    currentListId = listId;
    currentEditTask = task;

    document.getElementById('modal-title').innerText = "Task Info";
    document.getElementById('task-name').value = task.name;
    document.getElementById('task-due-date').value = task.dueDate;
    document.getElementById('task-description').value = task.description;

    showModal();
}

function updateTask(task, name, dueDate, description) {
    fetch('/api/tasks.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ list_id: currentListId, task_id: task.id, name, due_date: dueDate, description })
    })
        .then(() => {
            task.name = name;
            task.dueDate = dueDate;
            task.description = description;
            renderLists();
        })
        .catch(err => console.error("Error updating task:", err));
}

function removeList(listId) {
    if (confirm('Are you sure you want to remove this list?')) {
        fetch('/api/lists.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ list_id: listId })
        })
            .then(() => {
                taskData = taskData.filter(list => list.id !== listId);
                renderLists();
            })
            .catch(err => console.error("Error removing list:", err));
    }
}

function showCompleted() {
    if (completedContainer.className === "show") {
        completedContainer.className = "hide";
        flip.className = "not-flipped";
    } else {
        completedContainer.className = "show";
        flip.className = "flip";
    }
}
